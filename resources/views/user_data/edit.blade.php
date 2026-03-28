@extends('layouts.dashboard-layout')
@section('container')
    <div class="card">
        <div class="card-header bg-light">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-primary text-decoration-none">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('userData.index') }}" class="text-primary text-decoration-none">Menu User Data</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong class="text-dark">{!! session()->get('success') !!}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('editSuccess'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong class="text-dark">{!! session()->get('editSuccess') !!}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card-body">
            <form action="{{ route('userData.update-user', $data_user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
            <div class="row">

                <div class="col-md-auto">
                        <div class="mb-3 text-center">
                            <img id="previewImage"
                                src="{{ $data_user->image ? asset('storage/user_images/' . $data_user->image) : asset('img/avatars/1.png') }}"
                                class="img-thumbnail mb-3" style="max-width: 200px;" alt="Foto User">
                        </div>

                        <div class="mb-3">
                            <label for="uploadImage" class="form-label">Pilih Gambar</label>
                            <input class="form-control" type="file" id="uploadImage" name="image" accept="image/*">
                        </div>
                </div>

                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Edit Informasi User</h5>
                                <div class="mb-3">
                                    <label for="username" class="form-label fw-semibold">Nama</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        id="username" name="username" value="{{ old('username', $data_user->username) }}"
                                        placeholder="Masukkan nama" required>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $data_user->email) }}"
                                        placeholder="Masukkan email" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="posisi" class="form-label">Posisi Pekerjaan</label>
                                    <select class="form-select @error('posisi') is-invalid @enderror" name="posisi"
                                        id="posisi" required>
                                        <option value="" disabled
                                            {{ old('posisi', $data_user->posisi ?? '') == '' ? 'selected' : '' }}>
                                            -- Pilih Posisi --
                                        </option>

                                        <optgroup label="🔧 Production Position">
                                            @foreach (['Fitter', 'Helper', 'Welder', 'Supervisor'] as $pos)
                                                <option value="{{ $pos }} (Produksi)"
                                                    {{ old('posisi', $data_user->posisi ?? '') == "$pos (Produksi)" ? 'selected' : '' }}>
                                                    {{ $pos }} (Produksi)
                                                </option>
                                            @endforeach
                                        </optgroup>

                                        <optgroup label="🏭 Warehouse Position">
                                            @foreach (['Helper', 'Supervisor'] as $pos)
                                                <option value="{{ $pos }} Warehouse"
                                                    {{ old('posisi', $data_user->posisi ?? '') == "$pos Warehouse" ? 'selected' : '' }}>
                                                    {{ $pos }} Warehouse
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>

                                    @error('posisi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select @error('role') is-invalid @enderror" name="role"
                                        id="role" required>
                                        <option value="produksi"
                                            {{ old('role', $data_user->role ?? '') == 'produksi' ? 'selected' : '' }}>
                                            Produksi</option>
                                        <option value="warehouse_staff"
                                            {{ old('role', $data_user->role ?? '') == 'warehouse_staff' ? 'selected' : '' }}>
                                            Warehouse Staff</option>
                                    </select>

                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('userData.index') }}" class="btn btn-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card-title {
            font-weight: 600;
            color: #343a40;
        }

        .form-label {
            font-size: 14px;
            color: #495057;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.getElementById('uploadImage').addEventListener('change', function(e) {
            const preview = document.getElementById('previewImage');
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                console.log('Preloader found. It will hide after 3 seconds...');
                setTimeout(function() {
                    preloader.style.display = 'none'; // Sembunyikan preloader setelah 3 detik
                    console.log('Preloader hidden.');
                }, 1500); // Durasi 3000 ms = 3 detik
            } else {
                console.error('Preloader element not found!');
            }
        });

    const posisiSelect = document.getElementById('posisi');
    const roleSelect   = document.getElementById('role');

    function syncRole() {
        const posisi = posisiSelect.value;

        if (posisi.includes('(Produksi)')) {
            roleSelect.value = 'produksi';
        } else if (posisi.includes('Warehouse')) {
            roleSelect.value = 'warehouse_staff';
        }
        // Kalau admin, biarkan — admin tidak punya posisi khusus
    }

    // Jalankan saat halaman load (jaga konsistensi data lama)
    syncRole();

    // Jalankan saat posisi berubah
    posisiSelect.addEventListener('change', syncRole);
    </script>
@endpush
