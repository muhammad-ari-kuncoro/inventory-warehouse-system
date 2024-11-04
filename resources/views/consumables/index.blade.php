@extends('layouts.dashboard-layout')
@section('container')
<div class="card">
    <h5 class="card-header text-center">Dashboard Menu Consumables</h5>
     {{-- Session Flash Data --}}
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

    {{-- Tampilan Button Data Dan Print  --}}
    <div class="row align-items-center mb-2">
        <!-- Print Button -->
        <div class="col-sm-2 mb-3">
            <a href="" class="btn btn-success w-100">Print Data</a>
        </div>

        <!-- Add Button -->
        <div class="col-sm-2 mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Tambah Data
            </button>
        </div>

        <!-- Tampilan Pencarian -->
        <div class="col mb-3">
            <form action="{{ route('consumable.index') }}" method="get" class="d-flex align-items-center">
                <input class="form-control me-2" type="text" name="search" placeholder="Pencarian" value="{{ $search ?? '' }}">
                <button type="submit" name="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>
    </div>


    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr class="table-info text-center">
                    <th>No</th>
                    <th>Nama Consumables</th>
                    <th>Spesifikasi Consumables</th>
                    <th>Kode Consumable</th>
                    <th>Quantity</th>
                    <th>Jenis Quantity</th>
                    <th>Jenis Consumables</th>
                    <th>Nama Project</th>
                    <th>Sub nama Project</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <p class="d-none">{{ $i= 1; }}</p>
            @foreach ($data_consumables as $data )
            <tbody>
                <tr>
                    <td>{{$i++;}}</td>
                    <td>{{$data->nama_consumable}}</td>
                    <td>{{$data->spesifikasi_consumable}}</td>
                    <td>{{$data->kode_consumable}}</td>
                    <td class="text-center">{{$data->quantity}}</td>
                    <td class="text-center">{{$data->jenis_quantity}}</td>
                    <td>{{$data->jenis_consumable}}</td>
                    <td>{{$data->project->nama_project}}</td>
                    <td class="text-center">{{$data->project->sub_nama_project}} </td>
                    <td>
                        <div class="mb-1">
                            <a href="{{route('consumable.edit',$data->id)}}" class="btn btn-warning btn-sm">Edit</a>
                        </div>
                        <div class="mb-1">
                            <a href="" class="btn btn-danger btn-sm">Hapus</a>
                        </div>
                    </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
    <div class="mb-3 mt-3">
        {{ $data_consumables->links('pagination::bootstrap-5') }}
    </div>

    </div>
  </div>
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Form Tambah Consumable</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('consumable.create')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_consumable" class="form-label">Nama Consumable</label>
                        <input class="form-control rounded-top  @error('nama_consumable') is-invalid @enderror"
                            type="text" name="nama_consumable" placeholder="Harap Di Isi Nama Consumable" required>
                        @error('nama_consumable')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="spesifikasi_consumable" class="form-label">Spesifikasi Consumable</label>
                        <input class="form-control rounded-top @error('spesifikasi_consumable') is-invalid @enderror"
                            type="text" name="spesifikasi_consumable" placeholder="Harap Di Isi Spesifikasi Consumable"
                            required>
                        @error('spesifikasi_consumable')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity Consumable</label>
                        <input class="form-control rounded-top @error('quantity') is-invalid @enderror" type="number"
                            name="quantity" placeholder="Harap Di Isi Quantity Material" required>
                        @error('quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="jenis_quantity" class="form-label" name="jenis_quantity">Jenis Quantity </label>
                        <select class="form-select rounded-top @error('jenis_quantity') is-invalid @enderror" name="jenis_quantity" required>
                            <option selected disabled>Pilih Jenis Quantity</option>
                            <option value="Pcs">Pcs</option>
                            <option value="Batang">Batang</option>
                            <option value="Set">Set</option>
                            <option value="Karung">Karung</option>
                            <option value="Box">Box</option>
                            <option value="Pasang">Pasang</option>
                            <option value="Kilo Gram">KG</option>
                            <option value="Lusin">Lusin</option>
                            @error('jenis_quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="jenis_consumable" class="form-label" name="jenis_consumable">Jenis Consumable </label>
                        <select class="form-select rounded-top @error('jenis_consumable') is-invalid @enderror"
                            name="jenis_consumable" required>
                            <option selected disabled>Pilih Jenis Material</option>
                            <option value="General Consumable">General Consumable</option>
                            <option value="Welding Consumable">Welding Consumable</option>
                            <option value="Safety Consumable">Safety Consumable</option>

                            @error('jenis_consumable')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="project_id" class="form-label" name="project_id">Nama Kategori Project</label>
                        <select class="form-select rounded-top @error('project_id') is-invalid @enderror"
                            name="project_id" required>
                            <option selected disabled>Pilih Kategori Project</option>
                            @foreach ($data_project as $data )
                            <option value="{{ $data->id }}">{{ $data->nama_project }} | {{ $data->sub_nama_project }} | NO JO : {{ $data->no_jo_project }} </option>
                            @error('project_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                            @endforeach

                        </select>
                    </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
