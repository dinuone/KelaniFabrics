<?php
namespace App\Services;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    public function getAll($search = null){


        $query = Category::query();

         if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('cat_name', 'LIKE', "%{$search}%")
                  ->orWhere('cat_status', 'LIKE', "%{$search}%");
        });
     }
        //return Category::paginate(10);
        return $query->paginate(10);

    }
    public function getActiveCategories(){
        return Category::where("cat_status",1)->get();
    }


    public function storeCategory(
        String $catName,
        String $catStatus,
    ):array {
        try{
        Category::create([
            'cat_name' => $catName,
            'cat_status' => $catStatus,

         ]);
         $type = 'success';
         $message = 'Category created successfully';
        }catch (\Exception $e){
            Log::error($e->getMessage());
            $type = 'error';
            $message = 'Something went wrong';
        }
        return [$type,$message];
    }
    public function updateCategory(
        Object $category,
        String $catName,
        String $catStatus,
    ){
        try{
        $category->update([
            'cat_name' => $catName,
            'cat_status' => $catStatus,
         ]);
         $type = 'success';
         $message = 'Category updated successfully';
        }catch (\Exception $e){
            Log::error($e->getMessage());
            $type = 'error';
            $message = 'Something went wrong';
        }
        return [$type,$message];
    }
    public function deleteCategory(
        object $category
    ): array
    {
        try{
                $category->delete();
                $type = 'success';
                $message = 'Category deleted successfully';

            }catch (\Exception $e){
                Log::error($e->getMessage());
                $type = 'error';
                $message = 'Something went wrong';
            }
            return [$type,$message];
    }



}
