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
                <li class="breadcrumb-item active" aria-current="page">Consumables</li>
            </ol>
        </nav>
    </div>
    <h5 class="card-header text-center">
        Dashboard Menu Consumable Realtime
        <br>
        <span id="currentDateTime" class="ms-2 text-muted"></span>
    </h5>

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
                    <form action="{{ route('consumable.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
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
                        <label for="projectFilter" class="form-label">Filter Jenis Consumable:</label>
                        <select id="projectFilter" class="form-select">
                            <option value="">Semua Kategori</option>
                            <option value="General Consumable">General Consumable</option>
                            <option value="Welding Consumable">Welding Consumable</option>
                            <option value="Safety Consumable">Safety Consumable</option>
                    </select>
                </div>
            </div>
            <!-- Add Button -->






            <div class="table-responsive">


                <table class="table table-bordered table-hover display" id="myTable7">
                    <thead>
                        <tr class="table-info text-center">
                            <th>No</th>
                            <th>Kode Consumable</th>
                            <th>Nama Consumables</th>
                            <th>Spesifikasi Consumables</th>
                            <th>Quantity</th>
                            <th>Jenis Quantity</th>
                            <th>Jenis Consumables</th>
                            <th>Harga Consumable</th>
                            <th>Nama Project</th>
                            <th>Sub nama Project</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_consumables as $data )
                        <tr>
                            <td class="text-center">{{$loop->iteration}}</td>
                            <td>{{$data->kode_consumable}}</td>
                            <td>{{$data->nama_consumable}}</td>
                            <td>{{$data->spesifikasi_consumable}}</td>
                            @if (0)
                            <td class="text-center bg-danger">{{$data->quantity}}</td>
                            @else
                            <td class="text-center">{{$data->quantity}}</td>
                            @endif
                            <td class="text-center">{{$data->jenis_quantity}}</td>
                            <td>{{$data->jenis_consumable}}</td>
                            <td class="text-center">Rp.{{$data->harga_consumable}}</td>
                            <td>{{$data->project->nama_project ?? '-' }}</td>
                            <td class="text-center">{{$data->project->sub_nama_project ?? '-' }} </td>
                            <td>
                                <div class="mb-auto">
                                    <a href="{{route('consumable.edit',$data->id)}}" class="btn btn-warning btn-sm">Edit</a>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Form Tambah Consumable</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('consumable.create')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_consumable" class="form-label">Nama Consumable</label>
                            <input class="form-control rounded-top  @error('nama_consumable') is-invalid @enderror"
                                type="text" name="nama_consumable" placeholder="Harap Di Isi Nama Consumable" required>
                            @error('nama_consumable')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="spesifikasi_consumable" class="form-label">Spesifikasi Consumable</label>
                            <input class="form-control rounded-top @error('spesifikasi_consumable') is-invalid @enderror"
                                type="text" name="spesifikasi_consumable" placeholder="Harap Di Isi Spesifikasi Consumable"
                                required>
                            @error('spesifikasi_consumable')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity Consumable</label>
                            <input class="form-control rounded-top @error('quantity') is-invalid @enderror" type="number"
                                name="quantity" placeholder="Harap Di Isi Quantity Material" required>
                            @error('quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="jenis_quantity" class="form-label" name="jenis_quantity">Jenis Quantity </label>
                            <select class="form-select rounded-top @error('jenis_quantity') is-invalid @enderror" name="jenis_quantity" required>
                                <option selected disabled>Pilih Jenis Quantity</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Batang">Batang</option>
                                <option value="Set">Set</option>
                                <option value="Karung">Karung</option>
                                <option value="Box">Box</option>
                                <option value="Pasang">Pasang</option>
                                <option value="Kilo Gram">KG</option>
                                <option value="Lusin">Lusin</option>
                                @error('jenis_quantity')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="jenis_consumable" class="form-label" name="jenis_consumable">Jenis Consumable </label>
                            <select class="form-select rounded-top @error('jenis_consumable') is-invalid @enderror"
                                name="jenis_consumable" required>
                                <option selected disabled>Pilih Jenis Consumable</option>
                                <option value="General Consumable">General Consumable</option>
                                <option value="Welding Consumable">Welding Consumable</option>
                                <option value="Safety Consumable">Safety Consumable</option>

                                @error('jenis_consumable')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </select>
                        </div>

                        <label for="harga_consumable" class="form-label" name="harga_consumable">Harga Consumable </label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control" name="harga_consumable" id="hargaConsumable" aria-label="Amount (to the nearest Rupiah)" oninput="formatCurrency(this)">
                            <span class="input-group-text">.00</span>
                        </div>


                        <div class="mb-3">
                            <label for="project_id" class="form-label" name="project_id">Nama Kategori Project</label>
                            <select class="form-select rounded-top @error('project_id') is-invalid @enderror"
                                name="project_id" required>
                                <option selected disabled>Pilih Kategori Project</option>
                                @foreach ($data_project as $data )
                                <option value="{{ $data->id }}">{{ $data->nama_project }} | {{ $data->sub_nama_project }} | NO JO : {{ $data->no_jo_project }} </option>
                                @error('project_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                @endforeach

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
    <style>
        .bg-danger {
            background-color: #f8d7da !important; /* Latar belakang merah muda */
        }
    </style>
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
                ],
                layout: {
                    topStart: 'buttons'
                },
                drawCallback: function () {
                    // Loop melalui semua baris tabel setelah DataTable digambar ulang
                    $('#myTable7 tbody tr').each(function () {
                        // Ambil nilai quantity dari kolom ke-4 (index 4)
                        var quantity = $(this).find('td').eq(4).text().trim();

                        // Jika quantity == 0, tambahkan kelas 'bg-danger' untuk merubah warna latar belakang
                        if (quantity == '0') {
                            $(this).addClass('bg-danger text-white'); // Menambahkan teks putih untuk kontras
                        } else {
                            $(this).removeClass('bg-danger text-white');
                        }
                    });
                }
            });

            $('#projectFilter').on('change', function () {
                var projectFilter = $(this).val(); // Ambil nilai dropdown

                // Terapkan filter pada kolom Kategori Project (index 6)
                table.column(6).search(projectFilter).draw();
            });

        });

        function formatCurrency(input) {
        // Ambil nilai input, hapus semua karakter selain angka
        let value = input.value.replace(/[^,\d]/g, '');

        // Ubah ke format angka dengan pemisah ribuan
        input.value = new Intl.NumberFormat('id-ID').format(value);
        }

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
