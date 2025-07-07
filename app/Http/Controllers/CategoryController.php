<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;
use App\Exports\CategoryExport;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService=$categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $search = request()->query('search');
        $categories = $this->categoryService->getAll($search);
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.manage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        list($type,$message)=$this->categoryService->storeCategory(
            catName: $request['catName'],
            catStatus: $request['catStatus'],
        );
         return redirect()->route('category.index')->with($type,$message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }
    public function export()
    {
        return Excel::download(new CategoryExport, 'categories.xlsx');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('category.manage',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        list($type,$message)=$this->categoryService->updateCategory(
            category:$category,
            catName: $request['catName'],
            catStatus: $request['catStatus'],
        );
         return redirect()->route('category.index')->with($type,$message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        list($type,$message)=$this->categoryService->deleteCategory(
            category : $category
        );
        return redirect()->route('category.index')->with($type,$message);
    }

}
