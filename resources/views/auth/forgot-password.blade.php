<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password - AntApple Jobs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Reset your AntApple Jobs account password securely.">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            font-family: 'Inter', sans-serif;
            position: relative;
            overflow-x: hidden;
            padding: 20px;
        }

        /* Animated Background */
        .bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M50 50h30v30H50V50zm0-30h30v30H50V20zM20 50h30v30H20V50zm0-30h30v30H20V20z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: 1;
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            z-index: 1;
            animation: float 6s ease-in-out infinite;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            top: -100px;
            right: -100px;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.15);
            bottom: -50px;
            left: -50px;
            animation-delay: 2s;
        }

        .shape-3 {
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            top: 50%;
            right: 20%;
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-20px) scale(1.05);
            }
        }

        .container {
            position: relative;
            z-index: 10;
        }

        /* Premium Card */
        .premium-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 48px;
            padding: 3rem 2.5rem;
            box-shadow: 0 50px 100px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.6s ease;
            position: relative;
            overflow: hidden;
        }

        .premium-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .premium-card:hover::before {
            opacity: 0.1;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Icon */
        .forgot-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: 0 20px 40px rgba(245, 158, 11, 0.3);
            animation: pulse 2s infinite;
        }

        .forgot-icon i {
            font-size: 3.5rem;
            color: white;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        /* Title */
        .title {
            font-size: 2.2rem;
            font-weight: 800;
            color: #1e2937;
            margin-bottom: 1rem;
            text-align: center;
            letter-spacing: -0.5px;
        }

        .subtitle {
            color: #64748b;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Alert */
        .alert-premium-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 20px;
            padding: 1.2rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #047857;
        }

        .alert-icon {
            width: 36px;
            height: 36px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #10b981;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        /* Form */
        .input-group-premium {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #1e2937;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-label i {
            color: #f59e0b;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            z-index: 2;
            transition: color 0.3s ease;
            font-size: 1.1rem;
        }

        .form-control {
            width: 100%;
            height: 60px;
            padding: 0 16px 0 52px;
            border: 2px solid #e2e8f0;
            border-radius: 20px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
            color: #1e2937;
            font-weight: 500;
        }

        .form-control:focus {
            outline: none;
            border-color: #f59e0b;
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
        }

        .form-control:focus+.input-icon {
            color: #f59e0b;
        }

        /* Button */
        .btn-send {
            width: 100%;
            height: 60px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            border: none;
            border-radius: 60px;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 20px 40px rgba(245, 158, 11, 0.3);
            cursor: pointer;
            margin: 1.5rem 0 1rem;
        }

        .btn-send:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px rgba(245, 158, 11, 0.4);
        }

        .btn-glow {
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .btn-send:hover .btn-glow {
            opacity: 1;
        }

        /* Info Box */
        .info-box {
            background: #f8fafc;
            border-radius: 20px;
            padding: 1rem;
            margin: 1.5rem 0;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .info-text {
            color: #475569;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* Help Links */
        .help-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .help-link {
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: all 0.3s ease;
            padding: 8px 16px;
            background: #f8fafc;
            border-radius: 40px;
        }

        .help-link:hover {
            color: #f59e0b;
            transform: translateY(-2px);
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        /* Loading State */
        .btn-send.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-send.loading .btn-text {
            opacity: 0;
        }

        .btn-send.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border: 2px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Success Animation */
        @keyframes checkmark {
            0% {
                transform: scale(0);
            }

            100% {
                transform: scale(1);
            }
        }

        .success-check {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 1.5rem;
            animation: checkmark 0.3s ease;
        }

        .btn-send.success .btn-text {
            opacity: 0;
        }

        .btn-send.success .success-check {
            display: block;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .premium-card {
                padding: 2rem 1.5rem;
            }

            .title {
                font-size: 1.8rem;
            }

            .forgot-icon {
                width: 80px;
                height: 80px;
            }

            .forgot-icon i {
                font-size: 2.5rem;
            }

            .form-control {
                height: 52px;
            }

            .btn-send {
                height: 52px;
                font-size: 1rem;
            }
        }
    </style>

</head>

<body>

    <!-- Animated Background -->
    <div class="bg-pattern"></div>
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-6 col-lg-5">

                <div class="premium-card animate__animated animate__fadeIn">

                    <!-- Icon -->
                    <div class="forgot-icon">
                        <i class="bi bi-key"></i>
                    </div>

                    <!-- Title -->
                    <h1 class="title">Forgot Password?</h1>
                    <p class="subtitle">
                        No worries! Enter your email address and we'll send you a link to reset your password.
                    </p>

                    <!-- Success Alert -->
                    @if (session('success'))
                        <div class="alert-premium-success animate__animated animate__fadeIn">
                            <div class="alert-icon">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div class="flex-grow-1">
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    <!-- Form -->
                    <form method="POST" action="{{ route('password.email') }}" id="forgotForm">
                        @csrf

                        <div class="input-group-premium">
                            <label class="form-label">
                                <i class="bi bi-envelope"></i>
                                Email Address
                            </label>
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="email" name="email" class="form-control" placeholder="your@email.com"
                                value="{{ old('email') }}" required autofocus>
                        </div>

                        <!-- Info Box -->
                        <div class="info-box">
                            <div class="info-icon">
                                <i class="bi bi-info-circle"></i>
                            </div>
                            <div class="info-text">
                                You'll receive a password reset link if your email is registered in our system.
                            </div>
                        </div>

                        <button type="submit" class="btn-send" id="sendBtn">
                            <span class="btn-text">Send Reset Link</span>
                            <i class="bi bi-send"></i>
                            <div class="btn-glow"></div>
                            <span class="success-check">
                                <i class="bi bi-check-lg"></i>
                            </span>
                        </button>

                    </form>

                    <!-- Help Links -->
                    <div class="help-links">
                        <a href="{{ route('login') }}" class="help-link">
                            <i class="bi bi-arrow-left"></i>
                            Back to Login
                        </a>
                        <a href="{{ route('register') }}" class="help-link">
                            <i class="bi bi-person-plus"></i>
                            Create Account
                        </a>
                    </div>

                    <!-- Security Note -->
                    <div
                        style="margin-top: 2rem; padding: 1rem; background: #f8fafc; border-radius: 20px; text-align: center; border: 1px solid #e2e8f0;">
                        <div
                            style="display: flex; align-items: center; justify-content: center; gap: 8px; color: #64748b; font-size: 0.85rem;">
                            <i class="bi bi-shield-lock-fill" style="color: #f59e0b;"></i>
                            <span>We'll never ask for your password via email</span>
                        </div>
                    </div>

                </div>

                <!-- Footer Note -->
                <div style="text-align: center; margin-top: 2rem; color: rgba(255,255,255,0.6); font-size: 0.85rem;">
                    <i class="bi bi-envelope-check me-1"></i>
                    AntApple Jobs · Password Recovery
                </div>

            </div>

        </div>

    </div>

    <script>
        const sendBtn = document.getElementById('sendBtn');
        const forgotForm = document.getElementById('forgotForm');

        // Form submission animation
        forgotForm.addEventListener('submit', function(e) {
            e.preventDefault();

            sendBtn.classList.add('loading');

            // Simulate form submission (remove setTimeout in production)
            setTimeout(() => {
                sendBtn.classList.remove('loading');
                sendBtn.classList.add('success');

                setTimeout(() => {
                    sendBtn.classList.remove('success');
                    this.submit();
                }, 1000);
            }, 1500);
        });

        // Auto-focus email field
        window.addEventListener('load', function() {
            document.querySelector('input[name="email"]').focus();
        });
    </script>

</body>

</html>
