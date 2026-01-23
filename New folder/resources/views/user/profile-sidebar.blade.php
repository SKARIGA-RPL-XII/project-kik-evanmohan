<div class="profile-sidebar p-3 bg-white rounded shadow-sm">
    <div class="text-center mb-3">
        <img src="{{ asset('assets/images/profile.jpg') }}" class="rounded-circle" width="90">
        <h5 class="mt-2">{{ Auth::user()->username }}</h5>
        <button class="btn btn-sm btn-success mt-2">Tambah Nomor HP</button>
    </div>

    <hr>

    <div class="small text-secondary">Kotak Masuk</div>
    <ul class="list-unstyled mt-2">
        <li><a href="#" class="text-dark d-block py-1">Chat</a></li>
        <li><a href="#" class="text-dark d-block py-1">Ulasan</a></li>
        <li><a href="#" class="text-dark d-block py-1">Pesan Bantuan</a></li>
    </ul>
</div>

<style>
.profile-sidebar {
    width: 250px;
}
</style>
