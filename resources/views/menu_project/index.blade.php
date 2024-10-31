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
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Tambah Data
        </button>
        <a href="" class="btn btn-success mb-3">Print Data</a>
        <table class="table table-bordered">
            <tr class="table-info text-center">
                <th>No</th>
                <th>Nama Project</th>
                <th>Sub Nama Project</th>
                <th>Kategori Nama Project</th>
                <th>Kode Project</th>
                <th>No Jo Project</th>
                <th>Aksi </th>
            </tr>

            <p class="d-none">{{ $i= 1; }}</p>
            @foreach ($menu_project as $data )
            <tr class="text-center">

                <td>{{ $i++; }}</td>
                <td>{{ $data->nama_project }}</td>
                <td>{{ $data->sub_nama_project }}</td>
                <td>{{ $data->kategori_project }}</td>
                <td>{{ $data->kode_project }}</td>
                <td>{{ $data->no_jo_project }}</td>
                <td>
                    <div class="mb-1">
                        <a href="{{route('edit_project.edit',$data->id)}}"><span class="btn btn-warning btn-sm">Edit</a></span>
                    </div>


                        {{-- <div class="mb-1">
                            <a href=""><span class="btn btn-danger btn-sm">Hapus</a></span>
                        </div> --}}
                </td>

            </tr>
            @endforeach
        </table>
        <div class="mb-3 mt-3">
            {{ $menu_project->links('pagination::bootstrap-5') }}
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
                <form action="{{ route('menu_project.tambah') }}" method="post">
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
                        <select class="form-select rounded-top @error('nama_project') is-invalid @enderror" name="kategori_project" required>
                            <option selected disabled>Open this select menu</option>
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
</div>

@endsection
