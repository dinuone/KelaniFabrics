<?php
namespace App\Services;
use App\Models\Delivery;
use Illuminate\Support\Facades\Log;

class DeliveryService
{
    public function getAll($search = null){

        $query = Delivery::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('status', 'LIKE', "%{$search}%");
            });
        }
        return Delivery::paginate(10);
    }

    public function storeDelivery(
        String $status,
    ):array {
        try{
        Delivery::create([
            'status' => $status,
         ]);
         $type = 'success';
         $message = 'Delivery created successfully';
        }catch (\Exception $e){
            Log::error($e->getMessage());
            $type = 'error';
            $message = 'Something went wrong';
        }
        return [$type,$message];
    }
    public function updateDelivery(
        Object $delivery,
        String $status,
    ){
        try{
        $delivery->update([
            'status' => $status,

         ]);
         $type = 'success';
         $message = 'Delivery updated successfully';
        }catch (\Exception $e){
            Log::error($e->getMessage());
            $type = 'error';
            $message = 'Something went wrong';
        }
        return [$type,$message];
    }
    public function deleteDelivery(
        object $delivery
    ): array
    {
        try{
                $delivery->delete();
                $type = 'success';
                $message = 'Delivery delete successfully';

            }catch (\Exception $e){
                Log::error($e->getMessage());
                $type = 'error';
                $message = 'Something went wrong';
            }
            return [$type,$message];
    }



}
