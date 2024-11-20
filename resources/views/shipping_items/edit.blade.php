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
                Form Data Lama
            </h5>
            <div class="card-body">
                <div class="mb-3">
                        <label for="tgl_kirim" class="form-label">Tanggal Pengiriman</label>
                        <input class="form-control rounded-top @error('tgl_kirim') is-invalid @enderror" type="date"
                        name="tgl_kirim" placeholder="Harap Di Isi Tanggal Pengiriman Barang" value="{{ old('tgl_kirim', $find_id->tgl_kirim)}}" disabled>
                        @error('tgl_kirim')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>



                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="pengirim" id="floatingTextarea2Disabled" style="height: 100px" disabled>{{ old('pengirim', $find_id->pengirim)}}</textarea>
                        <label for="floatingTextarea2Disabled">Pengirim</label>
                        @error('pengirim')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                      </div>

                      <div class="form-floating mb-3">
                        <textarea class="form-control" name="tujuan"  id="floatingTextarea2Disabled" style="height: 100px" disabled>{{ old('tujuan', $find_id->tujuan)}}</textarea>
                        <label for="floatingTextarea2Disabled">tujuan</label>
                        @error('tujuan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="deskripsi_brg"  id="floatingTextarea2Disabled" style="height: 100px" disabled>{{ old('deskripsi_brg', $find_id->deskripsi_brg)}}</textarea>
                            <label for="floatingTextarea2Disabled">Deskripsi Barang</label>
                            @error('deskripsi_brg')
                            <div class="invalid-Deskripsi">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">quantity</label>
                            <input class="form-control rounded-top @error('quantity') is-invalid @enderror" type="number" name="quantity" placeholder="Harap Di Isi quantity " value="{{ old('quantity', $find_id->quantity) }}" disabled>
                            @error('quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jenis_quantity" class="form-label">jenis Quantity</label>
                            <input class="form-control rounded-top @error('jenis_quantity') is-invalid @enderror" type="text" name="jenis_quantity" value="{{ old('jenis_quantity', $find_id->jenis_quantity) }}" disabled>
                            @error('jenis_quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="project_id" class="form-label">Nama Projects</label>
                            <input class="form-control rounded-top @error('project_id') is-invalid @enderror"
                            type="text"
                            name="project_id"
                            value="{{ old('project_id', $find_id->project->nama_project . ' ' . $find_id->project->sub_nama_project) }}"
                            disabled>
                            @error('jenis_quantity')
                            <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan Barang</label>
                        <textarea class="form-control" placeholder="{{ old('keterangan_brg', $find_id->keterangan_brg) }}" name="keterangan_brg"  style="height: 100px" disabled></textarea>
                    </div>




                </div>
        </div>
    </div>

    <!-- Card 2: Detail Barang -->
    <div class="col-md-6">
        <div class="card">
            <h5 class="card-header text-center text-bold">
                Form Data Edit Baru
            </h5>
            <div class="card-body">
                <form action="{{ route('shipping-items.update',$find_id->id) }}" method="post">
                    @csrf
                    @method('patch')
                <div class="mb-3">
                    <label for="tgl_kirim" class="form-label">Tanggal Pengiriman</label>
                    <input class="form-control rounded-top @error('tgl_kirim') is-invalid @enderror" type="date"
                        name="tgl_kirim" placeholder="Harap Di Isi Tanggal Pengiriman Barang" value="{{ old('tgl_kirim', $find_id->tgl_kirim)}}">
                    @error('tgl_kirim')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>



                <div class="form-floating mb-3">
                    <textarea class="form-control" name="pengirim" id="floatingTextarea2Disabled" style="height: 100px">{{ old('pengirim', $find_id->pengirim)}}</textarea>
                    <label for="floatingTextarea2Disabled">Pengirim</label>
                    @error('pengirim')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                  </div>

                  <div class="form-floating mb-3">
                    <textarea class="form-control" name="tujuan"  id="floatingTextarea2Disabled" style="height: 100px">{{ old('tujuan', $find_id->tujuan)}}</textarea>
                    <label for="floatingTextarea2Disabled">tujuan</label>
                    @error('tujuan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                  </div>

                  <div class="form-floating mb-3">
                    <textarea class="form-control" name="deskripsi_brg"  id="floatingTextarea2Disabled" style="height: 100px">{{ old('deskripsi_brg', $find_id->deskripsi_brg)}}</textarea>
                        <label for="floatingTextarea2Disabled">Deskripsi Barang</label>
                        @error('deskripsi_brg')
                        <div class="invalid-Deskripsi">
                            {{ $message }}
                        </div>
                        @enderror
                 </div>
                 <div class="mb-3">
                    <label for="quantity" class="form-label">quantity</label>
                    <input class="form-control rounded-top @error('quantity') is-invalid @enderror" type="number" name="quantity" placeholder="Harap Di Isi quantity " value="{{ old('quantity', $find_id->quantity) }}">
                    @error('quantity')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jenis_quantity" class="form-label" name="jenis_quantity">Jenis Consumable </label>
                    <select class="form-select select-2 rounded-top @error('jenis_quantity') is-invalid @enderror"  value="{{ old('jenis_quantity', $find_id->jenis_quantity)}}"
                        name="jenis_quantity" required>
                        <option value="" disabled {{ old('jenis_quantity'), $find_id->jenis_quantity === null ? 'selected' : '' }}>Pilih salah satu</option>
                        <option value="Pcs" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Pcs</option>
                        <option value="Unit" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Unit</option>
                        <option value="Set" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Set</option>
                        <option value="Kg" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Kg</option>
                        <option value="Lembar" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Lembar</option>
                        <option value="EA" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>EA</option>
                        <option value="Liter" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Liter</option>
                        <option value="Drum" {{ old('jenis_quantity') == $find_id->jenis_quantity ? 'selected' : '' }}>Drum</option>
                        @error('jenis_quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </select>
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
                    <label class="form-label">Keterangan Barang</label>
                    <textarea class="form-control" name="keterangan_brg"  style="height: 100px">{{ old('keterangan_brg', $find_id->keterangan_brg) }}</textarea>
                </div>

                <div class="mb-3 text-center">
                    <a href="{{route('shipping-items.index')}}" class="btn btn-secondary">Go Back</a>
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
