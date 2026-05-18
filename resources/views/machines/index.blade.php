@extends('layouts.dashboard-layout')
@section('container')
<div class="card shadow-sm border-0">
    <div class="card-header bg-light">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-primary text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Machines</li>
            </ol>
        </nav>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        <strong>{!! session()->get('success') !!}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @elseif (session('delete'))
    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
        <strong>Data Has Been Deleted</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @elseif (session('editSuccess'))
    <div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
        <strong>{!! session()->get('editSuccess') !!}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card-body">

        <div class="row align-items-end mb-3 g-2">
            <div class="col-md-3">
                <label for="projectFilterMaterial" class="form-label fw-semibold">Filter Type Machines</label>
                <select id="projectFilterMaterial" class="form-select">
                    <option disabled>Choose Type</option>
                    <option value="">All Type</option>
                    <option value="Cutting Machines">Cutting Machines</option>
                    <option value="Forming Machines">Forming Machines</option>
                    <option value="Welding Machines">Welding Machines</option>
                    <option value="Machining Machines">Machining Machines</option>
                    <option value="Surface Treatment Machines">Surface Treatment Machines</option>
                    <option value="spesial machines">spesial machines</option>
                    <option value="Pipe Bending">Pipe Bending</option>
                </select>
            </div>

            <div class="col-md-5">
                <label class="form-label fw-semibold">Import Data Excel</label>
                <form action="" method="POST" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
                    @csrf
                    <input type="file" class="form-control form-control-sm @error('file') is-invalid @enderror"
                        name="file" required>
                    @error('file')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-success btn-sm text-nowrap">
                        <i class='bx bx-upload'></i> Import
                    </button>
                </form>
            </div>

            <div class="col-md-4 d-flex justify-content-end gap-2">
                <a href="{{ route('machine.export') }}" class="btn btn-outline-danger btn-sm">
                    <i class='bx bxs-file-pdf'></i> Export PDF
                </a>
                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#modalAddMachine">
                    <i class='bx bx-plus'></i> Add Data
                </button>
                <a href="{{ route('machine.create.multiple') }}" class="btn btn-outline-success btn-sm"><i class='bx bx-plus'></i> Add Data Multiple</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover display" id="myTable7">
                <thead class="table-info text-center">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Code Machine</th>
                        <th class="text-center">Name Machine</th>
                        <th class="text-center">Type Machine</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_machine_asset as $data)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $data->kd_mesin_assets }}</td>
                        <td class="text-center">{{ $data->nama_mesin }}</td>
                        <td class="text-center">{{ $data->jenis_mesin }}</td>
                        <td class="text-center">{{ $data->quantity }} {{ $data->jenis_quantity }}</td>
                        <td class="text-center">
                            <a href="{{ route('machine.edit', $data->id) }}" class="btn btn-warning btn-sm">
                                <i class='bx bx-edit-alt'></i>
                            </a>
                            <a href="{{ route('machine.show', $data->id) }}" class="btn btn-success btn-sm">
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
<div class="modal fade" id="modalAddMachine" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Data Machines</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('machine.create') }}" method="post">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name Machine</label>
                        <input class="form-control @error('nama_mesin') is-invalid @enderror" type="text"
                            name="nama_mesin" placeholder="Please fill in the name machine field ..." required autocomplete>
                        @error('nama_mesin')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Spesification Machine</label>
                        <input class="form-control @error('spesifikasi_mesin') is-invalid @enderror" type="text"
                            name="spesifikasi_mesin" placeholder="Please fill in the spesification machine field ..."
                            required autofocus>
                        @error('spesifikasi_mesin')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Type Machine</label>
                        <select class="select-type-machine @error('jenis_mesin') is-invalid @enderror" name="jenis_mesin"
                            required>
                            <option selected disabled>Choose Type Machine</option>
                            <option value="Cutting Machines">Cutting Machines</option>
                            <option value="Forming Machines">Forming Machines</option>
                            <option value="Welding Machines">Welding Machines</option>
                            <option value="Machining Machines">Machining Machines</option>
                            <option value="Surface Treatment Machines">Surface Treatment Machines</option>
                            <option value="spesial machines">spesial machines</option>
                            <option value="Pipe Bending">Pipe Bending</option>
                        </select>
                        @error('jenis_mesin')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Quantity Machine</label>
                            <input class="form-control @error('quantity') is-invalid @enderror" type="number" min="1"
                                name="quantity" placeholder="0" required>
                            @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Type Quantity</label>
                            <select class="select-type-quantity @error('jenis_quantity') is-invalid @enderror"
                                name="jenis_quantity" required>
                                <option selected disabled>Choose Type</option>
                                <option value="Unit">Unit</option>
                                <option value="Set">Set</option>
                            </select>
                            @error('jenis_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Price Machine</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control" name="harga_mesin" id="hargaConsumable"
                                placeholder="0" oninput="formatCurrency(this)">
                            <span class="input-group-text">.00</span>
                        </div>
                        @error('harga_mesin')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
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
    document.addEventListener('DOMContentLoaded', function () {
        const preloader = document.getElementById('preloader');
        if (preloader) setTimeout(() => preloader.style.display = 'none', 1500);
    });

    $(document).ready(function () {
        var table = $('#myTable7').DataTable({
            drawCallback: function () {
                $('#myTable7 tbody tr').each(function () {
                    var quantity = parseInt($(this).find('td').eq(4).text().trim());
                    if (quantity === 0) {
                        $(this).addClass('bg-danger text-white');
                    } else {
                        $(this).removeClass('bg-danger text-white');
                    }
                });
            }
        });

        $('#projectFilterMaterial').on('change', function () {
            table.column(3).search($(this).val()).draw();
        });

        $('.select-type-quantity').select2({
            width: '100%',
            placeholder: "Choose Type Quantity",
            dropdownParent: $('#modalAddMachine')
        });

        $('.select-type-machine').select2({
            width: '100%',
            placeholder: "Choose Type Machine",
            dropdownParent: $('#modalAddMachine')
        });
    });

    function formatCurrency(input) {
        let value = input.value.replace(/[^,\d]/g, '');
        input.value = new Intl.NumberFormat('id-ID').format(value);
    }
</script>
@endpush
