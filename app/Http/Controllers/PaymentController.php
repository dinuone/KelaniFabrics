<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Services\PaymentService;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\RedirectResponse;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService=$paymentService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->query('search');
        $payments = $this->paymentService->getAll($search);

 
        return view('payment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('payment.manage');
    }

    public function export()
    {
        return Excel::download(new PaymentsExport, 'payment_report.xlsx');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        list($type,$message)=$this->paymentService->storePayment(
            paidDate: $request['paidDate'],
            paidAmount: $request['paidAmount'],
            method:$request['method'],
            discount:$request['discount'],
        );
         return redirect()->route('payment.index')->with($type,$message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        return view('payment.manage',compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        list($type,$message)=$this->paymentService->updatePayment(
            payment:$payment,
            paidDate: $request['paymentDate'],
            paidAmount: $request['paidAmount'],
            method:$request['method'],
            discount:$request['discount'],
        );
         return redirect()->route('payment.index')->with($type,$message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment):RedirectResponse
    {
        list($type,$message)=$this->paymentService->deletePayment(
            payment : $payment
        );
        return redirect()->route('payment.index')->with($type,$message);
    }

    public function exportPdf()
    {
        $payments = Payment::with(['order.stock.product'])->get();

        $pdf = Pdf::loadView('payment.pdf', compact('payments'))
                ->setPaper('a4', 'landscape');

        return $pdf->download('payment.pdf');
    }
}
