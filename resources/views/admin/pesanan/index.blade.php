@extends('layouts.app')

@section('content')
<h3>Kelola Pesanan</h3>
<table class="table mt-3">
    <tr><th>Kode Pesanan</th><th>Pembeli</th><th>Status</th><th>Aksi</th></tr>
    @foreach($pesanan as $p)
    <tr>
        <td>{{ $p->kode_pesanan }}</td>
        <td>{{ $p->user->nama }}</td>
        <td>{{ $p->status_bayar }} / {{ $p->status_verifikasi }}</td>
        <td>
            <a href="{{ route('pesanan.show',$p) }}" class="btn btn-sm btn-info">Detail</a>
            <form action="{{ route('pesanan.update',$p) }}" method="POST" style="display:inline">
                @csrf @method('PUT')
                <button class="btn btn-sm btn-success">Verifikasi</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
