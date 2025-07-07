<?php
namespace App\Services;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Type\Integer;


class OrderService
{
  public function getAll($search = null)
    {
        $query = Order::with(['customer', 'stock.product', 'payment']); // eager loading

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_type', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhere('qty', 'LIKE', "%{$search}%");
            });
        }

        return $query->latest()->paginate(10);
    }


    public function storeOrder(
        String $orderType,
        string $status,
        String $qty,
    ):array {
        try{
        Order::create([
            'order_type' => $orderType,
            'status' => $status,
            'qty' => $qty,
        ]);
         $type = 'success';
         $message = 'Order created successfully';
        }catch (\Exception $e){
            Log::error($e->getMessage());
            $type = 'error';
            $message = 'Something went wrong';
        }
        return [$type,$message];
    }
    public function updateOrder(
        Object $order,
        String $orderType,
        string $status,
        String $qty,

    ){
        try{
        $order->update([
            'order_type' => $orderType,
            'status' =>  $status,
            'qty' => $qty,


         ]);
         $type = 'success';
         $message = 'Order Updated successfully';
        }catch (\Exception $e){
            Log::error($e->getMessage());
            $type = 'error';
            $message = 'Something went wrong';
        }
        return [$type,$message];
    }
    public function deleteOrder(
        object $order
    ): array
    {
        try{
                $order->delete();
                $type = 'success';
                $message = 'Order Deleted successfully';

            }catch (\Exception $e){
                Log::error($e->getMessage());
                $type = 'error';
                $message = 'Something went wrong';
            }
            return [$type,$message];
    }



}
