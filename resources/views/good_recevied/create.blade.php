@extends('layouts.dashboard-layout')
@push('styles')
<style>
    #div_tool{
        display: none;
    }

    #div_consumable{
        display: none;
    }

    #div_material{
        display: none;
    }
</style>
@endpush
@section('container')

<div class="card">
    <h5 class="card-header text-center text-bold">
        Halaman Edit Data Edit Alat Dan Permesinan
    </h5>
    <div class="card-body">
        <form action="{{route('good-received.store')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="tanggal_masuk" class="form-label">Tanggal Masuk </label>
                <input class="form-control rounded-top @error('tanggal_masuk') is-invalid @enderror" type="date"
                    name="tanggal_masuk" placeholder="Harap Di Isi Tanggal Masuk Barang">
                @error('tanggal_masuk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="no_transaksi" class="form-label">No Transaksi Barang </label>
                <input class="form-control rounded-top @error('no_transaksi') is-invalid @enderror" type="text" name="no_transaksi" placeholder="Harap Di Isi No Transaksi Barang">
                @error('no_transaksi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_supplier" class="form-label">Nama Supplier </label>
                <input class="form-control rounded-top @error('nama_supplier') is-invalid @enderror" type="text" name="nama_supplier" placeholder="Harap Di Isi Nama Supplier">
                @error('nama_supplier')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- input Group Select --}}
            <div class="mb-3">
                <label for="nama_supplier" class="form-label">Jenis Barang Masuk </label>
                <select name="jenis_barang" id="jenis_barang" class="form-select">
                    <option value="" selected disabled>-- Pilih Jenis Barang Masuk --</option>
                    <option value="Materials">Materials</option>
                    <option value="Consumables">Consumables</option>
                    <option value="Tools">Tools</option>
                </select>
            </div>

            <div class="mb-3" id="div_material">
                <label class="form-label">Nama Material </label>
                <select name="material_id" id="" class="form-select select-2" data-placeholder="Pilih Salah Satu">
                    @foreach ($materials as $material)
                        <option></option>
                        <option value="{{ $material->id }}">{{ $material->nama_material }} | {{$material->spesifikasi_material}} | ({{$material->quantity}}) {{$material->jenis_quantity}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3" id="div_consumable">
                <label for="" class="form-label">Nama Cosumable </label>
                <select name="consumable_id" id="" class="form-select select-2" data-placeholder="Pilih Salah Satu">
                    @foreach ($consumables as $consumable)
                        <option></option>
                        <option value="{{ $consumable->id }}">{{ $consumable->nama_consumable }} | {{$consumable->spesifikasi_consumable}} | ({{$consumable->quantity}}) {{$consumable->jenis_quantity}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3" id="div_tool">
                <label class="form-label">Nama Tool </label>
                <select name="" id="" class="form-select select-2" data-placeholder="Pilih Salah Satu">
                    @foreach ($tools as $tool)
                        <option></option>
                        <option value="{{ $tool->id }}">{{ $tool->nama_alat }} | {{$tool->spesifikasi_alat}} | ({{$tool->quantity}}) {{$tool->jenis_quantity}}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Akhir Input  --}}

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity masuk </label>
                <input class="form-control rounded-top @error('quantity') is-invalid @enderror" type="number"
                    name="quantity" placeholder="Harap Di Isi Quantity">
                @error('quantity')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="quantity_jenis" class="form-label" name="quantity Jenis">Quantity Jenis </label>
                <select class="form-select select-2"  name="quantity_jenis" data-placeholder="Pilih Salah Satu">
                    <option></option>
                    <option value="Pcs">Pcs</option>
                    <option value="Unit">Unit</option>
                    <option value="Set">Set</option>
                    <option value="Kg">Kg</option>
                    <option value="Lembar">Lembar</option>
                    <option value="EA">EA</option>
                    <option value="Liter">Liter</option>
                    <option value="Drum">Drum</option>

                    @error('quantity_jenis')
                    <div class="invalid-feedba  ck">
                        {{ $message }}
                    </div>
                    @enderror
                </select>
            </div>

            <div class="mb-3">
                <label for="jenis_stok" class="form-label" name="jenis_stok">Jenis Stock </label>
                <select class="form-select select-2" name="jenis_stok" data-placeholder="Pilih Salah Satu">
                    <option></option>
                    <option value="Materials">Materials</option>
                    <option value="Tools">Tools</option>
                    <option value="Consumable">Consumable</option>
                    @error('quantity_jenis')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </select>
            </div>

            <div class="mb-3">
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Catatan Keterangan Barang" name="keterangan_barang" style="height: 100px"></textarea>
                    <label for="floatingTextarea">Keterangan Barang </label>
                  </div>
                  @error('keterangan_barang')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
            </div>


            <div class="mb-5">
                <div class="col sm-4">
                    <a href="{{ route('good-received.index') }}" class="btn btn-secondary">Go Back</a>
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
