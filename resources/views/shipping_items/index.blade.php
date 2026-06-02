@extends('layouts.dashboard-layout')
@section('container')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-primary text-decoration-none">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Subcon Out</li>
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
                    <label for="projectFilter" class="form-label fw-semibold">Filter Status</label>
                    <select id="projectFilter" class="form-select">
                        <option value="">All Status</option>
                        <option value="Draft">Draft</option>
                        <option value="Shipped">Shipped</option>
                    </select>
                </div>

                <div class="col-md-9 d-flex justify-content-end gap-2">
                    <a href="{{ route('shipping-items.create') }}" class="btn btn-outline-primary btn-sm">
                        <i class='bx bx-plus'></i> Add Data
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover display" id="myTable7">
                    <thead class="table-info text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Code SO</th>
                            <th class="text-center">Delivery Date</th>
                            <th class="text-center">Vendor / Destination</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_shipping as $data)
                            <tr class="text-center">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    @if($data->kd_sj_brg_keluar === 'draft')
                                        <span class="text-muted text-uppercase small">Waiting Publish</span>
                                    @else
                                        <strong>{{ $data->kd_sj_brg_keluar }}</strong>
                                    @endif
                                </td>
                                <td class="text-center">{{ $data->date_delivery ?? '-' }}</td>
                                <td>{{ $data->to ?? 'Internal Draft' }}</td>
                                <td>
                                    @if($data->status === 'draft')
                                        <span class="badge bg-label-warning text-warning uppercase">Draft</span>
                                    @else
                                        <span class="badge bg-label-success text-success uppercase">Shipped</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('shipping-items.edit', $data->id) }}"
                                        class="btn btn-warning btn-sm" title="Edit">
                                            <i class='bx bx-edit-alt'></i>
                                        </a>

                                        <form action="{{ route('shipping-items.destroy', $data->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                                    onclick="return confirm('Are you sure you want to delete this OS?')">
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
            var table = $('#myTable7').DataTable({});

            $('#projectFilter').on('change', function() {
                table.column(4).search($(this).val()).draw();
            });
        });

        function updateDateTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            const el = document.getElementById('currentDateTime');
            if (el) el.textContent = now.toLocaleDateString('id-ID', options);
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>
@endpush
