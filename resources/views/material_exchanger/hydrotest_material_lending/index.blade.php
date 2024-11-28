@extends('layouts.dashboard-layout')
@section('container')
<div class="card">
    <h5 class="card-header text-center mb-3">
        Dashboard Menu Peminjaman Materials Hydrotest  Saat ini
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


            <!-- Add Button -->
            <div class="col-sm-auto mb-3">
                <a href="{{route('hydrotest-material-lending.create')}}" class="btn btn-primary">Tambah Data</a>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-sm-3 mb-3">
                <label for="projectFilter">Filter Nama Pengambil:</label>
                <select id="projectFilter" class="form-select select-2">
                    <option value="" disabled>Nama Pengambil</option>
                    @foreach($data_tools as $data)
                    <option value="{{ $data->bagian_divisi }}">{{ $data->bagian_divisi }}</option>
                    @endforeach
                </select>
            </div>
        </div> --}}


        <div class="table-responsive">
            <table class="table table-bordered table-hover display" id="myTable11">
                <thead>
                    <tr class="table-info text-center">
                        <th>No</th>
                        <th>Kode Peminjaman Material</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Nama Materials</th>
                        <th>Spesifikasi Materials</th>
                        <th>Jenis Materials</th>
                        <th>Nama Peminjam Materialsn</th>
                        <th>Bagian Divisi</th>
                        <th>Quantity</th>
                        <th>Jenis Quantity</th>
                        <th>Keterangan Material</th>
                        <th>Aksi </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Material_lending as $data )

                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td>{{$data->}}</td>
                        <td class="text-center"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center"></td>
                        <td></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center "></td>
                        <td>
                            <div class="mb-1">
                                <a href=""><span class="btn btn-primary btn-sm">Detail</a></span>
                            </div>
                        </td>
                    </tr>
                    {{-- @endforeach --}}

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
    $(document).ready(function () {
        // Inisialisasi DataTable

        var table = $('#myTable11').DataTable({
            dom: '<"d-flex justify-content-between"lBf>rtip', // Menempatkan tombol, filter, dan search secara sejajar
            buttons: [
                {
                    extend: 'excel',
                    text: 'Export Excel',
                    className: 'btn btn-success btn-sm',
                    exportOptions: {
                        modifier: {
                            search: 'applied' // Hanya data yang terlihat (terfilter) yang diexport
                        }
                    }
                },
                {
                    extend: 'pdf',
                    text: 'Export PDF',
                    className: 'btn btn-danger btn-sm',
                    exportOptions: {
                        modifier: {
                            search: 'applied' // Hanya data yang terlihat (terfilter) yang diexport
                        }
                    }
                },
            ],
            layout: {
                topStart: 'buttons'
            }
        });

        // Event handler untuk dropdown filter Nama Project
        $('#projectFilter').on('change', function () {
            var projectFilter = $(this).val(); // Mendapatkan nilai Nama Project | Sub Nama Project

            // Terapkan filter pada kolom Nama Project (kolom ke-5 di tabel)
            table.column(4).search(projectFilter).draw();
        });
    });

    function updateDateTime() {
        const now = new Date();
        const options = {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
            hour: '2-digit', minute: '2-digit', second: '2-digit'
        };
        document.getElementById('currentDateTime').textContent = now.toLocaleDateString('id-ID', options);
    }

    // Jalankan fungsi pertama kali
    updateDateTime();

    // Perbarui waktu setiap detik
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
