<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EcomOrder;
use App\Models\EcomOrderItem;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
       
        $validated = $request->validate([
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'customer_address' => 'required|string',
            'customer_city' => 'nullable|string',
            'customer_state' => 'nullable|string',
            'customer_name' => 'nullable|string',
            'customer_id' => 'required',
            'payment_method' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.color_id' => 'required|exists:colors,id',
            'items.*.size_id' => 'required|exists:sizes,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {


             $date = date('Ymd');
            $lastOrder = EcomOrder::where('order_number', 'like', "ORD{$date}%")
                ->orderBy('order_number', 'desc')
                ->first();

            if (!$lastOrder) {
                $nextIncrement = 1;
            } else {
                // Extract last increment number from order_number, e.g. ORD202507190001
                $lastNumber = (int)substr($lastOrder->order_number, -4);
                $nextIncrement = $lastNumber + 1;
            }

            $orderNumber = 'ORD' . $date . str_pad($nextIncrement, 4, '0', STR_PAD_LEFT);

            $order = EcomOrder::create([
                'order_number' => $orderNumber,
                'customer_email' => $validated['customer_email'] ?? null,
                'customer_phone' => $validated['customer_phone'] ?? null,
                'customer_address' => $validated['customer_address'] ?? null,
                'customer_city' => $validated['customer_city'] ?? null,
                'customer_state' => $validated['customer_state'] ?? null,
                'customer_name' => $validated['customer_name'] ?? null,
                'customer_id' => $validated['customer_id'] ?? null,
                'payment_method' => $validated['payment_method'] ?? null,
                'status' => 'pending',
                'total_amount' => $validated['total_amount'],
            ]);

            foreach ($validated['items'] as $item) {
                $stock = Stock::where('product_id', $item['product_id'])
                    ->where('color_id', $item['color_id'])
                    ->where('size_id', $item['size_id'])
                    ->first();

                if (!$stock) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stock not found for the selected product, color, and size.",
                        'stock_not_found' => true,
                    ], 200);
                  
                }

               if ($stock->receive_qty < $item['quantity']) {
                    return response()->json([
                        'success' => false,
                        'message' => "Not enough stock for product ID {$item['product_id']}.",
                        'out_of_stock' => true,
                    ], 200);
                }

                // Reduce stock quantity
                $stock->receive_qty -= $item['quantity'];
                $stock->save();

                // Create order item record
                EcomOrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'color_id' => $item['color_id'],
                    'size_id' => $item['size_id'],
                    'quantity' => $item['quantity'],
                    'price' => $stock->price,  // Assuming price is stored in stock table
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'order_ref' => $orderNumber,
                'total_amount' => $order->total_amount,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function markOrderAsPaid(Request $request)
    {
        $validated = $request->validate([
            'order_ref' => 'required|string', 
        ]);

        $order = EcomOrder::where('order_number', $validated['order_ref'])->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $order->status = 'paid';
        $order->save();

        return response()->json(['success' => true, 'message' => 'Order marked as paid']);
    }
    
}
