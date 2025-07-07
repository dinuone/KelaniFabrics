<?php
namespace App\Services;
use App\Models\Faq;
use Illuminate\Support\Facades\Log;

class FaqService
{
    public function getAll($search = null){

        $query = Faq::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('topic', 'LIKE', "%{$search}%")
                  ->orWhere('comment', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");

            });
        }

        return $query->paginate(10);
        //return Faq::paginate(10);
    }

    public function storeFaq(
        String $topic,
        String $comment,
        String $email,
    ):array {
        try{
        Faq::create([
            'topic' => $topic,
            'comment' => $comment,
            'email' => $email,
         ]);
         $type = 'success';
         $message = 'Faq created successfully';
        }catch (\Exception $e){
            Log::error($e->getMessage());
            $type = 'error';
            $message = 'Something went wrong';
        }
        return [$type,$message];
    }
    public function updateFaq(
        Object $faq,
        String $topic,
        String $comment,
        String $email,
    ){
        try{
        $faq->update([
            'topic' => $topic,
            'comment' => $comment,
            'email' => $email,
         ]);
         $type = 'success';
         $message = 'Faq updated successfully';
        }catch (\Exception $e){
            Log::error($e->getMessage());
            $type = 'error';
            $message = 'Something went wrong';
        }
        return [$type,$message];
    }
    public function deleteFaq(
        object $faq
    ): array
    {
        try{
                $faq->delete();
                $type = 'success';
                $message = 'Faq delete successfully';

            }catch (\Exception $e){
                Log::error($e->getMessage());
                $type = 'error';
                $message = 'Something went wrong';
            }
            return [$type,$message];
    }



}
