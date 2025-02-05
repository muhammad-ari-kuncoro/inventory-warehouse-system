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
                Form Detail Data Diri Peminjaman Alat
            </h5>
            <div class="card-body">
                <form action="{{route('consumable-issuance.store')}}" method="post">
                    @csrf

                    <div class="mb-3">
                        <label for="kd_peminjam_tool" class="form-label">Kode Peminjaman Alat </label>
                        <input class="form-control rounded-top @error('kd_peminjam_tool') is-invalid @enderror " type="text" name="kd_peminjam_tool"
                            placeholder="Harap Di Isi Spesifikasi Consumable" value="{{ old('kd_peminjam_tool', $find_id->kd_peminjam_tool)}}" disabled>
                            @error('kd_peminjam_tool')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                    </div>


                    <div class="mb-3">
                        <label for="tanggal_pengambilan" class="form-label">Tanggal Pengambilan</label>
                        <input class="form-control rounded-top @error('tanggal_pengambilan') is-invalid @enderror"
                            type="date" name="tanggal_pengambilan"
                            value="{{ old('tanggal_pengambilan', $find_id->tanggal_pengambilan)}}" disabled>
                        @error('tanggal_pengambilan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


            <div class="mb-3">
                <label for="bagian_divisi" class="form-label">Bagian Divisi </label>
                <input class="form-control rounded-top @error('bagian_divisi') is-invalid @enderror " type="text" name="bagian_divisi"
                    placeholder="Harap Di Isi Spesifikasi Consumable" value="{{ old('bagian_divisi', $find_id->bagian_divisi)}}" disabled>
                    @error('bagian_divisi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
            </div>




            <div class="mb-3">
                <label for="bagian_divisi" class="form-label">Nama Peminjam </label>
                <input class="form-control rounded-top @error('nama_peminjam_alat') is-invalid @enderror " type="text" name="nama_peminjam_alat"
                    placeholder="Harap Di Isi Spesifikasi Consumable" value="{{ old('nama_peminjam_alat', $find_id->nama_peminjam_alat)}}" disabled>
                    @error('nama_peminjam_alat')
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
                    <label for="bagian_divisi" class="form-label">Nama tool </label>
                    <input class="form-control rounded-top @error('nama_pengambil') is-invalid @enderror " type="text" name="nama_pengambil"
                        placeholder="Harap Di Isi Spesifikasi tool" value="{{ old('nama_alat', $find_id->tool->nama_alat)}}" disabled>
                        @error('nama_pengambil')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                </div>

                <div class="mb-3">
                    <label for="bagian_divisi" class="form-label">Spesifikasi Alat </label>
                    <input class="form-control rounded-top @error('nama_pengambil') is-invalid @enderror " type="text" name="nama_pengambil"
                        placeholder="Harap Di Isi Spesifikasi Alat" value="{{ old('spesifikasi_alat', $find_id->tool->spesifikasi_alat)}}" disabled>
                        @error('nama_pengambil')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                </div>


                <div class="mb-3">
                    <label for="bagian_divisi" class="form-label">Quantity </label>
                    <input class="form-control rounded-top @error('quantity') is-invalid @enderror " type="text" name="quantity"
                        placeholder="Harap Di Isi Spesifikasi Consumable" value="{{ old('quantity', $find_id->quantity)}}" disabled>
                        @error('quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                </div>


                <div class="mb-3">
                    <label for="bagian_divisi" class="form-label">jenis Quantity </label>
                    <input class="form-control rounded-top @error('jenis_quantity') is-invalid @enderror " type="text" name="jenis_quantity"
                        placeholder="Harap Di Isi Spesifikasi Consumable" value="{{ old('jenis_quantity', $find_id->jenis_quantity)}}" disabled>
                        @error('jenis_quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                </div>




                <div class="mb-3">
                    <label class="form-label">Keterangan Barang</label>
                    <textarea class="form-control" placeholder="{{ old('keterangan_alat', $find_id->keterangan_alat)}}" name="keterangan_alat"  style="height: 100px" disabled></textarea>
                </div>

                <div class="mb-3 text-center">
                    <a href="{{ route('check-out-tools.index') }}" class="btn btn-secondary">Go Back</a>

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
