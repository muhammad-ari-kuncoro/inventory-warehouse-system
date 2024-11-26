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
                Form Data Diri Peminjaman Kebutuhan Materials Hydrotest
            </h5>
            <div class="card-body">
                <form action="{{route('hydrotest-material-lending.store')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="tgl_pinjam_material" class="form-label">Tanggal Peminjaman</label>
                        <input class="form-control rounded-top @error('tgl_pinjam_material') is-invalid @enderror" type="date"
                            name="tgl_pinjam_material" placeholder="Harap Di Isi Tanggal Peminjaman Materials Untuk Kebutuhan Hydrotest">
                        @error('tgl_pinjam_material')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bagian_divisi" class="form-label">Bagian Divisi</label>
                        <input class="form-control rounded-top @error('bagian_divisi') is-invalid @enderror" type="text"
                            name="bagian_divisi" placeholder="Harap Di Isi Bagian Divisi Pengambil ">
                        @error('bagian_divisi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>



                    <div class="mb-3">
                        <label for="nama_peminjam" class="form-label">Nama Peminjam Materials</label>
                        <input class="form-control rounded-top @error('nama_peminjam') is-invalid @enderror" type="text" name="nama_peminjam" placeholder="Harap Di Isi Nama Pengambil Consumable ">
                        @error('nama_peminjam')
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
                    <label for="material_id" class="form-label">Nama Materials</label>
                    <select class="form-select select-2 @error('material_id') is-invalid @enderror" name="material_id" data-placeholder="Pilih Salah Satu">
                        @foreach ($data_materials as $data )
                        <option></option>
                        <option value="{{$data->id}}">{{$data->nama_material}} | {{$data->spesifikasi_material}} | {{$data->quantity}} ({{$data->jenis_quantity}})</option>
                        @endforeach
                    </select>
                    @error('material_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">quantity</label>
                    <input class="form-control rounded-top @error('quantity') is-invalid @enderror"
                           type="number"
                           name="quantity"
                           value="{{ old('quantity') }}"
                           placeholder="Harap diisi quantity"
                           min="1">
                    @error('quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jenis_quantity" class="form-label" name="jenis_quantity">Jenis quantity </label>
                    <select class="form-select select-2 rounded-top @error('jenis_quantity') is-invalid @enderror" name="jenis_quantity" data-placeholder="Pilih Salah Satu " required>
                        <option selected disabled></option>
                        <option value="Pcs">Pcs</option>
                        <option value="Unit">Unit</option>
                        <option value="KLG">Kaleng</option>
                        <option value="Batang">Batang</option>
                        <option value="Set">Set</option>
                        <option value="Karung">Karung</option>
                        <option value="Box">Box</option>
                        <option value="Pasang">Pasang</option>
                        <option value="Kilo Gram">KG</option>
                        <option value="Lusin">Lusin</option>
                        @error('jenis_quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jenis_material" class="form-label" name="jenis_material">Jenis quantity </label>
                    <select class="form-select select-2 rounded-top @error('jenis_material') is-invalid @enderror" name="jenis_material" data-placeholder="Pilih Salah Satu " required>
                        <option selected disabled></option>
                        <option value="Temporary">Temporary</option>
                        <option value="baru">baru</option>
                        @error('jenis_material')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </select>
                </div>



                <div class="mb-3">
                    <label class="form-label">Keterangan Alat</label>
                    <textarea class="form-control" placeholder="Catatan Keterangan Barang (Opsional)" name="keterangan_material"  style="height: 100px"></textarea>
                </div>

                <div class="mb-3 text-center">
                    <a href="{{ route('hydrotest-material-lending.index') }}" class="btn btn-secondary">Go Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
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
