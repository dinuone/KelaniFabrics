<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use App\Models\Customer;
use App\Models\Stock;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected OrderService $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService=$orderService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->query('search'); // Get ?search= query
        $orders = $this->orderService->getAll($search); // Make sure this returns data


        return view('order.index', compact('orders'));
    }

    public function export()
    {
        return Excel::download(new OrdersExport, 'orders.xlsx');
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();

        // Fetch stocks where availability is NOT 'Out of Stock'
        // Or receive_qty > 0 (depending on your logic)
        $stocks = Stock::with(['product', 'color', 'size'])
            ->where('availability', '!=', 'Out of Stock')
            ->where('receive_qty', '>', 0)
            ->get();

        return view('order.manage', compact('customers', 'stocks'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'stock_id' => 'required|exists:stocks,id',
            'orderType' => 'required|in:Cash on Delivery,Card Payment,Cash',
            'status' => 'required',
            'qty' => 'required|integer|min:1',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        // Start transaction to avoid partial updates
        \DB::beginTransaction();
        try {
            DB::table('orders')->lockForUpdate()->get();
            // Reduce stock availability
            $stock = Stock::findOrFail($validated['stock_id']);
            if ($stock->receive_qty < $validated['qty']) {
                return back()->withErrors(['qty' => 'Ordered quantity exceeds available stock.'])->withInput();
            }
            $stock->receive_qty -= $validated['qty'];
            $stock->save();

            $orderRef = Order::generateOrderRef();
            dd($orderRef);

            $order = Order::create([
                'customer_id' => $validated['customer_id'],
                'stock_id' => $validated['stock_id'],
                'order_type' => $validated['orderType'],
                'status' => $validated['status'],
                'qty' => $validated['qty'],
                'shipping_address' => $validated['shipping_address'],
                'notes' => $validated['notes'] ?? null,
                'order_ref' => $orderRef,
            ]);

            $amount = $stock->price * $order->qty;

            $paymentStatus = match($order->order_type) {
                'Card Payment', 'Cash' => 'Paid',
                'Cash on Delivery' => 'Pending',
            };

            Payment::create([
                'order_id' => $order->id,
                'amount' => $amount,
                'status' => $paymentStatus,
            ]);

            \DB::commit();

            return redirect()->route('order.index')->with('success', 'Order and payment recorded successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create order: ' . $e->getMessage()])->withInput();
        }
    }



    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'stock_id' => 'required|exists:stocks,id',
            'orderType' => 'required|in:Cash on Delivery,Card Payment,Cash',
            'status' => 'required',
            'qty' => 'required|integer|min:1',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        \DB::beginTransaction();
        try {
            $order = Order::findOrFail($id);

            $oldQty = $order->qty;
            $oldStockId = $order->stock_id;

            // If stock changed, revert old stock qty and reduce new stock qty
            if ($validated['stock_id'] != $oldStockId) {
                // Restore old stock qty
                $oldStock = Stock::findOrFail($oldStockId);
                $oldStock->receive_qty += $oldQty;
                $oldStock->save();

                // Reduce new stock qty
                $newStock = Stock::findOrFail($validated['stock_id']);
                if ($newStock->receive_qty < $validated['qty']) {
                    return back()->withErrors(['qty' => 'Ordered quantity exceeds available stock.'])->withInput();
                }
                $newStock->receive_qty -= $validated['qty'];
                $newStock->save();
            } else {
                // Same stock, adjust qty difference
                $stock = Stock::findOrFail($oldStockId);
                $qtyDiff = $validated['qty'] - $oldQty;

                if ($qtyDiff > 0 && $stock->receive_qty < $qtyDiff) {
                    return back()->withErrors(['qty' => 'Ordered quantity exceeds available stock.'])->withInput();
                }

                $stock->receive_qty -= $qtyDiff;
                $stock->save();
            }

            $order->update([
                'customer_id' => $validated['customer_id'],
                'stock_id' => $validated['stock_id'],
                'order_type' => $validated['orderType'],
                'status' => $validated['status'],
                'qty' => $validated['qty'],
                'shipping_address' => $validated['shipping_address'],
                'notes' => $validated['notes'] ?? null,
            ]);

            $stock = Stock::findOrFail($order->stock_id);
            $amount = $stock->price * $order->qty;

            $paymentStatus = match ($order->order_type) {
                'Card Payment', 'Cash' => 'Paid',
                'Cash on Delivery' => 
                    in_array($order->status, ['Delivered', 'Collected']) ? 'Paid' : 'Pending',
            };

            if ($order->payment) {
                $order->payment->update([
                    'amount' => $amount,
                    'status' => $paymentStatus,
                ]);
            } else {
                Payment::create([
                    'order_id' => $order->id,
                    'amount' => $amount,
                    'status' => $paymentStatus,
                ]);
            }

            \DB::commit();

            return redirect()->route('order.index')->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update order: ' . $e->getMessage()])->withInput();
        }
    }

 

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with(['customer', 'stock.product', 'payment'])->findOrFail($id);
        return view('order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $stocks = Stock::all();

        return view('order.manage', compact('order', 'stocks'));
    }


 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        list($type,$message)=$this->orderService->deleteOrder(
            order : $order
        );
        return redirect()->route('order.index')->with($type,$message);
    }
}
