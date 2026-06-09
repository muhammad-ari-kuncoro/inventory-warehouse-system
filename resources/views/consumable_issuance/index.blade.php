@extends('layouts.dashboard-layout')

@section('container')
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white border-bottom pb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Consumable Issuance</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h5 class="mb-0 fw-semibold">Consumable Out</h5>
                    <small class="text-muted" id="currentDateTime"></small>
                </div>

                <div class="d-flex align-items-center gap-3">
                    @php
                        // Cek jam operasional langsung di Blade untuk kebutuhan teks alert
                        $currentHour = \Carbon\Carbon::now('Asia/Jakarta')->hour;
                        $isOutsideHours = $currentHour >= 17 || $currentHour < 8;
                    @endphp

                    {{-- Tampilkan pesan alert sesuai kondisi penyebab error --}}
                    @if (!$canCreate)
                        @if ($isOutsideHours)
                            <div class="alert alert-danger mb-0 py-2 px-3 small">
                                <i class="bx bx-time-five me-1"></i>
                                Sistem Tutup. Input data hanya bisa dilakukan jam 08:00 s/d 17:00 WIB.
                            </div>
                        @elseif (isset($nextAllowedTime))
                            <div class="alert alert-warning mb-0 py-2 px-3 small">
                                <i class="bx bx-error-circle me-1"></i>
                                Anda sudah melakukan pengambilan consumable hari ini.
                                Berikutnya pada: <strong>{{ \Carbon\Carbon::parse($nextAllowedTime)->format('d-m-Y H:i') }}
                                    WIB</strong>.
                            </div>
                        @endif
                    @endif

                    {{-- Tombol Aksi dinamis --}}
                    @if ($canCreate)
                        <a href="{{ route('consumable-issuance.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus me-1"></i> Buat Pengambilan
                        </a>
                    @else
                        <button class="btn btn-secondary" disabled>
                            <i class="bx bx-lock-alt me-1"></i> Pengambilan Terkunci
                        </button>
                    @endif
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <strong>{!! session('success') !!}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @elseif (session('delete'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                <strong>{!! session('delete') !!}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @elseif (session('forbidden'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                <strong>{!! session('forbidden') !!}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @elseif (session('editSuccess'))
            <div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
                <strong>{!! session('editSuccess') !!}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label class="form-label fw-semibold small">Filter Status</label>
                    <select id="statusFilter" class="form-select form-select-sm select-2">
                        <option value="">Semua Status</option>
                        <option value="draft">Draft</option>
                        <option value="submitted">Submitted</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover display" id="myTable11">
                    <thead>
                        <tr class="table-info text-center">
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal Transaksi</th>
                            <th>Dibuat Oleh</th>
                            <th>Total Item</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $data->kd_consumable_out }}</td>
                                <td class="text-center">{{ $data->transaction_date_out }}</td>
                                <td>{{ $data->user->username ?? '-' }}</td>
                                <td class="text-center">{{ $data->details->count() ?? '-' }} item</td>
                                <td class="text-center" data-search="{{ $data->status }}">
                                    @if ($data->status == 'draft')
                                        <span class="badge bg-warning text-dark">Draft</span>
                                    @elseif ($data->status == 'submitted')
                                        <span class="badge bg-success">Submitted</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('consumable-issuance.show', $data->id) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="bx bx-show-alt me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                        @endforelse
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
            if (preloader) {
                setTimeout(function() {
                    preloader.style.display = 'none';
                }, 1500);
            }
        });

        $(document).ready(function() {
            var table = $('#myTable11').DataTable({
                dom: '<"d-flex justify-content-between"lBf>rtip',
                buttons: [{
                    extend: 'excel',
                    text: '<i class="bx bx-export me-1"></i> Export Excel',
                    className: 'btn btn-success btn-sm',
                    exportOptions: {
                        modifier: {
                            search: 'applied'
                        }
                    }
                }],
                layout: {
                    topStart: 'buttons'
                },
                columnDefs: [{
                    orderable: false,
                    targets: [6]
                }]
            });

            // Filter status pakai data-search attribute
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var filterVal = $('#statusFilter').val();
                if (!filterVal) return true;
                var rowNode = table.row(dataIndex).node();
                var cellSearch = $(rowNode).find('td[data-search]').data('search');
                return cellSearch == filterVal;
            });

            $('#statusFilter').on('change', function() {
                table.draw();
            });
        });

        function updateDateTime() {
            const now = new Date();
            document.getElementById('currentDateTime').textContent =
                now.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>

    <script>
        $('.select-2').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
        });
    </script>
@endpush
