@extends('layouts.dashboard-layout')
@section('container')

<div class="card">
    <h5 class="card-header text-center text-bold">
        Halaman Edit Data Edit Alat Dan Permesinan
    </h5>
    <div class="card-body">
        <form action="{{ route('tools.update',$find_id->id) }}" method="post">
            @csrf
            @method('patch')
            <div class="mb-3">
                <label for="nama_mesin" class="form-label">Nama Alat Atau Mesin </label>
                <input class="form-control rounded-top @error('nama_mesin') is-invalid @enderror" type="text"
                    name="nama_mesin" placeholder="Harap Di Isi Nama Mesin"
                    value="{{ old('nama_mesin', $find_id->nama_mesin)}}">

                @error('nama_mesin')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="spesifikasi_alat" class="form-label">Spesifikasi Mesin </label>
                <input class="form-control rounded-top @error('spesifikasi_alat') is-invalid @enderror " type="text"
                    name="spesifikasi_alat" placeholder="Harap Di Isi Spesifikasi Alat Atau Mesin"
                    value="{{ old('spesifikasi_alat', $find_id->spesifikasi_alat)}}">
                @error('spesifikasi_alat')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jenis_alat" class="form-label">Jenis Alat Lama </label>
                <input class="form-control rounded-top @error('jenis_alat') is-invalid @enderror " type="text"
                    name="jenis_alat" placeholder="{{ old('jenis_alat', $find_id->jenis_alat)}}" disabled>
                @error('jenis_alat')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="jenis_alat" class="form-label" name="jenis_alat">Jenis Alat </label>
                <select class="form-select" id="basic-usage" name="jenis_alat">
                    <option value="" disabled {{ old('jenis_alat'), $find_id->jenis_alat === null ? 'selected' : '' }}>Pilih salah satu</option>
                    <option value="Alat Pemotong"{{ old('jenis_alat') == $find_id->jenis_alat ? 'selected' : '' }}>Alat Pemotong(Cutting Tools)</option>
                    <option value="Mesin Las"{{ old('jenis_alat') == $find_id->jenis_alat ? 'selected' : '' }}>Mesin las (Machine Welding)</option>
                    <option value="Alat Pengangkat" {{ old('jenis_alat') == $find_id->jenis_alat ? 'selected' : '' }}>Alat Pengangkat</option>
                    <option value="Alat Pemukul" {{ old('jenis_alat') == $find_id->jenis_alat ? 'selected' : '' }}>Alat Pemukul (Lifting Equipment)</option>
                    <option value="Mesin Pembentuk" {{ old('jenis_alat') == $find_id->jenis_alat ? 'selected' : '' }}>Mesin Pembentuk</option>
                    <option value="Alat Pemukul"{{ old('jenis_alat') == $find_id->jenis_alat ? 'selected' : '' }}>Mesin Pemukul(Hammer)</option>
                    <option value="Alat Pengunci"{{ old('jenis_alat') == $find_id->jenis_alat ? 'selected' : '' }}>Alat Pengunci</option>
                    <option value="Alat Pengukur"{{ old('jenis_alat') == $find_id->jenis_alat ? 'selected' : '' }}>Alat Pengunci</option>
                    <option value="Alat Tester" {{ old('jenis_alat') == $find_id->jenis_alat ? 'selected' : '' }}>Alat Tester</option>

                    @error('jenis_alat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </select>
            </div>



            <div class="mb-3">
                <label for="" class="form-label">Tipe Data Alat lama </label>
                <input class="form-control rounded-top" type="text"
                    placeholder="{{ old('tipe_alat', $find_id->tipe_alat)}}" disabled>
            </div>


            <div class="mb-3">
                <label for="tipe_alat" class="form-label" name="tipe_alat">Tipe Alat </label>
                <select class="form-select" id="basic-usage2" name="tipe_alat">
                    <option selected disabled {{ old('jenis_alat'), $find_id->jenis_alat === null ? 'selected' : '' }}>Pilih Tipe Alat</option>
                    <option value="Kecil"{{ old('tipe_alat') == $find_id->tipe_alat ? 'selected' : '' }}>Kecil</option>
                    <option value="Sedang"{{ old('tipe_alat') == $find_id->tipe_alat ? 'selected' : '' }}>Sedang</option>
                    <option value="Besar"{{ old('tipe_alat') == $find_id->tipe_alat ? 'selected' : '' }}>Besar/Berat</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity </label>
                <input class="form-control rounded-top @error('quantity') is-invalid @enderror " type="number"
                    name="quantity" placeholder="Harap Di Isi Quantity Alat Atau Mesin "
                    value="{{ old('quantity', $find_id->quantity)}}">
                @error('quantity')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Jenis Quantity Data Lama </label>
                <input class="form-control rounded-top" type="text"
                    placeholder="{{ old('jenis_quantity', $find_id->jenis_quantity)}}" disabled>
            </div>

            <div class="mb-3">
                <label for="jenis_quantity" class="form-label" name="jenis_quantity">Jenis Quantity  </label>
                <select class="form-select" id="basic-usage2" name="jenis_quantity" data-placeholder="Choose one thing">
                    <option selected disabled {{ old('jenis_quantity'), $find_id->jenis_quantity === null ? 'selected' : '' }}>Pilih Jenis Quantity</option>
                    <option value="Unit"{{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Unit</option>
                    <option value="Pcs"{{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Pcs</option>
                    <option value="Set"{{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Set</option>
                </select>
            </div>

            <div class="row mb-3">
                <div class="col sm-4">
                    <a href="{{ route('tools.index') }}" class="btn btn-secondary">Go Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>


            </div>
        </form>

    </div>
</div>

@endsection

@push('scripts')
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

<script>
    $( '#basic-usage' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
} );

$( '#basic-usage2' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
} );


</script>

@endpush
