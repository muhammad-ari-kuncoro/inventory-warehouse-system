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
            @if ($do_draft)
                <div class="card-header text-end">
                    <form action="{{ route('good-received.delete-draft') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Hapus Draft</button>
                    </form>
                </div>
            @endif
            <div class="card-body row">
                <div class="col-lg-6">
                    <form action="{{ route('good-received.store') }}" method="post" id="formSubmit">
                        @csrf
                        <h4>Form Data Alamat</h4>
                       <div class="mb-3">
                            <label for="tanggal_masuk" class="form-label">Tanggal Masuk Barang</label>
                            <input class="form-control rounded-top @error('tanggal_masuk') is-invalid @enderror" type="date" name="tanggal_masuk" placeholder="Harap Di Isi Tanggal Pengiriman Barang">
                            @error('tanggal_masuk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="kode_surat_jalan" class="form-label">No Surat Jalan</label>
                            <input class="form-control rounded-top @error('kode_surat_jalan') is-invalid @enderror" type="text" name="kode_surat_jalan" placeholder="Harap Di Isi No Surat Jalan Barang">
                            @error('kode_surat_jalan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_supplier" class="form-label">Nama Supplier</label>
                            <input class="form-control rounded-top @error('nama_supplier') is-invalid @enderror" type="text" name="nama_supplier" placeholder="Harap Di Isi Nama Supplier">
                            @error('nama_supplier')
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
                    <form action="{{ route('good-received.store.item') }}" method="post">
                        @csrf
                        <h4>Form Barang</h4>
                        <div class="mb-3">
                            <label for="jenis_barang" class="form-label">Jenis Barang Masuk</label>
                            <select name="jenis_barang" id="jenis_barang"
                                class="form-select @error('jenis_barang') is-invalid @enderror">
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

                        <div class="mb-3" id="div_material">
                            <label class="form-label">Nama Material</label>
                            <select name="material_id" class="form-select select-2" data-placeholder="Pilih Salah Satu">
                                <option></option>
                                @foreach ($materials as $material)
                                <option value="{{ $material->id }}">{{ $material->nama_material }} |
                                    {{$material->spesifikasi_material}} | ({{$material->quantity}})
                                    {{$material->jenis_quantity}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3" id="div_consumable">
                            <label for="consumable_id" class="form-label">Nama Consumable</label>
                            <select name="consumable_id" class="form-select select-2"
                                data-placeholder="Pilih Salah Satu">
                                <option></option>
                                @foreach ($consumables as $consumable)
                                <option value="{{ $consumable->id }}">{{ $consumable->nama_consumable }} |
                                    {{$consumable->spesifikasi_consumable}} | ({{$consumable->quantity}})
                                    {{$consumable->jenis_quantity}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3" id="div_tool">
                            <label class="form-label">Nama Tool</label>
                            <select name="tools_id" class="form-select select-2" data-placeholder="Pilih Salah Satu">
                                <option></option>
                                @foreach ($tools as $tool)
                                <option value="{{ $tool->id }}">{{ $tool->nama_alat }} | {{$tool->spesifikasi_alat}} |
                                    ({{$tool->quantity}}) {{$tool->jenis_quantity}}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input class="form-control rounded-top @error('quantity') is-invalid @enderror"
                                type="number" min="1" name="quantity"
                                placeholder="Harap Di Isi Tanggal Pengiriman Barang">
                            @error('quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="quantity_jenis" class="form-label">Quantity Jenis</label>
                            <select class="form-select select-2 @error('quantity_jenis') is-invalid @enderror"
                                name="quantity_jenis" data-placeholder="Pilih Salah Satu">
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
                            @error('quantity_jenis')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="keterangan_barang" id="floatingTextarea2Disabled"
                                style="height: 100px"></textarea>
                            <label for="floatingTextarea2Disabled">Keterangan barang </label>
                            @error('keterangan_barang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>



                        <div class="mb-3 text-end">
                            <button type="submit" class="btn btn-success">Tambah Barang</button>
                            <a href="{{route('good-received.index')}}" class="btn btn-secondary">Go back</a>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12">
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama barang</th>
                                    <th>Jenis Barang</th>
                                    <th>Quantity</th>
                                    <th>Jenis Quantity</th>
                                    <th>Keterangan barang</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($do_draft)
                                    @foreach ($do_draft->details as $detail)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                {{ optional($detail->material)->nama_material ?? optional($detail->consumable)->nama_consumable ?? optional($detail->tool)->nama_alat
                                                            ?? '-' }}
                                            </td>
                                            <td>{{ $detail->jenis_barang }}</td>
                                            <td>{{ $detail->quantity }}</td>
                                            <td>{{ $detail->quantity_jenis }}</td>
                                            <td>{{ $detail->keterangan_barang }}</td>
                                            <td>

                                                <form action="{{ route('good-received.delete-detail', $detail->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class='bx bx-edit-alt' ></i></button>
                                                </form>
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
                        <button class="btn btn-primary" onclick="submitForm()">Submit</button>

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
