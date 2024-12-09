@extends('layouts.dashboard-layout')
@section('container')

<div class="card">
    <h5 class="card-header text-center">

    </h5>
    <div class="card-body">
        <form action="{{ route('delivery-order.update-detail',$find_id->id) }}" method="post">
            @csrf
            @method('patch')
            <div class="mb-3">
                <label for="item_description" class="form-label">Item Description </label>
                <input class="form-control rounded-top @error('item_description') is-invalid @enderror" type="text" name="item_description"
                    placeholder="Harap Di Isi Nama Project" value="{{ old('item_description', $find_id->item_description)}}">
                    @error('item_description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
            </div>

            <div class="mb-3">
                <label for="item_size" class="form-label">Ukuran Barang </label>
                <input class="form-control rounded-top @error('item_size') is-invalid @enderror " type="text" name="item_size"
                    placeholder="Harap Di Isi Sub Nama Project" value="{{ old('item_size', $find_id->item_size)}}">

                    @error('item_size')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
            </div>




            <div class="mb-3">
                <label for="item_qty" class="form-label">Jumlah Quantity </label>
                <input class="form-control rounded-top @error('item_qty') is-invalid @enderror" type="number" min="1" name="item_qty"
                    placeholder="Harap Di Isi No Jo Project" value="{{ old('item_qty', $find_id->item_qty)}}">

                    @error('item_qty')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

            </div>

            <div class="mb-3">
                <label for="item_weight" class="form-label">Berat Barang (KG) </label>
                <input class="form-control rounded-top @error('item_weight') is-invalid @enderror" type="number" min="1" name="item_weight"
                    placeholder="Harap Di Isi No Jo Project" value="{{ old('item_weight', $find_id->item_weight)}}">

                    @error('item_weight')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

            </div>

            <div class="mb-3">
                <label class="form-label">Satuan Barang</label>
                <select class="form-select select-2 @error('satuan_barang') is-invalid @enderror" name="satuan_barang" data-placeholder="Pilih Salah Satu">
                    <option value="" disabled {{ old('satuan_barang'), $find_id->satuan_barang === null ? 'selected' : '' }}>Pilih salah satu</option>
                    <option value="Pcs" {{ old('satuan_barang', $find_id->satuan_barang) == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                    <option value="Unit" {{ old('satuan_barang', $find_id->satuan_barang) == 'Unit' ? 'selected' : '' }}>Unit</option>
                    <option value="Set" {{ old('satuan_barang', $find_id->satuan_barang) == 'Set' ? 'selected' : '' }}>Set</option>
                    <option value="Kg" {{ old('satuan_barang', $find_id->satuan_barang) == 'Kg' ? 'selected' : '' }}>Kg</option>
                    <option value="Lembar" {{ old('satuan_barang', $find_id->satuan_barang) == 'Lembar' ? 'selected' : '' }}>Lembar</option>
                    <option value="EA" {{ old('satuan_barang', $find_id->satuan_barang) == 'EA' ? 'selected' : '' }}>EA</option>
                    <option value="Liter" {{ old('satuan_barang', $find_id->satuan_barang) == 'Liter' ? 'selected' : '' }}>Liter</option>
                    <option value="Drum" {{ old('satuan_barang', $find_id->satuan_barang) == 'Drum' ? 'selected' : '' }}>Drum</option>
                    <option value="MTR" {{ old('satuan_barang', $find_id->satuan_barang) == 'MTR' ? 'selected' : '' }}>MTR</option>
                    <option value="BOX" {{ old('satuan_barang', $find_id->satuan_barang) == 'BOX' ? 'selected' : '' }}>BOX</option>
                </select>
                @error('satuan_barang')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>




            <div class="row mb-3">
                <div class="col sm-4">
                <a href="{{ route('delivery-order.create') }}" class="btn btn-secondary">Go Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>


            </div>
        </form>

    </div>
</div>

@endsection
