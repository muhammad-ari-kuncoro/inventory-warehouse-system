@extends('layouts.dashboard-layout')
@section('container')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-primary text-decoration-none">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Materials</li>
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
                    <label for="projectFilter" class="form-label fw-semibold">Filter Type Materials</label>
                    <select id="projectFilter" class="form-select">
                        <option value="">All Type</option>
                        <option value="New">New</option>
                        <option value="Temporary">Temporary</option>
                    </select>
                </div>

                <div class="col-md-5">
                    <label class="form-label fw-semibold">Import Data Excel</label>
                    <form action="" method="POST" enctype="multipart/form-data"
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
                    <a href="{{ route('material.export') }}" class="btn btn-outline-danger btn-sm">
                        <i class='bx bxs-file-pdf'></i> Export PDF
                    </a>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalTambah">
                        <i class='bx bx-plus'></i> Add Data
                    </button>
                    <a href="{{ route('material.create.multiple') }}" class="btn btn-outline-success btn-sm"><i class='bx bx-plus'></i> Add Data Multiple</a>
                </div>

            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover display" id="myTable7">
                    <thead class="table-info text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Materials Names</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Type Materials</th>
                            <th class="text-center">Projects Items</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_material as $data)
                            <tr class="text-center">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $data->nama_material ?? '-' }}</td>
                                <td class="text-center {{ $data->quantity == 0 ? 'bg-danger text-white' : '' }}">
                                    {{ $data->quantity }} {{ $data->jenis_quantity ?? '-' }}
                                </td>
                                <td class="text-center">{{ $data->jenis_material }}</td>
                                <td>
                                    <span class="fw-semibold">{{ $data->project->nama_project ?? '-' }}</span>
                                    <br>
                                    <small class="text-muted">{{ $data->project->sub_nama_project ?? '-' }}</small>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('material.edit', $data->id) }}" class="btn btn-warning btn-sm">
                                        <i class='bx bx-edit-alt'></i>
                                    </a>
                                    <a href="{{ route('material.show', $data->id) }}" class="btn btn-success btn-sm">
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
                    <h5 class="modal-title" id="modalTambahLabel">Add Data Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('material.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">


                        <div class="mb-3">
                            <label class="form-label fw-semibold">Material Name</label>
                            <input type="text" class="form-control @error('nama_material') is-invalid @enderror"
                                name="nama_material" placeholder="Please fill in the material name field ..." required>
                            @error('nama_material')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Spesification Material</label>
                            <input type="text" class="form-control @error('spesifikasi_material') is-invalid @enderror"
                                name="spesifikasi_material"
                                placeholder="Please fill in the spesification material field ..." required>
                            @error('spesifikasi_material')
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
                                <label class="form-label fw-semibold">Quantity Type</label>
                                <select class="form-select rounded-top @error('jenis_quantity') is-invalid @enderror"
                                    name="jenis_quantity" required>
                                    <option selected disabled>Choose Quantity Type ...</option>
                                    <option value="Pcs">Pcs</option>
                                    <option value="Rod">Rod</option>
                                    <option value="Set">Set</option>
                                    <option value="Sack">Sack</option>
                                    <option value="Box">Box</option>
                                    <option value="Ea">Ea</option>
                                    @error('jenis_quantity')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </select>
                                @error('jenis_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Type Material</label>
                            <select class="form-select" name="jenis_material" required>
                                <option value="" disabled selected>Choose Type Material</option>
                                <option value="New">New</option>
                                <option value="Temporary">Temporary</option>
                            </select>
                            @error('jenis_material')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Material Price</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" name="harga_material" id="hargaMaterials"
                                    placeholder="0" oninput="formatCurrency(this)">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Project</label>
                            <select class="form-select @error('project_id') is-invalid @enderror" name="project_id"
                                required>
                                <option value="" disabled selected>Choose Project</option>
                                @foreach ($data_project as $project)
                                    <option value="{{ $project->id }}">
                                        {{ $project->nama_project }} | {{ $project->sub_nama_project }} | JO:
                                        {{ $project->no_jo_project }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
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
    <script>
        $(document).ready(function() {
            var table = $('#myTable7').DataTable({
                drawCallback: function() {
                    $('#myTable7 tbody tr').each(function() {
                        var qty = $(this).find('td').eq(2).text().trim();
                        if (qty == '0') {
                            $(this).addClass('bg-danger');
                        } else {
                            $(this).removeClass('bg-danger');
                        }
                    });
                }
            });

            $('#projectFilter').on('change', function() {
                table.column(3).search($(this).val(), true, false).draw();
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
    </script>
@endpush
