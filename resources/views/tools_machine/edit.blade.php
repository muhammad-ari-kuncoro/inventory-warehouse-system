@extends('layouts.dashboard-layout')
@section('container')

<div class="card">
    <h5 class="card-header text-center text-bold">
        Halaman Edit Data Edit Alat Dan Permesinan
    </h5>
    <div class="card-body">
        <form action="" method="post">
            @csrf
            @method('patch')
            <div class="mb-3">
                <label for="nama_alat" class="form-label">Nama Alat Atau Mesin </label>
                <input class="form-control rounded-top @error('nama_alat') is-invalid @enderror" type="text"
                    name="nama_alat" placeholder="Harap Di Isi Nama Alat Atau Mesin"
                    value="{{ old('nama_alat', $find_id->nama_alat)}}">

                @error('nama_alat')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="spesifikasi_alat" class="form-label">Spesifikasi Alat Atau Mesin </label>
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
                <select class="form-select" id="basic-usage" name="jenis_alat" data-placeholder="Choose one thing">
                    <option value="" disabled {{ old('jenis_alat'), $find_id->jenis_alat === null ? 'selected' : '' }}>Pilih salah satu</option>
                    <option value="Alat Pemotong"{{ old('jenis_alat') == $find_id->jenis_alat ? 'selected' : '' }}>Alat Pemotong(Cutting Tools)</option>
                    <option value="Mesin Las"{{ old('jenis_alat') == $find_id->jenis_alat ? 'selected' : '' }}>Mesin las (Machine Welding)</option>
                    <option value="Alat Pengangkat">Alat Pengangkat</option>
                    <option value="Alat Pemukul ">Alat Pemukul (Lifting Equipment)</option>
                    <option value="Mesin Pembentuk">Mesin Pembentuk</option>
                    <option value="Alat Pemukul">Mesin Pemukul(Hammer)</option>
                    <option value="Alat Pengunci">Alat Pengunci</option>
                    <option value="Alat Pengukur">Alat Pengunci</option>
                    <option value="Alat Tester">Alat Tester</option>

                    @error('jenis_alat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </select>
            </div>



            <div class="mb-3">
                <label for="" class="form-label">Kategori Nama Project Lama </label>
                <input class="form-control rounded-top" type="text"
                    placeholder="{{ old('kategori_project', $find_id->kategori_project)}}" disabled>
            </div>


            <div class="mb-3">
                <label for="tipe_alat" class="form-label" name="tipe_alat">Tipe Alat </label>
                <select class="form-select" id="basic-usage2" data-placeholder="Choose one thing">
                    <option selected disabled>Pilih Tipe Alat</option>
                    <option>Reactive</option>
                    <option>Solution</option>
                    <option>Conglomeration</option>
                    <option>Algoritm</option>
                    <option>Holistic</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="no_jo_project" class="form-label">No Jo Project </label>
                <input class="form-control rounded-top @error('no_jo_project') is-invalid @enderror" type="text"
                    name="no_jo_project" placeholder="Harap Di Isi No Jo Project"
                    value="{{ old('no_jo_project', $find_id->no_jo_project)}}">

                @error('no_jo_project')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror


            </div>




            <div class="row mb-3">
                <div class="col sm-4">
                    <a href="{{ route('project.index') }}" class="btn btn-secondary">Go Back</a>
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
