<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Account</title>
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
            background: url('{{ asset('images/register-bg.jpg') }}') no-repeat center center;
            background-size: cover;
            color: white;
        }

        .left-side::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            /* Dark overlay */
        }

        .left-content {
            position: relative;
            z-index: 2;
        }

        .left-side::before {
            backdrop-filter: blur(1px);
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
    </style>
</head>

<body>

    <div class="container-fluid h-100">
        <div class="row h-100">

            <!-- LEFT SIDE -->
            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center left-side">
                <div class="text-center px-5 left-content">

                    <h1 class="fw-bold mb-0">Join AntApple</h1>

                    <p class="lead">
                        Post jobs.
                        Manage applicants.
                        Grow your company.
                    </p>
                    <p class="mt-4 opacity-75">
                        Built for startups, SMEs, and modern Nigerian businesses.
                    </p>
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center bg-white">
                <div class="w-75" style="max-width: 450px;">

                    <h3 class="fw-bold mb-2">Create your account</h3>
                    <p class="text-muted mb-4">Start posting jobs in minutes</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <input type="text" name="name"
                                class="form-control rounded-3 @error('name') is-invalid @enderror"
                                placeholder="Full name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input type="email" name="email"
                                class="form-control rounded-3 @error('email') is-invalid @enderror"
                                placeholder="Email address" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input type="password" name="password"
                                class="form-control rounded-3 @error('password') is-invalid @enderror"
                                placeholder="Password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <input type="password" name="password_confirmation" class="form-control rounded-3"
                                placeholder="Confirm password" required>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-dark rounded-3">
                                <i class="bi bi-person-plus"></i> Create Account
                            </button>
                        </div>

                        <div class="text-center">
                            <small class="text-muted">
                                Already have an account?
                                <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">
                                    Login
                                </a>
                            </small>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</body>

</html>
