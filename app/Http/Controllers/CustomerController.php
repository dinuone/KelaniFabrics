<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Services\CustomerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Exports\CustomerExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;


class CustomerController extends Controller
{
    protected CustomerService $customerService;
    public function __construct(CustomerService $customerService)
    {
        $this->customerService=$customerService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->query('search');
        $customers = $this->customerService->getAll($search);
        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.manage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        list($type,$message)=$this->customerService->storeCustomer(
            custFName: $request['custFName'],
            custLName: $request['custLName'],
            email:$request['email'],
            address:$request['address'],
            gender:$request['gender'],
            contactNumber: $request['contactNumber'],
        );
        return redirect()->route('customer.index')->with($type,$message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customer.manage',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        list($type,$message)=$this->customerService->updateCustomer(
            customer:$customer,
            custFName: $request['custFName'],
            custLName: $request['custLName'],
            email:$request['email'],
            address:$request['address'],
            gender:$request['gender'],
        );
        return redirect()->route('customer.index')->with($type,$message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        list($type,$message)=$this->customerService->deleteCustomer(
            customer : $customer
        );
        return redirect()->route('customer.index')->with($type,$message);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $results = \DB::table('customers')
            ->select(
                'id',
                \DB::raw("CONCAT(cust_fname, ' ', IFNULL(cust_lname, '')) as name"),
                'contact_number',
                'address'
            )
            ->whereNull('deleted_at') // exclude soft deleted
            ->whereRaw("CONCAT(cust_fname, ' ', IFNULL(cust_lname, '')) LIKE ?", ["%{$query}%"])
            ->limit(10)
            ->get();

        return response()->json($results);
    }

    public function export()
    {
        return Excel::download(new CustomerExport, 'customers.xlsx');
    }


    public function exportPdf()
    {
        $customers = Customer::all();

        $pdf = Pdf::loadView('customer.pdf', compact('customers'))
                ->setPaper('a4', 'landscape');

        return $pdf->download('customers.pdf');
    }


}
