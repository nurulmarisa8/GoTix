<?php
// app/Http/Controllers/Admin/ReportController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
// use DB;

class ReportController extends Controller
{
    /**
     * Tampilkan halaman laporan penjualan tiket.
     */
    public function salesReport(Request $request)
    {
        // Logika untuk mengambil data penjualan, misalnya:
        // $totalSales = Booking::where('status', 'approved')->sum('total_price');
        // $bookingsData = Booking::with('event')->filter($request->all())->get();

        $reportData = [
            'total_sales' => 15000000, // Data dummy
            'total_tickets_sold' => Booking::where('status', 'approved')->sum('quantity'),
        ];
        
        return view('admin.reports.sales_report', compact('reportData'));
    }
}