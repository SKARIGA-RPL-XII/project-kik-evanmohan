{{-- resources/views/user/alamat.blade.php --}}

<h5 class="mb-4">Daftar Alamat Pengiriman</h5>

{{-- Notifikasi sukses --}}
@if(session('success'))
    <div class="alert alert-success p-3 rounded mb-3">
        {{ session('success') }}
    </div>
@endif

{{-- Kalau belum ada alamat --}}
@if(auth()->user()->alamats->count() == 0)
    <div class="text-center py-5 text-muted">
        <i class="bi bi-geo-alt fs-1"></i>
        <p class="mt-3">Belum ada alamat tersimpan</p>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahAlamat">
            + Tambah Alamat Pertama
        </button>
    </div>
@else

    {{-- TOMBOL TAMBAH ALAMAT BARU --}}
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahAlamat">
            + Tambah Alamat Baru
        </button>
    </div>

    @php
        // --- SORTING: Alamat utama muncul paling atas ---
        $alamats = auth()->user()->alamats->sortByDesc('is_utama');
    @endphp

    {{-- Loop semua alamat user --}}
    @foreach($alamats as $alamat)
        <div class="p-4 bg-light rounded mb-3 border {{ $alamat->is_utama ? 'border-primary border-3' : '' }} position-relative">

            @if($alamat->is_utama)
                <span class="badge bg-success position-absolute top-0 end-0 mt-2 me-3">
                    Alamat Utama
                </span>
            @endif

            <div class="d-flex justify-content">
                <h6 class="mb-1">{{ $alamat->nama_penerima }}</h6>
                <p class="mb-1 small text-muted">
                    {{ $alamat->alamat_lengkap }}<br>
                    {{ $alamat->kecamatan }}, {{ $alamat->kota}}, {{ $alamat->provinsi }} {{ $alamat->kode_pos }}
                    @if($alamat->patokan)
                        <br><small class="text-primary">Patokan: {{ $alamat->patokan }}</small>
                    @endif
                </p>
            </div>

            <div class="mt-3 d-flex gap-2 flex-wrap">
                <!-- Tombol Edit -->
                <button type="button" class="btn btn-sm btn-outline-warning"
                        onclick="editAlamat({{ $alamat->toJson() }})">
                    Ubah
                </button>

                <!-- Tombol Hapus -->
                <form action="{{ route('alamat.destroy', $alamat->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Yakin hapus alamat ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>

                <!-- Tombol Jadikan Utama -->
                @if(!$alamat->is_utama)
                    <form action="{{ route('alamat.setPrimary', $alamat->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-success">
                            Jadikan Utama
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach
@endif

{{-- Modal Tambah/Edit Alamat --}}
<div class="modal fade" id="modalTambahAlamat" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="formAlamat" action="{{ route('alamat.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="POST">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Alamat Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label>Nama Penerima <span class="text-danger">*</span></label>
                            <input type="text" name="nama_penerima" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label>Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="alamat_lengkap" rows="3" class="form-control" required></textarea>
                        </div>
                        <div class="col-12">
                            <label>Patokan (opsional)</label>
                            <input type="text" name="patokan" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Kecamatan <span class="text-danger">*</span></label>
                            <input type="text" name="kecamatan" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Kota/Kabupaten <span class="text-danger">*</span></label>
                            <input type="text" name="kota" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Provinsi <span class="text-danger">*</span></label>
                            <input type="text" name="provinsi" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Kode Pos <span class="text-danger">*</span></label>
                            <input type="text" name="kode_pos" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Alamat</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function editAlamat(data) {
    const form = document.getElementById('formAlamat');
    document.querySelector('#modalTambahAlamat .modal-title').textContent = 'Edit Alamat';

    form.action = `/alamat/${data.id}`;
    form.querySelector('[name="_method"]').value = 'PUT';

    form.nama_penerima.value = data.nama_penerima;
    form.alamat_lengkap.value = data.alamat_lengkap;
    form.patokan.value = data.patokan || '';
    form.kecamatan.value = data.kecamatan;
    form.kota.value = data.kota;
    form.provinsi.value = data.provinsi;
    form.kode_pos.value = data.kode_pos;

    new bootstrap.Modal(document.getElementById('modalTambahAlamat')).show();
}

// Reset form saat modal ditutup
document.getElementById('modalTambahAlamat').addEventListener('hidden.bs.modal', function () {
    const form = document.getElementById('formAlamat');
    form.reset();
    form.action = "{{ route('alamat.store') }}";
    form.querySelector('[name="_method"]').value = 'POST';
    document.querySelector('#modalTambahAlamat .modal-title').textContent = 'Tambah Alamat Baru';
});
</script>
