<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;
use App\Services\FaqService;
use Illuminate\Http\RedirectResponse;

class FaqController extends Controller
{
    protected FaqService $faqService;
    public function __construct(FaqService $faqService)
    {
        $this->faqService=$faqService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->query('search'); // Get ?search= query
        $faqs = $this->faqService->getAll($search); // Make sure this returns data

        return view('faq.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('faq.manage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaqRequest $request)
    {
        list($type,$message)=$this->faqService->storeFaq(
            topic: $request['topic'],
            comment: $request['comment'],
            email:$request['email'],
        );
         return redirect()->route('faq.index')->with($type,$message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        return view('faq.manage',compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaqRequest $request, Faq $faq)
    {
        list($type,$message)=$this->faqService->updatefaq(
            faq:$faq,
            topic: $request['topic'],
            comment: $request['comment'],
            email:$request['email'],
        );
         return redirect()->route('faq.index')->with($type,$message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq):RedirectResponse
    {
        list($type,$message)=$this->faqService->deleteFaq(
            faq : $faq
        );
        return redirect()->route('faq.index')->with($type,$message);
    }

}
