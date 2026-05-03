@extends('layouts.dashboard-layout')
@section('container')
<div class="card shadow-sm border-0">
    <div class="card-header bg-light">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}" class="text-primary text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Tools</li>
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
        <strong>Data Telah Dihapus</strong>
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
                <label for="projectFilter" class="form-label fw-semibold">Filter Category Type Tools</label>
                <select id="projectFilter" class="form-select">
                    <option value="">Select Type Tools</option>
                    <option value="Cutting Tools">Cutting Tools</option>
                    <option value="Lifting Tools">Lifting Tools</option>
                    <option value="Forming Tools">Forming Tools</option>
                    <option value="Fastener Tools">Fastener Tools</option>
                    <option value="Measuring Tools">Measuring Tools</option>
                    <option value="Tester Tools">Tester Tools</option>
                </select>
            </div>

            <div class="col-md-5">
                <label class="form-label fw-semibold">Import Data Excel</label>
                <form action="{{ route('tools.import') }}" method="POST" enctype="multipart/form-data"
                    class="d-flex gap-2 align-items-center">
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
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#modalTambah">
                    <i class='bx bx-plus'></i> Add Data
                </button>
                <a href="{{ route('tools.export') }}" class="btn btn-outline-danger btn-sm">
                        <i class='bx bxs-file-pdf'></i> Export PDF
                </a>
                <a href="{{ route('tools.create.multiple') }}" class="btn btn-outline-success btn-sm"><i class='bx bx-plus'></i> Add Data Multiple</a>
            </div>

        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover display" id="myTable7">
                <thead class="table-info text-center">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Code Tools</th>
                        <th class="text-center">Tools Name</th>
                        <th class="text-center">Type Name</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_tools as $data)
                    <tr class="text-center">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $data->kode_alat ?? '-' }}</td>
                        <td>{{ $data->nama_alat ?? '-' }}</td>
                        <td>{{ $data->jenis_alat ?? '-' }}</td>
                        <td class="text-center {{ $data->quantity == 0 ? 'bg-danger text-white' : '' }}">
                            {{ $data->quantity }} {{ $data->jenis_quantity ?? '-' }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('tools.edit', $data->id) }}" class="btn btn-warning btn-sm">
                                <i class='bx bx-edit-alt'></i>
                            </a>
                            <a href="{{ route('tools.show', $data->id) }}" class="btn btn-success btn-sm">
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

<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahLabel">Tambah Data Tools</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('tools.create') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tool Name</label>
                        <input type="text" class="form-control @error('nama_alat') is-invalid @enderror"
                            name="nama_alat" placeholder="Please fill in the Tools name field ..." required>
                        @error('nama_alat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Spesification Tool</label>
                        <input type="text" class="form-control @error('spesifikasi_alat') is-invalid @enderror"
                            name="spesifikasi_alat" placeholder="Please fill in the Spesification Tool field ..."
                            required>
                        @error('spesifikasi_alat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Type Tools</label>
                        <select class="form-select select2-type-tools @error('jenis_alat') is-invalid @enderror"
                            name="jenis_alat" required>
                            <option value="">Select Type Tools</option>
                            <option value="Cutting Tools">Cutting Tools</option>
                            <option value="Lifting Tools">Lifting Tools</option>
                            <option value="Forming Tools">Forming Tools</option>
                            <option value="Fastener Tools">Fastener Tools</option>
                            <option value="Measuring Tools">Measuring Tools</option>
                            <option value="Tester Tools">Tester Tools</option>
                        </select>
                        @error('jenis_alat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Size Tools</label>
                        <select class="form-select select2-size-tools @error('tipe_alat') is-invalid @enderror"
                            name="tipe_alat" required>
                            <option value="">Select Size Tools</option>
                            <option value="Small">Small</option>
                            <option value="Medium">Medium</option>
                            <option value="Large">Large</option>
                        </select>
                        @error('tipe_alat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Quantity</label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                name="quantity" placeholder="0" min="1" required>
                            @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-6">
                            <label class="form-label fw-semibold">Type Quantity</label>
                            <select class="form-select select2-type-qty @error('jenis_quantity') is-invalid @enderror"
                                name="jenis_quantity" required>
                                <option value="">Select Type Quantity</option>
                                <option value="Unit">Unit</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Set">Set</option>
                                <option value="Lot">Lot</option>
                                <option value="Pack">Pack</option>
                            </select>
                            @error('jenis_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                    <button type="submit" class="btn btn-primary">Save Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
    rel="stylesheet" />
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
    $(document).ready(function () {

        var table = $('#myTable7').DataTable({
            drawCallback: function () {
                $('#myTable7 tbody tr').each(function () {
                    var qty = $(this).find('td').eq(4).text().trim();
                    if (parseInt(qty) === 0) {
                        $(this).addClass('bg-danger');
                    } else {
                        $(this).removeClass('bg-danger');
                    }
                });
            }
        });

$('#projectFilter').on('change', function () {
    var val = $(this).val().trim();console.log("Mencari: '" + val + "'");

    table.column(3).search(val).draw();
});

        $('#modalTambah').on('shown.bs.modal', function () {
            $('.select2-type-tools').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#modalTambah'),
                width: '100%',
                placeholder: 'Select Type Tools',
            });

            $('.select2-size-tools').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#modalTambah'),
                width: '100%',
                placeholder: 'Select Size Tools',
            });

            $('.select2-type-qty').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#modalTambah'),
                width: '100%',
                placeholder: 'Select Type Quantity',
            });
        });

        $('#modalTambah').on('hidden.bs.modal', function () {
            if ($('.select2-type-tools').hasClass('select2-hidden-accessible')) {
                $('.select2-type-tools').select2('destroy');
            }
            if ($('.select2-size-tools').hasClass('select2-hidden-accessible')) {
                $('.select2-size-tools').select2('destroy');
            }
            if ($('.select2-type-qty').hasClass('select2-hidden-accessible')) {
                $('.select2-type-qty').select2('destroy');
            }
        });

    });

    document.addEventListener('DOMContentLoaded', function () {
        const preloader = document.getElementById('preloader');
        if (preloader) setTimeout(() => preloader.style.display = 'none', 1500);
    });

</script>
@endpush
