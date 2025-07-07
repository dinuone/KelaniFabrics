<?php
namespace App\Services;
use App\Models\Product;
;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Type\Integer;

class ProductService
{
    public function getAll($search = null)
    {
        $query = Product::with(['category', 'subCategory', 'colors']);  // eager load relations

        if ($search) {
            $query->where('product_name', 'LIKE', "%{$search}%");
        }

        return $query->paginate(10);
    }

    public function storeProduct(
        String $productName,
        string $qty,
        string $productPrice,
        string $availability,
    ):array {
        try{
        Product::create([
            'product_name' => $productName,
            'qty' => $qty,
            'product_price' => $productPrice,
            'availability' => $availability,
         ]);
         $type = 'success';
         $message = 'Product created successfully';
        }catch (\Exception $e){
            Log::error($e->getMessage());
            $type = 'error';
            $message = 'Something went wrong';
        }
        return [$type,$message];
    }
    public function updateProduct(
        Object $product,
        String $productName,
        string $qty,
        string $productPrice,
        string $availability,
    ){
        try{
        $product->update([
            'product_name' => $productName,
            'qty' => $qty,
            'product_price' => $productPrice,
            'availability' => $availability,

         ]);
         $type = 'success';
         $message = 'Product Updated successfully';
        }catch (\Exception $e){
            Log::error($e->getMessage());
            $type = 'error';
            $message = 'Something went wrong';
        }
        return [$type,$message];
    }
    public function deleteProduct(
        object $product
    ): array
    {
        try{
                $product->delete();
                $type = 'success';
                $message = 'Product Deleted successfully';

            }catch (\Exception $e){
                Log::error($e->getMessage());
                $type = 'error';
                $message = 'Something went wrong';
            }
            return [$type,$message];
    }



}
