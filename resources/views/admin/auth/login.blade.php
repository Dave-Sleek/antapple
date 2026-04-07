<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">

    <div class="card shadow-sm border-0" style="max-width: 380px; width: 100%;">
        <div class="card-body p-4">

            <div class="text-center mb-4">
                <h4 class="fw-bold">Admin Login</h4>
                <p class="text-muted small mb-0">
                    Sign in to manage job listings
                </p>
            </div>

            <form method="POST">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label small">Email address</label>
                    <input type="email" name="email" class="form-control" placeholder="admin@example.com" required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label small">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <!-- Error -->
                @error('email')
                    <div class="alert alert-danger py-2 small">
                        {{ $message }}
                    </div>
                @enderror

                <!-- Button -->
                <div class="d-grid mt-4">
                    <button class="btn btn-primary fw-semibold">
                        Login
                    </button>
                </div>
            </form>

        </div>
    </div>

</body>

</html>
