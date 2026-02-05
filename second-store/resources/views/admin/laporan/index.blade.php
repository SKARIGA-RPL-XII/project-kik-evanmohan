@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<div class="container">

    {{-- ========================== --}}
    {{--  SELECT MODE LAPORAN      --}}
    {{-- ========================== --}}
    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-header bg-white">
            <form method="GET" class="row g-2">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Pilih Mode</label>
                    <select name="mode" class="form-control" onchange="this.form.submit()">
                        <option value="harian"  {{ $mode == 'harian' ? 'selected' : '' }}>Laporan Harian</option>
                        <option value="bulanan" {{ $mode == 'bulanan' ? 'selected' : '' }}>Laporan Bulanan</option>
                    </select>
                </div>

                @if ($mode == 'harian')
                    <input type="hidden" name="tanggal" value="{{ $tanggal }}">
                @else
                    <input type="hidden" name="bulan"  value="{{ $bulan }}">
                    <input type="hidden" name="tahun"  value="{{ $tahun }}">
                @endif
            </form>
        </div>
    </div>


    {{-- ========================== --}}
    {{--        TAMPIL HARIAN       --}}
    {{-- ========================== --}}
    @if ($mode == 'harian')
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-white">
            <h5 class="mb-0 fw-bold">Laporan Harian</h5>
            <div class="d-flex gap-2">
                <form method="GET" class="d-flex">
                    <input type="hidden" name="mode" value="harian">
                    <input type="date" name="tanggal" class="form-control form-control-sm"
                        value="{{ $tanggal }}" onchange="this.form.submit()">
                </form>

                <button type="button"
                    onclick="confirmExport('{{ route('admin.laporan.export', ['mode' => 'harian', 'tanggal' => $tanggal]) }}', 'Harian ({{ $tanggal }})')"
                    class="btn btn-success btn-sm px-3">
                    <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                </button>
            </div>
        </div>

        <div class="card-body table-responsive">
            @include('admin.laporan.table', ['list' => $harian])
        </div>
    </div>
    @endif



    {{-- ========================== --}}
    {{--        TAMPIL BULANAN      --}}
    {{-- ========================== --}}
    @if ($mode == 'bulanan')
    <div class="card border-0 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-white">
            <h5 class="mb-0 fw-bold">Laporan Bulanan</h5>
            <button type="button"
                onclick="confirmExport('{{ route('admin.laporan.export', ['mode' => 'bulanan', 'bulan' => $bulan, 'tahun' => $tahun]) }}', 'Bulanan ({{ $bulan }}-{{ $tahun }})')"
                class="btn btn-success btn-sm px-3">
                <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
            </button>
        </div>

        <div class="px-3">
            <form method="GET" class="row g-2 mt-2 pb-3 border-bottom">
                <input type="hidden" name="mode" value="bulanan">
                <div class="col-md-3">
                    <select name="bulan" class="form-control form-control-sm" onchange="this.form.submit()">
                        @foreach(range(1,12) as $b)
                            <option value="{{ sprintf('%02d',$b) }}"
                                {{ $bulan == sprintf('%02d',$b) ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="tahun" class="form-control form-control-sm" onchange="this.form.submit()">
                        @foreach(range(date('Y') - 5, date('Y')) as $t)
                            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive">
            @include('admin.laporan.table', ['list' => $bulanan])
        </div>
    </div>
    @endif

</div>

{{-- Script SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmExport(url, periode) {
        Swal.fire({
            title: 'Export Laporan?',
            text: "Anda akan mengunduh laporan Excel untuk periode " + periode,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2dce89',
            cancelButtonColor: '#f5365c',
            confirmButtonText: 'Ya, Download!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Menampilkan loading sementara sebelum download dimulai
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Mengalihkan ke URL export
                window.location.href = url;

                // Menutup SweetAlert setelah jeda singkat (karena browser akan menangani download)
                setTimeout(() => {
                    Swal.close();
                }, 2000);
            }
        })
    }
</script>
@endsection
