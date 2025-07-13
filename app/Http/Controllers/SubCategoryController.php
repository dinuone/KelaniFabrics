<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Http\Requests\StoreSub_categoryRequest;
use App\Http\Requests\UpdateSub_categoryRequest;
use App\Models\Category;
use App\Services\SubCategoryService;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use App\Exports\SubCategoryExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;


use function PHPSTORM_META\type;

class SubCategoryController extends Controller
{
    protected SubCategoryService $subcategoryService;
    protected CategoryService $categoryService;
    public function __construct(SubCategoryService $subcategoryService,CategoryService $categoryService)
    {
        $this->subcategoryService=$subcategoryService;
        $this->categoryService=$categoryService;

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->query('search'); // Get ?search= query
        $sub_categories = $this->subcategoryService->getAll($search); // Make sure this returns data
        return view('subcategory.index', compact('sub_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = $this->categoryService->getActiveCategories();
        return view('subcategory.manage', compact('category'));


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSub_categoryRequest $request)
    {
        list($type,$message)=$this->subcategoryService->storeSubCategory(
            catId: $request['catName'],
            //catId:$request['catId'],
            subCatName: $request['subCatName'],
            subCatStatus: $request['subCatStatus'],
        );
         return redirect()->route('sub_category.index')->with($type,$message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sub_category $sub_category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sub_category $sub_category)
    {
        return view('subcategory.manage',compact('sub_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSub_categoryRequest $request, Sub_category $sub_category)
    {
        list($type,$message)=$this->subcategoryService->updateSubCategory(
            sub_category:$sub_category,
            catId: $request['CatName'],
            //catId:$request['catId'],
            subCatName: $request['subCatName'],
            subCatStatus: $request['subCatStatus'],
        );
         return redirect()->route('subcategory.index')->with($type,$message);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sub_category $sub_category):RedirectResponse
    {
        list($type,$message)=$this->subcategoryService->deleteSubCategory(
            sub_category:$sub_category,
        );
        return redirect()->route('subcategory.index')->with($type,$message);
    }
    public function getSubCategoryByCatId($catId)
    {
        $sub_categories = $this->subcategoryService->getSubCategoryByCatId($catId);
        return response()->json($sub_categories);
    }
    public function export()
    {
        return Excel::download(new SubCategoryExport, 'sub_categories.xlsx');
    }

    public function exportPdf()
    {
        $sub_categories = SubCategory::with('category')->get();

        $pdf = Pdf::loadView('subCategory.pdf', compact('sub_categories'))
                ->setPaper('a4', 'portrait');

        return $pdf->download('subcategory_report.pdf');
    }
}
