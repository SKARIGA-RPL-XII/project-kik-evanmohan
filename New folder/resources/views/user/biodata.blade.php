<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-4 text-center">
            <img id="previewImage"
                 src="{{ $user->image_url }}"
                 class="img-fluid rounded mb-2" style="max-height: 200px;">
            <input type="file" name="image" id="image" class="form-control mb-2" onchange="previewImage(event)">
        </div>

        <div class="col-md-8">
            <h5>Ubah Biodata Diri</h5>

            <div class="mb-3">
                <label for="username" class="form-label"><strong>Nama</strong></label>
                <input type="text" class="form-control" name="username" id="username"
                       value="{{ old('username', $user->username) }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label"><strong>Email</strong></label>
                <input type="email" class="form-control" name="email" id="email"
                       value="{{ old('email', $user->email) }}">
            </div>

            <div class="mb-3">
                <label for="no_hp" class="form-label"><strong>Nomor HP</strong></label>
                <input type="text" class="form-control" name="no_hp" id="no_hp"
                       value="{{ old('no_hp', $user->no_hp) }}">
            </div>

            <button type="submit" class="btn btn-success mt-2">Simpan Perubahan</button>
        </div>
    </div>
</form>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        document.getElementById('previewImage').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
