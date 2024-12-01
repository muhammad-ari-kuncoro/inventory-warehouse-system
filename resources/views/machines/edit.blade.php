@extends('layouts.dashboard-layout')
@section('container')

<div class="card">
    <h5 class="card-header text-center text-bold">
        Halaman Edit Data  Permesinan
    </h5>
    <div class="card-body">
        <form action="{{ route('machine.update',$find_id->id) }}" method="post">
            @csrf
            @method('patch')
            <div class="mb-3">
                <label for="nama_mesin" class="form-label">Nama Mesin </label>
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
                <label for="spesifikasi_mesin" class="form-label">Spesifikasi Mesin </label>
                <input class="form-control rounded-top @error('spesifikasi_mesinp') is-invalid @enderror " type="text"
                    name="spesifikasi_mesin" placeholder="Harap Di Isi Spesifikasi Alat Atau Mesin"
                    value="{{ old('spesifikasi_mesin', $find_id->spesifikasi_mesin)}}">
                @error('spesifikasi_mesinp')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jenis_mesin" class="form-label">Jenis Mesin Lama </label>
                <input class="form-control rounded-top @error('jenis_mesin') is-invalid @enderror " type="text"
                    name="jenis_mesin" placeholder="{{ old('jenis_mesin', $find_id->jenis_mesin)}}" disabled>
                @error('jenis_alat')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="jenis_mesin" class="form-label" name="jenis_mesin">Jenis Mesin </label>
                <select class="form-select basic-usage" name="jenis_mesin">
                    <option value="" disabled {{ old('jenis_mesin'), $find_id->jenis_mesin === null ? 'selected' : '' }}>Pilih salah satu</option>
                    <option value="Cutting Machines"{{ old('jenis_mesin') == $find_id->jenis_mesin ? 'selected' : '' }}>Cutting Machines</option>
                    <option value="Forming Machines"{{ old('jenis_mesin') == $find_id->jenis_mesin ? 'selected' : '' }}>Forming Machines</option>
                    <option value="Welding Machines" {{ old('jenis_mesin') == $find_id->jenis_mesin ? 'selected' : '' }}>Welding Machines</option>
                    <option value="Machining Machines" {{ old('jenis_mesin') == $find_id->jenis_mesin ? 'selected' : '' }}>Machining Machines</option>
                    <option value="Surface Treatment Machines" {{ old('jenis_mesin') == $find_id->jenis_mesin ? 'selected' : '' }}>Surface Treatment Machines</option>
                    <option value="Special Machines"{{ old('jenis_mesin') == $find_id->jenis_mesin ? 'selected' : '' }}>Special Machines</option>
                    <option value="Pipe Bending Machines"{{ old('jenis_mesin') == $find_id->jenis_mesin ? 'selected' : '' }}>Pipe Bending Machines</option>


                    @error('jenis_mesin')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
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
                <select class="form-select basic-usage" name="jenis_quantity" data-placeholder="Choose one thing">
                    <option value="" disabled {{ old('jenis_quantity'), $find_id->jenis_quantity === null ? 'selected' : '' }}>Pilih salah satu</option>
                    <option value="Unit"{{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Unit</option>
                    <option value="Pcs"{{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Pcs</option>
                    <option value="Set"{{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Set</option>
                </select>
            </div>

            <label for="harga_mesin" class="form-label">Harga Mesin</label>
            <div class="input-group mb-3">
                <span class="input-group-text">Rp</span>
                <input
                    type="text"
                    class="form-control"
                    name="harga_mesin"
                    id="hargaConsumable"
                    aria-label="Amount (to the nearest Rupiah)"
                    oninput="formatCurrency(this)" value="{{ old('harga_mesin', $find_id->harga_mesin)}}"
                >
                @error('harga_mesin')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                <span class="input-group-text">.00</span>
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


    $( '.basic-usage' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
} );


function formatCurrency(input) {
        // Ambil nilai input, hapus semua karakter selain angka
        let value = input.value.replace(/[^,\d]/g, '');

        // Ubah ke format angka dengan pemisah ribuan
        input.value = new Intl.NumberFormat('id-ID').format(value);
    }



</script>

@endpush
