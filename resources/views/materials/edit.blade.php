@extends('layouts.dashboard-layout')
@section('container')

<div class="card">
    <h5 class="card-header text-center">

    </h5>
    <div class="card-body">
        <form action="{{route('material.update',$find_id->id)}}" method="post">
            @csrf
            @method('patch')
            <div class="mb-3">
                <label for="nama_material" class="form-label">Nama Material </label>
                <input class="form-control rounded-top @error('nama_material') is-invalid @enderror" type="text" name="nama_material"
                    placeholder="Harap Di Isi Nama Material" value="{{ old('nama_material', $find_id->nama_material)}}">
                    @error('nama_material')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
            </div>

            <div class="mb-3">
                <label for="spesifikasi_material" class="form-label">Spesifikasi Material </label>
                <input class="form-control rounded-top @error('spesifikasi_material') is-invalid @enderror " type="text" name="spesifikasi_material"
                    placeholder="Harap Di Isi Spesifikasi Material" value="{{ old('spesifikasi_material', $find_id->spesifikasi_material)}}">
                    @error('spesifikasi_material')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input class="form-control rounded-top @error('quantity') is-invalid @enderror" type="number" name="quantity"
                    placeholder="Harap Di Isi Quantity" value="{{ old('quantity', $find_id->quantity)}}">
                    @error('quantity')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
            </div>



            {{-- Data Lama Tidak Bisa di input --}}
            <div class="mb-3">
                <label for="" class="form-label">Jenis Quantity Lama </label>
                <input class="form-control rounded-top" type="text"
                    placeholder="{{ old('jenis_quantity', $find_id->jenis_quantity)}}" disabled>
            </div>




            <div class="mb-3">
                <label for="" class="form-label">Jenis Quantity</label>
                <select class="form-select rounded-top @error('jenis_quantity') is-invalid @enderror"  value="{{ old('jenis_quantity', $find_id->jenis_quantity)}}" name="jenis_quantity">
                    <option value="" disabled {{ old('jenis_quantity'), $find_id->jenis_quantity === null ? 'selected' : '' }}>Pilih salah satu</option>
                    <option value="Pcs" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Pcs</option>
                    <option value="Batang" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Batang</option>
                    <option value="Set" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Set</option>
                    <option value="Karung" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Karung</option>
                    <option value="Box" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Box</option>
                    @error('jenis_quantity')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                  </select>
            </div>



            {{-- Data Lama Tidak Bisa di input --}}
            <div class="mb-3">
                <label for="" class="form-label">Kategori Nama Project Lama </label>
                <input class="form-control rounded-top" type="text"
                    placeholder="{{ old('projet_id', $find_id->project->nama_project)}}" disabled>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Kategori Sub Nama Project Lama </label>
                <input class="form-control rounded-top" type="text"
                    placeholder="{{ old('projet_id', $find_id->project->sub_nama_project)}}" disabled>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">No JO  Project Lama </label>
                <input class="form-control rounded-top" type="text"
                    placeholder="{{ old('projet_id', $find_id->project->no_jo_project)}}" disabled>
            </div>
            {{-- end --}}





            <div class="mb-3">
                <label for="project_id" class="form-label" name="project_id">Kategori Nama Project baru </label>
                <select class="form-select rounded-top @error('project_id') is-invalid @enderror"  value="{{ old('project_id', $find_id->project_id)}}" name="project_id" >
                    @foreach ($data_project as $data )
                    <option value="" disabled {{ old('project_id'), $find_id->project_id === null ? 'selected' : '' }}>Pilih salah satu</option>
                    <option value="{{ $data->id }}" {{ old('project_id') == $find_id->project_id ? 'selected' : '' }}>{{ $data->nama_project }} | {{ $data->sub_nama_project }} | NO JO : {{ $data->no_jo_project }}</option>
                    @endforeach
                </select>
                @error('project_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- data lama tidak bisa di input --}}
            <div class="mb-3">
                <label for="" class="form-label">Jenis Project Lama </label>
                <input class="form-control rounded-top" type="text"
                    placeholder="{{ old('jenis_material', $find_id->jenis_material)}}" disabled>
            </div>

            <div class="mb-3">
                <label for="jenis_material" class="form-label" name="jenis_material">Jenis Materials </label>
                <select class="form-select rounded-top @error('jenis_material') is-invalid @enderror"  value="{{ old('jenis_material', $find_id->jenis_material)}}"
                    name="jenis_material" required>
                    <option value="" disabled {{ old('jenis_material'), $find_id->jenis_material === null ? 'selected' : '' }}>Pilih salah satu</option>
                    <option value="Besar" {{ old('jenis_material') == $find_id->jenis_material ? 'selected' : '' }}>Besar</option>
                    <option value="Kecil" {{ old('jenis_material') == $find_id->jenis_material ? 'selected' : '' }}>Kecil</option>
                    @error('jenis_material')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </select>
            </div>


            <div class="row mb-3">
                <div class="col sm-4">
                <a href="{{ route('material.index') }}" class="btn btn-secondary">Go Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>


            </div>
        </form>

    </div>
</div>

@endsection