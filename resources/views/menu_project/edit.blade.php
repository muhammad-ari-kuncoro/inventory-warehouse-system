@extends('layouts.dashboard-layout')
@section('container')

<div class="card">
    <h5 class="card-header text-center">

    </h5>
    <div class="card-body">
        <form action="{{ route('edit_project.update',$find_id->id) }}" method="post">
            @csrf
            @method('patch')
            <div class="mb-3">
                <label for="nama_project" class="form-label">Nama Project </label>
                <input class="form-control rounded-top @error('nama_project') is-invalid @enderror" type="text" name="nama_project"
                    placeholder="Harap Di Isi Nama Project" value="{{ old('nama_project', $find_id->nama_project)}}">
                    @error('nama_project')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
            </div>

            <div class="mb-3">
                <label for="sub_nama_project" class="form-label">Sub Nama Project </label>
                <input class="form-control rounded-top @error('sub_nama_project') is-invalid @enderror " type="text" name="sub_nama_project"
                    placeholder="Harap Di Isi Sub Nama Project" value="{{ old('sub_nama_project', $find_id->sub_nama_project)}}">
                    @error('sub_nama_project')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Kategori Nama Project Lama </label>
                <input class="form-control rounded-top" type="text"
                    placeholder="{{ old('kategori_project', $find_id->kategori_project)}}" disabled>
            </div>


            <div class="mb-3">
                <label for="kategori_project" class="form-label" name="kategori_project">Kategori Nama Project baru </label>
                <select class="form-select rounded-top @error('kategori_project') is-invalid @enderror" name="kategori_project" >
                    <option selected disabled>Open this select menu</option>
                    <option value="General Industri">General Industri</option>
                    <option value="Oil Dan Migas">Oil Dan Migas</option>
                    <option value="Panas Bumi">Panas Bumi</option>
                </select>
                @error('kategori_project')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="mb-3">
                <label for="no_jo_project" class="form-label">No Jo Project </label>
                <input class="form-control rounded-top @error('no_jo_project') is-invalid @enderror" type="text" name="no_jo_project"
                    placeholder="Harap Di Isi No Jo Project" value="{{ old('no_jo_project', $find_id->no_jo_project)}}">
                    @error('no_jo_project')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
            </div>




            <div class="row mb-3">
                <div class="col sm-4">
                <a href="{{ route('menu_project.index') }}" class="btn btn-secondary">Go Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>


            </div>
        </form>

    </div>
</div>

@endsection
