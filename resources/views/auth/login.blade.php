<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            overflow: hidden;
        }

        .left-side {
            position: relative;
            background: url('{{ asset('images/login-bg.jpg') }}') no-repeat center center;
            background-size: cover;
            color: white;
        }

        .left-side::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
        }

        .left-content {
            position: relative;
            z-index: 2;
        }

        .left-side::before {
            backdrop-filter: blur(0.5px);
        }

        .left-side {
            animation: zoomIn 20s ease-in-out infinite alternate;
        }

        @keyframes zoomIn {
            from {
                background-size: 100%;
            }

            to {
                background-size: 110%;
            }
        }

        .brand-title {
            font-weight: 700;
            font-size: 2.2rem;
        }

        .form-control {
            padding: 0.75rem 1rem;
        }

        .btn-dark {
            padding: 0.75rem;
            font-weight: 500;
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background: #ddd;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }
    </style>
</head>

<body>

    <div class="container-fluid h-100">
        <div class="row h-100">

            <!-- LEFT SIDE -->
            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center left-side">
                <div class="text-center px-5 left-content">

                    <h1 class="brand-title mb-4">Sproutplex</h1>
                    <p class="lead">
                        Connect with top talent across Nigeria.
                        Build your team faster. Hire smarter.
                    </p>

                    <p class="mt-4 opacity-75">
                        Trusted by modern companies to post and manage jobs efficiently.
                    </p>

                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center bg-white">

                <div class="w-75" style="max-width:400px;">
                    <h3 class="fw-bold mb-2">Welcome back</h3>
                    <p class="text-muted mb-4">Login to your employer account</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <input type="email" name="email"
                                class="form-control rounded-3 @error('email') is-invalid @enderror"
                                placeholder="Email address" value="{{ old('email') }}" required>

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <input type="password" name="password" class="form-control rounded-3" placeholder="Password"
                                required>
                        </div>

                        <!-- Forgot Password -->
                        <div class="text-end mb-3">
                            <a href="{{ route('password.request') }}" class="small text-decoration-none">
                                Forgot password?
                            </a>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-dark rounded-3">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </button>
                        </div>

                    </form>

                    <div class="divider">
                        <span class="text-muted small">OR</span>
                    </div>

                    <!-- Google Login -->
                    <div class="d-grid mb-3">
                        <a href="{{ route('google.redirect') }}" class="btn btn-outline-dark rounded-3">

                            <i class="bi bi-google"></i> Continue with Google

                        </a>
                    </div>

                    <div class="text-center">
                        <small class="text-muted">
                            Don’t have an account?
                            <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">
                                Create one
                            </a>
                        </small>
                    </div>

                </div>

            </div>

        </div>
    </div>

</body>

</html>
