@extends('layouts.login-layout')
@section('container')

<!-- Logo -->

<div class="app-brand justify-content-center">

    <span class="app-brand-logo demo">
        <img src="{{ asset('asset/img/img-import/thumb_armindo_jaya_mandiri-removebg-preview.png') }}"
            style="width: 170px; height: auto;" alt="Logo">
    </span>
</div>



<!-- /Logo -->
@if (session()->has('success'))
<div class="alert alert-primary" role="alert">{{ session('success') }}</div>
@endif


@if (session()->has('loginError'))
<div class="alert alert-danger" role="alert">{{ session('loginError') }}</div>
@endif



<form class="mb-3" action="{{ route('login_page_dasboard') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
            placeholder="Enter your email or username" autofocus required value="{{ old('email') }}" />
        @error('email')
        <div class="invalid-feedback">
            {{ $message }}
        </div>

        @enderror
    </div>

    <div class="mb-3 form-password-toggle">
        <div class="d-flex justify-content-between">
            <label class="form-label" for="password">Password</label>
            </a>
        </div>

        <div class="input-group input-group-merge">
            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                name="password" placeholder="Enter your Password " autofocus required value="{{ old('password') }}"/>
                <div class="mb-3">
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                    @enderror
                </div>

            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
        </div>

    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
    </div>
</form>


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

  @endsection
