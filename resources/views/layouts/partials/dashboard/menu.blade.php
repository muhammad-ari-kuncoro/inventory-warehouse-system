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
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Dashboard Page</span>
        </li>
        <li class="menu-item {{ $sub_title === 'Dashboard' ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ $sub_title === 'Created Users' ? 'active' : '' }}">
            <a href="{{ route('userData.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Analytics">Created Users</div>
            </a>
        </li>



        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Menu Project</span>
        </li>



        <li class="menu-item {{ $sub_title === 'Main Project' ? 'active' : '' }}">
            <a href="" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-receipt"></i>
                <div data-i18n="Layouts">Project</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ $sub_title === 'Main Project' ? 'active' : '' }}">
                    <a href="{{ route('project.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-layout"></i>
                        <div data-i18n="Layouts">Main Project</div>
                    </a>
                </li>
                <li class="menu-item {{ $sub_title === 'Sub Project' ? 'active' : '' }}">
                    <a href="" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-layer"></i>
                        <div data-i18n="Layouts">Sub Project</div>
                    </a>
                </li>
            </ul>
        </li>


        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Stock</span>
        </li>

        <li class="menu-item {{ $sub_title === 'Materials' || $sub_title === 'Consumables' ? 'active' : '' }}">
            <a href="" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-data"></i>
                <div data-i18n="Layouts">Data Stok</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $sub_title === 'Materials' ? 'active' : '' }}">
                    <a href="{{ route('material.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-cog"></i>
                        <div data-i18n="Layouts">Materials</div>
                    </a>
                </li>
                <li class="menu-item {{ $sub_title === 'Consumables' ? 'active' : '' }}">
                    <a href="{{ route('consumable.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-basket"></i>
                        <div data-i18n="Layouts">Consumables</div>
                    </a>
                </li>

            </ul>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Assets</span>
        </li>

        <li class="menu-item {{ $sub_title === 'Tools' || $sub_title === 'Machine' ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-buildings"></i>
                <div data-i18n="Layouts">Assets</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ $sub_title === 'Tools' ? 'active' : '' }}">
                    <a href="{{ route('tools.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-wrench"></i>
                        <div data-i18n="Layouts">Tools</div>
                    </a>
                </li>

                <li class="menu-item {{ $sub_title === 'Machine' ? 'active' : '' }}">
                    <a href="{{ route('machine.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-devices"></i>
                        <div data-i18n="Layouts">Machine</div>
                    </a>
                </li>



            </ul>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Document</span>
        </li>



        <li class="menu-item {{ $sub_title === 'Good Received' || $sub_title === 'Delivery Order' || $sub_title === 'Shipping Fabricated' ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bx-file'></i>
                <div data-i18n="Layouts">Document Warehouse</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ $sub_title === 'Good Received' ? 'active' : '' }}">
                    <a href="{{ route('good-received.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-file-blank"></i>
                        <div data-i18n="Layouts">Good Received</div>
                    </a>
                </li>

                <li class="menu-item {{ $sub_title === 'Delivery Order' ? 'active' : '' }}">
                    <a href="{{ route('delivery-order.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-car"></i>
                        <div data-i18n="Layouts">Delivery Order</div>
                    </a>
                </li>


                <li class="menu-item {{ $sub_title === 'Barang Keluar' ? 'active' : '' }}">
                    <a href="{{ route('shipping-items.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-log-out"></i>
                        <div data-i18n="Layouts">Shipping Fabricated</div>
                    </a>
                </li>


            </ul>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Production</span>
        </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Produksi </div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $sub_title === 'Pengambilan Consumable' ? 'active' : '' }}">
                    <a href="{{ route('consumable-issuance.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-clipboard"></i>
                        <div data-i18n="Analytics">Consumable Out</div>
                    </a>
                </li>

                <li class="menu-item {{ $sub_title === 'Pengambilan Material' ? 'active' : '' }}">
                    <a href="{{ route('material-issuance.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-clipboard"></i>
                        <div data-i18n="Analytics">Material Out</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Equipment Production</span>
        </li>



        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-wrench"></i>
                <div data-i18n="Layouts">Perlengkapan</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ $sub_title === 'Peminjaman Alat' ? 'active' : '' }}">
                    <a href="{{ route('check-out-tools.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-archive-out"></i>
                        <div data-i18n="Analytics">Tools Machine Out</div>
                    </a>
                </li>

                <li class="menu-item {{ $sub_title === 'Pengembalian Alat' ? 'active' : '' }}">
                    <a href="{{ route('check-in-tools.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-archive-in"></i>
                        <div data-i18n="Analytics">Tools Machine In </div>
                    </a>
                </li>
            </ul>
        </li>




        <li class="menu-header small text-uppercase ">
            <span class="menu-header-text">Equipment Hydrotest</span>
        </li>


        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-group"></i>
                <div data-i18n="Layouts">Perlengkapan Pengujian</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ $sub_title === 'Peminjaman Materials Hydrotest' ? 'active' : '' }}">
                    <a href="{{ route('hydrotest-material-lending.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-minus-back"></i>
                        <div data-i18n="Analytics">Peminjaman Materials HydroTest</div>
                    </a>
                </li>

                <li class="menu-item {{ $sub_title === 'Pengembalian Materials Hydrotest' ? 'active' : '' }}">
                    <a href="" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-minus-front"></i>
                        <div data-i18n="Analytics">Pengembalian Materials HydroTest</div>
                    </a>
                </li>
            </ul>
        </li>
        </li>
    </ul>
</aside>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let dropdowns = document.querySelectorAll(".has-dropdown");
        dropdowns.forEach(function (dropdown) {
            let toggle = dropdown.querySelector(".menu-toggle");
            let submenu = dropdown.querySelector(".menu-sub");
            submenu.style.display = "none";

            toggle.addEventListener("click", function () {
                let isVisible = submenu.style.display === "block";
                submenu.style.display = isVisible ? "none" : "block";
            });
        });
    });
</script>
