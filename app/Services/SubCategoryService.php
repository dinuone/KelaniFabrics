<?php
namespace App\Services;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Log;

class SubCategoryService
{
    public function getAll($search = null){

        $query = SubCategory::with('category');



        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('sub_cat_name', 'LIKE', "%{$search}%")
                  ->orWhere('sub_cat_status', 'LIKE', "%{$search}%");

            });
        }


        return $query->paginate(10);
        //return Sub_category::paginate(10);
    }

    public function storeSubCategory(
        String $catId,
        String $subCatName,
        String $subCatStatus,
    ):array {
        //dd($catId);
        try{
            SubCategory::create([
            'cat_id'=>$catId,
            'sub_cat_name' => $subCatName,
            'sub_cat_status' => $subCatStatus,
         ]);
         $type = 'success';
         $message = 'SubCategory created successfully';
        }catch (\Exception $e){
            //dd($e->getMessage());
            Log::error($e->getMessage());
            $type = 'error';
            $message = 'Something went wrong';
        }
        return [$type,$message];
    }
    public function updateSubCategory(
        Object $sub_category,
        String $catId,
        String $subCatName,
        String $subCatStatus,
    ){
        try{
        $sub_category->update([
            'cat_id'=>$catId,
            'sub_cat_name' => $subCatName,
            'sub_cat_status' => $subCatStatus,
         ]);
         $type = 'success';
         $message = 'SubCategory updated successfully';
        }catch (\Exception $e){
            Log::error($e->getMessage());
            $type = 'error';
            $message = 'Something went wrong';
        }
        return [$type,$message];
    }
    public function deleteSubCategory(
        object $sub_category
    ): array
    {
        try{
                $sub_category->delete();
                $type = 'success';
                $message = 'SubCategory delete successfully';

            }catch (\Exception $e){
                Log::error($e->getMessage());
                $type = 'error';
                $message = 'Something went wrong';
            }
            return [$type,$message];
    }
    public function getSubCategoryByCatId(
        string $catId,
    )
    {
        return SubCategory::where('cat_id', $catId)->get();
    }



}
