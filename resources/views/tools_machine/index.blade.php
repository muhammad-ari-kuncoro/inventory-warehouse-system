@extends('layouts.dashboard-layout')
@section('container')
<div class="card">
    <h5 class="card-header text-center mb-3">
        Dashboard Menu Mesin & Tools Saat ini
        <br>
        <span id="currentDateTime" class="ms-2 text-muted"></span>
    </h5>
    {{-- Session Notifikasi --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong class="text-dark">{!! session()->get('success') !!}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif (session('delete'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong class="text-dark">Data Telah Dihapus</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif (session('editSuccess'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong class="text-dark">{!! session()->get('editSuccess') !!}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif


    <div class="card-body">

        {{-- Tampilan Button Data Dan Print  --}}
        <div class="row align-items-center mb-2">
            <!-- Print Button -->
            <div class="col-sm-2 mb-3">
                <a href="" class="btn btn-success w-100">Print Data</a>
            </div>

            <!-- Add Button -->
            <div class="col-sm-2 mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Tambah Data
                </button>
            </div>





        <div class="card-datatable table-responsive pt-0">

            <table class="datatables-basic table table-bordered table-hover display" id="myTable2">
                <thead>
                    <tr class="table-info text-center">
                        <th>No</th>
                        <th>Nama Alat</th>
                        <th>Spesifikasi Alat</th>
                        <th>Kode Alat</th>
                        <th>Jenis Alat</th>
                        <th>Tipe Alat</th>
                        <th class="text-center">Quantity Alat</th>
                        <th>Jenis Quantity</th>
                        <th>Aksi</th>
                    </tr>
                </thead>


                <tbody>
                    @foreach ($data_tools as $data )
                    <tr>
                        <td class="text-center">{{$loop->iteration;}}</td>
                        <td>{{$data->nama_alat}}</td>
                        <td>{{$data->spesifikasi_alat}}</td>
                        <td>{{$data->kode_alat}}</td>
                        <td>{{$data->jenis_alat}}</td>
                        <td>{{$data->tipe_alat}}</td>
                        <td class="text-center">{{$data->quantity}}</td>
                        <td>{{$data->jenis_quantity}}</td>
                        <td>
                            <div class="mb-1">
                                <a href="{{route('tools.edit',$data->id)}}"><span class="btn btn-warning btn-sm">Edit</a></span>
                            </div>

                        </td>
                        {{-- <div class="mb-1">
                                     <a href=""><span class="btn btn-danger btn-sm">Hapus</a></span>
                                 </div> --}}

                    </tr>
                    @endforeach
                </tbody>


            </table>
        </div>
        <div class="mb-3 mt-3">
            {{-- {{ $menu_project->links('pagination::bootstrap-5') }} --}}
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Menu Tools</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('tools.create')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_alat" class="form-label">Nama Alat Atau Mesin </label>
                        <input class="form-control rounded-top  @error('nama_alat') is-invalid @enderror" type="text"
                            name="nama_alat" placeholder="Harap Di Isi Tools Peralatan Atau Permesinan" required>
                        @error('nama_alat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="spesifikasi_alat" class="form-label">Spesifikasi Alat Atau Mesin </label>
                        <input class="form-control rounded-top @error('spesifikasi_alat') is-invalid @enderror"
                            type="text" name="spesifikasi_alat"
                            placeholder="Harap Di Isi Spesifikasi Peralatan Atau Permesinan" required>
                        @error('spesifikasi_alat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jenis_alat" class="form-label" name="jenis_alat">Jenis Alat </label>
                        <select class="form-select rounded-top @error('jenis_alat') is-invalid @enderror"
                            name="jenis_alat" required>
                            <option selected disabled>Pilih Jenis Alat</option>
                            <option value="Alat Pemotong">Alat Pemotong(Cutting Tools)</option>
                            <option value="Mesin Las">Mesin las (Machine Welding)</option>
                            <option value="Alat Pengangkat">Alat Pengangkat</option>
                            <option value="Alat Pemukul ">Alat Pemukul (Lifting Equipment)</option>
                            <option value="Mesin Pembentuk">Mesin Pembentuk</option>
                            <option value="Alat Pemukul">Mesin Pemukul(Hammer)</option>
                            <option value="Alat Pengunci">Alat Pengunci</option>
                            <option value="Alat Pengukur">Alat Pengunci</option>
                            <option value="Alat Tester">Alat Tester</option>

                            @error('jenis_alat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tipe_alat" class="form-label" name="tipe_alat">Tipe Alat </label>
                        <select class="form-select rounded-top @error('tipe_alat') is-invalid @enderror"
                            name="tipe_alat" required>
                            <option selected disabled>Pilih Jenis Alat</option>
                            <option value="Kecil">Kecil</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Besar">Berat/Besar</option>
                            @error('tipe_alat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity Alat Atau Mesin </label>
                        <input class="form-control rounded-top @error('quantity') is-invalid @enderror" type="number"
                            name="quantity" placeholder="Harap Di Isi Spesifikasi Peralatan Atau Permesinan" required>
                        @error('quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jenis_quantity" class="form-label" name="jenis_quantity">Jenis Quantity Alat</label>
                        <select class="form-select rounded-top @error('jenis_quantity') is-invalid @enderror"
                            name="jenis_quantity" required>
                            <option selected disabled>Pilih Jenis Alat</option>
                            <option value="Unit">Unit</option>
                            <option value="Pcs">Pcs</option>
                            <option value="Set">Set</option>
                            @error('jenis_quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script>
    let table = new DataTable('#myTable2');

    function updateDateTime() {
        const now = new Date();
        const options = {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
            hour: '2-digit', minute: '2-digit', second: '2-digit'
        };
        document.getElementById('currentDateTime').textContent = now.toLocaleDateString('id-ID', options);
    }

    // Jalankan fungsi pertama kali
    updateDateTime();

    // Perbarui waktu setiap detik
    setInterval(updateDateTime, 1000);
</script>
@endpush


