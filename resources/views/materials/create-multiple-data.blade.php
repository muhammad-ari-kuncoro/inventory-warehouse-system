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
                    <a href="{{ route('material.index') }}" class="text-primary text-decoration-none">Materials</a>
                </li>
                <li class="breadcrumb-item active">Add New Multiple Data Material</li>
            </ol>
        </nav>
        <a href="{{ route('material.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left-circle"></i> Back
        </a>
    </div>

    <div class="card-body">

        <form id="materialForm">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Material Name</label>
                <input type="text" class="form-control @error('nama_material') is-invalid @enderror"
                    name="nama_material" id="nama_material"
                    placeholder="Please fill in the material name field ..." required>
                @error('nama_material')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Spesification Material</label>
                <input type="text" class="form-control @error('spesifikasi_material') is-invalid @enderror"
                    name="spesifikasi_material" id="spesifikasi_material"
                    placeholder="Please fill in the spesification material field ..." required>
                @error('spesifikasi_material')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-2 mb-3">
                <div class="col-6">
                    <label class="form-label fw-semibold">Quantity</label>
                    <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                        name="quantity" id="quantity" placeholder="0" min="1" required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold">Type Quantity</label>
                    <select class="form-select rounded-top @error('jenis_quantity') is-invalid @enderror"
                        name="jenis_quantity" id="jenis_quantity" required>
                        <option selected disabled>Choose Type Quantity ...</option>
                        <option value="Pcs">Pcs</option>
                        <option value="Rod">Rod</option>
                        <option value="Set">Set</option>
                        <option value="Sack">Sack</option>
                        <option value="Box">Box</option>
                        <option value="Ea">Ea</option>
                    </select>
                    @error('jenis_quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Type Material</label>
                <select class="form-select @error('jenis_material') is-invalid @enderror"
                    name="jenis_material" id="jenis_material" required>
                    <option value="" disabled selected>Choose Type Material</option>
                    <option value="New">New</option>
                    <option value="Temporary">Temporary</option>
                </select>
                @error('jenis_material')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Material Price</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" class="form-control" name="harga_material" id="harga_material"
                        placeholder="0" oninput="formatCurrency(this)">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Project</label>
                <select class="form-select @error('project_id') is-invalid @enderror"
                    name="project_id" id="project_id" required>
                    <option value="" disabled selected>Choosee Project</option>
                    @foreach ($data_project as $project)
                        <option value="{{ $project->id }}">
                            {{ $project->nama_project }} | {{ $project->sub_nama_project }} | JO: {{ $project->no_jo_project }}
                        </option>
                    @endforeach
                </select>
                @error('project_id')
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

        <h6 class="fw-semibold mb-3">List Materials</h6>
        <div class="table-responsive">
            <table class="table table-bordered table-hover display" id="materialTable">
                <thead class="table-info text-center">
                    <tr>
                        <th>No</th>
                        <th>Material Name</th>
                        <th>Spesification</th>
                        <th>Quantity</th>
                        <th>Type Quantity</th>
                        <th>Type Material</th>
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
            <a href="{{ route('material.index') }}" class="btn btn-danger btn-sm">
                <i class="bi bi-x-circle me-1"></i> Cancel
            </a>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let daftarMaterial = [];
        const addBtn       = document.getElementById('addToTable');
        const submitBtn    = document.getElementById('submitAll');
        const materialForm = document.getElementById('materialForm');

        addBtn.addEventListener('click', function () {
            const nama_material       = document.getElementById('nama_material').value.trim();
            const spesifikasi_material = document.getElementById('spesifikasi_material').value.trim();
            const quantity            = document.getElementById('quantity').value.trim();
            const jenis_quantity      = document.getElementById('jenis_quantity').value;
            const jenis_material      = document.getElementById('jenis_material').value;
            const harga_material      = document.getElementById('harga_material').value.trim();

            const projSelect          = document.getElementById('project_id');
            const project_id          = projSelect.value;
            const project_name        = projSelect.options[projSelect.selectedIndex]?.text ?? '';

            if (!nama_material || !spesifikasi_material || !quantity ||
                !jenis_quantity || !jenis_material || !project_id) {
                alert('All Fields Are Required!');
                return;
            }

            daftarMaterial.push({
                nama_material, spesifikasi_material,
                quantity, jenis_quantity,
                jenis_material, harga_material,
                project_id, project_name
            });

            renderTable();
            materialForm.reset();
        });

        function renderTable() {
            const tbody = document.querySelector('#materialTable tbody');
            tbody.innerHTML = '';
            daftarMaterial.forEach((m, i) => {
                tbody.insertAdjacentHTML('beforeend', `
                    <tr class="text-center">
                        <td>${i + 1}</td>
                        <td>${esc(m.nama_material)}</td>
                        <td>${esc(m.spesifikasi_material)}</td>
                        <td>${esc(m.quantity)}</td>
                        <td>${esc(m.jenis_quantity)}</td>
                        <td>${esc(m.jenis_material)}</td>
                        <td>Rp ${esc(m.harga_material)}</td>
                        <td>${esc(m.project_name)}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="hapusItem(${i})">
                                <i class="bi bi-trash">Delete</i>
                            </button>
                        </td>
                    </tr>`);
            });
        }

        window.hapusItem = function (index) {
            daftarMaterial.splice(index, 1);
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

        submitBtn.addEventListener('click', async function () {
            if (daftarMaterial.length === 0) {
                alert('The table is still empty! Please add data first.');
                return;
            }

            const csrfToken = document.querySelector('input[name="_token"]')?.value ?? null;
            if (!csrfToken) {
                alert('CSRF token not found. Please refresh the page.');
                return;
            }

            submitBtn.disabled  = true;
            submitBtn.innerText = 'Saving...';

            try {
                const res = await fetch("{{ route('material.store.multiple_data') }}", {
                    method : 'POST',
                    headers: {
                        'Content-Type' : 'application/json',
                        'X-CSRF-TOKEN' : csrfToken,
                        'Accept'       : 'application/json'
                    },
                    body: JSON.stringify({ data: daftarMaterial })
                });

                if (!res.ok) {
                    const text = await res.text();
                    let msg = 'An Error Occurred. Check The Console For Details.';
                    try { const json = JSON.parse(text); if (json.message) msg = json.message; } catch {}
                    alert(msg);
                    return;
                }

                const result = await res.json();
                alert(result.message ?? 'Data saved successfully!');
                daftarMaterial = [];
                renderTable();

            } catch (err) {
                console.error(err);
                alert('Network Error. Check The Console.');
            } finally {
                submitBtn.disabled  = false;
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
</script>
@endpush
