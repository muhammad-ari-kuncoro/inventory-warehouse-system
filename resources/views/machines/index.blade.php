@extends('layouts.dashboard-layout')
@section('container')

<div class="card">
    <div class="card-header bg-light">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active text-primary text-decoration-none" aria-current="page">Tools</li>
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
            <div class="row">
                <!-- Dropdown Filter -->
                <div class="col-sm-auto mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Tambah Data
                    </button>
                </div>
            </div>
                <div class="row">

                    <div class="col-md-3 mb-3">
                        <label for="projectFilter" class="form-label">Filter Jenis Consumable:</label>
                        <select id="projectFilter" class="form-select">
                            <option value="">Semua Kategori</option>
                            <option value="Cutting Machines">Cutting Machines</option>
                            <option value="Forming Machines">Forming Machines</option>
                            <option value="Welding Machines">Welding Machines</option>
                            <option value="Machining Machines">Machining Machines</option>
                            <option value="Surface Treatment Machines">Surface Treatment Machines</option>
                            <option value="spesial machines">spesial machines</option>
                            <option value="Pipe Bending">Pipe Bending</option>
                    </select>
                </div>
            </div>
            <!-- Add Button -->






            <div class="table-responsive">


                <table class="table table-bordered table-hover display" id="myTable7">
                    <thead>
                        <tr class="table-info text-center">
                            <th>No</th>
                            <th>Kode Mesin Asset</th>
                            <th>Nama Mesin</th>
                            <th>Spesifikasi Mesin</th>
                            <th>Jenis Mesin</th>
                            <th>Quantity</th>
                            <th>Harga Mesin</th>
                            <th>Jenis Quantity</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_machine_asset as $data)

                        <tr>
                            <td class="text-center">{{$loop->iteration}}</td>
                            <td>{{$data->kd_mesin_assets}}</td>
                            <td>{{$data->nama_mesin}}</td>
                            <td>{{$data->spesifikasi_mesin}}</td>
                            <td class="text-center">{{$data->jenis_mesin}}</td>
                            <td class="text-center">{{$data->quantity}}</td>
                            <td class="text-center">{{$data->jenis_quantity}}</td>
                            <td class="text-center">{{$data->harga_mesin}}</td>
                            <td>
                                <div class="mb-auto">
                                    <a href="{{route('machine.edit',$data->id)}}" class="btn btn-warning btn-sm">Edit</a>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Form Tambah Mesin Assets</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('machine.create')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_mesin" class="form-label">Nama Mesin</label>
                            <input class="form-control rounded-top  @error('nama_mesin') is-invalid @enderror"
                                type="text" name="nama_mesin" placeholder="Harap Di Isi Nama Mesin" required>
                            @error('nama_mesin')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="spesifikasi_mesin" class="form-label">Spesifikasi Mesin</label>
                            <input class="form-control rounded-top @error('spesifikasi_mesin') is-invalid @enderror"
                                type="text" name="spesifikasi_mesin" placeholder="Harap Di Isi Spesifikasi Mesin"
                                required>
                            @error('spesifikasi_mesin')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jenis_mesin" class="form-label" name="jenis_mesin">Jenis Mesin </label>
                            <select class="form-select rounded-top @error('jenis_mesin') is-invalid @enderror" name="jenis_mesin" required>
                                <option selected disabled>Pilih Jenis Mesin</option>
                                <option value="Cutting Machines">Cutting Machines</option>
                                <option value="Forming Machines">Forming Machines</option>
                                <option value="Welding Machines">Welding Machines</option>
                                <option value="Machining Machines">Machining Machines</option>
                                <option value="Surface Treatment Machines">Surface Treatment Machines</option>
                                <option value="spesial machines">spesial machines</option>
                                <option value="Pipe Bending">Pipe Bending</option>


                                @error('jenis_mesin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity Mesin</label>
                            <input class="form-control rounded-top @error('quantity') is-invalid @enderror"
                                type="number" min="1"  name="quantity" placeholder="Harap Di Isi Quantity Mesin"
                                required>
                            @error('quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>






                        <div class="mb-3">
                            <label for="jenis_quantity" class="form-label" name="jenis_quantity">Jenis Quantity </label>
                            <select class="form-select rounded-top @error('jenis_quantity') is-invalid @enderror"
                                name="jenis_quantity" required>
                                <option selected disabled>Pilih Jenis Material</option>
                                <option value="Unit">Unit</option>
                                <option value="Set">Set</option>
                                @error('jenis_quantity')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </select>
                        </div>

                        <label for="harga_mesin" class="form-label">Harga Mesin</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Rp</span>
                            <input
                                type="text"
                                class="form-control"
                                name="harga_mesin"
                                id="hargaConsumable"
                                aria-label="Amount (to the nearest Rupiah)"
                                oninput="formatCurrency(this)"
                            >
                            @error('harga_mesin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            <span class="input-group-text">.00</span>
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
                table.column(4).search(projectFilter).draw();
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
