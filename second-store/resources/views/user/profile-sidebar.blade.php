<div class="profile-sidebar bg-white rounded shadow-sm p-4 text-center">
    <!-- FOTO PROFIL -->
    <img
        src="{{ $user->image_url }}"
        class="rounded-circle mb-3 profile-avatar"
        alt="Foto Profil"
    >

    <!-- NAMA & NOMOR HP -->
    <h4 class="fw-bold mb-1">{{ $user->username }}</h4>
    <p class="text-muted mb-3">
        {{ $user->no_hp ?? 'Nomor HP belum ditambahkan' }}
    </p>

    <hr>

    <!-- MENU TAB -->
    <div class="small text-secondary fw-semibold mb-2">Pengaturan Akun</div>

    <ul class="list-unstyled profile-menu mb-0">
        <li>
            <a href="?tab=biodata"
               class="profile-link {{ $tab === 'biodata' ? 'active' : '' }}">
                <i class="bi bi-person me-2"></i>Biodata Diri
            </a>
        </li>
        <li>
            <a href="?tab=alamat"
               class="profile-link {{ $tab === 'alamat' ? 'active' : '' }}">
                <i class="bi bi-geo-alt me-2"></i>Alamat
            </a>
        </li>
        <li>
            <a href="?tab=favorit"
               class="profile-link {{ $tab === 'favorit' ? 'active' : '' }}">
                <i class="bi bi-heart me-2"></i>Favorit
            </a>
        </li>
    </ul>
</div>

<style>
/* SIDEBAR */
.profile-sidebar {
    width: 100%;
}

/* FOTO PROFIL */
.profile-avatar {
    width: 140px;
    height: 140px;
    object-fit: cover;
    border: 4px solid #e9ecef;
}

/* MENU */
.profile-menu li {
    margin-bottom: 10px;
}

.profile-link {
    display: block;
    padding: 10px 14px;
    border-radius: 8px;
    color: #212529;
    text-decoration: none;
    transition: all 0.2s ease;
}

/* Hover & Active diganti abu-abu */
.profile-link:hover {
    background-color: #f1f3f5;
    color: #6B7280; /* abu-abu */
}

.profile-link.active {
    background-color: #e9ecef;
    color: #374151; /* abu-abu gelap */
    font-weight: 600;
}
</style>
