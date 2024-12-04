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
            {{-- @if ($do_draft) --}}
                <div class="card-header text-end">
                    <form action="" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Delete Draft</button>
                    </form>
                </div>
            {{-- @endif --}}
            <div class="card-body row">
                <div class="col-lg-6">
                    <form action="" method="post" id="formSubmit">
                        @csrf
                        <h4>Form Address</h4>
                        <div class="mb-3">
                            <label for="tgl_kirim" class="form-label">Date </label>
                            <input class="form-control rounded-top @error('tgl_kirim') is-invalid @enderror" type="date" name="tgl_kirim" placeholder="Harap Di Isi Tanggal Pengiriman Barang">
                            @error('tgl_kirim')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <label for="tgl_kirim" class="form-label">Address </label>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="pengirim"  id="floatingTextarea2Disabled" style="height: 100px"></textarea>
                            <label for="floatingTextarea2Disabled">To</label>
                            @error('pengirim')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>



                    </form>
                </div>
                <div class="col-lg-6">
                    <form action="{{route('shipping-items.store.item')}}" method="post">
                        @csrf
                        <h4>Form Items</h4>
                        <div class="form-group mb-3">
                            <label class="form-label">Items Names</label>
                            <input type="text" name="item_names" class="form-control" id="" placeholder="Harap Masukkan Deskripsi Barang">
                            @error('item_names')
                            <div class="invalid-Deskripsi">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group mb-3">
                            <label class="form-label">Quantity</label>
                            <input class="form-control @error('quantity') is-invalid @enderror" type="number" name="quantity" min="1" placeholder="Masukkan Jumlah Barang">
                            @error('quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>



                        <div class="mb-3">
                            <label class="form-label">Type Items</label>
                            <select class="form-select select-2 @error('quantity_type') is-invalid @enderror" name="quantity_type" data-placeholder="Pilih Salah Satu">
                                <option></option>
                                <option value="Pcs">Pcs</option>
                                <option value="Unit">Unit</option>
                                <option value="Set">Set</option>
                                <option value="Kg">Kg</option>
                                <option value="Lmbr">Lmbr</option>
                                <option value="EA">EA</option>
                                <option value="Liter">Liter</option>
                                <option value="Drum">Drum</option>
                            </select>
                            @error('quantity_type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <label class="form-label">Deskcription Items</label>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="description_items"  id="floatingTextarea2Disabled" style="height: 100px"></textarea>
                            <label for="floatingTextarea2Disabled">Description</label>
                            @error('description_items')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3 text-end">
                            <button type="submit" class="btn btn-success">Submit Items</button>
                            <a href="{{route('shipping-items.index')}}" class="btn btn-secondary">Go back</a>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12">
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Description Items</th>
                                    <th>Quantity</th>
                                    <th>Type</th>
                                    <th>Description Items</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @if ($do_draft)
                                    @foreach ($do_draft->details as $detail) --}}
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    {{-- @endforeach
                                @else --}}
                                <tr>
                                    <td colspan="6" class="text-center">No Item Found</td>
                                </tr>
                                {{-- @endif --}}
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-primary" onclick="submitForm()">Submit DO</button>

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
