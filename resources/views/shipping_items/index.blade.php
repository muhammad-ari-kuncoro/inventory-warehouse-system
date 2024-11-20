@extends('layouts.dashboard-layout')
@section('container')
<div class="card">
    <h5 class="card-header text-center">
        Dashboard Menu Barang Keluar
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



            <!-- Add Button -->
            <div class="col-sm-2">
                <a  class="btn btn-primary" data-bs-target="#exampleModal" href="{{route('shipping-items.create')}}">
                    Tambah Data
                </a>
            </div>


        </div>




        <div class="table-responsive">

            <table class="table table-bordered  table-hover display" id="myTable10">
                <thead>
                    <tr class="table-info">
                        <th>No</th>
                        <th>Tanggal Keluar</th>
                        <th>Kode Surat Jalan barang keluar</th>
                        <th class="text-center">Pengirim </th>
                        <th>Alamat</th>
                        <th>Deskripsi Barang</th>
                        <th>Quantity Barang Keluar</th>
                        <th>Jenis Quantity</th>
                        <th>Keterangan Barang</th>
                        <th>Nama Project</th>
                        <th>Aksi </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_shipping as $data )

                    <tr class="text-center">

                        <td class="text-center">{{$loop->iteration}}</td>
                        <td>{{$data->tgl_kirim}}</td>
                        <td>{{$data->kd_sj_brg_keluar}}</td>
                        <td>{{$data->pengirim}}</td>
                        <td>{{$data->tujuan}}</td>
                        <td>{{$data->deskripsi_brg}}</td>
                        <td class="text-center">{{$data->quantity}}</td>
                        <td>{{$data->jenis_quantity}}</td>
                        <td>{{$data->keterangan_brg}}</td>
                        <td>{{$data->project->nama_project}} | {{$data->project->sub_nama_project}}</td>
                        <td>
                            <div class="mb-1">
                                <a href="{{  route('shipping-items.edit',$data->id) }}"><span class="btn btn-warning btn-sm">Edit</a></span>
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


{{--
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Menu Project</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_project" class="form-label">Nama Project </label>
                        <input class="form-control rounded-top  @error('nama_project') is-invalid @enderror" type="text" name="nama_project"
                            placeholder="Harap Di Isi Nama Project" required>
                            @error('nama_project')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                    </div>

                    <div class="mb-3">
                        <label for="formFile" class="form-label">Sub Nama Project </label>
                        <input class="form-control rounded-top @error('sub_nama_project') is-invalid @enderror" type="text" name="sub_nama_project"
                            placeholder="Harap Di Isi Sub Nama Project" required>
                            @error('sub_nama_project')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                    </div>

                    <div class="mb-3">
                        <label for="formFile" class="form-label" name="kategori_project">Kategori Nama Project </label>
                        <select class="form-select rounded-top @error('kategori_project') is-invalid @enderror" name="kategori_project" required>
                            <option selected disabled>Pilih Kategori Nama Project</option>
                            <option value="General Industri">General Industri</option>
                            <option value="Oil Dan Migas">Oil Dan Migas</option>
                            <option value="Panas Bumi">Panas Bumi</option>
                            @error('kategori_project')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                            @enderror
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="formFile" name="no_jo_project" class="form-label">No Jo Project </label>
                        <input class="form-control rounded-top @error('no_jo_project') is-invalid @enderror" type="text" name="no_jo_project"
                            placeholder="Harap Di Isi Sub Nama Project" required>
                            @error('no_jo_project')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                    </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}

@endsection
@push('scripts')
<script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script>
    let table = new DataTable('#myTable10');
</script>
@endpush
