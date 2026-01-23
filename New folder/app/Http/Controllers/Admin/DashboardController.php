<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function admin()
    {
        $kategoris = Kategori::latest()->get();

        // Ambil penghasilan per bulan tahun ini
        $income = DB::table('orders')
            ->selectRaw('MONTH(created_at) as bulan, SUM(total_harga) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $labels = [];
        $data = [];
        $tableData = [];

        for ($i = 1; $i <= 12; $i++) {
            $found = $income->firstWhere('bulan', $i);
            $labels[] = date('M', mktime(0,0,0,$i,1));
            $data[] = $found ? $found->total : 0;
            $tableData[] = [
                'bulan' => date('F', mktime(0,0,0,$i,1)),
                'total' => $found ? $found->total : 0
            ];
        }

        return view('admin.dashboard', compact('kategoris', 'labels', 'data', 'tableData'));
    }

    // METHOD LAIN TETAP (JANGAN DIHAPUS)
    public function profile()
    {
        return view('admin.profile');
    }

    public function billing()
    {
        return view('admin.billing');
    }

    public function management()
    {
        return view('admin.management');
    }
}
