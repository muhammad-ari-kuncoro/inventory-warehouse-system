@extends('layouts.dashboard-layout')
@section('container')
<div class="card">
    <h5 class="card-header text-center">
        Dashboard Menu Barang Masuk
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
            <div class="col-sm-2 mb-3">
                <a href="" class="btn btn-success w-100">Print Data</a>
            </div>

            <!-- Add Button -->
            <div class="col-sm-2 mb-3">
                {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Tambah Data
                </button> --}}
                <a href="{{route('good-received.create')}}" class="btn btn-primary">Tambah Data</a>
            </div>


        </div>




        <div class="table-responsive">

            <table class="table table-bordered" id="myTable6">
                <thead>
                    <tr class="table-info text-center">
                        <th>No </th>
                        <th>Tanggal masuk </th>
                        <th>No Transaksi </th>
                        <th>Nama Supplier </th>
                        <th>Kode Surat Jalan</th>
                        <th>Nama Barang </th>
                        <th>Quantity Masuk</th>
                        <th>Quantity Jenis</th>
                        <th>Jenis Stock</th>
                        <th>Keterangan Barang</th>
                        <th>Aksi </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data_good_received as $data )
                    <tr class="text-center">

                        <td class="text-center">{{$loop->iteration}}</td>
                        <td>{{$data->tanggal_masuk}}</td>
                        <td>{{$data->no_transaksi}}</td>
                        <td>{{$data->nama_supplier}}</td>
                        <td>{{$data->kode_surat_jalan}}</td>
                        <!-- Tampilkan Nama Material, Consumable, dan Tool -->
                        <td>
                            {{ optional($data->material)->nama_material
                                ?? optional($data->consumable)->nama_consumable
                                ?? optional($data->tool)->nama_tool
                                ?? '-' }}
                        </td>

                        <td class="text-center">{{$data->quantity}}</td>
                        <td>{{$data->quantity_jenis}}</td>
                        <td>{{$data->jenis_barang}}</td>
                        <td>{{$data->keterangan_barang}}</td>
                        <td>
                            <div class="mb-1">
                                <a href=""><span class="btn btn-warning btn-sm">Edit</a></span>
                            </div>


                            {{-- <div class="mb-1">
                                <a href=""><span class="btn btn-danger btn-sm">Hapus</a></span>
                            </div> --}}
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
    let table = new DataTable('#myTable6');

</script>
@endpush
