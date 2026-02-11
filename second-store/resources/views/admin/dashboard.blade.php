@extends('layouts.navbar.auth.app')

@section('content')
<div class="container-fluid py-4">
    {{-- BARIS 1: STATISTIC CARDS --}}
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Today's Money</p>
                                <h5 class="font-weight-bolder">$53,000</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Today's Users</p>
                                <h5 class="font-weight-bolder">2,300</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">New Clients</p>
                                <h5 class="font-weight-bolder">+3,462</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Sales</p>
                                <h5 class="font-weight-bolder">$103,430</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BARIS 2: DIAGRAM & CATEGORIES --}}
    <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="card z-index-2 h-100 shadow-sm">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <h6 class="text-capitalize"><i class="fas fa-chart-bar me-2 text-primary"></i>Produk Paling Laku</h6>
                </div>
                <div class="card-body p-3">
                    <div id="chart-produk-terlaris" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card h-100 shadow-sm">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Categories</h6>
                </div>
                <div class="card-body p-3">
                    <div style="max-height: 350px; overflow-y: auto;">
                        <ul class="list-group">
                            @forelse ($kategoris as $kategori)
                                <a href="{{ route('admin.kategori.index', $kategori->id) }}"
                                   class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center">
                                        <div class="icon icon-shape icon-sm me-3 shadow text-center">
                                            @if ($kategori->image)
                                                <img src="{{ asset('storage/' . $kategori->image) }}" class="rounded-circle" width="30" height="30">
                                            @else
                                                <i class="ni ni-folder-17 text-white opacity-10"></i>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark text-sm">{{ $kategori->nama_kategori }}</h6>
                                            <span class="text-xs">{{ $kategori->deskripsi ?? 'Tanpa deskripsi' }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <i class="ni ni-bold-right my-auto"></i>
                                    </div>
                                </a>
                            @empty
                                <li class="list-group-item text-center text-muted">Belum ada kategori</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BARIS 3: TOP SELLING PRODUCTS DENGAN IMAGE --}}
    <div class="row mt-4">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header pb-0 p-3 bg-transparent">
                    <h6 class="mb-0">Top Selling Products</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Qty Sold</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topProducts as $tp)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div>
                                                @if($tp->image)
                                                    <img src="{{ asset('storage/' . $tp->image) }}" class="avatar avatar-sm me-3" alt="product image">
                                                @else
                                                    <div class="avatar avatar-sm me-3 bg-gradient-secondary d-flex align-items-center justify-content-center">
                                                        <i class="ni ni-box-2 text-white text-xs"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $tp->nama_produk }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0 text-secondary">{{ $tp->total_qty }} pcs</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-success">Best Seller</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth.footer')
</div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const labels = {!! json_encode($topProducts->pluck('nama_produk')->toArray()) !!};
            const seriesData = {!! json_encode($topProducts->pluck('total_qty')->toArray()) !!};

            var options = {
                series: [{ name: 'Total Terjual', data: seriesData }],
                chart: { type: 'bar', height: 350, toolbar: { show: false } },
                plotOptions: {
                    bar: { borderRadius: 4, horizontal: false, columnWidth: '50%', distributed: true }
                },
                colors: ['#5e72e4', '#2dce89', '#11cdef', '#fb6340', '#f5365c'],
                xaxis: { categories: labels },
                legend: { show: false }
            };

            var chart = new ApexCharts(document.querySelector("#chart-produk-terlaris"), options);
            chart.render();
        });
    </script>
@endpush
