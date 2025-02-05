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
            @if ($do_draft)
                <div class="card-header text-end">
                    <form action="{{ route('delivery-order.delete-draft') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Hapus Draft</button>
                    </form>
                </div>
            @endif
            <div class="card-body row">
                <div class="col-lg-6">
                    <form action="{{ route('delivery-order.store') }}" method="post" id="formSubmit">
                        @csrf
                        <h4>Form Alamat</h4>
                        <div class="mb-3">
                            <label for="tanggal_pengiriman" class="form-label">Tanggal Pengiriman</label>
                            <input class="form-control rounded-top @error('tanggal_pengiriman') is-invalid @enderror" type="date" name="tanggal_pengiriman" placeholder="Harap Di Isi Tanggal Pengiriman Barang">
                            @error('tanggal_pengiriman')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="penerima"  id="floatingTextarea2Disabled" style="height: 100px"></textarea>
                            <label for="floatingTextarea2Disabled">Alamat Penerima</label>
                            @error('penerima')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="project_id" class="form-label">Nama Project</label>
                            <select class="form-select select-2 @error('project_id') is-invalid @enderror" name="project_id" data-placeholder="Pilih Salah Satu">
                                <option></option>
                                @foreach ($data_project as $data )
                                    <option value="{{$data->id}}">{{$data->nama_project}} | {{$data->sub_nama_project}}</option>
                                @endforeach
                            </select>
                            @error('project_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="col-lg-6">
                    <form action="{{ route('delivery-order.store.item') }}" method="post">
                        @csrf
                        <h4>Form Barang</h4>
                        <div class="form-group mb-3">
                            <label class="form-label">Deskripsi Barang</label>
                            <input type="text" name="item_description" class="form-control" id="" placeholder="Harap Masukkan Deskripsi Barang">
                            @error('deskripsi_barang')
                            <div class="invalid-Deskripsi">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Ukuran Barang</label>
                            <input class="form-control @error('item_size') is-invalid @enderror" type="text" name="item_size" placeholder="Harap Masukkan Ukuran Barang (123 X 123 X 123) ">
                            @error('item_size')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Jumlah Barang</label>
                            <input class="form-control @error('item_qty') is-invalid @enderror" type="number" name="item_qty" min="1" placeholder="Masukkan Jumlah Barang">
                            @error('item_qty')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Berat Barang (Kg)</label>
                            <input class="form-control @error('item_weight') is-invalid @enderror" type="number" step="0.01" name="item_weight" min="1" placeholder="Masukkan Berat Barang Dalam Kg">
                            @error('item_weight')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Satuan Barang</label>
                            <select class="form-select select-2 @error('satuan_barang') is-invalid @enderror" name="satuan_barang" data-placeholder="Pilih Salah Satu">
                                <option></option>
                                <option value="Pcs">Pcs</option>
                                <option value="Unit">Unit</option>
                                <option value="Set">Set</option>
                                <option value="Kg">Kg</option>
                                <option value="Lembar">Lembar</option>
                                <option value="EA">EA</option>
                                <option value="Liter">Liter</option>
                                <option value="Drum">Drum</option>
                                <option value="MTR">MTR</option>
                                <option value="BOX">BOX</option>
                            </select>
                            @error('satuan_barang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3 text-end">
                            <button type="submit" class="btn btn-success">Tambah Barang</button>
                            <a href="{{route('delivery-order.index')}}" class="btn btn-secondary">Go back</a>
                        </div>
                    </form>
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
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($do_draft)
                                    @foreach ($do_draft->details as $detail)
                                        <tr>
                                            <td>{{ $detail->item_description }}</td>
                                            <td>{{ $detail->item_size }}</td>
                                            <td>{{ $detail->item_weight }}</td>
                                            <td>{{ $detail->item_qty }}</td>
                                            <td>{{ $detail->item_measurement }}</td>
                                            <td>

                                                <form action="{{ route('delivery-order.delete-per-draft', $detail->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bx bx-trash-alt"></i>
                                                    </button>
                                                    <a href="{{route('delivery-order.detail-updating',$detail->id)}}"><span class="btn btn-info btn-sm"><i class='bx bx-edit-alt' ></i></a></span></a>
                                                </form>


                                            </td>

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
    document.addEventListener('DOMContentLoaded', function () {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            console.log('Preloader found. It will hide after 3 seconds...');
            setTimeout(function () {
                preloader.style.display = 'none'; // Sembunyikan preloader setelah 3 detik
                console.log('Preloader hidden.');
            }, 1500); // Durasi 3000 ms = 3 detik
        } else {
            console.error('Preloader element not found!');
        }
    });

</script>


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
