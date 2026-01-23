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

        {{-- Hitung total --}}
        @php
            $sum_item = 0;
            $sum_bayar = 0;
            $sum_ongkir = 0;
        @endphp

        @forelse ($list as $row)

            @php
                $sum_item  += $row->total_item;
                $sum_bayar += $row->total_bayar;
                $sum_ongkir += $row->ongkir;
            @endphp

            <tr>
                <td>{{ $row->created_at->format('d M Y') }}</td>
                <td>#{{ $row->kode_order }}</td>
                <td>{{ $row->nama_pembeli }}</td>
                <td>{{ $row->total_item }}</td>
                <td>Rp {{ number_format($row->total_bayar,0,',','.') }}</td>
                <td>Rp {{ number_format($row->ongkir,0,',','.') }}</td>
                <td>{{ $row->ekspedisi }}</td>
            </tr>

        @empty

            <tr>
                <td colspan="7" class="text-center text-muted py-3">Tidak ada data.</td>
            </tr>

        @endforelse
    </tbody>

    {{-- ========================== --}}
    {{--       BARIS TOTAL         --}}
    {{-- ========================== --}}
    @if(count($list) > 0)
    <tfoot>
        <tr class="bg-light fw-bold">
            <td colspan="3" class="text-end">TOTAL :</td>
            <td>{{ $sum_item }}</td>
            <td>Rp {{ number_format($sum_bayar,0,',','.') }}</td>
            <td>Rp {{ number_format($sum_ongkir,0,',','.') }}</td>
            <td></td>
        </tr>
    </tfoot>
    @endif

</table>
