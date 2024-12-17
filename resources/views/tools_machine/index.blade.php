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
                <li class="breadcrumb-item active" aria-current="page">Tools</li>
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
            <!-- Print Button -->
            <div class="row align-items-center mb-3">
                <!-- Tombol Tambah Data -->
                <div class="col-md-6 d-flex justify-content-start">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Tambah Data
                    </button>
                </div>

                <!-- Form Import Data -->
                <div class="col-md-6 d-flex justify-content-end">
                    <form action="{{ route('tools.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                        @csrf
                        <div class="me-2">
                            <label for="importFile" class="form-label mb-0">Import Data Excel:</label>
                            <input type="file" class="form-control form-control-sm @error('file') is-invalid @enderror" id="importFile" name="file" required>
                            @error('file')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success btn-sm">Import Data</button>
                    </form>
                </div>
            </div>

                <div class="row">

                    <div class="col-md-3 mb-3">
                        <label for="projectFilter" class="form-label">Filter Kategori Tipe Alat:</label>
                        <select id="projectFilter" class="form-select">
                            <option value="">Semua Kategori</option>
                            <option value="Alat Pemotong">Alat Pemotong(Cutting Tools)</option>
                            <option value="Mesin Las">Mesin las (Machine Welding)</option>
                            <option value="Alat Pengangkat">Alat Pengangkat</option>
                            <option value="Alat Pemukul ">Alat Pemukul (Lifting Equipment)</option>
                            <option value="Mesin Pembentuk">Mesin Pembentuk</option>
                            <option value="Alat Pemukul">Mesin Pemukul(Hammer)</option>
                            <option value="Alat Pengunci">Alat Pengunci</option>
                            <option value="Alat Pengukur">Alat Pengunci</option>
                            <option value="Alat Tester">Alat Tester</option>
                    </select>
                </div>
            </div>
            <!-- Add Button -->






            <div class="table-responsive">


                <table class="table table-bordered table-hover display" id="myTable7">
                    <thead>
                        <tr class="table-info text-center">
                            <th>No</th>
                            <th>Kode Alat</th>
                            <th>Nama Alat</th>
                            <th>Spesifikasi Alat</th>
                            <th>Jenis Alat</th>
                            <th>Tipe Alat</th>
                            <th class="text-center">Quantity Alat</th>
                            <th>Jenis Quantity</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_tools as $data )
                        <tr>
                            <td class="text-center">{{$loop->iteration;}}</td>
                            <td>{{$data->kode_alat}}</td>
                            <td>{{$data->nama_alat}}</td>
                            <td>{{$data->spesifikasi_alat}}</td>
                            <td>{{$data->jenis_alat}}</td>
                            <td>{{$data->tipe_alat}}</td>
                            <td class="text-center">{{$data->quantity}}</td>
                            <td>{{$data->jenis_quantity}}</td>
                            <td>
                                <div class="mb-1">
                                    <a href="{{route('tools.edit',$data->id)}}"><span class="btn btn-warning btn-sm">Edit</a></span>
                                </div>

                            </td>
                            {{-- <div class="mb-1">
                                         <a href=""><span class="btn btn-danger btn-sm">Hapus</a></span>
                                     </div> --}}

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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Menu Tools</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('tools.create')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_alat" class="form-label">Nama Alat Atau Mesin </label>
                        <input class="form-control rounded-top  @error('nama_alat') is-invalid @enderror" type="text"
                            name="nama_alat" placeholder="Harap Di Isi Tools Peralatan Atau Permesinan" required>
                        @error('nama_alat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="spesifikasi_alat" class="form-label">Spesifikasi Alat Atau Mesin </label>
                        <input class="form-control rounded-top @error('spesifikasi_alat') is-invalid @enderror"
                            type="text" name="spesifikasi_alat"
                            placeholder="Harap Di Isi Spesifikasi Peralatan Atau Permesinan" required>
                        @error('spesifikasi_alat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jenis_alat" class="form-label" name="jenis_alat">Jenis Alat </label>
                        <select class="form-select rounded-top @error('jenis_alat') is-invalid @enderror"
                            name="jenis_alat" required>
                            <option selected disabled>Pilih Jenis Alat</option>
                            <option value="Alat Pengangkat">Alat Pengangkat</option>
                            <option value="Alat Pemukul ">Alat Pemukul (Lifting Equipment)</option>
                            <option value="Alat Pengunci">Alat Pengunci</option>
                            <option value="Alat Pengukur">Alat Pengukur</option>
                            <option value="Alat Tester">Alat Tester</option>

                            @error('jenis_alat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tipe_alat" class="form-label" name="tipe_alat">Tipe Alat </label>
                        <select class="form-select rounded-top @error('tipe_alat') is-invalid @enderror"
                            name="tipe_alat" required>
                            <option selected disabled>Pilih Jenis Alat</option>
                            <option value="Kecil">Kecil</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Besar">Berat/Besar</option>
                            @error('tipe_alat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity Alat Atau Mesin </label>
                        <input class="form-control rounded-top @error('quantity') is-invalid @enderror" min="1" type="number"
                            name="quantity" placeholder="Harap Di Isi Spesifikasi Peralatan Atau Permesinan" required>
                        @error('quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jenis_quantity" class="form-label" name="jenis_quantity">Jenis Quantity Alat</label>
                        <select class="form-select rounded-top @error('jenis_quantity') is-invalid @enderror"
                            name="jenis_quantity" required>
                            <option selected disabled>Pilih Jenis Alat</option>
                            <option value="Unit">Unit</option>
                            <option value="Pcs">Pcs</option>
                            <option value="Set">Set</option>
                            @error('jenis_quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </select>
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
                dom: '<"d-flex justify-content-between"lBf>rtip', // Menempatkan tombol, filter, dan search secara sejajar
                buttons: [{
                        extend: 'excel',
                        text: 'Export Excel',
                        className: 'btn btn-success btn-sm',
                        exportOptions: {
                            modifier: {
                                search: 'applied' // Hanya data yang terlihat (terfilter) yang diexport
                            }
                        }
                    },
                    // {
                    //     extend: 'pdf',
                    //     text: 'Export PDF',
                    //     className: 'btn btn-danger btn-sm',
                    //     exportOptions: {
                    //         modifier: {
                    //             search: 'applied' // Hanya data yang terlihat (terfilter) yang diexport
                    //         }
                    //     }
                    // },
                ],
                layout: {
                    topStart: 'buttons'
                }
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
