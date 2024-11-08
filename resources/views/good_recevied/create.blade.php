@extends('layouts.dashboard-layout')
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
                <input class="form-control rounded-top @error('nama_supplier') is-invalid @enderror" type="date" name="nama_supplier" placeholder="Harap Di Isi Nama Supplier">
                @error('nama_supplier')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>





            <div class="mb-3">
                <label for="material_id" class="form-label" name="material_id">Nama Barang Masuk </label>
                <select class="form-select" id="basic-usage" name="material_id" data-placeholder="Choose one thing">
                    <option></option>
                    <optgroup label="Consumable">
                        @foreach ($data_consumable as $data )
                        <option value="{{$data->id}}">{{$data->nama_consumable}} | {{$data->spesifikasi_consumable}} | Qty Tersisa:({{$data->quantity}} {{$data->jenis_quantity}})</option>
                        @endforeach
                    </optgroup>


                    @error('nama_barang')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </select>
                <br>

                <select class="form-select mb-3" id="basic-usage4" name="nama_barang" data-placeholder="Choose one thing">
                    <option></option>
                    <optgroup label="Material">
                        @foreach ($data_material as $data)
                        <option value="{{$data->id}}">{{$data->nama_material}} | {{$data->spesifikasi_material}} | Qty Tersisa:({{$data->quantity}} {{$data->jenis_quantity}}) </option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Tools" class="text-bold">
                        @foreach ($data_tools as $data)
                        <option value="{{$data->id}}">{{$data->nama_alat}} | {{$data->spesifikasi_alat}} | Qty Tersisa:({{$data->quantity}} {{$data->jenis_quantity}})</option>
                        @endforeach
                    </optgroup>

                    @error('nama_barang')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </select>
            </div>

            <div class="mb-3">
                <label for="nama_barang" class="form-label" name="nama_barang">Nama Barang Masuk </label>

            </div>





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
                <select class="form-select" id="basic-usage2" name="quantity_jenis" data-placeholder="Choose one thing">
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
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </select>
            </div>

            <div class="mb-3">
                <label for="jenis_stock" class="form-label" name="jenis_stock">Jenis Stock </label>
                <select class="form-select" id="basic-usage3" name="jenis_stock" data-placeholder="Choose one thing">
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
    $('#basic-usage').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
    });

    $('#basic-usage2').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
    });

    $('#basic-usage3').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
    });

    $('#basic-usage4').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
    });

</script>



@endpush
