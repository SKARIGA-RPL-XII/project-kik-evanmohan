<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanPesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanPesananController extends Controller
{
    public function index(Request $request)
    {
        // Mode default harian
        $mode = $request->mode ?? 'harian';

        // HARlAN
        $tanggal = $request->tanggal ?? Carbon::today()->toDateString();
        $harian = LaporanPesanan::whereDate('created_at', $tanggal)
            ->orderBy('created_at', 'desc')
            ->get();

        // BULANAN
        $bulan  = $request->bulan ?? Carbon::now()->format('m');
        $tahun  = $request->tahun ?? Carbon::now()->format('Y');

        $bulanan = LaporanPesanan::whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.laporan.index', compact(
            'mode',
            'tanggal',
            'bulan',
            'tahun',
            'harian',
            'bulanan'
        ));
    }
}
