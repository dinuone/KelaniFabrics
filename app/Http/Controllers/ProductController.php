<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Color;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    protected ProductService $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService=$productService;
    }
    public function index()
    {
        $search = request()->query('search'); // Get ?search= query
        $products = $this->productService->getAll($search); // Make sure this returns data

        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $lastProduct = Product::whereNotNull('product_ref')->orderBy('id', 'desc')->first();
        $lastNumber = 0;

            if ($lastProduct && $lastProduct->product_ref) {
                // Extract numeric part: PRO000123 => 123
                $lastNumber = (int)substr($lastProduct->product_ref, 3);
            }

        $nextProductId = 'PRO' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
        $colors = Color::all();
        $categories = Category::all();

        return view('product.manage', compact('nextProductId','colors','categories'));
     // return view('product.manage');
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreProductRequest $request)
    // {
    //     list($type,$message)=$this->productService->storeProduct(
    //         productName: $request['productName'],
    //         qty:$request['qty'],
    //         productPrice:$request['productPrice'],
    //         availability:$request['availability'],

    //     );
    //     return redirect()->route('product.inddex')->with($type,$message);
    // }
    public function store(Request $request)
    {




        $validated = $request->validate([
            'productName'       => 'required|string|max:255',
            'description'       => 'nullable',
            'productPrice'      => 'required|numeric|min:0',
            'category_id'       => 'required|exists:categories,id',
            'sub_category_id'   => 'required|exists:sub_categories,id',
            'color'             => 'required|integer|exists:colors,id',
            'size'              => 'required|array|min:1',
            'productImage'      => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'size.required'     => 'Please select at least one size.',
            'size.min'          => 'Please select at least one size.',
        ]);





        $existingProduct = Product::withTrashed()
            ->where('product_name', $validated['productName'])
            ->where('cat_id', $validated['category_id'])
            ->where('sub_cat_id', $validated['sub_category_id'])
            ->first();

        if ($existingProduct) {
            if ($existingProduct->trashed()) {

                $existingProduct->restore();
                $existingProduct->update([
                    'price'       => $validated['productPrice'],
                    'description' => $validated['description'],
                    'status'      => true,
                ]);
            }


            $existingProduct->colors()->syncWithoutDetaching([$validated['color']]);
            $existingProduct->sizes()->syncWithoutDetaching($validated['size']);

            return redirect()->route('product.index')->with('success', 'Product restored and updated successfully.');
        }


        $data = [
            'product_name' => $validated['productName'],
            'description'  => $validated['description'],
            'cat_id'       => $validated['category_id'],
            'sub_cat_id'   => $validated['sub_category_id'],
            'price'        => $validated['productPrice'],
            'status'       => true,
        ];

        if ($request->hasFile('productImage')) {
            $data['image'] = $request->file('productImage')->store('products', 'public');
        }

        $product = Product::create($data);


        $product->sizes()->attach($validated['size']);
        $product->colors()->attach($validated['color']);

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    public function export()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

        $colors = Color::all();
        $categories = Category::all();
        $subcategories = SubCategory::where('cat_id', $product->cat_id)->get();
        $product->load(['colors', 'sizes']);

       return view('product.manage', compact('product', 'colors', 'categories', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateProductRequest $request, Product $product)
    // {

    //     list($type,$message)=$this->productService->updateproduct(
    //         product : $product,
    //         productName: $request['productName'],
    //         qty:$request['qty'],
    //         productPrice:$request['productPrice'],
    //         availability:$request['availability'],
    //     );
    //     return redirect()->route('product.inddex')->with($type,$message);
    // }


    public function update(Request $request, Product $product)
    {
          $validated = $request->validate([
            'productName'       => 'required|string|max:255',
           'description'       => 'nullable',
            'productPrice'      => 'required|numeric|min:0',
            'category_id'       => 'required|exists:categories,id',
            'sub_category_id'   => 'required|exists:sub_categories,id',
            'color'             => 'required|integer|exists:colors,id',
            'size'              => 'required|array|min:1',
            'productImage'      => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'size.required'     => 'Please select at least one size.',
            'size.min'          => 'Please select at least one size.',
        ]);


        $data = [
            'product_name' => $validated['productName'],
            'description' => $validated['description'] ?? null,
            'cat_id' => $validated['category_id'],
            'sub_cat_id' => $validated['sub_category_id'],
            'price' => $validated['productPrice'],
            'status' => true,
        ];


        if ($request->hasFile('productImage')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $path = $request->file('productImage')->store('products', 'public');
            $data['image'] = $path;
        }


        $product->update($data);

        $product->sizes()->sync($validated['size']);


        $product->colors()->sync([$validated['color']]);

        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }



    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('product_name', 'like', "%{$query}%")
            ->orWhere('product_ref', 'like', "%{$query}%")
            ->limit(10)
            ->with('colors','sizes')
            ->get(['id', 'product_name', 'product_ref', 'price']);

        return response()->json($products);
    }


    public function destroy(Product $product):RedirectResponse
    {
        $product->delete();
        return redirect()->route('product.index');
    }

    public function exportPdf(Request $request)
    {
        $products = Product::with(['category', 'subCategory', 'colors'])->get();

        $pdf = Pdf::loadView('product.pdf', compact('products'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('products.pdf');
    }


}
