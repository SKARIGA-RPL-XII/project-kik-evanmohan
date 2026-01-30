<div class="bg-white rounded shadow-sm overflow-hidden">
    <!-- Tabs -->
    <ul class="nav nav-tabs border-0">
        <li class="nav-item">
            <a class="nav-link px-4 py-3 rounded-0 {{ $tab === 'biodata' ? 'active-tab' : 'text-dark' }}"
                href="?tab=biodata">
                <i class="bi bi-person me-2"></i>Biodata Diri
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link px-4 py-3 rounded-0 {{ $tab === 'alamat' ? 'active-tab' : 'text-dark' }}"
                href="?tab=alamat">
                <i class="bi bi-geo-alt me-2"></i>Daftar Alamat
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link px-4 py-3 rounded-0 {{ $tab === 'pesanan' ? 'active-tab' : 'text-dark' }}"
                href="?tab=pesanan">
                <i class="bi bi-bag me-2"></i>Riwayat Pesanan
            </a>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link px-4 py-3 rounded-0 {{ $tab === 'favorit' ? 'active-tab' : 'text-dark' }}"
                href="?tab=favorit">
                <i class="bi bi-heart me-2"></i>Favorit
            </a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="p-4" style="min-height: 500px;">
        @if($tab === 'biodata')
            @include('user.biodata')

        @elseif($tab === 'alamat')
            @include('user.alamat')

        @elseif($tab === 'favorit')
            @include('user.favorit', ['favorits' => $favorits ?? collect()])

        @else
            @include('user.biodata') {{-- fallback --}}
        @endif
    </div>
</div>

<style>
/* Tabs */
.nav-tabs .nav-link {
    border: none;
    color: #374151; /* abu-abu gelap default */
    transition: all 0.2s ease;
}

.nav-tabs .nav-link:hover {
    background-color: #f1f3f5; /* abu-abu hover */
    color: #6B7280; /* abu-abu medium */
}

.nav-tabs .nav-link.active-tab {
    background-color: #e9ecef; /* abu-abu terang */
    color: #374151; /* abu-abu gelap */
    font-weight: 600;
}
</style>
