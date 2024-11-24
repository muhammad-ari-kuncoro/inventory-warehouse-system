@extends('layouts.dashboard-layout')
@section('container')
<div class="card">
    <div class="card-body">

        <h5 class="card-header text-center mb-3">
            Dashboard Menu Material Saat ini
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




            <div class="table-responsive">
                <table class="table table-bordered table-hover display" id="myTable2">
                    <thead>
                        <tr class="table-info text-center">
                            <th>No</th>
                            <th>Nama Materials</th>
                            <th>Spesifikasi Materials</th>
                            <th>Kode Material</th>
                            <th>Quantity</th>
                            <th>Jenis Quantity</th>
                            <th>Jenis Materials</th>
                            <th>Nama Project</th>
                            <th>Sub Nama Project</th>
                            <th>Aksi </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data_material as $data )
                        <tr>
                        <td class="text-center">{{$loop->iteration; }}</td>
                        <td>{{ $data->nama_material }}</td>
                        <td>{{ $data->spesifikasi_material }}</td>
                        <td>{{ $data->kode_material }}</td>
                        <td class="text-center">{{ $data->quantity }}</td>
                        <td class="text-center">{{ $data->jenis_quantity }}</td>
                        <td class="text-center">{{ $data->jenis_material}}</td>
                        <td>{{ $data->project->nama_project }}</td>
                        <td>{{ $data->project->sub_nama_project }}</td>
                        <td>
                            <div class="mb-1">
                                <a href="{{ route('material.edit',$data->id) }}"><span class="btn btn-warning btn-sm mb-3">Edit</a></span>
                                <a href=""><span class="btn btn-danger btn-sm">Hapus</a></span>
                            </div>

                        </td>
                    </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('material.create') }}" method="post">
                    @csrf

                    <div class="mb-3">
                        <label for="nama_material" class="form-label">Nama Material</label>
                        <input class="form-control rounded-top  @error('nama_material') is-invalid @enderror"
                            type="text" name="nama_material" placeholder="Harap Di Isi Nama Material" required>
                        @error('nama_material')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="spesifikasi_material" class="form-label">Spesifikasi Materials</label>
                        <input class="form-control rounded-top @error('spesifikasi_material') is-invalid @enderror"
                            type="text" name="spesifikasi_material" placeholder="Harap Di Isi Spesifikasi Material"
                            required>
                        @error('spesifikasi_material')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity Materials</label>
                        <input class="form-control rounded-top @error('quantity') is-invalid @enderror" type="number"
                            name="quantity" placeholder="Harap Di Isi Quantity Material" required>
                        @error('quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="jenis_quantity" class="form-label" name="jenis_quantity">Jenis Quantity </label>
                        <select class="form-select rounded-top @error('jenis_quantity') is-invalid @enderror" name="jenis_quantity" required>
                            <option selected disabled>Pilih Jenis Quantity</option>
                            <option value="Pcs">Pcs</option>
                            <option value="Batang">Batang</option>
                            <option value="Set">Set</option>
                            <option value="Karung">Karung</option>
                            <option value="Box">Box</option>
                            @error('jenis_quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                            @enderror
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="jenis_material" class="form-label" name="jenis_material">Jenis Materials </label>
                        <select class="form-select rounded-top @error('jenis_material') is-invalid @enderror"
                            name="jenis_material" required>
                            <option selected disabled>Pilih Jenis Material</option>
                            <option value="Besar">Besar</option>
                            <option value="Kecil">Kecil</option>
                            @error('jenis_material')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="project_id" class="form-label" name="project_id">Nama Kategori Project</label>
                        <select class="form-select rounded-top @error('project_id') is-invalid @enderror"
                            name="project_id" required>
                            <option selected disabled>Pilih Kategori Project</option>
                            @foreach ($data_project as $data )
                            <option value="{{ $data->id }}">{{ $data->nama_project }} | {{ $data->sub_nama_project }} | NO JO : {{ $data->no_jo_project }} </option>

                            @error('project_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                            @endforeach

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
    let table = new DataTable('#myTable2',

    );



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
