@extends('layouts.dashboard-layout')
@section('container')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-primary text-decoration-none">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Delivery Order</li>
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
                <strong>{!! session()->get('delete') !!}</strong>
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
                    <label for="categoryFilter" class="form-label fw-semibold">Filter Project Category</label>
                    <select id="categoryFilter" class="form-select form-select-sm">
                        <option value="">All Categories</option>
                        <option value="Migas">Migas (Oil & Gas)</option>
                        <option value="Geothermal">Geothermal</option>
                        <option value="General Industry">General Industry</option>
                    </select>
                </div>

                <div class="col-md-9 d-flex justify-content-end gap-2">
                    <a href="{{ route('delivery-order.create') }}" class="btn btn-outline-primary btn-sm">
                        <i class='bx bx-plus'></i> Add Data
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover display" id="myTable11">
                    <thead class="table-info text-center">
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th class="text-center" style="width: 15%">DO No</th>
                            <th class="text-center" style="width: 15%">Delivery Date</th>
                            <th class="text-center" style="width: 45%">Project</th>
                            <th class="text-center">Category</th>
                            <th class="text-center" style="width: 20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_delivery_order as $data)
                            <tr class="align-middle">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center fw-semibold">{{ $data->do_no }}</td>
                                <td class="text-center">{{ $data->do_date }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $data->project->nama_project ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $data->project->sub_nama_project ?? 'N/A' }}</small>
                                </td>
                                <td data-search="{{ $data->project->kategori_project }}" class="text-center">
                                    @if ($data->project->kategori_project == 'General Industry')
                                        <span class="badge bg-primary">{{ $data->project->kategori_project }}</span>
                                    @elseif($data->project->kategori_project == 'Migas') {{-- Perbaikan: Tambah ->project --}}
                                        <span class="badge bg-danger">{{ $data->project->kategori_project }}</span>
                                    @elseif($data->project->kategori_project == 'Geothermal')
                                        <span class="badge bg-success">{{ $data->project->kategori_project }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $data->project->kategori_project ?? '-' }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('delivery-order.edit', $data->id) }}"
                                            class="btn btn-warning btn-sm" title="Edit">
                                            <i class='bx bx-edit-alt'></i>
                                        </a>
                                        <a href="{{ route('delivery-order.show', $data->id) }}"
                                            class="btn btn-success btn-sm" title="Detail">
                                            <i class='bx bx-show'></i>
                                        </a>
                                        <a href="{{ route('delivery-order.print-pdf', $data->id) }}"
                                            class="btn btn-info btn-sm text-white" target="_blank" title="Print PDF">
                                            <i class='bx bx-printer'></i>
                                        </a>
                                        <form action="{{ route('delivery-order.delete-data', $data->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                                onclick="return confirm('Yakin ingin menghapus DO ini?')">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) setTimeout(() => preloader.style.display = 'none', 1000);
        });

        $(document).ready(function() {
            var table = $('#myTable11').DataTable({
                "pageLength": 10,
                "ordering": true
            });

            $('#categoryFilter').on('change', function() {
                var val = $(this).val();

                if (val === '') {
                    table.column(4).search('').draw();
                } else {
                    table.column(4).search('^' + val + '$', true, false).draw();
                }
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
            const el = document.getElementById('currentDateTime');
            if (el) el.textContent = now.toLocaleDateString('id-ID', options);
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>
@endpush
