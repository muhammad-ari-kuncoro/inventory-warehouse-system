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
    <div class="col-lg-12">
        {{-- Session Notifikasi --}}
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
        <div class="card">
            <div class="card-body row">
                <div class="col-lg-12">
                    <h4>Form Detail Delivery Order</h4>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="tanggal_pengiriman" class="form-label">Delivery Order Number</label>
                        <input class="form-control rounded-top" type="text" value="{{ $do->do_no }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_pengiriman" class="form-label">Tanggal Pengiriman</label>
                        <input class="form-control rounded-top @error('tanggal_pengiriman') is-invalid @enderror" type="date" value="{{ $do->do_date }}" name="tanggal_pengiriman" placeholder="Harap Di Isi Tanggal Pengiriman Barang" disabled>
                        @error('tanggal_pengiriman')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="project_id" class="form-label">Nama Project</label>
                        <select class="form-select select-2 @error('project_id') is-invalid @enderror" name="project_id" data-placeholder="Pilih Salah Satu" disabled>
                            <option></option>
                            @foreach ($data_project as $data )
                                <option value="{{$data->id}}"{{ $do->project_id == $data->id ? 'selected' : '' }}>{{$data->nama_project}} | {{$data->sub_nama_project}}</option>
                            @endforeach
                        </select>
                        @error('project_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">Alamat Penerima</label>
                        <textarea class="form-control" name="penerima"  id="floatingTextarea2Disabled" rows="8" disabled>{{ $do->shipment_address }}</textarea>
                        @error('penerima')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Deskripsi Item</th>
                                    <th>Ukuran</th>
                                    <th>Weight</th>
                                    <th>Qty</th>
                                    <th>Satuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($do)
                                    @foreach ($do->details as $detail)
                                        <tr>
                                            <td>{{ $detail->item_description }}</td>
                                            <td>{{ $detail->item_size }}</td>
                                            <td>{{ $detail->item_weight }}</td>
                                            <td>{{ $detail->item_qty }}</td>
                                            <td>{{ $detail->item_measurement }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="text-center">No Item Found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 col-lg-6">
                      <a href="{{route('delivery-order.index')}}" class="btn btn-secondary">Go back</a>
                    </div>
                </div>
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
    function submitForm() {
        $("#formSubmit").submit();
    }
</script>
@endpush
