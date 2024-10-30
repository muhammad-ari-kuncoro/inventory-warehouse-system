@include('layouts.partials.auth.header')
  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
                <div class="container">
                @yield('container')





            </div>
          </div>
        </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

   @include('layouts.partials.auth.footer')
