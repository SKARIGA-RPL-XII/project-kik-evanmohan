{{-- @extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

<div class="card">
    <div class="card-header">
        <h5>Laporan Bulanan</h5>

        <form method="GET" class="row mt-3">

            <div class="col-md-4">
                <label>Bulan</label>
                <select name="bulan" class="form-control" onchange="this.form.submit()">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ sprintf('%02d', $i) }}"
                            {{ $bulan == sprintf('%02d', $i) ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="col-md-4">
                <label>Tahun</label>
                <input type="number" name="tahun" class="form-control"
                       value="{{ $tahun }}" onchange="this.form.submit()">
            </div>

        </form>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead class="bg-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Kode Order</th>
                    <th>Pembeli</th>
                    <th>Total Item</th>
                    <th>Total Bayar</th>
                    <th>Ongkir</th>
                    <th>Ekspedisi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($data as $row)
                    <tr>
                        <td>{{ $row->created_at->format('d M Y') }}</td>
                        <td>#{{ $row->kode_order }}</td>
                        <td>{{ $row->nama_pembeli }}</td>
                        <td>{{ $row->total_item }}</td>
                        <td>Rp {{ number_format($row->total_bayar, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($row->ongkir, 0, ',', '.') }}</td>
                        <td>{{ $row->ekspedisi }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-3 text-muted">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection --}}
