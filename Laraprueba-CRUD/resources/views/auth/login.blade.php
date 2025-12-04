@extends('adminlte::auth.login')

@section('auth_body')
<form method="post" action="{{ url('/login') }}">
    @csrf
    
    <!-- Email input -->
    <div class="input-group mb-3">
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
               placeholder="Email" value="{{ old('email') }}" required>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Password input -->
    <div class="input-group mb-3">
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
               placeholder="Password" required>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
        @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    
    <!-- Remember me -->
    <div class="row">
        <div class="col-8">
            <div class="icheck-primary">
                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">
                    Remember Me
                </label>
            </div>
        </div>
        <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </div>
    </div>
</form>

<!-- Google OAuth Button -->
<div class="row mt-3">
    <div class="col-12">
        <a href="{{ route('google.redirect') }}" class="btn btn-danger btn-block">
            <i class="fab fa-google mr-2"></i> Sign in with Google
        </a>
    </div>
</div>

<!-- Forgot password link -->
@if (Route::has('password.request'))
    <p class="my-0">
        <a href="{{ route('password.request') }}">
            I forgot my password
        </a>
    </p>
@endif

<!-- Register link -->
@if (Route::has('register'))
    <p class="my-0">
        <a href="{{ route('register') }}" class="text-center">
            Register a new membership
        </a>
    </p>
@endif
@endsection
