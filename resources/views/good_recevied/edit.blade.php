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
    <!-- Card 1 -->
    <div class="col-md-6">
        <div class="card">
            <h5 class="card-header text-center text-bold">
                Detail Barang Masuk
            </h5>
            <div class="card-body">
                @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    {!! session()->get('error') !!}
                </div>
                @endif
                <form action="" method="post">
                    @csrf
                    <!-- Row 1 -->
                    <div class="row text-center">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_masuk" class="form-label">Tanggal Masuk </label>
                                <input class="form-control rounded-top text-center" type="text" name="tanggal_masuk"
                                    placeholder="{{ old('tanggal_masuk', $find_id->tanggal_masuk)}}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_transaksi" class="form-label">No Transaksi </label>
                                <input class="form-control rounded-top text-center" type="text" name="no_transaksi"
                                    placeholder="{{ old('no_transaksi', $find_id->no_transaksi)}}" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="row text-center">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_supplier" class="form-label">Nama Supplier </label>
                                <input class="form-control rounded-top text-center" type="text" name="nama_supplier"
                                    placeholder="{{ old('nama_supplier', $find_id->nama_supplier)}}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jenis_barang" class="form-label">Jenis Barang </label>
                                <input class="form-control rounded-top text-center" type="text" name="jenis_barang"
                                    placeholder="{{ old('jenis_barang', $find_id->jenis_barang)}}" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Row 3 -->
                    <div class="row text-center">
                        <!-- Row 3 -->
                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="jenis_barang" class="form-label">Jenis Barang </label>
                                    <input class="form-control rounded-top text-center" type="text" name="jenis_barang"
                                        placeholder="{{ old('jenis_barang', $find_id->jenis_barang ?? 'Tidak ada data') }}"
                                        disabled>
                                </div>
                            </div>
                        </div>

                        <!-- Row 4: Tampilkan data spesifik berdasarkan jenis barang -->
                        @if ($find_id->jenis_barang === 'Materials')
                        <div class="row text-center">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_material" class="form-label">Nama Material</label>
                                    <input class="form-control rounded-top text-center" type="text" name="nama_material"
                                        placeholder="{{ $find_id->material->nama_material }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="spesifikasi_material" class="form-label">Spesifikasi Material</label>
                                    <input class="form-control rounded-top text-center" type="text"
                                        name="spesifikasi_material"
                                        placeholder="{{ $find_id->material->spesifikasi_material }}" disabled>
                                </div>
                            </div>
                        </div>
                        @elseif ($find_id->jenis_barang === 'Consumables')
                        <div class="row text-center">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_consumable" class="form-label">Nama Consumable</label>
                                    <input class="form-control rounded-top text-center" type="text"
                                        name="nama_consumable" placeholder="{{ $find_id->consumable->nama_consumable }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="spesifikasi_consumable" class="form-label">Spesifikasi
                                        Consumable</label>
                                    <input class="form-control rounded-top text-center" type="text"
                                        name="spesifikasi_consumable"
                                        placeholder="{{ $find_id->consumable->spesifikasi_consumable }}" disabled>
                                </div>
                            </div>
                        </div>
                        @elseif ($find_id->jenis_barang === 'Tools')
                        <div class="row text-center">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_tool" class="form-label">Nama Tool</label>
                                    <input class="form-control rounded-top text-center" type="text" name="nama_tool"
                                        placeholder="{{ $find_id->tool->nama_alat }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="spesifikasi_tool" class="form-label">Spesifikasi Tool</label>
                                    <input class="form-control rounded-top text-center" type="text"
                                        name="spesifikasi_tool" placeholder="{{ $find_id->tool->spesifikasi_alat }}"
                                        disabled>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                     <!-- Row 4  -->
                    <div class="row text-center">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity Masuk </label>
                                <input class="form-control rounded-top text-center" type="text" name="quantity"
                                    placeholder="{{ old('quantity', $find_id->quantity)}}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quantity_jenis" class="form-label">Quantity Jenis </label>
                                <input class="form-control rounded-top text-center" type="text" name="quantity_jenis"
                                    placeholder="{{ old('quantity_jenis', $find_id->quantity_jenis)}}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="keterangan_barang" class="form-label">Keterangan Barang </label>
                                <input class="form-control rounded-top text-center" type="text" name="keterangan_barang"
                                    placeholder="{{ old('keterangan_barang', $find_id->keterangan_barang ?? 'Tidak ada data') }}"
                                    disabled>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>





