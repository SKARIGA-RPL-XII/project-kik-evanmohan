@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

<div class="container">

    {{-- ========================== --}}
    {{--  SELECT MODE LAPORAN      --}}
    {{-- ========================== --}}
    <div class="card mb-3">
        <div class="card-header">
            <form method="GET" class="row g-2">

                <div class="col-md-4">
                    <select name="mode" class="form-control" onchange="this.form.submit()">
                        <option value="harian"  {{ $mode == 'harian' ? 'selected' : '' }}>Laporan Harian</option>
                        <option value="bulanan" {{ $mode == 'bulanan' ? 'selected' : '' }}>Laporan Bulanan</option>
                    </select>
                </div>

                {{-- Inject parameter --}}
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
    <div class="card mb-4">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">Laporan Harian</h5>

            <div class="d-flex gap-2">

                <form method="GET" class="d-flex">
                    <input type="hidden" name="mode" value="harian">
                    <input type="date" name="tanggal" class="form-control"
                        value="{{ $tanggal }}" onchange="this.form.submit()">
                </form>

                {{-- tombol export --}}
        <a href="{{ route('admin.laporan.export', [
            'mode' => 'harian',
            'tanggal' => $tanggal
        ]) }}" class="btn btn-success btn-sm">
            Export Excel Harian
        </a>


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
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">Laporan Bulanan</h5>

            {{-- tombol export --}}
            <a href="{{ route('admin.laporan.export', [
                'mode' => 'bulanan',
                'bulan' => $bulan,
                'tahun' => $tahun
            ]) }}" class="btn btn-success btn-sm">
                Export Excel Bulanan
            </a>


        </div>

        <form method="GET" class="row g-2 mt-2 px-3 pb-3">

            <input type="hidden" name="mode" value="bulanan">

            <div class="col-md-4">
                <select name="bulan" class="form-control" onchange="this.form.submit()">
                    @foreach(range(1,12) as $b)
                        <option value="{{ sprintf('%02d',$b) }}"
                            {{ $bulan == sprintf('%02d',$b) ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <select name="tahun" class="form-control" onchange="this.form.submit()">
                    @foreach(range(date('Y') - 5, date('Y')) as $t)
                        <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>
                            {{ $t }}
                        </option>
                    @endforeach
                </select>
            </div>

        </form>

        <div class="card-body table-responsive">
            @include('admin.laporan.table', ['list' => $bulanan])
        </div>
    </div>
    @endif

</div>

@endsection
