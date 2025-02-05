@extends('layouts.dashboard-layout')
@section('container')

<div class="card">
    <h5 class="card-header text-center">

    </h5>
    <div class="card-body">
        <form action="{{ route('project.update',$find_id->id) }}" method="post">
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

                    <option value="" disabled {{ old('kategori_project'), $find_id->kategori_project === null ? 'selected' : '' }}>Pilih salah satu</option>
                    <option value="General Industri" {{ old('kategori_project') == $find_id->kategori_project ? 'selected' : '' }}>General Industri</option>
                    <option value="Oil Dan Migas Industri" {{ old('kategori_project') == $find_id->kategori_project ? 'selected' : '' }}>Oil Dan Migas Industri</option>
                    <option value="Panas Bumi Industri" {{ old('kategori_project') == $find_id->kategori_project ? 'selected' : '' }}>Panas Bumi Industri</option>

                    @error('kategori_project')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror


                </select>
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

            <div class="mb-3">
                <label for="no_po_project" class="form-label">No Po Project </label>
                <input class="form-control rounded-top @error('no_po_project') is-invalid @enderror" type="text" name="no_po_project"
                    placeholder="Harap Di Isi No Jo Project" value="{{ old('no_po_project', $find_id->no_po_project)}}">

                    @error('no_po_project')
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            console.log('Preloader found. It will hide after 3 seconds...');
            setTimeout(function () {
                preloader.style.display = 'none'; // Sembunyikan preloader setelah 3 detik
                console.log('Preloader hidden.');
            }, 1500); // Durasi 3000 ms = 3 detik
        } else {
            console.error('Preloader element not found!');
        }
    });

</script>
