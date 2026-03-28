@extends('layouts.dashboard-layout')
@section('container')
<div class="card">
    <div class="card-header bg-light">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-primary text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Menu User Data</li>
            </ol>
        </nav>
    </div>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong class="text-dark">{!! session()->get('success') !!}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif (session('delete'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong class="text-dark">Data Telah Dihapus</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif (session('editSuccess'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong class="text-dark">{!! session()->get('editSuccess') !!}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card-body">
        <div class="row">
            <div class="row">
                <div class="col-md-auto">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 text-center">
                            <img id="previewImage"
                                 src="{{ $data_user->image ? asset('storage/user_images/' . $data_user->image) : asset('img/avatars/1.png') }}"
                                 class="img-thumbnail mb-3" style="max-width: 200px;" alt="Foto User">
                        </div>
                    </form>
                </div>
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Informasi User (Pengguna)</h5>

                        <div class="mb-3">
                            <strong>Nama:</strong>
                            <div class="text-muted">{{ $data_user->username }}</div>
                        </div>

                        <div class="mb-3">
                            <strong>Email:</strong>
                            <div class="text-muted">{{ $data_user->email }}</div>
                        </div>

                        <div class="mb-3">
                            <strong>Role:</strong>
                            <div class="text-muted">{{ $data_user->role }}</div>
                        </div>

                        <div class="mb-3">
                            <strong>Posisi:</strong>
                            <div class="text-muted">{{ $data_user->posisi }}</div>
                        </div>

                        <div class="mb-4">
                            <strong>Tanggal Bergabung:</strong>
                            <div class="text-muted">{{ $data_user->created_at->format('d M Y') }}</div>
                        </div>
                            <a href="{{ route('userData.index') }}" class="btn btn-secondary">Batal</a>
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

    .text-muted {
        font-size: 15px;
    }
</style>
@endpush
@push('scripts')
<script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script src="//cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
<script src="//cdn.datatables.net/buttons/3.2.0/js/buttons.dataTables.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/3.2.0/js/buttons.print.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            console.log('Preloader found. It will hide after 3 seconds...');
            setTimeout(function () {
                preloader.style.display = 'none'; // Sembunyikan preloader setelah 3 detik
                console.log('Preloader hidden.');
            }, 1500); // Durasi 3000 ms = 3 detik
        } else {
            console.error('Preloader element not found!');
        }
    });

</script>
<script>
    $(document).ready(function () {
        // Inisialisasi DataTable
        var table = $('#myTable5').DataTable({

        });

        $('#projectFilter').on('change', function () {
            var projectFilter = $(this).val(); // Ambil nilai dropdown

            // Terapkan filter pada kolom Kategori Project (index 3)
            table.column(4).search(projectFilter).draw();
        });

    });

    function updateDateTime() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        document.getElementById('currentDateTime').textContent = now.toLocaleDateString('id-ID', options);
    }

    // Jalankan fungsi pertama kali
    updateDateTime();

    // Perbarui waktu setiap detik
    setInterval(updateDateTime, 1000);

</script>
<script>
    document.getElementById('uploadImage').addEventListener('change', function (e) {
        const preview = document.getElementById('previewImage');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>

<!-- Preview JS -->
<script>
    document.getElementById('uploadImage').addEventListener('change', function (e) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('previewImage').src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    });
</script>



@endpush
