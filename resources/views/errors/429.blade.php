@extends('layouts.app')

@section('title', '429 - Too Many Requests')

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
                            <i class="bi bi-speedometer2"></i>
                        </div>
                        <div class="error-icon-glow"></div>
                    </div>

                    {{-- Error Code --}}
                    <div class="error-code">429</div>

                    {{-- Title --}}
                    <h1 class="error-title">Too Many Requests</h1>

                    {{-- Description --}}
                    <p class="error-description">
                        You've sent too many requests in a short period. Please wait a moment before trying again.
                    </p>

                    {{-- Help Text --}}
                    <div class="help-text">
                        <i class="bi bi-info-circle"></i>
                        <span>This is a security measure to prevent server overload and protect your account.</span>
                    </div>

                    {{-- Rate Limit Info --}}
                    <div class="rate-limit">
                        <div class="limit-icon">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div class="limit-content">
                            <span class="limit-label">Rate Limit:</span>
                            <span class="limit-value">60 requests per minute</span>
                        </div>
                    </div>

                    {{-- Cooldown Timer --}}
                    <div class="cooldown-timer">
                        <span class="timer-text">Try again in</span>
                        <span class="timer-count" id="cooldown">30</span>
                        <span class="timer-text">seconds</span>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="error-actions">
                        <a href="{{ url('/jobs') }}" class="btn-primary">
                            <i class="bi bi-house-door me-2"></i>
                            Return Home
                            <div class="btn-glow"></div>
                        </a>
                    </div>

                    {{-- Help Suggestion --}}
                    <div class="help-suggestion">
                        <i class="bi bi-lightbulb"></i>
                        <span>Need to make many requests? Consider our API plan for higher limits.</span>
                    </div>

                    {{-- Security Note --}}
                    <div class="security-note">
                        <i class="bi bi-shield-check"></i>
                        <span>Your IP has been logged. Excessive requests may result in temporary blocks.</span>
                    </div>
                </div>

                {{-- Footer Note --}}
                <div class="error-footer">
                    <span>This is a temporary restriction. <a href="{{ route('contact') }}">Contact Support</a></span>
                    <span class="separator">•</span>
                    <span>Error Code: 429</span>
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
        border: 1px solid rgba(16, 185, 129, 0.1);
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
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2310b981' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
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
        background: #10b981;
        top: -50px;
        right: -50px;
        animation-delay: 0s;
    }

    .shape-2 {
        width: 150px;
        height: 150px;
        background: #047857;
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
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3);
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
        background: radial-gradient(circle, rgba(16, 185, 129, 0.4) 0%, transparent 70%);
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
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
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
        color: #10b981;
        font-size: 1rem;
    }

    /* Rate Limit Info */
    .rate-limit {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 1rem;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 2rem;
        border: 1px solid #e2e8f0;
    }

    .limit-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .limit-content {
        text-align: left;
    }

    .limit-label {
        display: block;
        font-size: 0.75rem;
        color: #64748b;
        letter-spacing: 0.5px;
    }

    .limit-value {
        display: block;
        font-weight: 700;
        color: #1e2937;
        font-size: 1rem;
    }

    /* Cooldown Timer */
    .cooldown-timer {
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
        color: #10b981;
        background: white;
        padding: 0.2rem 0.5rem;
        border-radius: 8px;
        min-width: 35px;
        display: inline-block;
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
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        border: none;
        border-radius: 60px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.4);
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

    /* Help Suggestion */
    .help-suggestion {
        background: #fef3c7;
        padding: 1rem;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        margin-bottom: 2rem;
        font-size: 0.85rem;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .help-suggestion i {
        font-size: 1rem;
        color: #f59e0b;
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
        color: #10b981;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .error-footer a:hover {
        color: #047857;
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

        .rate-limit {
            flex-direction: column;
            text-align: center;
        }

        .limit-content {
            text-align: center;
        }
    }
</style>

<script>
    // Cooldown timer
    let cooldown = 30;
    const timerElement = document.getElementById('cooldown');

    if (timerElement) {
        const interval = setInterval(() => {
            cooldown--;
            timerElement.textContent = cooldown;

            if (cooldown <= 0) {
                clearInterval(interval);
                timerElement.parentElement.style.display = 'none';
            }
        }, 1000);
    }
</script>
