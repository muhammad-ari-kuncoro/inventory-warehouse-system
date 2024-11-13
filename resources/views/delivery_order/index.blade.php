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

            <table class="table table-bordered" id="myTable7">
                <thead>
                    <tr class="table-info text-center">
                        <th>No</th>
                        <th>Tanggal Pengiriman</th>
                        <th>PO No</th>
                        <th>Nama Pengiriman Project</th>
                        <th>Items Descriptions</th>
                        <th>Pengirim</th>
                        <th>Dikirim </th>
                        <th>Quantity </th>
                        <th>Satuan</th>
                        <th>Keterangan Item</th>
                        <th>Delivery Order No</th>
                        <th>Aksi </th>
                    </tr>
                </thead>
                <tbody>

                    <tr class="text-center">


                        <td>hellow world</td>
                        <td>hellow world</td>
                        <td>hellow world</td>
                        <td>hellow world</td>
                        <td>hellow world</td>
                        <td>hellow world</td>
                        <td>hellow world</td>
                        <td>hellow world</td>
                        <td>hellow world</td>
                        <td>hellow world</td>
                        <td>hellow world</td>
                        <td>
                            <div class="mb-1">
                                <a href=""><span class="btn btn-warning btn-sm">Edit</a></span>
                            </div>
                                {{-- <div class="mb-1">
                                    <a href=""><span class="btn btn-danger btn-sm">Hapus</a></span>
                                </div> --}}
                        </td>

                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@push('scripts')
<script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script>
    let table = new DataTable('#myTable7');
</script>
@endpush
