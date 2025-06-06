 {{-- <!-- Footer -->
 <footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
      <div class="mb-2 mb-md-0">
        ©
        <script>
          document.write(new Date().getFullYear());
        </script>
        , made  by
        <a href="https://www.linkedin.com/in/muhamad-ari-kuncoro-72a605215/" target="_blank" class="footer-link fw-bolder">Muhammad Ari Kuncoro </a>
      </div>
      <div>
    </div>
  </footer>
  <!-- / Footer --> --}}

  <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->
<!-- Core JS -->
<!-- build:js asset/vendor/js/core.js -->
<script src="{{ asset('../asset/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('../asset/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('../asset/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('../asset/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

<script src="{{ asset('../asset/vendor/js/menu.js') }}"></script>


<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('../asset/vendor/libs/apex-charts/apexcharts.js') }}"></script>


<!-- Main JS -->
<script src="{{ asset('../asset/js/main.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('../asset/js/dashboards-analytics.js') }}"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
@stack('scripts')

</body>
</html>
