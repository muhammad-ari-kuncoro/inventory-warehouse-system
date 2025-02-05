<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-primary shadow-lg" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
      <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="bx bx-menu bx-sm text-white"></i>
      </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center w-100" id="navbar-collapse">
      <!-- Judul Halaman -->
      <h5 class="text-white fw-bold me-auto mb-0">Dashboard Master Data</h5>

      <!-- Waktu Terkini -->
      <div class="text-white me-auto ms-3">
        <span id="currentDateTime" class="fw-light"></span>
      </div>

      <ul class="navbar-nav flex-row align-items-center ms-auto">


        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
          <a class="nav-link dropdown-toggle hide-arrow text-white" href="javascript:void(0);" data-bs-toggle="dropdown">
            <div class="avatar avatar-online">
              <img src="../asset/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item" href="#">
                <div class="d-flex">
                  <div class="flex-shrink-0 me-3">
                    <div class="avatar avatar-online">
                      <img src="../asset/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </div>
                  <div class="flex-grow-1">
                    <span class="fw-semibold d-block">John Doe</span>
                    <small class="text-muted">Admin</small>
                  </div>
                </div>
              </a>
            </li>
            <li><div class="dropdown-divider"></div></li>
            <li><a class="dropdown-item" href=""><i class="bx bx-user me-2"></i> <span class="align-middle">My Profile</span></a></li>
            <li><a class="dropdown-item" href="#"><i class="bx bx-cog me-2"></i> <span class="align-middle">Settings</span></a></li>
            <li><a class="dropdown-item" href="{{ route('logout_dashboard') }}"><i class="bx bx-power-off me-2"></i> <span class="align-middle">Log Out</span></a></li>
          </ul>
        </li>
        <!--/ User -->
      </ul>
    </div>
  </nav>

@push('scripts')
<script>
    $(document).ready(function () {
        var table = $('#myTable7').DataTable();
        $('#projectFilter').on('change', function () {
            table.column(4).search($(this).val()).draw();
        });
    });

    // Fungsi untuk memperbarui waktu setiap detik
    function updateDateTime() {
        document.getElementById('currentDateTime').textContent = new Date().toLocaleString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
    }
    setInterval(updateDateTime, 1000);
    updateDateTime(); // Jalankan saat halaman pertama kali dimuat
</script>
@endpush
