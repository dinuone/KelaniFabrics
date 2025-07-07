<?php
namespace App\Services;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class PaymentService
{
  public function getAll($search = null)
    {
        $query = Payment::with(['order.stock.product', 'order.stock.color', 'order.stock.size']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('paid_date', 'LIKE', "%{$search}%")
                ->orWhere('paid_amount', 'LIKE', "%{$search}%")
                ->orWhere('method', 'LIKE', "%{$search}%")
                ->orWhere('discount', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('order', function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('order.stock.product', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('order.stock.color', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            })
            ->orWhereHas('order.stock.size', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        return $query->paginate(10);
    }


    public function storePayment(
        String $paidDate,
        String $paidAmount,
        String $method,
        String $discount,
    ):array {
        try{
        Payment::create([
            'paid_date' => $paidDate,
            'paid_amount' => $paidAmount,
            'method' => $method,
            'discount' => $discount,
         ]);
         $type = 'success';
         $message = 'Payment created successfully';
        }catch (\Exception $e){
            Log::error($e->getMessage());
            $type = 'error';
            $message = 'Something went wrong';
        }
        return [$type,$message];
    }
    public function updatePayment(
        Object $payment,
        String $paidDate,
        String $paidAmount,
        String $method,
        String $discount,
    ){
        try{
        $payment->update([
            'paid_date' => $paidDate,
            'paid_amount' => $paidAmount,
            'method' => $method,
            'discount' => $discount,
         ]);
         $type = 'success';
         $message = 'Payment updated successfully';
        }catch (\Exception $e){
            Log::error($e->getMessage());
            $type = 'error';
            $message = 'Something went wrong';
        }
        return [$type,$message];
    }
    public function deletePayment(
        object $payment
    ): array
    {
        try{
                $payment->delete();
                $type = 'success';
                $message = 'Payment delete successfully';

            }catch (\Exception $e){
                Log::error($e->getMessage());
                $type = 'error';
                $message = 'Something went wrong';
            }
            return [$type,$message];
    }



}

