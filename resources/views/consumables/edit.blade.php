@extends('layouts.dashboard-layout')
@section('container')

<div class="card">
    <h5 class="card-header text-center">
            Dashboard Edit Consumable
    </h5>
    <div class="card-body">

        <form action="{{route('consumable.update',$find_id->id)}}" method="post">
            @csrf
            @method('patch')
            <div class="mb-3">
                <label for="nama_consumable" class="form-label">Nama Consumable </label>
                <input class="form-control rounded-top @error('nama_consumable') is-invalid @enderror" type="text" name="nama_consumable"
                    placeholder="Harap Di Isi Nama Consumable" value="{{ old('nama_consumable', $find_id->nama_consumable)}}">
                    @error('nama_consumable')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
            </div>

            <div class="mb-3">
                <label for="spesifikasi_consumable" class="form-label">Spesifikasi Consumable </label>
                <input class="form-control rounded-top @error('spesifikasi_consumable') is-invalid @enderror " type="text" name="spesifikasi_consumable"
                    placeholder="Harap Di Isi Spesifikasi Consumable" value="{{ old('spesifikasi_consumable', $find_id->spesifikasi_consumable)}}">
                    @error('spesifikasi_consumable')
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

            <label for="harga_consumable" class="form-label" name="harga_consumable">Harga Consumable </label>
            <div class="input-group mb-3">
                <span class="input-group-text">Rp</span>
                <input type="text" class="form-control" name="harga_consumable" id="hargaConsumable" aria-label="Amount (to the nearest Rupiah)" oninput="formatCurrency(this)" value="{{ old('harga_consumable', $find_id->harga_consumable)}}">
                <span class="input-group-text">.00</span>
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
                    <option value="Pasang" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Pasang</option>
                    <option value="Lusin" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Lusin</option>
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
                    placeholder="{{ old('jenis_consumable', $find_id->jenis_consumable)}}" disabled>
            </div>

            <div class="mb-3">
                <label for="jenis_consumable" class="form-label" name="jenis_consumable">Jenis Consumable </label>
                <select class="form-select rounded-top @error('jenis_consumable') is-invalid @enderror"  value="{{ old('jenis_consumable', $find_id->jenis_consumable)}}"
                    name="jenis_consumable" required>
                    <option value="" disabled {{ old('jenis_consumable'), $find_id->jenis_consumable === null ? 'selected' : '' }}>Pilih salah satu</option>
                    <option value="General Consumable" {{ old('jenis_consumable') == $find_id->jenis_consumable ? 'selected' : '' }}>General Consumable</option>
                    <option value="Welding Consumable" {{ old('jenis_consumable') == $find_id->jenis_consumable ? 'selected' : '' }}>Welding Consumable</option>
                    <option value="Safety Consumable" {{ old('jenis_consumable') == $find_id->jenis_consumable ? 'selected' : '' }}>Safety Consumable</option>
                    @error('jenis_consumable')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </select>
            </div>
            {{-- End --}}


            <div class="row mb-3">
                <div class="col sm-4">
                <a href="{{ route('consumable.index') }}" class="btn btn-secondary">Go Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>


            </div>
        </form>

    </div>
</div>

@endsection
