@extends('layouts.dashboard-layout')
@section('container')


<div class="card">
    <h5 class="card-header text-center">
        Dashboard Menu Material
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
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Tambah Data
        </button>
        <a href="" class="btn btn-success mb-3">Print Data</a>
        <table class="table table-bordered">

            <tr class="table-info text-center">
                <th>No</th>
                <th>Nama Materials</th>
                <th>Spesifikasi Materials</th>
                <th>Kode Material</th>
                <th>Jenis Quantity</th>
                <th>Quantity</th>
                <th>Jenis Materials</th>
                <th>Nama Project</th>
                <th>Sub Nama Project</th>
                <th>Aksi </th>
            </tr>
            <tr>
                <td>hello world</td>
                <td>hello world</td>
                <td>hello world</td>
                <td>hello world</td>
                <td>hello world</td>
                <td>hello world</td>
                <td>hello world</td>
                <td>hello world</td>
                <td>hello world</td>
                <td>
                    <div class="mb-1">

                        <a href=""><span class="btn btn-warning btn-sm">Edit</a></span>
                    </div>

                    <a href=""><span class="btn btn-danger btn-sm">Delete</a></span>
    </div>
    </td>
    </tr>
    </table>
    <div class="mb-3 mt-3">
        {{-- {{ $menu_project->links('pagination::bootstrap-5') }} --}}
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_material" class="form-label">Nama Material</label>
                        <input class="form-control rounded-top  @error('nama_material') is-invalid @enderror"
                            type="text" name="nama_material" placeholder="Harap Di Isi Nama Material" required>
                        @error('nama_material')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="spesifikasi_material" class="form-label">Spesifikasi Materials</label>
                        <input class="form-control rounded-top @error('spesifikasi_material') is-invalid @enderror"
                            type="text" name="spesifikasi_material" placeholder="Harap Di Isi Spesifikasi Material"
                            required>
                        @error('spesifikasi_material')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity Materials</label>
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
                        <select class="form-select rounded-top @error('jenis_quantity') is-invalid @enderror"
                            name="jenis_quantity" required>
                            <option selected disabled>Pilih Jenis Quantity</option>
                            <option value="Besar">Besar</option>
                            <option value="Kecil">Kecil</option>
                            @error('jenis_quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                            @enderror
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="jenis_material" class="form-label" name="jenis_material">Kode Materials </label>
                        <select class="form-select rounded-top @error('jenis_material') is-invalid @enderror"
                            name="jenis_material" required>
                            <option selected disabled>Pilih Jenis Material</option>
                            <option value="Besar">Besar</option>
                            <option value="Kecil">Kecil</option>
                            @error('jenis_material')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="formFile" name="no_jo_project" class="form-label">No Jo Project </label>
                        <input class="form-control rounded-top @error('no_jo_project') is-invalid @enderror" type="text"
                            name="no_jo_project" placeholder="Harap Di Isi Sub Nama Project" required>
                        @error('no_jo_project')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="project_id" class="form-label" name="project_id">Nama Kategori Project</label>
                        <select class="form-select rounded-top @error('project_id') is-invalid @enderror"
                            name="project_id" required>
                            @foreach ($data_project as $data )

                            <option selected disabled>Pilih Jenis Project</option>
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
