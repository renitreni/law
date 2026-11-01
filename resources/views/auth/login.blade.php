@extends('layouts.guest.spark')

@section('content')
    <!-- ==========================================
         START: Authentication Container & Login Card
         ========================================== -->
    <div class="login-wrapper">
        <!-- Glowing background shapes for modern visual appearance -->
        <div class="login-bg-shape login-bg-shape-1"></div>
        <div class="login-bg-shape login-bg-shape-2"></div>

        <!-- Main centered login card -->
        <div class="login-card">

            <!-- Brand Identity -->
            <a href="{{ url('/') }}" class="login-brand text-decoration-none">
                <i class="bi bi-asterisk"></i>
                <span>Spark Admin</span>
            </a>

            <p class="login-subtitle">Please sign in to access your dashboard</p>

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" id="loginForm" class="needs-validation" novalidate>
                @csrf

                <!-- General Auth Error -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-custom alert-custom-danger mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill alert-custom-icon"></i>
                        <div class="alert-custom-content">
                            {{ $errors->first() }}
                        </div>
                    </div>
                @endif

                <!-- Email Input Group -->
                <div class="login-form-group">
                    <label for="email" class="login-form-label">Email Address</label>
                    <div class="login-input-group">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" id="email" name="email" class="login-input @error('email') is-invalid @enderror" placeholder="name@company.com" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Password Input Group -->
                <div class="login-form-group">
                    <label for="password" class="login-form-label">Password</label>
                    <div class="login-input-group">
                        <i class="bi bi-shield-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="login-input login-input-password @error('password') is-invalid @enderror" placeholder="••••••••" required autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <button type="button" class="password-toggle-btn" id="toggle-password" aria-label="Show password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Options (Remember me & Forgot Password) -->
                <div class="login-options">
                    <label class="custom-control-label">
                        <input type="checkbox" class="custom-checkbox-input" name="remember" id="rememberMe" {{ old('remember') ? 'checked' : '' }}>
                        <span>Remember Me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password-link">Forgot Password?</a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-login" id="btn-submit">
                    <span>Sign In to Dashboard</span>
                    <i class="bi bi-arrow-right"></i>
                </button>

            </form>

            <!-- Divider -->
            <div class="login-divider">Or sign in with</div>

            <!-- Social Logins -->
            <div class="social-login-grid">
                <button class="btn-social" type="button" id="btn-google">
                    <i class="bi bi-google text-danger"></i>
                    <span>Google</span>
                </button>
                <button class="btn-social" type="button" id="btn-github">
                    <i class="bi bi-github"></i>
                    <span>GitHub</span>
                </button>
            </div>

            <!-- Footer Link -->
            <p class="login-footer-text">
                Don't have an account? <a href="#" id="link-register">Register Now</a>
            </p>

        </div>
    </div>
    <!-- END: Authentication Container -->

@endsection
