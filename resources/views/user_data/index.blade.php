@extends('layouts.dashboard-layout')
@section('container')
    <div class="card">
        <div class="card-header bg-light">
            <!-- Breadcrumb Navigation -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-primary text-decoration-none">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Menu User Data</li>
                </ol>
            </nav>
        </div>

        {{-- Session Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong class="text-dark">{!! session()->get('success') !!}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('delete'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong class="text-dark">Data has been deleted</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('editSuccess'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong class="text-dark">{!! session()->get('editSuccess') !!}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <div class="card-body">


            <div class="row align-items-center">
                <div class="col-md-9 col-lg-6 mb-3">
                    <label for="projectFilter" class="form-label">Filter Category Project</label>
                    <select id="projectFilter" class="form-select w-auto" style="max-width: 300px;">
                        <option value="">All Categories</option>

                        <optgroup label="🔧 Production Position">
                            <option value="Fitter (Production)">Fitter (Production)</option>
                            <option value="Helper (Production)">Helper (Production)</option>
                            <option value="Welder (Production)">Welder (Production)</option>
                            <option value="Supervisor (production)">Supervisor (Production)</option>
                        </optgroup>

                        <optgroup label="🏭 Warehouse Position">
                            <option value="Helper Warehouse">Helper Warehouse (Staff)</option>
                            <option value="Supervisor Warehouse">Supervisor Warehouse (Staff)</option>
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-3 col-lg-6 mb-3 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add Data
                    </button>
                </div>
            </div>

            <!-- Add Button -->



            <div class="table-responsive">


                <table class="table table-bordered table-hover display" id="myTable5">
                    <thead>
                        <tr class="table-info text-center">
                            <th class="text-center">No</th>
                            <th class="text-center">Usename</th>
                            <th class="text-center">User Role</th>
                            <th class="text-center">Position</th>
                            <th class="text-center">Action</th>
                    </thead>
                    <tbody>
                        @foreach ($data_user as $data)
                            <tr class="text-center">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $data->username }}</td>
                                <td class="text-center">{{ $data->role }}</td>
                                <td class="text-center">{{ $data->posisi }}</td>
                                <td>
                                    <div class="mb-1">
                                        <a href="{{ route('userData.read-user', $data->id) }}"><span
                                                class="btn btn-success btn-sm mb-2"><i
                                                    class='bx bx-show'></i></a></span></a>
                                        <a href="{{ route('userData.edit-user', $data->id) }}"><span
                                                class="btn btn-warning btn-sm mb-2"><i
                                                    class='bx bx-edit'></i></a></span></a>
                                    </div>
                                    <div class="mb-1">
                                        <form action="{{ route('userData.delete-user', $data->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </form>
                                    </div>


                                    {{-- <div class="mb-1">
                            <a href=""><span class="btn btn-danger btn-sm">Hapus</a></span>
                        </div> --}}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Data User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('userData.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Username -->
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input class="form-control @error('username') is-invalid @enderror" type="text"
                                name="username" placeholder="Please enter your name..." required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email"
                                name="email" placeholder="Please enter your email..." required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input class="form-control @error('password') is-invalid @enderror" type="password"
                                name="password" placeholder="Please enter your password..." required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Posisi -->
                        <div class="mb-3">
                            <label class="form-label">Job Position</label>
                            <select class="form-select @error('posisi') is-invalid @enderror" name="posisi"
                                id="posisi" required>
                                <option value="" disabled selected>-- Choose Position --</option>
                                <optgroup label="🔧 Production Position">
                                    <option value="Fitter (Production)">Fitter (Production)</option>
                                    <option value="Helper (Production)">Helper (Production)</option>
                                    <option value="Welder (Production)">Welder (Production)</option>
                                    <option value="Supervisor (Production)">Supervisor (Production)</option>
                                </optgroup>
                                <optgroup label="🏭 Warehouse Position">
                                    <option value="Helper Warehouse">Helper Warehouse</option>
                                    <option value="Supervisor Warehouse">Supervisor Warehouse</option>
                                </optgroup>
                            </select>
                            @error('posisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div class="mb-3">
                            <label class="form-label">Roles</label>
                            <select class="form-select @error('role') is-invalid @enderror" name="role" id="role"
                                required>
                                <option value="Production">Production</option>
                                <option value="Warehouse Staff">Warehouse Staff</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Footer + Submit MASIH DI DALAM FORM -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>

                    </form> <!-- ✅ Tutup form SETELAH tombol submit -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="//cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
    <script src="//cdn.datatables.net/buttons/3.2.0/js/buttons.dataTables.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/3.2.0/js/buttons.print.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                console.log('Preloader found. It will hide after 3 seconds...');
                setTimeout(function() {
                    preloader.style.display = 'none'; // Sembunyikan preloader setelah 3 detik
                    console.log('Preloader hidden.');
                }, 1500); // Durasi 3000 ms = 3 detik
            } else {
                console.error('Preloader element not found!');
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            var table = $('#myTable5').DataTable({

            });

            $('#projectFilter').on('change', function() {
                var projectFilter = $(this).val(); // Ambil nilai dropdown

                // Terapkan filter pada kolom Kategori Project (index 3)
                table.column(3).search(projectFilter).draw();
            });

        });

        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('currentDateTime').textContent = now.toLocaleDateString('id-ID', options);
        }

        // Jalankan fungsi pertama kali
        updateDateTime();

        // Perbarui waktu setiap detik
        setInterval(updateDateTime, 1000);


        const posisiSelect = document.getElementById('posisi');
        const roleSelect = document.getElementById('role');

        function syncRole() {
            const posisi = posisiSelect.value;

            if (posisi.includes('(Production)')) {
                roleSelect.value = 'Production';
            } else if (posisi.includes('Warehouse')) {
                roleSelect.value = 'Warehouse Staff';
            }
            // Kalau admin, biarkan — admin tidak punya posisi khusus
        }

        // Jalankan saat halaman load (jaga konsistensi data lama)
        syncRole();

        // Jalankan saat posisi berubah
        posisiSelect.addEventListener('change', syncRole);
    </script>
@endpush
