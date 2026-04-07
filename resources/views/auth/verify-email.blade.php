<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Verify Your Email - AntApple Jobs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Verify your email address to activate your AntApple Jobs account.">

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
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
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
        .verification-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3);
            animation: pulse 2s infinite;
        }

        .verification-icon i {
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

        /* Email Illustration */
        .email-illustration {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }

        .envelope {
            position: relative;
            width: 60px;
            height: 60px;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: bounce 2s infinite;
        }

        .envelope:nth-child(2) {
            animation-delay: 0.2s;
        }

        .envelope:nth-child(3) {
            animation-delay: 0.4s;
        }

        .envelope i {
            font-size: 2rem;
            color: #10b981;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
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

        .email-highlight {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #047857;
            padding: 0.5rem 1rem;
            border-radius: 60px;
            display: inline-block;
            margin: 1rem auto;
            font-weight: 600;
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

        /* Steps */
        .steps {
            margin: 2rem 0;
        }

        .step-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 20px;
            margin-bottom: 1rem;
        }

        .step-number {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
        }

        .step-text {
            flex: 1;
            color: #1e2937;
            font-weight: 500;
        }

        .step-text small {
            display: block;
            color: #64748b;
            font-size: 0.85rem;
            margin-top: 4px;
        }

        /* Button */
        .btn-resend {
            width: 100%;
            height: 60px;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
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
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3);
            cursor: pointer;
            margin: 2rem 0 1rem;
        }

        .btn-resend:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px rgba(16, 185, 129, 0.4);
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

        .btn-resend:hover .btn-glow {
            opacity: 1;
        }

        /* Timer */
        .resend-timer {
            text-align: center;
            margin-top: 1rem;
        }

        .timer-text {
            color: #64748b;
            font-size: 0.9rem;
        }

        .timer-count {
            color: #10b981;
            font-weight: 700;
            font-size: 1.1rem;
            margin-left: 4px;
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
            color: #10b981;
            transform: translateY(-2px);
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        /* Loading State */
        .btn-resend.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-resend.loading .btn-text {
            opacity: 0;
        }

        .btn-resend.loading::after {
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

        .btn-resend.success .btn-text {
            opacity: 0;
        }

        .btn-resend.success .success-check {
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

            .verification-icon {
                width: 80px;
                height: 80px;
            }

            .verification-icon i {
                font-size: 2.5rem;
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

                    <!-- Animated Envelopes -->
                    <div class="email-illustration">
                        <div class="envelope">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="envelope">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <div class="envelope">
                            <i class="bi bi-envelope-paper"></i>
                        </div>
                    </div>

                    <!-- Icon -->
                    <div class="verification-icon">
                        <i class="bi bi-patch-check"></i>
                    </div>

                    <!-- Title -->
                    <h1 class="title">Verify Your Email</h1>
                    <p class="subtitle">
                        We've sent a verification link to your email address. Please check your inbox and click the link
                        to activate your account.
                    </p>

                    <!-- Email Highlight -->
                    <div class="text-center">
                        <span class="email-highlight">
                            <i class="bi bi-envelope-fill me-2"></i>
                            {{ request()->email ?? 'your@email.com' }}
                        </span>
                    </div>

                    <!-- Steps -->
                    <div class="steps">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <div class="step-text">
                                Check your inbox
                                <small>Look for an email from AntApple Jobs</small>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <div class="step-text">
                                Click the verification link
                                <small>This confirms your email address</small>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div class="step-text">
                                Start your journey
                                <small>Access all features after verification</small>
                            </div>
                        </div>
                    </div>

                    <!-- Success Alert -->
                    @if (session('message'))
                        <div class="alert-premium-success animate__animated animate__fadeIn">
                            <div class="alert-icon">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div class="flex-grow-1">
                                {{ session('message') }}
                            </div>
                        </div>
                    @endif

                    <!-- Resend Form -->
                    <form method="POST" action="{{ route('verification.send') }}" id="resendForm">
                        @csrf

                        <button type="submit" class="btn-resend" id="resendBtn">
                            <span class="btn-text">Resend Verification Email</span>
                            <i class="bi bi-send"></i>
                            <div class="btn-glow"></div>
                            <span class="success-check">
                                <i class="bi bi-check-lg"></i>
                            </span>
                        </button>

                    </form>

                    <!-- Timer (optional) -->
                    <div class="resend-timer" id="timer" style="display: none;">
                        <span class="timer-text">You can request another email in</span>
                        <span class="timer-count" id="countdown">60</span>
                        <span class="timer-text">seconds</span>
                    </div>

                    <!-- Help Links -->
                    <div class="help-links">
                        <a href="{{ route('login') }}" class="help-link">
                            <i class="bi bi-arrow-left"></i>
                            Back to Login
                        </a>
                        <a href="{{ route('contact') }}" class="help-link">
                            <i class="bi bi-question-circle"></i>
                            Need Help?
                        </a>
                    </div>

                    <!-- Security Note -->
                    <div
                        style="margin-top: 2rem; padding: 1rem; background: #f8fafc; border-radius: 20px; text-align: center; border: 1px solid #e2e8f0;">
                        <div
                            style="display: flex; align-items: center; justify-content: center; gap: 8px; color: #64748b; font-size: 0.85rem;">
                            <i class="bi bi-shield-lock-fill" style="color: #10b981;"></i>
                            <span>We'll never ask for your password via email</span>
                        </div>
                    </div>

                </div>

                <!-- Footer Note -->
                <div style="text-align: center; margin-top: 2rem; color: rgba(255,255,255,0.6); font-size: 0.85rem;">
                    <i class="bi bi-envelope-check me-1"></i>
                    AntApple Jobs · Email Verification
                </div>

            </div>

        </div>

    </div>

    <script>
        const resendBtn = document.getElementById('resendBtn');
        const resendForm = document.getElementById('resendForm');
        const timer = document.getElementById('timer');
        const countdown = document.getElementById('countdown');
        let timeLeft = 60;

        // Form submission animation
        resendForm.addEventListener('submit', function(e) {
            e.preventDefault();

            resendBtn.classList.add('loading');

            // Simulate form submission
            setTimeout(() => {
                resendBtn.classList.remove('loading');
                resendBtn.classList.add('success');

                // Start timer after successful resend
                startTimer();

                setTimeout(() => {
                    resendBtn.classList.remove('success');
                }, 2000);

                // Submit form after animation
                setTimeout(() => {
                    this.submit();
                }, 500);
            }, 1500);
        });

        function startTimer() {
            timer.style.display = 'block';
            resendBtn.disabled = true;
            resendBtn.style.opacity = '0.5';
            resendBtn.style.pointerEvents = 'none';

            const interval = setInterval(() => {
                timeLeft--;
                countdown.textContent = timeLeft;

                if (timeLeft <= 0) {
                    clearInterval(interval);
                    timer.style.display = 'none';
                    resendBtn.disabled = false;
                    resendBtn.style.opacity = '1';
                    resendBtn.style.pointerEvents = 'auto';
                    timeLeft = 60;
                }
            }, 1000);
        }

        // Auto-start timer if already sent
        @if (session('message'))
            startTimer();
        @endif
    </script>

</body>

</html>
