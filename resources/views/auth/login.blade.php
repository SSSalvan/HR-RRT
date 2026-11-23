@extends('layouts.auth')

@section('content')
<style>
    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        background: #f5f7fa;
        padding: 20px;
    }

    .login-container {
        width: 100%;
        max-width: 450px;
        margin: 0 auto;
    }

    .login-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 40px;
    }

    .login-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .login-header h2 {
        color: #2c3e50;
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .login-header p {
        color: #8F9FBC;
        font-size: 0.9rem;
    }

    .form-group-modern {
        margin-bottom: 20px;
    }

    .form-group-modern label {
        display: block;
        color: #2c3e50;
        font-weight: 500;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .form-control-modern {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        font-size: 0.95rem;
        transition: border-color 0.2s ease;
        background: white;
    }

    .form-control-modern:focus {
        outline: none;
        border-color: #3378FF;
    }

    .form-control-modern.is-invalid {
        border-color: #F42B3D;
    }

    .btn-login {
        width: 100%;
        padding: 12px;
        background: #3378FF;
        border: none;
        border-radius: 6px;
        color: white;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s ease;
        margin-top: 10px;
    }

    .btn-login:hover {
        background: #2666e8;
    }

    .remember-forgot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        font-size: 0.85rem;
    }

    .remember-forgot a {
        color: #3378FF;
        text-decoration: none;
    }

    .remember-forgot a:hover {
        text-decoration: underline;
    }

    .user-cards-section {
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid #e0e0e0;
    }

    .user-cards-title {
        text-align: center;
        color: #6c757d;
        font-size: 0.8rem;
        font-weight: 500;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .user-cards-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .user-card {
        background: #f8f9fa;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        padding: 15px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
    }

    .user-card:hover {
        border-color: #3378FF;
        background: #f0f7ff;
    }

    .user-card-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: #3378FF;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
        margin: 0 auto 10px;
    }

    .user-card-info h4 {
        color: #2c3e50;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 3px;
    }

    .user-card-info p {
        color: #8F9FBC;
        font-size: 0.75rem;
        margin-bottom: 6px;
    }

    .user-card-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 500;
    }

    .badge-admin {
        background: #e3f2fd;
        color: #3378FF;
    }

    .badge-user {
        background: #e0f7fa;
        color: #19b3b3;
    }

    .invalid-feedback {
        display: block;
        color: #F42B3D;
        font-size: 0.8rem;
        margin-top: 5px;
    }

    @media (max-width: 767px) {
        .user-cards-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="login-wrapper">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2>Sign In</h2>
                <p>Human Resource Management System</p>
            </div>

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <div class="form-group-modern">
                    <label for="email">Email Address</label>
                    <input
                        id="email"
                        type="email"
                        class="form-control-modern @error('email') is-invalid @enderror"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        autofocus
                        placeholder="Enter your email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group-modern">
                    <label for="password">Password</label>
                    <input
                        id="password"
                        type="password"
                        class="form-control-modern @error('password') is-invalid @enderror"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Enter your password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="remember-forgot">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Remember Me
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    Sign In
                </button>
            </form>

            <!-- Dummy User Cards -->
            <div class="user-cards-section">
                <div class="user-cards-title">Quick Login - Demo Accounts</div>
                <div class="user-cards-grid">
                    <!-- Admin Card -->
                    <div class="user-card" onclick="fillLoginForm('admin@admin.id', 'password')">
                        <div class="user-card-avatar">A</div>
                        <div class="user-card-info">
                            <h4>Admin</h4>
                            <p>admin@admin.id</p>
                            <span class="user-card-badge badge-admin">Administrator</span>
                        </div>
                    </div>

                    <!-- User Card -->
                    <div class="user-card" onclick="fillLoginForm('user@admin.id', 'password')">
                        <div class="user-card-avatar" style="background: #19b3b3;">U</div>
                        <div class="user-card-info">
                            <h4>User</h4>
                            <p>user@admin.id</p>
                            <span class="user-card-badge badge-user">Regular User</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function fillLoginForm(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
        document.querySelector('.btn-login').focus();
    }
</script>
@endsection
