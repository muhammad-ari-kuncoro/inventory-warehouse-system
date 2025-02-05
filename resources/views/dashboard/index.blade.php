@extends('layouts.dashboard-layout')

@section('container')
<div class="container mt-4">
    <h4 class="mb-4">Kanban Dashboard Menu</h4>

    <div class="row flex-nowrap overflow-auto mb-5">
        <!-- Dashboard Section -->
        <div class="container-fluid mb-5">
            <div class="row g-4">
                <!-- Dashboard Section -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="card h-100 shadow">
                        <div class="card-body text-center">
                            <i class="tf-icons bx bx-home-circle display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Dashboard</h5>
                            <p class="card-text">Monitor key metrics and insights.</p>
                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">View Dashboard</a>
                        </div>
                    </div>
                </div>

                <!-- Project Section -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="card h-100 shadow">
                        <div class="card-body text-center">
                            <i class="tf-icons bx bx-layout display-4 text-success mb-3"></i>
                            <h5 class="card-title">Menu Project</h5>
                            <p class="card-text">Manage ongoing projects.</p>
                            <a href="{{ route('project.index') }}" class="btn btn-success btn-sm">View Projects</a>
                        </div>
                    </div>
                </div>

                <!-- Stock Section -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="card h-100 shadow">
                        <div class="card-body text-center">
                            <i class="tf-icons bx bx-cog display-4 text-info mb-3"></i>
                            <h5 class="card-title">Materials</h5>
                            <p class="card-text">View and manage material stock.</p>
                            <a href="{{ route('material.index') }}" class="btn btn-info btn-sm">View Materials</a>
                        </div>
                    </div>
                </div>

                <!-- Consumables Section -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="card h-100 shadow">
                        <div class="card-body text-center">
                            <i class="tf-icons bx bx-basket display-4 text-warning mb-3"></i>
                            <h5 class="card-title">Consumables</h5>
                            <p class="card-text">Track consumable inventory.</p>
                            <a href="{{ route('consumable.index') }}" class="btn btn-warning btn-sm">View Consumables</a>
                        </div>
                    </div>
                </div>

                <!-- Tools Section -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="card h-100 shadow">
                        <div class="card-body text-center">
                            <i class="tf-icons bx bx-wrench display-4 text-danger mb-3"></i>
                            <h5 class="card-title">Tools</h5>
                            <p class="card-text">Manage company tools.</p>
                            <a href="{{ route('tools.index') }}" class="btn btn-danger btn-sm">View Tools</a>
                        </div>
                    </div>
                </div>

                <!-- Machines Section -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="card h-100 shadow">
                        <div class="card-body text-center">
                            <i class="tf-icons bx bx-devices display-4 text-secondary mb-3"></i>
                            <h5 class="card-title">Machines</h5>
                            <p class="card-text">Monitor machine status.</p>
                            <a href="{{ route('machine.index') }}" class="btn btn-secondary btn-sm">View Machines</a>
                        </div>
                    </div>
                </div>

                <!-- Good Received Section -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="card h-100 shadow">
                        <div class="card-body text-center">
                            <i class="tf-icons bx bx-folder display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Good Received</h5>
                            <p class="card-text">Track incoming goods.</p>
                            <a href="{{ route('good-received.index') }}" class="btn btn-primary btn-sm">View Documents</a>
                        </div>
                    </div>
                </div>

                <!-- Shipping Items Section -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="card h-100 shadow">
                        <div class="card-body text-center">
                            <i class="tf-icons bx bx-log-out display-4 text-dark mb-3"></i>
                            <h5 class="card-title">Shipping Items</h5>
                            <p class="card-text">Manage shipping items.</p>
                            <a href="{{ route('shipping-items.index') }}" class="btn btn-dark btn-sm">View Shipments</a>
                        </div>
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
                    <div class="row row-bordered g-0">
                      <div class="col-md-8">
                        <h5 class="card-header m-0 me-2 pb-3">Total Revenue</h5>
                        <div id="totalRevenueChart" class="px-2"></div>
                      </div>
                      <div class="col-md-4">
                        <div class="card-body">
                          <div class="text-center">
                            <div class="dropdown">
                              <button
                                class="btn btn-sm btn-outline-primary dropdown-toggle"
                                type="button"
                                id="growthReportId"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">

                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                                <a class="dropdown-item" href="javascript:void(0);">2021</a>
                                <a class="dropdown-item" href="javascript:void(0);">2020</a>
                                <a class="dropdown-item" href="javascript:void(0);">2019</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="growthChart"></div>
                        <div class="text-center fw-semibold pt-3 mb-2">62% Company Growth</div>

                        <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                          <div class="d-flex">
                            <div class="me-2">
                              <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                            </div>
                            <div class="d-flex flex-column">
                              <small>2022</small>
                              <h6 class="mb-0">$32.5k</h6>
                            </div>
                          </div>
                          <div class="d-flex">
                            <div class="me-2">
                              <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                            </div>
                            <div class="d-flex flex-column">
                              <small>2021</small>
                              <h6 class="mb-0">$41.2k</h6>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Statistik Barang Keluar</h5>
                </div>
                <div class="card-body">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between pb-0">
                          <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Order Statistics</h5>
                            <small class="text-muted">42.82k Total Sales</small>
                          </div>
                          <div class="dropdown">
                            <button
                              class="btn p-0"
                              type="button"
                              id="orederStatistics"
                              data-bs-toggle="dropdown"
                              aria-haspopup="true"
                              aria-expanded="false"
                            >
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                              <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                              <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                              <a class="dropdown-item" href="javascript:void(0);">Share</a>
                            </div>
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex flex-column align-items-center gap-1">
                              <h2 class="mb-2">8,258</h2>
                              <span>Total Orders</span>
                            </div>
                            <div id="orderStatisticsChart"></div>
                          </div>
                          <ul class="p-0 m-0">
                            <li class="d-flex mb-4 pb-1">
                              <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary"
                                  ><i class="bx bx-mobile-alt"></i
                                ></span>
                              </div>
                              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                  <h6 class="mb-0">Electronic</h6>
                                  <small class="text-muted">Mobile, Earbuds, TV</small>
                                </div>
                                <div class="user-progress">
                                  <small class="fw-semibold">82.5k</small>
                                </div>
                              </div>
                            </li>
                            <li class="d-flex mb-4 pb-1">
                              <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
                              </div>
                              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                  <h6 class="mb-0">Fashion</h6>
                                  <small class="text-muted">T-shirt, Jeans, Shoes</small>
                                </div>
                                <div class="user-progress">
                                  <small class="fw-semibold">23.8k</small>
                                </div>
                              </div>
                            </li>
                            <li class="d-flex mb-4 pb-1">
                              <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                              </div>
                              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                  <h6 class="mb-0">Decor</h6>
                                  <small class="text-muted">Fine Art, Dining</small>
                                </div>
                                <div class="user-progress">
                                  <small class="fw-semibold">849k</small>
                                </div>
                              </div>
                            </li>
                            <li class="d-flex">
                              <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-secondary"
                                  ><i class="bx bx-football"></i
                                ></span>
                              </div>
                              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                  <h6 class="mb-0">Sports</h6>
                                  <small class="text-muted">Football, Cricket Kit</small>
                                </div>
                                <div class="user-progress">
                                  <small class="fw-semibold">99</small>
                                </div>
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
