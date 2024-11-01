@extends('layouts.dashboard-layout')
@section('container')

<div class="card">
    <h5 class="card-header text-center">

    </h5>
    <div class="card-body">
        <form action="" method="post">
            @csrf
            @method('patch')
            <div class="mb-3">
                <label for="nama_material" class="form-label">Nama Material </label>
                <input class="form-control rounded-top @error('nama_material') is-invalid @enderror" type="text" name="nama_material"
                    placeholder="Harap Di Isi Nama Material" value="">
                    @error('nama_material')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
            </div>

            <div class="mb-3">
                <label for="spesifikasi_material" class="form-label">Spesifikasi Material </label>
                <input class="form-control rounded-top @error('spesifikasi_material') is-invalid @enderror " type="text" name="spesifikasi_material"
                    placeholder="Harap Di Isi Spesifikasi Material" value="">
                    @error('spesifikasi_material')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input class="form-control rounded-top @error('quantity') is-invalid @enderror" type="text" name="quantity"
                    placeholder="Harap Di Isi Quantity" value="">
                    @error('quantity')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Kategori Nama Project Lama </label>
                <input class="form-control rounded-top" type="text"
                    placeholder="" disabled>
            </div>


            <div class="mb-3">
                <label for="project_id" class="form-label" name="project_id">Kategori Nama Project baru </label>
                <select class="form-select rounded-top @error('project_id') is-invalid @enderror" name="project_id" >
                    @foreach ($data_project as $data )

                    <option selected disabled>Pilih Kategori Project</option>
                    <option value="{{ $data->id }}">
                        {{ $data->nama_project }} | {{ $data->sub_nama_project }} | NO JO : {{ $data->no_jo_project }}
                    </option>
                    @endforeach
                </select>
                @error('project_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="mb-3">
                <label for="jenis_material" class="form-label">No Jenis Material </label>
                <input class="form-control rounded-top @error('jenis_material') is-invalid @enderror" type="text" name="jenis_material"
                    placeholder="Harap Di Isi Jenis Material" value="">
                    @error('jenis_material')
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
