@extends('layouts.dashboard-layout')
@section('container')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-primary text-decoration-none">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Good Received</li>
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
                    <label for="categoryFilter" class="form-label fw-semibold">Filter Categories</label>
                    <select id="categoryFilter" class="form-select">
                        <option value="">All Categories</option>
                        <option value="Materials">Materials</option>
                        <option value="Machine">Machine</option>
                        <option value="Consumable">Consumable</option>
                    </select>
                </div>

                <div class="col-md-9 d-flex justify-content-end gap-2">
                    <a href="{{ route('good-received.create') }}" class="btn btn-outline-primary btn-sm">
                        <i class='bx bx-plus'></i> Add Data
                    </a>
                    <a href="{{ route('good-received.export-filter') }}" class="btn btn-outline-danger btn-sm">
                        <i class='bx bxs-file-pdf'></i> Export PDF
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover display" id="myTable7">
                    <thead class="table-info text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">No Doc</th>
                            <th class="text-center">Date Of Entry</th>
                            <th class="text-center">Name Supplier</th>
                            <th class="text-center">Project</th>
                            <th class="text-center">Category Items</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_delivery_order as $data)
                            <tr class="text-center">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $data->kode_surat_jalan }}</td>
                                <td class="text-center">{{ $data->tanggal_masuk }}</td>
                                <td class="text-center">{{ $data->nama_supplier }}</td>
                                <td class="text-center">
                                    <span class="fw-semibold">{{ $data->project->nama_project ?? 'N/A' }}</span>
                                    <br>
                                    <small class="text-muted">{{ $data->project->sub_nama_project ?? 'N/A' }}</small>
                                </td>

                                <td class="text-center">

                                    @if ($data->details && $data->details->count() > 0)
                                        @foreach ($data->details->pluck('jenis_barang')->unique() as $jenis)
                                            @if ($jenis == 'Materials')
                                                <span
                                                    class="badge bg-primary px-3 py-2 d-inline-flex align-items-center gap-1">
                                                    <i class="bx bx-cube-alt fs-6"></i> {{ $jenis }}
                                                </span>
                                            @elseif($jenis == 'Consumables')
                                                <span
                                                    class="badge bg-warning text-dark px-3 py-2 d-inline-flex align-items-center gap-1">
                                                    <i class="bx bx-test-tube fs-6"></i> {{ $jenis }}
                                                </span>
                                            @elseif($jenis == 'Machines')
                                                <span
                                                    class="badge bg-danger px-3 py-2 d-inline-flex align-items-center gap-2">
                                                    <i class="bx bx-cog fs-6"></i> {{ $jenis }}
                                                </span>
                                            @else
                                                <span
                                                    class="badge bg-secondary px-3 py-2 d-inline-flex align-items-center gap-1">
                                                    <i class="bx bx-package fs-6"></i> {{ $jenis }}
                                                </span>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>


                                <td class="text-center">
                                    @if ($data->status == 'draft')
                                        <span class="badge bg-warning text-dark">
                                            <i class="bx bx-time-five"></i> {{ $data->status }}
                                        </span>
                                    @elseif($data->status == 'received')
                                        <span class="badge bg-success">
                                            <i class="bx bx-check-circle"></i> {{ $data->status }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($data->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('good-received.edit', $data->id) }}"
                                            class="btn btn-warning btn-sm" title="Edit Data">
                                            <i class='bx bx-edit-alt'></i>
                                        </a>

                                        <a href="{{ route('good-received.show', $data->id) }}"
                                            class="btn btn-success btn-sm" title="Show Detail">
                                            <i class='bx bx-show'></i>
                                        </a>

                                        <a href="{{ route('good-received.export.single.download', $data->id) }}"
                                            class="btn btn-info btn-sm text-white" target="_blank" title="Print Bukti GR">
                                            <i class='bx bx-printer'></i>
                                        </a>

                                        <form action="{{ route('good-received.destroy', $data->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Data"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data GR ini? Stok yang terkait akan disesuaikan kembali.')">
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
    <script src="//cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
    <script src="//cdn.datatables.net/buttons/3.2.0/js/buttons.dataTables.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/3.2.0/js/buttons.print.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) setTimeout(() => preloader.style.display = 'none', 1000);
        });

        $(document).ready(function() {
            var table = $('#myTable7').DataTable({});

            $('#categoryFilter').on('change', function() {
                table.column(5).search($(this).val()).draw();
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
