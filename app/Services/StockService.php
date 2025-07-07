<?php
namespace App\Services;
use App\Models\Stock;
use Illuminate\Support\Facades\Log;

class StockService
{
   public function getAll($search = null)
    {
        $query = Stock::with(['product', 'product.category', 'color', 'size']); // eager load relations

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('product', function ($q2) use ($search) {
                    $q2->where('product_name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('product.category', function ($q3) use ($search) {
                    $q3->where('cat_name', 'LIKE', "%{$search}%");
                })
                ->orWhere('receive_qty', 'LIKE', "%{$search}%")
                ->orWhere('reorder_level', 'LIKE', "%{$search}%")
                ->orWhere('availability', 'LIKE', "%{$search}%");
            });
        }

        return $query->paginate(10);
    }


    public function storeStock(
        String $productName,
        String $catName,
        String $receiveQty,
        String $recorderLevel,
        String $availability,
    ):array {
        try{
        Stock::create([
            'product_name' => $productName,
            'cat_name' => $catName,
            'receive_qty' => $receiveQty,
            'recorder_level' => $recorderLevel,
            'availability' => $availability,
         ]);
         $type = 'success';
         $message = 'Stock created successfully';
        }catch (\Exception $e){
            Log::error($e->getMessage());
            $type = 'error';
            $message = 'Something went wrong';
        }
        return [$type,$message];
    }
    public function updateStock(
        Object $stock,
        String $productName,
        String $catName,
        String $receiveQty,
        String $recorderLevel,
        String $availability,
    ){
        try{
        $stock->update([
            'product_name' => $productName,
            'cat_name' => $catName,
            'receive_qty' => $receiveQty,
            'recorder_level' => $recorderLevel,
            'availability' => $availability,
         ]);
         $type = 'success';
         $message = 'Stock updated successfully';
        }catch (\Exception $e){
            Log::error($e->getMessage());
            $type = 'error';
            $message = 'Something went wrong';
        }
        return [$type,$message];
    }
    public function deleteEmployee(
        object $stock
    ): array
    {
        try{
                $stock->delete();
                $type = 'success';
                $message = 'Stock delete successfully';

            }catch (\Exception $e){
                Log::error($e->getMessage());
                $type = 'error';
                $message = 'Something went wrong';
            }
            return [$type,$message];
    }



}


