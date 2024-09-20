<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class LaporanController extends Controller
{
    public function index()
    {
        // Menampilkan form untuk memilih periode laporan
        return view('contents.admin.laporan');
    }

    public function generate(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $period = $request->input('period');

        // Menyesuaikan format tanggal berdasarkan periode
        $format = $this->getDateFormat($period);

        // Query untuk mendapatkan data laporan
        $reportData = Transaksi::selectRaw("
            DATE_FORMAT(created_at, ?) as period,
            SUM(berat) as total_weight,
            SUM(total_harga) as total_revenue,
            SUM(total_harga) - SUM(harga_per_gram * berat) as profit
        ", [$format])
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('period')
        ->get()
        ->map(function($item) {
            return [
                'period' => $item->period,
                'total_weight' => $item->total_weight,
                'total_revenue' => $item->total_revenue,
                'profit' => $item->profit,
            ];
        });

        return view('contents.admin.laporan', compact('reportData'));
    }

    private function getDateFormat($period)
    {
        switch ($period) {
            case 'daily':
                return '%Y-%m-%d';
            case 'monthly':
                return '%Y-%m';
            case 'yearly':
                return '%Y';
            default:
                return '%Y-%m-%d';
        }
    }
}
