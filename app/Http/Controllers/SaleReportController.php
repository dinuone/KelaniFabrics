<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Payment;
use App\Exports\SaleReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class SaleReportController extends Controller
{
   

    public function export(Request $request)
    {
        $filters = $request->only(['from_date', 'to_date', 'status']);
        $fileName = 'sale-report-' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new SaleReportExport($filters), $fileName);
    }

    public function generate(Request $request)
    {
        $hasFilters = $request->filled('from_date') || $request->filled('to_date') || $request->filled('status') || $request->filled('search');

        $totalAmount = 0;

        if ($hasFilters) {
            $query = Payment::with(['order.stock.product', 'order']);

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59',
                ]);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

           

            // Clone to calculate total before pagination
            $totalAmount = (clone $query)->get()->sum(function ($payment) {
                return $payment->amount ?? 0;
            });

            $payments = $query->latest()->paginate(10)->withQueryString();
        } else {
            $payments = new LengthAwarePaginator(
                collect([]),
                0,
                10,
                1,
                ['path' => LengthAwarePaginator::resolveCurrentPath()]
            );
        }

       

        return view('reports.sale', compact('payments', 'totalAmount'));
    }



}
