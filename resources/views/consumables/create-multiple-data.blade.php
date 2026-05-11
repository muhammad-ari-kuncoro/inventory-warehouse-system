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
                        <a href="{{ route('consumable.index') }}" class="text-primary text-decoration-none">consumables</a>
                    </li>
                    <li class="breadcrumb-item active">Add New Multiple Data Consumable</li>
                </ol>
            </nav>
            <a href="{{ route('consumable.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left-circle"></i> Back
            </a>
        </div>

        <div class="card-body">

            <form id="consumableForm">
                @csrf
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Consumable Name</label>
                        <input type="text" class="form-control @error('nama_consumable') is-invalid @enderror"
                            name="nama_consumable" id="nama_consumable" placeholder="Enter consumable name..." required>
                        @error('nama_consumable')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Specification</label>
                        <input type="text" class="form-control @error('spesifikasi_consumable') is-invalid @enderror"
                            name="spesifikasi_consumable" id="spesifikasi_consumable" placeholder="Enter specification..."
                            required>
                        @error('spesifikasi_consumable')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Quantity</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity"
                            id="quantity" placeholder="0" min="1" required>
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="jenis_quantity" class="form-label fw-semibold">Type Quantity</label>
                        <select id="jenis_quantity"
                            class="select-type-quantity form-select @error('jenis_quantity') is-invalid @enderror"
                            name="jenis_quantity" required>
                            <option disabled>Choose Unit</option>
                            <option value="Pcs">Pcs</option>
                            <option value="Length">Length</option>
                            <option value="Set">Set</option>
                            <option value="Sack">Sack</option>
                            <option value="Box">Box</option>
                            <option value="Kg">Kilogram (Kg)</option>
                            <option value="G">Gram (G)</option>
                            <option value="Dozen">Dozen</option>
                        </select>
                        @error('jenis_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="jenis_consumable" class="form-label fw-semibold">Type Consumable</label>
                        <select id="jenis_consumable" class="form-select @error('jenis_consumable') is-invalid @enderror"
                            name="jenis_consumable" required>
                            <option selected disabled>Choose Type</option>
                            <option value="General Consumable">General Consumable</option>
                            <option value="Welding Consumable">Welding Consumable</option>
                            <option value="Safety Consumable">Safety Consumable</option>
                        </select>
                        @error('jenis_consumable')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Price per Unit</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="text" class="form-control" name="harga_consumable" id="harga_consumable"
                                placeholder="0" oninput="formatCurrency(this)">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Project Assignment</label>
                    <select class="select-project @error('project_id') is-invalid @enderror" name="project_id" id="project_id"
                        required>
                        <option value="" disabled selected>Select Project...</option>
                        @foreach ($data_project as $project)
                            <option value="{{ $project->id }}">
                                {{ $project->nama_project }} | {{ $project->sub_nama_project }} | JO:
                                {{ $project->no_jo_project }}
                            </option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-primary px-4" id="addToTable">
                        <i class="bi bi-plus-circle me-2"></i>Add to List
                    </button>
                </div>
            </form>

            <hr>

            <h6 class="fw-semibold mb-3">List consumables</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-hover display" id="consumableTable">
                    <thead class="table-info text-center">
                        <tr>
                            <th>No</th>
                            <th>Consumable Name</th>
                            <th>Spesification</th>
                            <th>Quantity</th>
                            <th>Type Quantity</th>
                            <th>Type consumable</th>
                            <th>Price</th>
                            <th>Project</th>
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
                <a href="{{ route('consumable.index') }}" class="btn btn-danger btn-sm">
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
            let daftarconsumable = [];

            const addBtn = document.getElementById('addToTable');
            const submitBtn = document.getElementById('submitAll');
            const consumableForm = document.getElementById('consumableForm');

            addBtn.addEventListener('click', function() {
                const nama_consumable = document.getElementById('nama_consumable').value.trim();
                const spesifikasi_consumable = document.getElementById('spesifikasi_consumable').value
                    .trim();
                const quantity = document.getElementById('quantity').value.trim();
                const jenis_quantity = document.getElementById('jenis_quantity').value;
                const jenis_consumable = document.getElementById('jenis_consumable').value;
                const harga_consumable = document.getElementById('harga_consumable').value.trim();

                const projSelect = document.getElementById('project_id');
                const project_id = projSelect.value;
                const project_name = projSelect.options[projSelect.selectedIndex]?.text ?? '';

                if (!nama_consumable || !spesifikasi_consumable || !quantity ||
                    !jenis_quantity || !jenis_consumable || !project_id) {
                    alert('All fields are required!');
                    return;
                }

                daftarconsumable.push({
                    nama_consumable,
                    spesifikasi_consumable,
                    quantity,
                    jenis_quantity,
                    jenis_consumable,
                    harga_consumable,
                    project_id,
                    project_name
                });

                renderTable();
                consumableForm.reset();
            });

            function renderTable() {
                const tbody = document.querySelector('#consumableTable tbody');
                tbody.innerHTML = '';
                daftarconsumable.forEach((m, i) => {
                    tbody.insertAdjacentHTML('beforeend', `
                    <tr class="text-center">
                        <td>${i + 1}</td>
                        <td>${esc(m.nama_consumable)}</td>
                        <td>${esc(m.spesifikasi_consumable)}</td>
                        <td>${esc(m.quantity)}</td>
                        <td>${esc(m.jenis_quantity)}</td>
                        <td>${esc(m.jenis_consumable)}</td>
                        <td>Rp ${esc(m.harga_consumable)}</td>
                        <td>${esc(m.project_name)}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="hapusItem(${i})">
                                <i class="bi bi-trash">Delete</i>
                            </button>
                        </td>
                    </tr>`);
                });
            }

            window.hapusItem = function(index) {
                daftarconsumable.splice(index, 1);
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
                if (daftarconsumable.length === 0) {
                    alert('the table is still empty! Add data first.');
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
                    const res = await fetch("{{ route('consumable.store.multiple_data') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            data: daftarconsumable
                        })
                    });

                    if (!res.ok) {
                        const text = await res.text();
                        let msg = 'An error occurred. Check the console for details.';
                        try {
                            const json = JSON.parse(text);
                            if (json.message) msg = json.message;
                        } catch {}
                        alert(msg);
                        return;
                    }

                    const result = await res.json();
                    alert(result.message ?? 'Data saved successfully!');
                    daftarconsumable = [];
                    renderTable();

                } catch (err) {
                    console.error(err);
                    alert('network error. Check the console.');
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
            let daftarconsumable = [];
        });
        $(document).ready(function() {
            $('.select-project').select2({
                width: '100%',
                placeholder: "Choose Project"
            });
            let daftarconsumable = [];
        });
    </script>
@endpush
