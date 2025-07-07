<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Services\StockService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Container\Attributes\DB;
use App\Models\Color;
use App\Models\Size;
use App\Exports\StockExport;
use Maatwebsite\Excel\Facades\Excel;



class StockController extends Controller
{
    protected StockService $stockService;
    public function __construct(StockService $stockService)
    {
        $this->stockService=$stockService;
    }
    /**
     * Display a listing of the resource.
     */

     public function export()
    {
        return Excel::download(new StockExport, 'stock-list.xlsx');
    }

    public function index()
    {
        $search = request()->query('search');
        $stocks = $this->stockService->getAll($search);

      
        return view('stock.index', compact('stocks'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->select('id', 'name', 'category') // Add fields you need
            ->limit(10)
            ->get();

        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
     
        $colors = Color::all();
        $sizes = Size::all();


        return view('stock.manage', compact('colors', 'sizes'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockRequest $request)
    {
        $data = $request->only([
            'product_id',
            'price',
            'color_id',
            'size_id',
            'receive_qty',
            'availability',
        ]);

        // Check for soft-deleted stock
        $existing = Stock::withTrashed()
            ->where('product_id', $data['product_id'])
            ->where('color_id', $data['color_id'])
            ->where('size_id', $data['size_id'])
            ->first();

        if ($existing) {
            $existing->restore(); // restore soft-deleted record
            $existing->update($data); // update restored record
        } else {
            Stock::create($data);
        }

        return redirect()->route('stock.index')->with('success', 'Stock saved successfully.');
    }





    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        return view('stock.manage',compact('stock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        // Load related data for dropdowns
        $products = Product::all();
        $colors = Color::all();
        $sizes = Size::all();

        // Return the edit view with data
        return view('stock.manage', compact('stock', 'products', 'colors', 'sizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStockRequest $request, Stock $stock)
    {
        // Validate and get only relevant fields
        $data = $request->only([
            'product_id',
            'price',
            'color_id',
            'size_id',
            'receive_qty',
            'availability',
        ]);

        // Update the stock record
        $stock->update($data);

        // Redirect with success message
        return redirect()->route('stock.index')->with('success', 'Stock updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteStock(Stock $stock): RedirectResponse
    {
        try {
            $stock->delete();
            return redirect()->route('stock.index')->with('success', 'Stock deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('stock.index')->with('error', 'Failed to delete stock: ' . $e->getMessage());
        }
    }
}
