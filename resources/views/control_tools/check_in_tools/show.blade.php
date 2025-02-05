@extends('layouts.dashboard-layout')
@push('styles')
<style>
    #div_tool {
        display: none;
    }

    #div_consumable {
        display: none;
    }

    #div_material {
        display: none;
    }
</style>
@endpush
@section('container')

<div class="row">
    <!-- Card 1: Data Umum -->
    <div class="col-md-6">
        <div class="card mb-3">
            <h5 class="card-header text-center text-bold">
                Form Data Diri Pengembalian Alat
            </h5>
            <div class="card-body">
                <form action="{{ route('check-in-tools.store') }}" method="post">
                    @csrf




                    <div class="mb-3">
                        <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian</label>
                        <input class="form-control rounded-top @error('tanggal_pengembalian') is-invalid @enderror" type="text"
                            name="tanggal_pengembalian" placeholder="Harap Di Isi Bagian Divisi Pengambil" value="{{ old('tanggal_pengembalian',$find_id_check_in_tool->tanggal_pengembalian) }}" disabled>
                        @error('bagian_divisi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>



                    <div class="mb-3">
                        <label for="kd_pengembalian_alat" class="form-label">Kode Pengembalian</label>
                        <input class="form-control rounded-top @error('kd_pengembalian_alat') is-invalid @enderror" type="text"
                            name="kd_pengembalian_alat" placeholder="Harap Di Isi Bagian Divisi Pengambil" value="{{ old('kd_pengembalian_alat',$find_id_check_in_tool->kd_pengembalian_alat) }}" disabled>
                        @error('bagian_divisi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>



                    <div class="mb-3">
                        <label for="nama_pengembalian" class="form-label">Nama Pengembalian</label>
                        <input class="form-control rounded-top @error('nama_pengembalian') is-invalid @enderror" type="text"
                            name="nama_pengembalian" placeholder="Harap Di Isi Bagian Divisi Pengambil" value="{{ old('nama_pengembalian',$find_id_check_in_tool->nama_pengembalian) }}" disabled>
                        @error('bagian_divisi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Detail Barang -->
    <div class="col-md-6">
        <div class="card">
            <h5 class="card-header text-center text-bold">
                Data Barang
            </h5>
            <div class="card-body">



                <div class="mb-3">
                    <label for="nama_alat" class="form-label">Nama Pengembalian</label>
                    <input class="form-control rounded-top @error('nama_alat') is-invalid @enderror" type="text"
                        name="nama_alat" placeholder="Harap Di Isi Bagian Divisi Pengambil" value="{{ old('nama_alat',$find_id_check_in_tool->tool->nama_alat) }}" disabled>
                    @error('bagian_divisi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="spesifikasi_alat" class="form-label">Nama Pengembalian</label>
                    <input class="form-control rounded-top @error('spesifikasi_alat') is-invalid @enderror" type="text"
                        name="spesifikasi_alat" placeholder="Harap Di Isi Bagian Divisi Pengambil" value="{{ old('spesifikasi_alat',$find_id_check_in_tool->tool->spesifikasi_alat) }}" disabled>
                    @error('bagian_divisi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input class="form-control rounded-top @error('quantity') is-invalid @enderror" type="text"
                        name="quantity" placeholder="Harap Di Isi Bagian Divisi Pengambil" value="{{ old('quantity',$find_id_check_in_tool->tool->quantity) }}" disabled>
                    @error('bagian_divisi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jenis_quantity" class="form-label">Quantity</label>
                    <input class="form-control rounded-top @error('jenis_quantity') is-invalid @enderror" type="text"
                        name="jenis_quantity" placeholder="Harap Di Isi Bagian Divisi Pengambil" value="{{ old('jenis_quantity',$find_id_check_in_tool->tool->jenis_quantity) }}" disabled>
                    @error('bagian_divisi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>



                <div class="mb-3">
                    <label class="form-label">Keterangan Alat</label>
                    <textarea class="form-control" placeholder="{{ old('jenis_quantity',$find_id_check_in_tool->tool->jenis_quantity) }}" name="keterangan_alat"  style="height: 100px" disabled></textarea>
                </div>

                <div class="mb-3 text-center">
                    <a href="{{ route('check-in-tools.index') }}" class="btn btn-secondary">Go Back</a>

                </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
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

<script>
    $('.select-2').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
    });
</script>
<script>
    $(document).ready(function(){
        $('#jenis_barang').on('change', function(){
            var value = this.value;

            if (value == 'Materials') {
                $('#div_material').show();
                $('#div_consumable').hide();
                $('#div_tool').hide();
            } else if (value == 'Consumables') {
                $('#div_material').hide();
                $('#div_consumable').show();
                $('#div_tool').hide();
            } else if (value == 'Tools') {
                $('#div_material').hide();
                $('#div_consumable').hide();
                $('#div_tool').show();
            }
        });
    });
</script>
@endpush