{{-- Form Input --}}

    <!-- Card 2 -->
    <div class="col-md-6">
        <div class="card">
            <h5 class="card-header text-center text-bold">
                Edit Data Barang Msuk
            </h5>
            <div class="card-body">
                <form action="{{route('good-received.update',$find_id->id)}}" method="post">
                    @csrf
                    @method('patch')
                    <!-- Row 1 -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_masuk" class="form-label">Tanggal Masuk </label>
                                <input class="form-control rounded-top @error('tanggal_masuk') is-invalid @enderror" type="date"
                                    name="tanggal_masuk" placeholder="Harap Di Isi Tanggal Masuk Barang" value="{{ old('tanggal_masuk', $find_id->tanggal_masuk)}}">
                                @error('tanggal_masuk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_transaksi" class="form-label">No Transaksi Barang </label>
                                <input class="form-control rounded-top @error('no_transaksi') is-invalid @enderror" type="text" name="no_transaksi" placeholder="Harap Di Isi No Transaksi Barang" value="{{ old('no_transaksi', $find_id->no_transaksi)}}">
                                @error('no_transaksi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Row 2 --}}
                    <div class="row text-center">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="nama_supplier" class="form-label">Nama Supplier </label>
                                <input class="form-control rounded-top @error('nama_supplier') is-invalid @enderror" type="text" name="nama_supplier" placeholder="Harap Di Isi Nama Supplier" value="{{ old('nama_supplier', $find_id->nama_supplier)}}">
                                @error('nama_supplier')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    {{-- Row 3 --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jenis_barang" class="form-label">Jenis Barang Masuk </label>
                                <select name="jenis_barang" name="jenis_barang" id="jenis_barang"@error('jenis_barang') is-invalid @enderror class="form-select">
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
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3" id="div_material">
                                <label class="form-label">Nama Material </label>
                                <select name="material_id" name="material_id" class="form-select select-2" data-placeholder="Pilih Salah Satu">
                                    @foreach ($materials as $material)
                                        <option></option>
                                        <option value="{{ $material->id }}">{{ $material->nama_material }} | {{$material->spesifikasi_material}} | ({{$material->quantity}}) {{$material->jenis_quantity}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3" id="div_consumable">
                                <label for="consumable_id" class="form-label">Nama Cosumable </label>
                                <select name="consumable_id" name="consumable_id" class="form-select select-2" data-placeholder="Pilih Salah Satu">
                                    @foreach ($consumables as $consumable)
                                        <option></option>
                                        <option value="{{ $consumable->id }}">{{ $consumable->nama_consumable }} | {{$consumable->spesifikasi_consumable}} | ({{$consumable->quantity}}) {{$consumable->jenis_quantity}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3" id="div_tool">
                                <label class="form-label">Nama Tool </label>
                                <select name="tools_id" name="tools_id" class="form-select select-2" data-placeholder="Pilih Salah Satu">
                                    @foreach ($tools as $tool)
                                        <option></option>
                                        <option value="{{ $tool->id }}">{{ $tool->nama_alat }} | {{$tool->spesifikasi_alat}} | ({{$tool->quantity}}) {{$tool->jenis_quantity}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    {{-- Row 4 --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity masuk </label>
                                <input class="form-control rounded-top @error('quantity') is-invalid @enderror" type="number"name="quantity" placeholder="Harap Di Isi Quantity" value="{{ old('quantity', $find_id->quantity)}}">
                                @error('quantity')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quantity_jenis" class="form-label" name="quantity_jenis">Quantity Jenis </label>
                                <select class="form-select select-2 @error('quantity_jenis') is-invalid @enderror"  name="quantity_jenis" data-placeholder="Pilih Salah Satu">
                                    <option value="" disabled {{ old('quantity_jenis'), $find_id->quantity_jenis === null ? 'selected' : '' }}>Pilih salah satu</option>
                                    <option value="Pcs" {{ old('quantity_jenis') == $find_id->quantity_jenis ? 'selected' : '' }}>Pcs</option>
                                    <option value="Batang" {{ old('quantity_jenis') == $find_id->quantity_jenis ? 'selected' : '' }}>Batang</option>
                                    <option value="Set" {{ old('quantity_jenis') == $find_id->quantity_jenis ? 'selected' : '' }}>Set</option>
                                    <option value="Karung" {{ old('quantity_jenis') == $find_id->quantity_jenis ? 'selected' : '' }}>Karung</option>
                                    <option value="Box" {{ old('quantity_jenis') == $find_id->quantity_jenis ? 'selected' : '' }}>Box</option>
                                    <option value="Pasang" {{ old('quantity_jenis') == $find_id->quantity_jenis ? 'selected' : '' }}>Pasang</option>
                                    <option value="Lusin" {{ old('quantity_jenis') == $find_id->quantity_jenis ? 'selected' : '' }}>Lusin</option>


                                    @error('quantity_jenis')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Row 5 -->
                    <div class="mb-3">
                        <label for="keterangan_barang" class="form-label">Keterangan Barang</label>
                        <textarea class="form-control @error('keterangan_barang') is-invalid @enderror"
                                  name="keterangan_barang"
                                  style="height: 100px"
                                  placeholder="Catatan Keterangan Barang">{{ old('keterangan_barang', $find_id->keterangan_barang) }}</textarea>
                        @error('keterangan_barang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    <!-- Submit Buttons -->
                    <div class="mb-5">
                        <div class="col sm-4">
                            <a href="{{ route('good-received.index') }}" class="btn btn-secondary">Go Back</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
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
        width: '100%',
        placeholder: $(this).data('placeholder'),
    });

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
