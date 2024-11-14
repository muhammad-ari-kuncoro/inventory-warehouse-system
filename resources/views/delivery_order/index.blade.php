@extends('layouts.dashboard-layout')
@section('container')
<div class="card">
    <h5 class="card-header text-center">
        Dashboard Menu Project
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
                <a href="{{route('delivery-order.create')}}" class="btn btn-primary">Tambah Data</a>

            </div>


        </div>




        <div class="table-responsive">

            <table class="table table-bordered table-hover" id="myTable11">
                <thead>
                    <tr class="table-info text-center">
                        <th>No</th>
                        <th>Tanggal Pengiriman</th>
                        <th>Purchase Order No</th>
                        <th>Delivery No</th>
                        <th>Nama Project</th>
                        <th>Items Descriptions</th>
                        <th>Alamat</th>
                        <th>Quantity </th>
                        <th>Satuan</th>
                        <th>Keterangan Item</th>
                        <th>Aksi </th>
                    </tr>
                </thead>
                @foreach ($data_delivery_order as $data)
                <tbody>
                    <tr>
                        <td class="text-center">{{$loop->iteration}}</td>
                        <td class="text-center">{{$data->tanggal_pengiriman}}</td>
                        <td>{{$data->purchase_no}}</td>
                        <td>{{$data->delivery_no}}</td>
                        <td>{{$data->project->nama_project}}|{{$data->project->sub_nama_project}}</td>
                        <td>{{$data->deskripsi_barang}}</td>
                        <td>{{$data->penerima}}</td>
                        <td class="text-center">{{$data->quantity}}</td>
                        <td>{{$data->jenis_quantity}}</td>
                        <td>{{$data->keterangan_barang}}</td>
                        <td>
                            <div class="mb-1">
                                <a href="{{ route('delivery-order.edit',$data->id) }}"><span class="btn btn-warning btn-sm">Edit</a></span>
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
    let table = new DataTable('#myTable11');
</script>
@endpush
