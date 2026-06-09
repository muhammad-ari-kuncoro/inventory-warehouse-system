<!DOCTYPE html>
<html lang="en" class="light-style" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('asset') }}/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>403 - Access Denied</title>

    <meta name="description" content="" />

    <link rel="icon" type="image/x-icon"
        href="{{ asset('asset/img/favicon/favicon.ico') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Fonts -->
    <link rel="stylesheet"
        href="{{ asset('asset/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet"
        href="{{ asset('asset/vendor/css/core.css') }}"
        class="template-customizer-core-css" />

    <link rel="stylesheet"
        href="{{ asset('asset/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />

    <link rel="stylesheet"
        href="{{ asset('asset/css/demo.css') }}" />

    <link rel="stylesheet"
        href="{{ asset('asset/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->K
    <link rel="stylesheet"
        href="{{ asset('asset/vendor/css/pages/page-misc.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('asset/vendor/js/helpers.js') }}"></script>

    <!-- Config -->
    <script src="{{ asset('asset/js/config.js') }}"></script>
</head>

<body>

    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">

            <div class="mt-3">
                <img
                    src="{{ asset('img/illustrations/403-error-forbidden.png') }}"
                    alt="403 Forbidden"
                    width="500"
                    class="img-fluid" />
            </div>

            <h2 class="mb-2 mx-2">
                403 - Access Denied
            </h2>

            <p class="mb-4 mx-2">
                Sorry 😖, you do not have permission to access this page.
            </p>

            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                Back to Dashboard
            </a>


        </div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('asset/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('asset/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('asset/vendor/js/bootstrap.js') }}"></script>

    <script src="{{ asset('asset/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('asset/vendor/js/menu.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('asset/js/main.js') }}"></script>

</body>

</html>
