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
              <a href="{{ route('project.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-layout"></i>
                  <div data-i18n="Layouts">Menu Project</div>
              </a>
          </li>

          <!-- Layouts Stuff -->
          <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Stock</span>
          </li>
          <li class="menu-item {{ ($sub_title === "Materials")  ? 'active' : ''}}">
              <a href="{{ route('material.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-cog"></i>
                  <div data-i18n="Layouts">Materials</div>
              </a>
          </li>
          <li class="menu-item {{ ($sub_title === "Consumables")  ? 'active' : ''}}">
              <a href="{{route('consumable.index')}}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-basket"></i>
                  <div data-i18n="Layouts">Consumables</div>
              </a>
          </li>
          <li class="menu-item {{ ($sub_title === "Tools")  ? 'active' : ''}}">
              <a href="{{route('tools.index')}}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-wrench"></i>
                  <div data-i18n="Layouts">Tools</div>
              </a>
          </li>
          {{-- End Layout --}}

          {{-- Layouts Document --}}
          <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Document Surat Jalan</span>
          </li>

          <li class="menu-item {{ ($sub_title === "Barang Masuk")  ? 'active' : ''}}">
              <a href="{{route('good-received.index')}}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-folder"></i>
                  <div data-i18n="Layouts">Barang Masuk</div>
              </a>
          </li>

          <li class="menu-item {{ ($sub_title === "Pengiriman Delivery Order")  ? 'active' : ''}}">
              <a href="{{route('delivery-order.index')}}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-car"></i>
                  <div data-i18n="Layouts">Pengiriman Delivery Order</div>
              </a>
          </li>


          <li class="menu-item {{ ($sub_title === "Barang Keluar")  ? 'active' : ''}}">
              <a href="{{route('shipping-items.index')}}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-log-out"></i>
                  <div data-i18n="Layouts">Barang Keluar</div>
              </a>
          </li>



          {{-- Layouts Document --}}
          <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Produksi</span>
          </li>
          <li class="menu-item {{ ($sub_title === "Pengambilan Consumable")  ? 'active' : ''}}">
              <a href="{{ route('consumable-issuance.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-clipboard"></i>
                  <div data-i18n="Analytics">Pengambilan Consumable</div>
              </a>
          </li>

        <li class="menu-item {{ ($sub_title === "Pengambilan Material")  ? 'active' : ''}}">
            <a href="{{route('material-issuance.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-clipboard"></i>
                <div data-i18n="Analytics">Pengambilan Materials</div>
            </a>
        </li>

          <li class="menu-item {{ ($sub_title === "Peminjaman Alat")  ? 'active' : ''}}">
            <a href="{{ route('check-out-tools.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-archive-out"></i>
                <div data-i18n="Analytics">Peminjaman  Alat</div>
            </a>
        </li>

        <li class="menu-item {{ ($sub_title === "")  ? 'active' : ''}}">
            <a href="" class="menu-link">
                <i class="menu-icon tf-icons bx bx-archive-in"></i>
                <div data-i18n="Analytics">Pengembalian Alat </div>
            </a>
        </li>


        <li class="menu-item {{ ($sub_title === "")  ? 'active' : ''}}">
            <a href="" class="menu-link">
                <i class="menu-icon tf-icons bx bx-clipboard"></i>
                <div data-i18n="Analytics">Pengembalian Materials HydroTest</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Project Luar</span>
        </li>

        <li class="menu-item {{ ($sub_title === "Pengiriman")  ? 'active' : ''}}">
            <a href="" class="menu-link">
                <i class="menu-icon tf-icons bx bx-arrow-to-right"></i>
                <div data-i18n="Layouts">Pengiriman Barang</div>
            </a>
            <a href="" class="menu-link">
              <i class="menu-icon tf-icons bx bx-arrow-to-left"></i>
              <div data-i18n="Layouts">Pengembalian Barang</div>
          </a>
        </li>









          </li>
      </ul>
  </aside>
  <!-- / Menu -->
