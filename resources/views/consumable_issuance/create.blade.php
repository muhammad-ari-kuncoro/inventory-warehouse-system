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
    <!-- Card 2: Detail Barang -->
    <div class="col-md-6">
         @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong class="text-dark">{!! session()->get('success') !!}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('failed'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong class="text-dark">{!! session()->get('failed') !!}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <h5 class="card-header text-center text-bold">
                Data Barang
            </h5>
            <form action="{{route('consumable-issuance.store')}}" method="post">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="tanggal_pengambilan" class="form-label">Tanggal pengambilan</label>
                    <input class="form-control rounded-top @error('tanggal_pengambilan') is-invalid @enderror" type="date" name="tanggal_pengambilan" placeholder="Harap Di Isi Tanggal pengambilan Consumbable">
                    @error('tanggal_pengambilan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="consumable_id" class="form-label">Nama Consumable</label>
                    <select class="form-select select-2 @error('consumable_id') is-invalid @enderror" name="consumable_id" data-placeholder="Pilih Salah Satu">
                        @foreach ($data_consumables as $data )
                        <option></option>
                        <option value="{{$data->id}}">{{$data->nama_consumable}} | {{$data->spesifikasi_consumable}} | {{$data->quantity}} ({{$data->jenis_quantity}}) | {{ $data->project->nama_project }}
                            | {{ $data->project->sub_nama_project }}</option>
                        @endforeach
                    </select>
                    @error('consumable_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
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
                    <label for="jenis_quantity" class="form-label" name="jenis_quantity">Jenis Quantity </label>
                    <select class="form-select select-2 rounded-top @error('jenis_quantity') is-invalid @enderror" name="jenis_quantity" data-placeholder="Pilih Salah Satu " required>
                        <option selected disabled></option>
                        <option value="Pcs">Pcs</option>
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
                    <label for="project_id" class="form-label">Keterangan Project</label>
                    <select class="form-select select-2 @error('project_id') is-invalid @enderror" name="project_id" data-placeholder="Pilih Salah Satu">
                        @foreach ($data_project as $data )
                        <option></option>
                        <option value="{{$data->id}}">{{$data->nama_project}} | {{$data->sub_nama_project}}</option>
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
                    <textarea class="form-control" placeholder="Catatan Keterangan Barang (Opsional)" name="keterangan_consumable"  style="height: 100px"></textarea>
                </div>

                <div class="mb-3 text-center">
                    <a href="{{ route('consumable-issuance.index') }}" class="btn btn-secondary">Go Back</a>
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
