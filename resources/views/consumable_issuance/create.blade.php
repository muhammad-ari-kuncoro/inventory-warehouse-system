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
                Form Data Diri
            </h5>
            <div class="card-body">
                <form action="{{route('delivery-order.store')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="tanggal_pengambilan" class="form-label">Tanggal pengambilan</label>
                        <input class="form-control rounded-top @error('tanggal_pengambilan') is-invalid @enderror" type="date"
                            name="tanggal_pengambilan" placeholder="Harap Di Isi Tanggal pengambilan Consumbable">
                        @error('tanggal_pengambilan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>




                    <div class="mb-3">
                        <label for="nama_pengmbil" class="form-label">Nama Pengambil Consumable </label>
                        <input class="form-control rounded-top @error('nama_pengmbil') is-invalid @enderror" type="text" name="nama_pengmbil" placeholder="Harap Di Isi Nama Pengambil Consumable ">
                        @error('nama_pengmbil')
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
                    <label for="project_id" class="form-label">Nama Consumable</label>
                    <select class="form-select select-2 @error('project_id') is-invalid @enderror" name="project_id" data-placeholder="Pilih Salah Satu">
                        @foreach ($data_consumables as $data )
                        <option></option>
                        <option value="{{$data->id}}">{{$data->nama_consumable}} | {{$data->spesifikasi_consumable}}</option>
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
                    <input class="form-control rounded-top @error('quantity') is-invalid @enderror" type="number" name="quantity" placeholder="Harap Di Isi quantity ">
                    @error('quantity')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>






                <div class="mb-3">
                    <label for="jenis_quantity" class="form-label">Quantity Jenis</label>
                    <select class="form-select select-2 @error('jenis_quantity') is-invalid @enderror" name="jenis_quantity" data-placeholder="Pilih Salah Satu">
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
                    @error('jenis_quantity')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan Barang</label>
                    <textarea class="form-control" placeholder="Catatan Keterangan Barang (Opsional)" name="keterangan_barang"  style="height: 100px"></textarea>
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
