@extends('layouts.app')

@section('title', '419 - Session Expired')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">

                {{-- Premium Card --}}
                <div class="error-card animate__animated animate__fadeInUp">
                    {{-- Animated Background --}}
                    <div class="error-bg-pattern"></div>
                    <div class="floating-shape shape-1"></div>
                    <div class="floating-shape shape-2"></div>

                    {{-- Icon --}}
                    <div class="error-icon-wrapper">
                        <div class="error-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="error-icon-glow"></div>
                    </div>

                    {{-- Error Code --}}
                    <div class="error-code">419</div>

                    {{-- Title --}}
                    <h1 class="error-title">Session Expired</h1>

                    {{-- Description --}}
                    <p class="error-description">
                        Your session has expired due to inactivity. Please refresh the page to continue where you left off.
                    </p>

                    {{-- Help Text --}}
                    <div class="help-text">
                        <i class="bi bi-info-circle"></i>
                        <span>Don't worry, your data is safe. A simple refresh will restore your session.</span>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="error-actions">
                        <a href="{{ url()->current() }}" class="btn-primary">
                            <i class="bi bi-arrow-repeat me-2"></i>
                            Refresh Page
                            <div class="btn-glow"></div>
                        </a>
                    </div>

                    {{-- Auto-refresh Timer --}}
                    <div class="auto-refresh">
                        <span class="timer-text">Auto-refreshing in</span>
                        <span class="timer-count" id="countdown">10</span>
                        <span class="timer-text">seconds</span>
                    </div>

                    {{-- Security Note --}}
                    <div class="security-note">
                        <i class="bi bi-shield-check"></i>
                        <span>This is a security measure to protect your account</span>
                    </div>
                </div>

                {{-- Footer Note --}}
                <div class="error-footer">
                    <span>Having trouble? <a href="{{ route('contact') }}">Contact Support</a></span>
                    <span class="separator">•</span>
                    <span>Error Code: 419</span>
                </div>

            </div>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    /* Premium Error Page Styles */
    .error-card {
        background: white;
        border-radius: 48px;
        padding: 3rem 2.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 50px 100px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(245, 158, 11, 0.1);
        transition: all 0.3s ease;
    }

    .error-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 60px 120px rgba(0, 0, 0, 0.15);
    }

    .error-bg-pattern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23f59e0b' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }

    .floating-shape {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        opacity: 0.3;
        z-index: 0;
        animation: float 8s ease-in-out infinite;
    }

    .shape-1 {
        width: 200px;
        height: 200px;
        background: #f59e0b;
        top: -50px;
        right: -50px;
        animation-delay: 0s;
    }

    .shape-2 {
        width: 150px;
        height: 150px;
        background: #d97706;
        bottom: -30px;
        left: -30px;
        animation-delay: 2s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0) scale(1);
            opacity: 0.2;
        }

        50% {
            transform: translateY(-20px) scale(1.1);
            opacity: 0.3;
        }
    }

    /* Icon */
    .error-icon-wrapper {
        position: relative;
        width: fit-content;
        margin: 0 auto 2rem;
    }

    .error-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
        box-shadow: 0 20px 40px rgba(245, 158, 11, 0.3);
    }

    .error-icon i {
        font-size: 3rem;
        color: white;
    }

    .error-icon-glow {
        position: absolute;
        top: -10px;
        left: -10px;
        right: -10px;
        bottom: -10px;
        background: radial-gradient(circle, rgba(245, 158, 11, 0.4) 0%, transparent 70%);
        filter: blur(15px);
        opacity: 0.6;
        animation: pulse 2s infinite;
        z-index: 1;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 0.6;
            transform: scale(1);
        }

        50% {
            opacity: 1;
            transform: scale(1.1);
        }
    }

    /* Error Code */
    .error-code {
        font-size: 8rem;
        font-weight: 800;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
        margin-bottom: 0.5rem;
        letter-spacing: -2px;
    }

    /* Title */
    .error-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1e2937;
        margin-bottom: 1rem;
    }

    /* Description */
    .error-description {
        color: #64748b;
        font-size: 1rem;
        line-height: 1.6;
        max-width: 400px;
        margin: 0 auto 1.5rem;
    }

    /* Help Text */
    .help-text {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 2rem;
        font-size: 0.85rem;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .help-text i {
        color: #f59e0b;
        font-size: 1rem;
    }

    /* Action Buttons */
    .error-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-bottom: 2rem;
    }

    .btn-primary {
        position: relative;
        padding: 14px 32px;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        border: none;
        border-radius: 60px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 15px 30px rgba(245, 158, 11, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(245, 158, 11, 0.4);
        color: white;
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

    /* Auto-refresh Timer */
    .auto-refresh {
        background: #f8fafc;
        padding: 0.75rem 1.5rem;
        border-radius: 60px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 2rem;
        font-size: 0.9rem;
        color: #475569;
    }

    .timer-count {
        font-size: 1.2rem;
        font-weight: 700;
        color: #f59e0b;
        background: white;
        padding: 0.2rem 0.5rem;
        border-radius: 8px;
        min-width: 35px;
        display: inline-block;
    }

    /* Security Note */
    .security-note {
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .security-note i {
        color: #10b981;
    }

    /* Footer */
    .error-footer {
        text-align: center;
        margin-top: 2rem;
        font-size: 0.85rem;
        color: #94a3b8;
    }

    .error-footer a {
        color: #f59e0b;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .error-footer a:hover {
        color: #d97706;
        text-decoration: underline;
    }

    .separator {
        margin: 0 0.75rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .error-card {
            padding: 2rem 1.5rem;
        }

        .error-code {
            font-size: 6rem;
        }

        .error-title {
            font-size: 1.5rem;
        }

        .error-actions {
            flex-direction: column;
        }

        .auto-refresh {
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
        }
    }
</style>

<script>
    // Auto-refresh timer
    let countdown = 10;
    const timerElement = document.getElementById('countdown');

    if (timerElement) {
        const interval = setInterval(() => {
            countdown--;
            timerElement.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(interval);
                window.location.reload();
            }
        }, 1000);
    }
</script>
