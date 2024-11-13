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
                Data Umum
            </h5>
            <div class="card-body">
                <form action="" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                        <input class="form-control rounded-top @error('tanggal_masuk') is-invalid @enderror" type="date"
                            name="tanggal_masuk" placeholder="Harap Di Isi Tanggal Masuk Barang">
                        @error('tanggal_masuk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_transaksi" class="form-label">No Transaksi Barang</label>
                        <input class="form-control rounded-top @error('no_transaksi') is-invalid @enderror" type="text"
                            name="no_transaksi" placeholder="Harap Di Isi No Transaksi Barang">
                        @error('no_transaksi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_supplier" class="form-label">Nama Supplier</label>
                        <input class="form-control rounded-top @error('nama_supplier') is-invalid @enderror" type="text"
                            name="nama_supplier" placeholder="Harap Di Isi Nama Supplier">
                        @error('nama_supplier')
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
                Detail Barang
            </h5>
            <div class="card-body">

                <div class="mb-3">
                    <label for="jenis_barang" class="form-label">Jenis Barang Masuk</label>
                    <select name="jenis_barang" id="jenis_barang" class="form-select @error('jenis_barang') is-invalid @enderror">
                        <option value="" selected disabled>-- Pilih Jenis Barang Masuk --</option>
                        <option value="Materials">Materials</option>
                        <option value="Consumables">Consumables</option>
                        <option value="Tools">Tools</option>
                    </select>
                    @error('jenis_barang')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="quantity_jenis" class="form-label">Quantity Jenis</label>
                    <select class="form-select select-2 @error('quantity_jenis') is-invalid @enderror" name="quantity_jenis" data-placeholder="Pilih Salah Satu">
                        <option></option>
                        <option value="Pcs">Pcs</option>
                        <option value="Unit">Unit</option>
                        <option value="Set">Set</option>
                        <option value="Kg">Kg</option>
                        <option value="Lembar">Lembar</option>
                        <option value="EA">EA</option>
                        <option value="Liter">Liter</option>
                        <option value="Drum">Drum</option>
                    </select>
                    @error('quantity_jenis')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan Barang</label>
                    <textarea class="form-control" placeholder="Catatan Keterangan Barang" name="keterangan_barang" style="height: 100px"></textarea>
                </div>

                <div class="mb-3 text-center">
                    <a href="{{ route('good-received.index') }}" class="btn btn-secondary">Go Back</a>
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
