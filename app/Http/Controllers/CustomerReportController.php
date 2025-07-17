<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FilteredCustomerExport;
use App\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;
class CustomerReportController extends Controller
{
   public function generate(Request $request)
    {

        $hasFilters = $request->filled('from_date') || $request->filled('to_date') || $request->filled('gender');


        if ($hasFilters) {
            $query = Customer::query();

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59',
                ]);
            }

            if ($request->filled('gender')) {
                $query->where('gender', $request->gender);
            }

           

            $customers = $query->latest()->paginate(10)->withQueryString();

        } else {
            $customers = new LengthAwarePaginator(
                collect([]),
                0,
                10,
                1,
                ['path' => LengthAwarePaginator::resolveCurrentPath()]
            );
        }

       

        return view('reports.customer', compact('customers'));
    }

    public function exportPdf(Request $request)
    {
        $customers = $this->filterCustomers($request);

        $pdf = Pdf::loadView('reports.customer-report-pdf', compact('customers'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('customer_report.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new FilteredCustomerExport($request), 'customer_report.xlsx');
    }

    private function filterCustomers($request)
    {
        $query = Customer::query();


        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        return $query->get();
    }
}
