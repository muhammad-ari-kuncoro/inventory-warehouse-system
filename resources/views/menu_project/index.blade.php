@extends('layouts.dashboard-layout')
@section('container')
<div class="card">
    <div class="card-header bg-light">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-primary text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Menu Project</li>
            </ol>
        </nav>
    </div>

    {{-- Session Notifikasi --}}
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


        <div class="row align-items-center">
            <!-- Dropdown Filter -->
            <div class="col-md-9 col-lg-6 mb-3">
                <label for="projectFilter" class="form-label">Filter Kategori Project:</label>
                <select id="projectFilter" class="form-select w-auto" style="max-width: 300px;">
                    <option value="">Semua Kategori</option>
                    <option value="General Industri">General Industri</option>
                    <option value="Oil Dan Migas">Oil Dan Migas</option>
                    <option value="Panas Bumi">Panas Bumi</option>
                </select>
            </div>
            <!-- Button Tambah Data -->
            <div class="col-md-3 col-lg-6 mb-3 d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Tambah Data
                </button>
            </div>
        </div>

        <!-- Add Button -->



        <div class="table-responsive">


            <table class="table table-bordered table-hover display" id="myTable7">
                <thead>
                    <tr class="table-info text-center">
                        <th>No</th>
                        <th>Kode Project</th>
                        <th>Tanggal</th>
                        <th>Nama Project</th>
                        <th>Sub Nama Project</th>
                        <th>Kategori Nama Project</th>
                        <th>No JO Project</th>
                        <th>No PO Project</th>
                        <th>Aksi </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menu_project as $data )
                    <tr class="text-center">

                        <td class="text-center">{{ $loop->iteration; }}</td>
                        <td>{{ $data->kode_project }}</td>
                        <td>{{$data->created_at->format('d-m-Y')}}</td>
                        <td>{{ $data->nama_project }}</td>
                        <td>{{ $data->sub_nama_project }}</td>
                        <td>{{ $data->kategori_project }}</td>
                        <td>{{ $data->no_jo_project }}</td>
                        <td>{{$data->no_po_project}}</td>
                        <td>
                            <div class="mb-1">
                                <a href="{{route('project.edit',$data->id)}}"><span
                                    class="btn btn-warning btn-sm mb-2"><i
                                        class='bx bx-edit-alt'></i></a></span></a></span>
                                        <a href="{{route('project.detail',$data->id)}}"><span
                                            class="btn btn-success btn-sm mb-2"><i class='bx bx-show'></i></a></span></a>
                            </div>


                            {{-- <div class="mb-1">
                            <a href=""><span class="btn btn-danger btn-sm">Hapus</a></span>
                        </div> --}}
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Menu Project</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('project.create') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_project" class="form-label">Nama Project </label>
                        <input class="form-control rounded-top  @error('nama_project') is-invalid @enderror" type="text"
                            name="nama_project" placeholder="Harap Di Isi Nama Project" required>
                        @error('nama_project')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="formFile" class="form-label">Sub Nama Project </label>
                        <input class="form-control rounded-top @error('sub_nama_project') is-invalid @enderror"
                            type="text" name="sub_nama_project" placeholder="Harap Di Isi Sub Nama Project" required>
                        @error('sub_nama_project')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="formFile" class="form-label" name="kategori_project">Kategori Nama Project
                        </label>
                        <select class="form-select rounded-top @error('kategori_project') is-invalid @enderror"
                            name="kategori_project" required>
                            <option selected disabled>Pilih Kategori Nama Project</option>
                            <option value="General Industri">General Industri</option>
                            <option value="Oil Dan Migas">Oil Dan Migas</option>
                            <option value="Panas Bumi">Panas Bumi</option>
                            @error('kategori_project')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                            @enderror
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="formFile" name="no_jo_project" class="form-label">No Jo Project </label>
                        <input class="form-control rounded-top @error('no_jo_project') is-invalid @enderror" type="text"
                            name="no_jo_project" placeholder="Harap Di Isi Sub Nama Project" required>
                        @error('no_jo_project')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="formFile" name="no_po_project" class="form-label">No PO Project </label>
                        <input class="form-control rounded-top @error('no_po_project') is-invalid @enderror" type="text"
                            name="no_po_project" placeholder="Harap Di Isi Sub Nama Project" required>
                        @error('no_po_project')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

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
        var table = $('#myTable7').DataTable({

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


@endpush
