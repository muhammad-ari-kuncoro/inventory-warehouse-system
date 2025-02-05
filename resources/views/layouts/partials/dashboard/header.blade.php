<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../asset/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>{{ $title }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('asset/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"/>


     {{-- Data Tables JS --}}
     <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/js/dataTables.min.js">
     <link rel="stylesheet" href="//cdn.datatables.net/buttons/3.2.0/css/buttons.dataTables.css">



 <!-- Styles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- Or for RTL support -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />






    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('asset/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('asset/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('asset/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('asset/css/demo.css') }}" />

    {{-- Data Tables CSS --}}
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('asset/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('asset/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->
    <style>
     #preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgb(255, 255, 255); /* Background gelap transparan */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    }

    .hidden {
    display: none;
    }

    /* Atur ukuran gambar agar tidak terpotong */
.logo-image {
    width: auto; /* Sesuaikan lebar otomatis berdasarkan tinggi */
    height: 90px; /* Tetapkan tinggi gambar */
    object-fit: contain; /* Pastikan seluruh gambar ditampilkan tanpa crop */
    display: block; /* Pastikan tidak ada margin atau spasi tambahan */
    margin: 2 auto; /* Pusatkan gambar */
}

/* Pastikan elemen pembungkus gambar tidak memotong */
.app-brand {
    overflow: visible; /* Tidak memotong konten di dalam elemen */
    text-align: center; /* Pusatkan konten */
}

/* Tambahkan jika ingin logo tetap terlihat saat di-scroll */
.app-brand {
    position: sticky; /* Tetap di posisi saat scroll */
    background-color: white; /* Tambahkan warna latar belakang agar terlihat jelas */
    padding: 10px 0;
    }

    <style>
    .form-label {
        font-weight: bold;
    }

    #projectFilter {
        max-width: 100%; /* Agar select input tidak terlalu panjang */
    }
</style>
<style>
    #projectFilter {
        max-width: 300px; /* Lebar maksimal dropdown */
        min-width: 200px; /* Lebar minimal dropdown */
    }

    .form-label {
        font-weight: bold; /* Supaya teks label lebih jelas */
    }

    .btn {
        white-space: nowrap; /* Mencegah teks tombol memotong ke bawah */
    }

    form .form-control-sm {
        max-width: 300px; /* Pastikan input file tidak terlalu panjang */
    }
</style>

<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        border-radius: 10px 10px 0 0;
    }
    .form-control-plaintext {
        padding: 0.375rem 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        background-color: #f8f9fa;
    }
</style>


    </style>
    {{-- GIni aja, karena dia global scope oke apa lan terus nanti, gw sibuk awkwkw --}}
    <!-- Helpers -->
    <script src="{{ asset('asset/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('asset/js/config.js') }}"></script>
    @stack('styles')
  </head>
