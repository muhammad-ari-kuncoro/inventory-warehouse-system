@extends('layouts.dashboard-layout')
@section('container')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-primary text-decoration-none">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('machine.index') }}" class="text-primary text-decoration-none">Machine</a>
                    </li>
                    <li class="breadcrumb-item active">Add New Multiple Data Machine</li>
                </ol>
            </nav>
            <a href="{{ route('machine.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left-circle"></i> Back
            </a>
        </div>

        <div class="card-body">
            <form id="machineForm">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Name Machine</label>
                    <input class="form-control @error('nama_mesin') is-invalid @enderror" type="text" name="nama_mesin" id="nama_mesin"
                        placeholder="Please fill in the name machine field ..." required autocomplete>
                    @error('nama_mesin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Spesification Machine</label>
                    <input class="form-control @error('spesifikasi_mesin') is-invalid @enderror" type="text" id="spesifikasi_mesin"
                        name="spesifikasi_mesin" placeholder="Please fill in the spesification machine field ..." required
                        autofocus>
                    @error('spesifikasi_mesin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Type Machine</label>
                    <select class="select-type-machine @error('jenis_mesin') is-invalid @enderror" name="jenis_mesin" id="jenis_mesin"
                        required>
                        <option selected disabled>Choose Type Machine</option>
                        <option value="Cutting Machines">Cutting Machines</option>
                        <option value="Forming Machines">Forming Machines</option>
                        <option value="Welding Machines">Welding Machines</option>
                        <option value="Machining Machines">Machining Machines</option>
                        <option value="Surface Treatment Machines">Surface Treatment Machines</option>
                        <option value="spesial machines">spesial machines</option>
                        <option value="Pipe Bending">Pipe Bending</option>
                    </select>
                    @error('jenis_mesin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Quantity Mesin</label>
                        <input class="form-control @error('quantity') is-invalid @enderror" type="number" min="1" id="quantity"
                            name="quantity" placeholder="0" required>
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Type Quantity</label>
                        <select class="select-type-quantity @error('jenis_quantity') is-invalid @enderror"
                            name="jenis_quantity" id="jenis_quantity" required>
                            <option disabled>Choose Type</option>
                            <option value="Unit">Unit</option>
                            <option value="Set">Set</option>
                        </select>
                        @error('jenis_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Price Machine</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" class="form-control" name="harga_mesin"  placeholder="0"
                            oninput="formatCurrency(this)" id="harga_mesin">
                        <span class="input-group-text">.00</span>
                    </div>
                    @error('harga_mesin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-primary btn-sm" id="addToTable">
                        <i class="bi bi-plus-circle me-1"></i> Add to Table
                    </button>
                </div>
            </form>

            <hr>

            <h6 class="fw-semibold mb-3">List Machines</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-hover display" id="machineTable">
                    <thead class="table-info text-center">
                        <tr>
                            <th>No</th>
                            <th>Name Machine</th>
                            <th>Spesification</th>
                            <th>Type Machine</th>
                            <th>Quantity</th>
                            <th>Type Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <button type="button" id="submitAll" class="btn btn-success btn-sm">
                    <i class="bi bi-check-circle me-1"></i> Save Data
                </button>
                <a href="{{ route('machine.index') }}" class="btn btn-danger btn-sm">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </a>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        tr.bg-danger td {
            background-color: #f8d7da !important;
            color: #842029 !important;
        }
    </style>
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let daftarMesin = [];
            const addBtn = document.getElementById('addToTable');
            const submitBtn = document.getElementById('submitAll');
            const machineForm = document.getElementById('machineForm');

            addBtn.addEventListener('click', function() {
                const nama_mesin = document.getElementById('nama_mesin').value.trim();
                const spesifikasi_mesin = document.getElementById('spesifikasi_mesin').value.trim();
                const quantity = document.getElementById('quantity').value.trim();
                const jenis_quantity = document.getElementById('jenis_quantity').value;
                const jenis_mesin = document.getElementById('jenis_mesin').value;
                const harga_mesin = document.getElementById('harga_mesin').value.trim();


                if (!nama_mesin || !spesifikasi_mesin || !quantity ||
                    !jenis_quantity || !jenis_mesin) {
                    alert('All Fields Are Required!');
                    return;
                }

                daftarMesin.push({
                    nama_mesin,
                    spesifikasi_mesin,
                    quantity,
                    jenis_quantity,
                    jenis_mesin,
                    harga_mesin,
                });

                renderTable();
                machineForm.reset();
            });

            function renderTable() {
                const tbody = document.querySelector('#machineTable tbody');
                tbody.innerHTML = '';
                daftarMesin.forEach((m, i) => {
                    tbody.insertAdjacentHTML('beforeend', `
                    <tr class="text-center">
                        <td>${i + 1}</td>
                        <td>${esc(m.nama_mesin)}</td>
                        <td>${esc(m.spesifikasi_mesin)}</td>
                        <td>${esc(m.quantity)}</td>
                        <td>${esc(m.jenis_quantity)}</td>
                        <td>${esc(m.jenis_mesin)}</td>
                        <td>Rp ${esc(m.harga_mesin)}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="hapusItem(${i})">
                                <i class="bi bi-trash">Delete</i>
                            </button>
                        </td>
                    </tr>`);
                });
            }

            window.hapusItem = function(index) {
                daftarMesin.splice(index, 1);
                renderTable();
            };

            function esc(text) {
                if (text == null) return '';
                return String(text)
                    .replace(/&/g, '&amp;')
                    .replace(/"/g, '&quot;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;');
            }

            submitBtn.addEventListener('click', async function() {
                if (daftarMesin.length === 0) {
                    alert('The table is still empty! Please add data first.');
                    return;
                }

                const csrfToken = document.querySelector('input[name="_token"]')?.value ?? null;
                if (!csrfToken) {
                    alert('CSRF token not found. Please refresh the page.');
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.innerText = 'Saving...';

                try {
                    const res = await fetch("{{ route('machine.store.multiple') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            data: daftarMesin
                        })
                    });

                    if (!res.ok) {
                        const text = await res.text();
                        let msg = 'An Error Occurred. Check The Console For Details.';
                        try {
                            const json = JSON.parse(text);
                            if (json.message) msg = json.message;
                        } catch {}
                        alert(msg);
                        return;
                    }

                    const result = await res.json();
                    alert(result.message ?? 'Data saved successfully!');
                    daftarMesin = [];
                    renderTable();

                } catch (err) {
                    console.error(err);
                    alert('Network Error. Check The Console.');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Save Data';
                }
            });
        });

        function formatCurrency(input) {
            let value = input.value.replace(/[^,\d]/g, '');
            input.value = new Intl.NumberFormat('id-ID').format(value);
        }
        document.addEventListener('DOMContentLoaded', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) setTimeout(() => preloader.style.display = 'none', 1500);
        });

        $(document).ready(function() {
            $('.select-type-quantity').select2({
                width: '100%',
                placeholder: "Choose Type Quantity"
            });
            $('.select-type-machine').select2({
                width: '100%',
                placeholder: "Choose Type Machine"
            });
            let daftarMesin = [];
        });
    </script>
@endpush
