<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Exports\DeliveryReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class DeliveryReportController extends Controller
{
    public function generate(Request $request)
    {
        $hasFilters = $request->filled('from_date') || $request->filled('to_date') || $request->filled('status');

        if ($hasFilters) {
            $query = Order::with(['customer', 'stock.product']);

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59',
                ]);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $orders = $query->latest()->paginate(10)->withQueryString();
        } else {
            // Return an empty LengthAwarePaginator
            $orders = Order::whereRaw('1 = 0')->paginate(10);
        }

        return view('reports.delivery', compact('orders'));
    }


    public function export(Request $request)
    {
        $filters = $request->only(['from_date', 'to_date', 'status']);
        $fileName = 'delivery-report-' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new DeliveryReportExport($filters), $fileName);
    }


    public function exportPdf(Request $request)
    {
        $query = \App\Models\Order::with(['customer', 'stock.product']);

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('order_ref', 'like', '%' . $request->search . '%');
        }

        $orders = $query->get();

        $pdf = Pdf::loadView('reports.deliver_pdf', compact('orders'));

        return $pdf->download('delivery_report.pdf');
    }
}
