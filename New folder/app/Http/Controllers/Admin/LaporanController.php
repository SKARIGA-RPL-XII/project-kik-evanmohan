<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function export(Request $request)
    {
        $mode = $request->mode;

        if ($mode === 'harian') {

            $tanggal = $request->tanggal;

            $list = Order::whereDate('created_at', $tanggal)
                ->orderBy('created_at', 'ASC')
                ->get();

            $filename = "laporan-harian-$tanggal.xlsx";
        }
        else {

            $bulan = $request->bulan;
            $tahun = $request->tahun;

            $list = Order::whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->orderBy('created_at', 'ASC')
                ->get();

            $filename = "laporan-bulanan-$bulan-$tahun.xlsx";
        }

        return Excel::download(new LaporanExport($list), $filename);
    }
}
