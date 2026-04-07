<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password - AntApple Jobs</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

        /* Logo/Icon */
        .reset-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
            animation: pulse 2s infinite;
        }

        .reset-icon i {
            font-size: 2.5rem;
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
            margin-bottom: 0.5rem;
            text-align: center;
            letter-spacing: -0.5px;
        }

        .subtitle {
            color: #64748b;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Alert */
        .alert-premium {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 20px;
            padding: 1.2rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #b91c1c;
        }

        .alert-icon {
            width: 36px;
            height: 36px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ef4444;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        /* Form Labels */
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
            color: #667eea;
        }

        /* Input Groups */
        .input-group-premium {
            position: relative;
            margin-bottom: 1.5rem;
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
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-control:focus+.input-icon {
            color: #667eea;
        }

        /* Password Strength Indicator */
        .password-strength {
            margin-top: 0.5rem;
            display: flex;
            gap: 0.5rem;
        }

        .strength-bar {
            height: 4px;
            flex: 1;
            background: #e2e8f0;
            border-radius: 100px;
            transition: all 0.3s ease;
        }

        .strength-bar.active {
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .strength-text {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 0.25rem;
            display: block;
        }

        /* Password Requirements */
        .password-requirements {
            background: #f8fafc;
            border-radius: 20px;
            padding: 1rem;
            margin: 1.5rem 0;
            border: 1px solid #e2e8f0;
        }

        .requirements-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1e2937;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .requirements-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .requirements-list li {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 0;
            color: #64748b;
            font-size: 0.85rem;
        }

        .requirements-list li i {
            width: 18px;
        }

        .requirements-list li.valid i {
            color: #10b981;
        }

        .requirements-list li.invalid i {
            color: #94a3b8;
        }

        /* Button */
        .btn-reset {
            width: 100%;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
            cursor: pointer;
            margin-top: 1rem;
        }

        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px rgba(102, 126, 234, 0.4);
        }

        .btn-reset:active {
            transform: translateY(0);
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

        .btn-reset:hover .btn-glow {
            opacity: 1;
        }

        /* Back to Login Link */
        .back-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .back-link a {
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
            padding: 8px 16px;
            border-radius: 40px;
            background: #f8fafc;
        }

        .back-link a:hover {
            color: #667eea;
            transform: translateX(-5px);
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        /* Token Hidden Field */
        .token-field {
            display: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .premium-card {
                padding: 2rem 1.5rem;
            }

            .title {
                font-size: 1.8rem;
            }

            .form-control {
                height: 52px;
            }

            .btn-reset {
                height: 52px;
                font-size: 1rem;
            }
        }

        /* Loading State */
        .btn-reset.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-reset.loading .btn-text {
            opacity: 0;
        }

        .btn-reset.loading::after {
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

        .btn-reset.success .btn-text {
            opacity: 0;
        }

        .btn-reset.success .success-check {
            display: block;
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
                    <div class="reset-icon">
                        <i class="bi bi-key"></i>
                    </div>

                    <!-- Title -->
                    <h1 class="title">Reset Password</h1>
                    <p class="subtitle">
                        Enter your email and choose a strong new password to secure your account.
                    </p>

                    <!-- Error Alert -->
                    @if ($errors->any())
                        <div class="alert-premium animate__animated animate__shakeX">
                            <div class="alert-icon">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </div>
                            <div class="flex-grow-1">
                                {{ $errors->first() }}
                            </div>
                        </div>
                    @endif

                    <!-- Form -->
                    <form method="POST" action="{{ route('password.update') }}" id="resetForm">
                        @csrf

                        <!-- Token -->
                        <input type="hidden" name="token" value="{{ $token }}">

                        <!-- Email Field -->
                        <div class="input-group-premium">
                            <label class="form-label">
                                <i class="bi bi-envelope"></i>
                                Email Address
                            </label>
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="email" name="email" value="{{ request()->email }}" class="form-control"
                                placeholder="your@email.com" required autofocus>
                        </div>

                        <!-- New Password Field -->
                        <div class="input-group-premium">
                            <label class="form-label">
                                <i class="bi bi-lock"></i>
                                New Password
                            </label>
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="••••••••" required>

                            <!-- Password Strength Indicator -->
                            <div class="password-strength">
                                <div class="strength-bar" id="strength1"></div>
                                <div class="strength-bar" id="strength2"></div>
                                <div class="strength-bar" id="strength3"></div>
                                <div class="strength-bar" id="strength4"></div>
                            </div>
                            <span class="strength-text" id="strengthText">Enter a password</span>
                        </div>

                        <!-- Password Requirements -->
                        <div class="password-requirements">
                            <div class="requirements-title">
                                <i class="bi bi-shield-check"></i>
                                Password Requirements
                            </div>
                            <ul class="requirements-list" id="passwordRequirements">
                                <li id="reqLength" class="invalid">
                                    <i class="bi bi-circle"></i>
                                    At least 8 characters
                                </li>
                                <li id="reqUpper" class="invalid">
                                    <i class="bi bi-circle"></i>
                                    At least 1 uppercase letter
                                </li>
                                <li id="reqLower" class="invalid">
                                    <i class="bi bi-circle"></i>
                                    At least 1 lowercase letter
                                </li>
                                <li id="reqNumber" class="invalid">
                                    <i class="bi bi-circle"></i>
                                    At least 1 number
                                </li>
                                <li id="reqSpecial" class="invalid">
                                    <i class="bi bi-circle"></i>
                                    At least 1 special character
                                </li>
                            </ul>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="input-group-premium">
                            <label class="form-label">
                                <i class="bi bi-lock-fill"></i>
                                Confirm Password
                            </label>
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" name="password_confirmation" id="passwordConfirm"
                                class="form-control" placeholder="••••••••" required>
                        </div>

                        <!-- Password Match Indicator -->
                        <div id="passwordMatch"
                            style="display: none; margin-top: -1rem; margin-bottom: 1rem; padding: 0.5rem 1rem; background: #d1fae5; border-radius: 12px; color: #047857; font-size: 0.9rem; display: flex; align-items: center; gap: 8px;">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Passwords match</span>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-reset" id="submitBtn">
                            <span class="btn-text">Reset Password</span>
                            <i class="bi bi-arrow-right"></i>
                            <div class="btn-glow"></div>
                            <span class="success-check">
                                <i class="bi bi-check-lg"></i>
                            </span>
                        </button>

                    </form>

                    <!-- Back to Login Link -->
                    <div class="back-link">
                        <a href="{{ route('login') }}">
                            <i class="bi bi-arrow-left"></i>
                            Back to Login
                        </a>
                    </div>

                    <!-- Security Note -->
                    <div
                        style="margin-top: 2rem; padding: 1rem; background: #f8fafc; border-radius: 20px; text-align: center; border: 1px solid #e2e8f0;">
                        <div
                            style="display: flex; align-items: center; justify-content: center; gap: 8px; color: #64748b; font-size: 0.85rem;">
                            <i class="bi bi-shield-lock-fill" style="color: #667eea;"></i>
                            <span>Your information is encrypted and secure</span>
                        </div>
                    </div>

                </div>

                <!-- Footer Note -->
                <div style="text-align: center; margin-top: 2rem; color: rgba(255,255,255,0.6); font-size: 0.85rem;">
                    <i class="bi bi-key me-1"></i>
                    AntApple Jobs · Secure Password Reset
                </div>

            </div>

        </div>

    </div>

    <script>
        // Password strength checker
        const password = document.getElementById('password');
        const passwordConfirm = document.getElementById('passwordConfirm');
        const strength1 = document.getElementById('strength1');
        const strength2 = document.getElementById('strength2');
        const strength3 = document.getElementById('strength3');
        const strength4 = document.getElementById('strength4');
        const strengthText = document.getElementById('strengthText');
        const submitBtn = document.getElementById('submitBtn');
        const passwordMatch = document.getElementById('passwordMatch');

        // Password requirement elements
        const reqLength = document.getElementById('reqLength');
        const reqUpper = document.getElementById('reqUpper');
        const reqLower = document.getElementById('reqLower');
        const reqNumber = document.getElementById('reqNumber');
        const reqSpecial = document.getElementById('reqSpecial');

        // Password strength checker
        password.addEventListener('input', function() {
            const val = this.value;
            let strength = 0;

            // Check length
            if (val.length >= 8) {
                strength++;
                updateRequirement(reqLength, true);
            } else {
                updateRequirement(reqLength, false);
            }

            // Check uppercase
            if (/[A-Z]/.test(val)) {
                strength++;
                updateRequirement(reqUpper, true);
            } else {
                updateRequirement(reqUpper, false);
            }

            // Check lowercase
            if (/[a-z]/.test(val)) {
                strength++;
                updateRequirement(reqLower, true);
            } else {
                updateRequirement(reqLower, false);
            }

            // Check number
            if (/[0-9]/.test(val)) {
                strength++;
                updateRequirement(reqNumber, true);
            } else {
                updateRequirement(reqNumber, false);
            }

            // Check special character
            if (/[^A-Za-z0-9]/.test(val)) {
                strength++;
                updateRequirement(reqSpecial, true);
            } else {
                updateRequirement(reqSpecial, false);
            }

            // Update strength bars
            updateStrengthBars(strength);

            // Update strength text
            const strengthTexts = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
            strengthText.textContent = strengthTexts[strength];

            // Check password match
            checkPasswordMatch();
        });

        passwordConfirm.addEventListener('input', checkPasswordMatch);

        function updateRequirement(element, isValid) {
            if (isValid) {
                element.classList.remove('invalid');
                element.classList.add('valid');
                element.querySelector('i').className = 'bi bi-check-circle-fill';
            } else {
                element.classList.remove('valid');
                element.classList.add('invalid');
                element.querySelector('i').className = 'bi bi-circle';
            }
        }

        function updateStrengthBars(strength) {
            const bars = [strength1, strength2, strength3, strength4];
            const colors = ['#ef4444', '#f59e0b', '#fbbf24', '#10b981', '#10b981'];

            bars.forEach((bar, index) => {
                bar.style.background = index < strength ? colors[strength] : '#e2e8f0';
            });
        }

        function checkPasswordMatch() {
            if (password.value && passwordConfirm.value) {
                if (password.value === passwordConfirm.value) {
                    passwordMatch.style.display = 'flex';
                } else {
                    passwordMatch.style.display = 'none';
                }
            } else {
                passwordMatch.style.display = 'none';
            }
        }

        // Form submission animation
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            e.preventDefault();

            submitBtn.classList.add('loading');

            // Simulate form submission (remove this in production)
            setTimeout(() => {
                submitBtn.classList.remove('loading');
                submitBtn.classList.add('success');

                setTimeout(() => {
                    this.submit();
                }, 500);
            }, 1500);
        });

        // Auto-focus email field
        window.addEventListener('load', function() {
            document.querySelector('input[name="email"]').focus();
        });
    </script>

</body>

</html>
