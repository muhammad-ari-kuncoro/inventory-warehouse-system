  <!-- Menu -->

  <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand demo justify-content-center mt-4">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('asset/img/img-import/thumb_armindo_jaya_mandiri-removebg-preview.png') }}"
                    style="width: 100px; height: auto;" alt="Logo">
            </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <!-- Dashboard -->
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Dashboard Page</span>
      </li>
      <li class="menu-item {{ ($sub_title === "Dashboard")  ? 'active' : ''}}">
        <a href="{{ route('dashboard') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div data-i18n="Analytics">Dashboard</div>
        </a>
      </li>

      <!-- Layouts project -->
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Projet</span>
      </li>
      <li class="menu-item {{ ($sub_title === "Menu Project")  ? 'active' : ''}}">
        <a href="{{ route('menu_project.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-layout"></i>
          <div data-i18n="Layouts">Menu Project</div>
        </a>
      </li>

        <!-- Layouts Materials -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Materials</span>
          </li>
          <li class="menu-item {{ ($sub_title === "Materials")  ? 'active' : ''}}">
            <a href="{{ route('materials.index') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-layout"></i>
              <div data-i18n="Layouts">Materials</div>
            </a>
          </li>





      </li>
    </ul>
  </aside>
  <!-- / Menu -->
