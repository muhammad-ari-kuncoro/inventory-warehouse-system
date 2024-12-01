@extends('layouts.dashboard-layout')

@section('container')
<div class="container mt-4">
    <h4 class="mb-4">Kanban Board - Horizontal Layout</h4>

    <div class="row flex-nowrap overflow-auto mb-5">
        <!-- Dashboard Section -->
        <div class="row flex-nowrap overflow-auto">
            <!-- Dashboard Section -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="tf-icons bx bx-home-circle display-4 text-primary mb-3"></i>
                        <h5 class="card-title">Dashboard</h5>
                        <p class="card-text">Monitor key metrics and insights.</p>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">View Dashboard</a>
                    </div>
                </div>
            </div>

            <!-- Project Section -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="tf-icons bx bx-layout display-4 text-success mb-3"></i>
                        <h5 class="card-title">Menu Project</h5>
                        <p class="card-text">Manage ongoing projects.</p>
                        <a href="{{ route('project.index') }}" class="btn btn-success btn-sm">View Projects</a>
                    </div>
                </div>
            </div>

            <!-- Stock Section -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="tf-icons bx bx-cog display-4 text-info mb-3"></i>
                        <h5 class="card-title">Materials</h5>
                        <p class="card-text">View and manage material stock.</p>
                        <a href="{{ route('material.index') }}" class="btn btn-info btn-sm">View Materials</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="tf-icons bx bx-basket display-4 text-warning mb-3"></i>
                        <h5 class="card-title">Consumables</h5>
                        <p class="card-text">Track consumable inventory.</p>
                        <a href="{{ route('consumable.index') }}" class="btn btn-warning btn-sm">View Consumables</a>
                    </div>
                </div>
            </div>

            <!-- Assets Section -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="tf-icons bx bx-wrench display-4 text-danger mb-3"></i>
                        <h5 class="card-title">Tools</h5>
                        <p class="card-text">Manage company tools.</p>
                        <a href="{{ route('tools.index') }}" class="btn btn-danger btn-sm">View Tools</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="tf-icons bx bx-devices display-4 text-secondary mb-3"></i>
                        <h5 class="card-title">Machines</h5>
                        <p class="card-text">Monitor machine status.</p>
                        <a href="{{ route('machine.index') }}" class="btn btn-secondary btn-sm">View Machines</a>
                    </div>
                </div>
            </div>

            <!-- Documents Section -->
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="tf-icons bx bx-folder display-4 text-primary mb-3"></i>
                        <h5 class="card-title">Good Received</h5>
                        <p class="card-text">Track incoming goods.</p>
                        <a href="{{ route('good-received.index') }}" class="btn btn-primary btn-sm">View Documents</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="tf-icons bx bx-log-out display-4 text-dark mb-3"></i>
                        <h5 class="card-title">Shipping Items</h5>
                        <p class="card-text">Manage shipping items.</p>
                        <a href="{{ route('shipping-items.index') }}" class="btn btn-dark btn-sm">View Shipments</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tambahkan card lainnya seperti sebelumnya -->
    </div>

    <!-- Statistik Laporan -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Statistik Barang Masuk</h5>
                </div>
                <div class="card-body">
                    <canvas id="goodsReceivedChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Statistik Barang Keluar</h5>
                </div>
                <div class="card-body">
                    <canvas id="goodsShippedChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data Statistik Barang Masuk
    const goodsReceivedCtx = document.getElementById('goodsReceivedChart').getContext('2d');
    new Chart(goodsReceivedCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Jumlah Barang Masuk',
                data: [30, 45, 50, 40, 60, 70],
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Data Statistik Barang Keluar
    const goodsShippedCtx = document.getElementById('goodsShippedChart').getContext('2d');
    new Chart(goodsShippedCtx, {
        type: 'pie',
        data: {
            labels: ['Material', 'Consumables', 'Tools', 'Machines'],
            datasets: [{
                label: 'Prosentase Barang Keluar',
                data: [25, 30, 20, 25],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
</script>
@endsection
