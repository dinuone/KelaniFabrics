<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Http\Requests\StoreDeliveryRequest;
use App\Http\Requests\UpdateDeliveryRequest;
use App\Services\DeliveryService;

class DeliveryController extends Controller
{
    protected DeliveryService $deliveryService;
    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService=$deliveryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->query('search'); // Get ?search= query
        $deliveries = $this->deliveryService->getAll($search); // Make sure this returns data

        return view('delivery.index', compact('deliveries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('delivery.manage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeliveryRequest $request)
    {
        list($type,$message)=$this->deliveryService->storeDelivery(
            status: $request['status'],
        );
         return redirect()->route('delivery.index')->with($type,$message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delivery $delivery)
    {
        return view('delivery.manage',compact('delivery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeliveryRequest $request, Delivery $delivery)
    {
        list($type,$message)=$this->deliveryService->updateDelivery(
            delivery:$delivery,
            status: $request['status'],
        );
         return redirect()->route('delivery.index')->with($type,$message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delivery $delivery)
    {
        list($type,$message)=$this->deliveryService->deleteDelivery(
            delivery : $delivery
        );
        return redirect()->route('delivery.index')->with($type,$message);
    }
}
