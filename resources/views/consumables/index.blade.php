@extends('layouts.dashboard-layout')
@section('container')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-primary text-decoration-none">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Consumables</li>
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <strong class="text-dark">{!! session()->get('success') !!}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('delete'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                <strong class="text-dark">Data Telah Dihapus</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('editSuccess'))
            <div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
                <strong class="text-dark">{!! session()->get('editSuccess') !!}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card-body">

            <div class="row align-items-end mb-3 g-2">

                <div class="col-md-3">
                    <label for="projectFilter" class="form-label fw-semibold">Filter Type Consumable</label>
                    <select id="projectFilter" class="form-select">
                        <option disabled>Choose Type</option>
                        <option value="">All Type</option>
                        <option value="General Consumable">General Consumable</option>
                        <option value="Welding Consumable">Welding Consumable</option>
                        <option value="Safety Consumable">Safety Consumable</option>
                    </select>
                </div>

                <div class="col-md-5">
                    <label class="form-label fw-semibold">Import Data Excel</label>
                    <form action="{{ route('consumable.import') }}" method="POST" enctype="multipart/form-data"
                        class="d-flex gap-2 align-items-center">
                        @csrf
                        <input type="file" class="form-control form-control-sm @error('file') is-invalid @enderror"
                            id="importFile" name="file" required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn btn-success btn-sm text-nowrap">
                            <i class='bx bx-upload'></i> Import
                        </button>
                    </form>
                </div>

                <div class="col-md-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('consumable.export') }}" class="btn btn-outline-danger btn-sm">
                        <i class='bx bxs-file-pdf'></i> Export Data
                    </a>
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        <i class='bx bx-plus'></i> Add Data
                    </button>
                    <a href="{{ route('consumable.create.multiple') }}" class="btn btn-outline-success btn-sm"><i
                            class='bx bx-plus'></i> Add Data Multiple</a>
                </div>

            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover display" id="myTable7">
                    <thead>
                        <tr class="table-info text-center">
                            <th class="text-center">No</th>
                            <th class="text-center">Consumables Codes</th>
                            <th class="text-center">Consumables Names</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Type Consumables</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_consumables as $data)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $data->kode_consumable }}</td>
                                <td class="text-center">{{ $data->nama_consumable }}</td>
                                @if (0)
                                    <td class="text-center bg-danger">{{ $data->quantity }} {{ $data->jenis_quantity }}</td>
                                @else
                                    <td class="text-center">{{ $data->quantity }} {{ $data->jenis_quantity }}</td>
                                @endif
                                <td class="text-center">{{ $data->jenis_consumable }}</td>
                                <td class="text-center">
                                    <a href="{{ route('consumable.edit', $data->id) }}" class="btn btn-warning btn-sm">
                                        <i class='bx bx-edit-alt'></i>
                                    </a>
                                    <a href="{{ route('consumable.show', $data->id) }}" class="btn btn-success btn-sm">
                                        <i class='bx bx-show-alt'></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" data-bs-focus="false" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Data Consumable</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('consumable.create') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_consumable" class="form-label">Consumable Name</label>
                            <input class="form-control rounded-top @error('nama_consumable') is-invalid @enderror"
                                type="text" name="nama_consumable"
                                placeholder="Please fill in the consumable name field ..." required>
                            @error('nama_consumable')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="spesifikasi_consumable" class="form-label">Spesification Consumable</label>
                            <input class="form-control rounded-top @error('spesifikasi_consumable') is-invalid @enderror"
                                type="text" name="spesifikasi_consumable"
                                placeholder="Please fill in the spesification consumable field ..." required>
                            @error('spesifikasi_consumable')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <label for="quantity" class="form-label">Quantity</label>
                        <input class="form-control rounded-top @error('quantity') is-invalid @enderror" type="number"
                            name="quantity" placeholder="Please fill in the quantity consumable field ..." required
                            min="1" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)">

                        <div class="mb-3 mt-3">
                            <label for="jenis_quantity" class="form-label">Type Quantity</label>
                            <select
                                class="select-type-quantity rounded-top @error('jenis_quantity') is-invalid @enderror"
                                name="jenis_quantity" required>
                                <option selected disabled>Choose Jenis Quantity<    /option>
                                <option value="Pcs">Pcs</option>
                                <option value="Length">Length<option>
                                <option value="Set">Set</option>
                                <option value="Sack">Sack</option>
                                <option value="Box">Box</option>
                                <option value="Kg">Kilogram (Kg)</option>
                                <option value="G">Gram (G)</option>
                                <option value="Dozen">Dozen</option>
                            </select>
                            @error('jenis_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jenis_consumable" class="form-label">Type Consumable</label>
                            <select class="form-select rounded-top @error('jenis_consumable') is-invalid @enderror"
                                name="jenis_consumable" required>
                                <option selected disabled>Choosee Type Consumable</option>
                                <option value="General Consumable">General Consumable</option>
                                <option value="Welding Consumable">Welding Consumable</option>
                                <option value="Safety Consumable">Safety Consumable</option>
                            </select>
                            @error('jenis_consumable')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <label for="harga_consumable" class="form-label">Price Consumable</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control" name="harga_consumable" id="hargaConsumable"
                                aria-label="Amount (to the nearest Rupiah)" oninput="formatCurrency(this)"
                                min="1">
                            <span class="input-group-text">.00</span>
                        </div>

                        <div class="mb-3">
                            <label for="project_id" class="form-label">For The Project</label>
                            <select class="select-project rounded-top @error('project_id') is-invalid @enderror"
                                name="project_id" required>
                                <option selected disabled>Choose The Project</option>
                                @foreach ($data_project as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama_project }} |
                                        {{ $data->sub_nama_project }} | NO JO : {{ $data->no_jo_project }}</option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <div class="invalid-feedback">{{ $message }}</div>
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

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        tr.bg-danger td {
            background-color: #f8d7da !important;
            color: #842029 !important;
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#myTable7').DataTable({
                drawCallback: function() {
                    $('#myTable7 tbody tr').each(function() {
                        var quantity = $(this).find('td').eq(4).text().trim();
                        if (quantity == '0') {
                            $(this).addClass('bg-danger text-white');
                        } else {
                            $(this).removeClass('bg-danger text-white');
                        }
                    });
                }
            });

            $('#projectFilter').on('change', function() {
                table.column(6).search($(this).val()).draw();
            });
        });

        function formatCurrency(input) {
            let value = input.value.replace(/[^,\d]/g, '');
            input.value = new Intl.NumberFormat('id-ID').format(value);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) setTimeout(() => preloader.style.display = 'none', 1500);
        });

        $(document).ready(function() {
            $('.select-type-quantity').select2({
                theme: "bootstrap-5", // Jika Anda menggunakan tema bootstrap-5-select2
                dropdownParent: $('#exampleModal'),
                width: '100%',
                placeholder: "Select an Choose Project"
            });
        });

        $(document).ready(function() {
            $('.select-project').select2({
                theme: "bootstrap-5", // Jika Anda menggunakan tema bootstrap-5-select2
                dropdownParent: $('#exampleModal'),
                width: '100%',
                placeholder: "Select an Choose Project"
            });
        });

    </script>
@endpush
