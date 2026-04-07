@extends('layouts.app')

@section('title', '403 - Access Forbidden')

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
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <div class="error-icon-glow"></div>
                    </div>

                    {{-- Error Code --}}
                    <div class="error-code">403</div>

                    {{-- Title --}}
                    <h1 class="error-title">Access Forbidden</h1>

                    {{-- Description --}}
                    <p class="error-description">
                        You don't have permission to access this page. This area is restricted to authorized personnel only.
                    </p>

                    {{-- Help Text --}}
                    <div class="help-text">
                        <i class="bi bi-info-circle"></i>
                        <span>If you believe this is a mistake, please contact your administrator.</span>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="error-actions">
                        <a href="{{ url()->previous() }}" class="btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Go Back
                        </a>
                        <a href="{{ url('dashboard') }}" class="btn-primary">
                            <i class="bi bi-house-door me-2"></i>
                            Dashboard
                            <div class="btn-glow"></div>
                        </a>
                    </div>

                    {{-- Security Note --}}
                    <div class="security-note">
                        <i class="bi bi-shield-check"></i>
                        <span>Your activity has been logged for security purposes</span>
                    </div>
                </div>

                {{-- Footer Note --}}
                <div class="error-footer">
                    <span>Need access? <a href="{{ route('contact') }}">Contact Support</a></span>
                    <span class="separator">•</span>
                    <span>Error Code: 403</span>
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
        border: 1px solid rgba(239, 68, 68, 0.1);
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
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ef4444' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
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
        background: #ef4444;
        top: -50px;
        right: -50px;
        animation-delay: 0s;
    }

    .shape-2 {
        width: 150px;
        height: 150px;
        background: #dc2626;
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
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
        box-shadow: 0 20px 40px rgba(239, 68, 68, 0.3);
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
        background: radial-gradient(circle, rgba(239, 68, 68, 0.4) 0%, transparent 70%);
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
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
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
        color: #ef4444;
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
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        color: white;
        border: none;
        border-radius: 60px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 15px 30px rgba(239, 68, 68, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(239, 68, 68, 0.4);
        color: white;
    }

    .btn-secondary {
        padding: 14px 32px;
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 60px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        border-color: #ef4444;
        color: #ef4444;
        transform: translateX(-5px);
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
        color: #ef4444;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .error-footer a:hover {
        color: #b91c1c;
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

        .btn-primary,
        .btn-secondary {
            justify-content: center;
        }
    }
</style>
