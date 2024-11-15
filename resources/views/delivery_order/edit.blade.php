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
                Form Detail Delivery Order
            </h5>
            <div class="card-body">
                <form action="{{route('delivery-order.update',$find_id->id)}}" method="post">
                    @csrf
                    @method('patch')
                    <div class="mb-3">
                        <label for="tanggal_pengiriman" class="form-label">Tanggal Pengiriman</label>
                        <input class="form-control rounded-top @error('tanggal_pengiriman') is-invalid @enderror"
                            type="date" name="tanggal_pengiriman"
                            value="{{ old('tanggal_pengiriman', $find_id->tanggal_pengiriman)}}" disabled>
                        @error('tanggal_pengiriman')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>





                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="pengirim" id="floatingTextarea2Disabled"
                            style="height: 100px" disabled>{{ old('pengirim', $find_id->pengirim)}}</textarea>
                        <label for="floatingTextarea2Disabled">pengirim</label>
                        @error('pengirim')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="penerima" id="floatingTextarea2Disabled"
                            style="height: 100px" disabled>{{ old('penerima', $find_id->penerima)}}</textarea>
                        <label for="floatingTextarea2Disabled">penerima</label>
                        @error('penerima')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="penerima" id="floatingTextarea2Disabled"
                            style="height: 100px" disabled>{{ old('deskripsi_barang', $find_id->deskripsi_barang)}}</textarea>
                        <label for="floatingTextarea2Disabled">Deskripsi barang</label>
                        @error('penerima')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="project_id" class="form-label">Data Lama Nama Project</label>
                        <input class="form-control rounded-top @error('project_id') is-invalid @enderror" type="text"
                            name="project_id" placeholder="Harap Di Isi project_id "
                            value="{{ old('project_id', $find_id->project->nama_project) }}  " disabled>
                        @error('project_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Kategori Sub Nama Project Lama </label>
                        <input class="form-control rounded-top" type="text"
                            placeholder="{{ old('projet_id', $find_id->project->sub_nama_project)}}" disabled>
                    </div>



                    <div class="mb-3">
                        <label for="quantity" class="form-label">quantity</label>
                        <input class="form-control rounded-top @error('quantity') is-invalid @enderror" type="number"
                            name="quantity" placeholder="Harap Di Isi quantity " value="{{ old('quantity', $find_id->quantity)}}" disabled>
                        @error('quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="jenis_quantity" class="form-label">jenis quantity</label>
                        <input class="form-control rounded-top @error('jenis_quantity') is-invalid @enderror" type="number"
                            name="jenis_quantity" placeholder="{{ old('jenis_quantity', $find_id->jenis_quantity)}}" disabled>
                        @error('jenis_quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="keterangan_barang" id="floatingTextarea2Disabled"
                            style="height: 100px" disabled>{{ old('keterangan_barang', $find_id->keterangan_barang)}}</textarea>
                        <label for="floatingTextarea2Disabled">keterangan_barang</label>
                        @error('keterangan_barang')
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
                    <label for="tanggal_pengiriman" class="form-label">Tanggal Pengiriman</label>
                    <input class="form-control rounded-top @error('tanggal_pengiriman') is-invalid @enderror"
                        type="date" name="tanggal_pengiriman"
                        value="{{ old('tanggal_pengiriman', $find_id->tanggal_pengiriman)}}">
                    @error('tanggal_pengiriman')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>


                <div class="form-floating mb-3">
                    <textarea class="form-control" name="pengirim" id="floatingTextarea2Disabled"
                        style="height: 100px">{{ old('pengirim', $find_id->pengirim)}}</textarea>
                    <label for="floatingTextarea2Disabled">Pengirim</label>
                    @error('pengirim')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <textarea class="form-control" name="penerima" id="floatingTextarea2Disabled"
                        style="height: 100px">{{ old('penerima', $find_id->penerima)}}</textarea>
                    <label for="floatingTextarea2Disabled">Penerima</label>
                    @error('penerima')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <textarea class="form-control" name="deskripsi_barang" id="floatingTextarea2Disabled"
                        style="height: 100px">{{ old('deskripsi_barang', $find_id->deskripsi_barang)}}</textarea>
                    <label for="floatingTextarea2Disabled">Deskripsi barang</label>
                    @error('deskripsi_barang')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>





                <div class="mb-3">
                    <label for="project_id" class="form-label" name="project_id">Kategori Nama Project baru </label>
                    <select class="form-select rounded-top @error('project_id') is-invalid @enderror"  value="{{ old('project_id', $find_id->project_id)}}" name="project_id" >
                        @foreach ($data_project as $data )
                        <option value="" disabled {{ old('project_id'), $find_id->project_id === null ? 'selected' : '' }}>Pilih salah satu</option>
                        <option value="{{ $data->id }}" {{ old('project_id') == $find_id->project_id ? 'selected' : '' }}>{{ $data->nama_project }} | {{ $data->sub_nama_project }} | NO JO : {{ $data->no_jo_project }}</option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">quantity</label>
                    <input class="form-control rounded-top @error('quantity') is-invalid @enderror" type="number"
                        name="quantity"  value="{{old('quantity', $find_id->quantity)}}">
                    @error('quantity')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jenis_quantity" class="form-label">Quantity Jenis</label>
                    <select class="form-select select-2 @error('jenis_quantity') is-invalid @enderror"  name="jenis_quantity" data-placeholder="Pilih Salah Satu">
                        <option value="" disabled {{ old('jenis_quantity'), $find_id->jenis_quantity === null ? 'selected' : '' }}>Pilih salah satu</option>
                        <option value="Pcs" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Pcs</option>
                        <option value="Batang" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Batang</option>
                        <option value="Set" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Set</option>
                        <option value="Karung" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Karung</option>
                        <option value="Box" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Box</option>
                        <option value="Pasang" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Pasang</option>
                        <option value="Lusin" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Lusin</option>


                        @error('jenis_quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </select>
                </div>



                <div class="form-floating mb-3">
                    <textarea class="form-control" name="keterangan_barang" id="floatingTextarea2Disabled"
                        style="height: 100px">{{ old('keterangan_barang', $find_id->keterangan_barang)}}</textarea>
                    <label for="floatingTextarea2Disabled">keterangan_barang</label>
                    @error('keterangan_barang')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3 text-center">
                    <a href="{{ route('delivery-order.index') }}" class="btn btn-secondary">Go Back</a>
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
    $(document).ready(function () {
        $('#jenis_barang').on('change', function () {
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
