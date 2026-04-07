<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>404 - Page Not Found | AntApple Jobs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Oops! The page you're looking for doesn't exist. Let's get you back on track.">

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
            padding: 3.5rem 3rem;
            box-shadow: 0 50px 100px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.6s ease;
            position: relative;
            overflow: hidden;
            max-width: 600px;
            margin: 0 auto;
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

        /* 404 Number */
        .error-number {
            font-size: 12rem;
            font-weight: 800;
            line-height: 1;
            text-align: center;
            margin-bottom: 1rem;
            position: relative;
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .digit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: bounce 2s ease infinite;
            display: inline-block;
        }

        .digit-1 {
            animation-delay: 0s;
        }

        .digit-2 {
            animation-delay: 0.2s;
        }

        .digit-3 {
            animation-delay: 0.4s;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        /* Error Icon */
        .error-icon {
            text-align: center;
            margin-bottom: 1rem;
            position: relative;
        }

        .error-icon i {
            font-size: 5rem;
            color: rgba(102, 126, 234, 0.3);
            animation: rotate 10s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Title */
        .title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1e2937;
            margin-bottom: 1rem;
            text-align: center;
        }

        .subtitle {
            color: #64748b;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 1.1rem;
            line-height: 1.6;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Lost Illustration */
        .lost-illustration {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin: 2rem 0;
            position: relative;
        }

        .lost-item {
            text-align: center;
            position: relative;
        }

        .lost-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            border: 1px solid rgba(102, 126, 234, 0.2);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .lost-icon i {
            font-size: 2rem;
            color: #667eea;
        }

        .lost-label {
            font-weight: 600;
            color: #1e2937;
            font-size: 0.9rem;
        }

        .arrow {
            position: absolute;
            top: 50%;
            right: -30px;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.5rem;
        }

        /* Search Bar */
        .search-wrapper {
            max-width: 400px;
            margin: 2rem auto;
            position: relative;
        }

        .search-input {
            width: 100%;
            height: 60px;
            padding: 0 20px 0 50px;
            border: 2px solid #e2e8f0;
            border-radius: 60px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        /* Quick Links */
        .quick-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin: 2rem 0;
        }

        .quick-link {
            padding: 10px 20px;
            background: #f8fafc;
            border-radius: 40px;
            color: #475569;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .quick-link:hover {
            background: white;
            color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.1);
        }

        /* Buttons */
        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin: 2rem 0 1rem;
        }

        .btn-primary {
            padding: 16px 36px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 60px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px rgba(102, 126, 234, 0.4);
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

        .btn-primary:hover .btn-glow {
            opacity: 1;
        }

        .btn-outline {
            padding: 16px 36px;
            background: white;
            color: #667eea;
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 60px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            border-color: #667eea;
            background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
            transform: translateY(-2px);
        }

        /* Fun Fact */
        .fun-fact {
            background: #f8fafc;
            border-radius: 20px;
            padding: 1rem;
            margin-top: 2rem;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .fact-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .fact-text {
            color: #475569;
            font-size: 0.9rem;
        }

        .fact-text strong {
            color: #667eea;
        }

        /* Report Link */
        .report-link {
            text-align: center;
            margin-top: 1rem;
        }

        .report-link a {
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .report-link a:hover {
            color: #667eea;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .premium-card {
                padding: 2rem 1.5rem;
            }

            .error-number {
                font-size: 8rem;
            }

            .title {
                font-size: 2rem;
            }

            .lost-illustration {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }

            .arrow {
                display: none;
            }

            .button-group {
                flex-direction: column;
            }

            .btn-primary,
            .btn-outline {
                width: 100%;
                justify-content: center;
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

            <div class="col-md-8 col-lg-6">

                <div class="premium-card animate__animated animate__fadeIn">

                    <!-- 404 Number -->
                    <div class="error-number">
                        <span class="digit digit-1">4</span>
                        <span class="digit digit-2">0</span>
                        <span class="digit digit-3">4</span>
                    </div>

                    <!-- Error Icon -->
                    <div class="error-icon">
                        <i class="bi bi-compass"></i>
                    </div>

                    <!-- Title -->
                    <h1 class="title">Page Not Found</h1>
                    <p class="subtitle">
                        Oops! It seems you've wandered off the beaten path. The page you're looking for doesn't exist or
                        has been moved.
                    </p>

                    <!-- Lost Illustration -->
                    <div class="lost-illustration">
                        <div class="lost-item">
                            <div class="lost-icon">
                                <i class="bi bi-house-door"></i>
                            </div>
                            <span class="lost-label">Home</span>
                        </div>
                        <i class="bi bi-arrow-right arrow"></i>
                        <div class="lost-item">
                            <div class="lost-icon">
                                <i class="bi bi-question-circle"></i>
                            </div>
                            <span class="lost-label">Lost?</span>
                        </div>
                        <i class="bi bi-arrow-right arrow"></i>
                        <div class="lost-item">
                            <div class="lost-icon">
                                <i class="bi bi-emoji-frown"></i>
                            </div>
                            <span class="lost-label">404</span>
                        </div>
                    </div>

                    <!-- Search Bar -->
                    <div class="search-wrapper">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" class="search-input" id="searchInput" placeholder="Search for jobs...">
                    </div>

                    <!-- Quick Links -->
                    <div class="quick-links">
                        <a href="/jobs" class="quick-link">
                            <i class="bi bi-briefcase"></i>
                            Browse Jobs
                        </a>
                        <a href="/companies" class="quick-link">
                            <i class="bi bi-building"></i>
                            Companies
                        </a>
                        <a href="/contact" class="quick-link">
                            <i class="bi bi-envelope"></i>
                            Contact
                        </a>
                    </div>

                    <!-- Action Buttons -->
                    <div class="button-group">
                        <a href="/jobs" class="btn-primary">
                            <i class="bi bi-house-door"></i>
                            <span>Go Back Home</span>
                            <div class="btn-glow"></div>
                        </a>
                        <a href="javascript:history.back()" class="btn-outline">
                            <i class="bi bi-arrow-left"></i>
                            <span>Go Back</span>
                        </a>
                    </div>

                    <!-- Fun Fact -->
                    <div class="fun-fact">
                        <div class="fact-icon">
                            <i class="bi bi-lightbulb"></i>
                        </div>
                        <div class="fact-text">
                            <strong>Did you know?</strong> The HTTP 404 error was inspired by room 404 at CERN, where
                            the World Wide Web was born.
                        </div>
                    </div>

                    <!-- Report Link -->
                    <div class="report-link">
                        <a href="/contact?subject=Broken%20Link">
                            <i class="bi bi-flag me-1"></i>
                            Report this broken link
                        </a>
                    </div>

                </div>

                <!-- Footer Note -->
                <div style="text-align: center; margin-top: 2rem; color: rgba(255,255,255,0.6); font-size: 0.85rem;">
                    <i class="bi bi-compass me-1"></i>
                    AntApple Jobs · Let's get you back on track
                </div>

            </div>

        </div>

    </div>

    <script>
        // Search functionality
        const searchInput = document.getElementById('searchInput');

        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const query = this.value.trim();
                if (query) {
                    window.location.href = `/jobs?search=${encodeURIComponent(query)}`;
                }
            }
        });

        // Random fun facts (optional rotation)
        const facts = [
            "The HTTP 404 error was inspired by room 404 at CERN, where the World Wide Web was born.",
            "404 is the most famous HTTP error code on the internet.",
            "The first 404 error page was created in 1992 at CERN.",
            "Some websites create creative 404 pages to keep users engaged.",
            "You're not lost, you're just exploring uncharted territory!"
        ];

        const factElement = document.querySelector('.fact-text strong');
        if (factElement) {
            factElement.nextSibling.textContent = facts[Math.floor(Math.random() * facts.length)];
        }

        // Track 404 error (optional analytics)
        console.log('404 Error:', window.location.pathname);
    </script>

</body>

</html>
