@extends('layouts.app')

@section('title', '500 - Server Error')

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
                    <div class="floating-shape shape-3"></div>

                    {{-- Icon --}}
                    <div class="error-icon-wrapper">
                        <div class="error-icon">
                            <i class="bi bi-tools"></i>
                        </div>
                        <div class="error-icon-glow"></div>
                        <div class="error-icon-pulse"></div>
                    </div>

                    {{-- Error Code --}}
                    <div class="error-code">500</div>

                    {{-- Title --}}
                    <h1 class="error-title">Server Error</h1>

                    {{-- Description --}}
                    <p class="error-description">
                        Something went wrong on our server. Our team has been notified and is working to fix the issue.
                    </p>

                    {{-- Help Text --}}
                    <div class="help-text">
                        <i class="bi bi-info-circle"></i>
                        <span>This error has been automatically reported to our engineering team.</span>
                    </div>

                    {{-- Status Dashboard --}}
                    <div class="status-dashboard">
                        <div class="status-item">
                            <span class="status-label">API Status:</span>
                            <span class="status-value status-degraded">Degraded</span>
                        </div>
                        <div class="status-item">
                            <span class="status-label">Database:</span>
                            <span class="status-value status-error">Connection Issue</span>
                        </div>
                        <div class="status-item">
                            <span class="status-label">Response Time:</span>
                            <span class="status-value status-slow">> 5s</span>
                        </div>
                    </div>

                    {{-- Estimated Fix Time --}}
                    <div class="estimate-card">
                        <i class="bi bi-clock-history"></i>
                        <div>
                            <span class="estimate-label">Estimated Fix Time</span>
                            <span class="estimate-value">~ 30 minutes</span>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="error-actions">
                        <a href="javascript:location.reload()" class="btn-secondary">
                            <i class="bi bi-arrow-repeat me-2"></i>
                            Try Again
                        </a>
                        <a href="{{ url('/jobs') }}" class="btn-primary">
                            <i class="bi bi-house-door me-2"></i>
                            Return Home
                            <div class="btn-glow"></div>
                        </a>
                    </div>

                    {{-- Support Options --}}
                    <div class="support-options">
                        <div class="support-item">
                            <i class="bi bi-envelope"></i>
                            <span>Email: <a href="mailto:support@Sproutplex.com">support@Sproutplex.com</a></span>
                        </div>
                        <div class="support-item">
                            <i class="bi bi-twitter-x"></i>
                            <span>X: <a href="#">@SproutplexJobs</a></span>
                        </div>
                        <div class="support-item">
                            <i class="bi bi-chat"></i>
                            <span>Live Chat: <a href="#">Available 24/7</a></span>
                        </div>
                    </div>

                    {{-- Incident ID --}}
                    <div class="incident-id">
                        <i class="bi bi-upc-scan"></i>
                        <span>Incident ID: <strong>#{{ strtoupper(substr(md5(uniqid()), 0, 8)) }}</strong></span>
                        <span class="copy-id" onclick="copyIncidentId()">Copy</span>
                    </div>

                    {{-- Security Note --}}
                    <div class="security-note">
                        <i class="bi bi-shield-check"></i>
                        <span>Our team is actively investigating this issue. No data has been lost.</span>
                    </div>
                </div>

                {{-- Footer Note --}}
                <div class="error-footer">
                    <span>Experiencing persistent issues? <a href="{{ route('contact') }}">Contact Support</a></span>
                    <span class="separator">•</span>
                    <span>Error Code: 500</span>
                    <span class="separator">•</span>
                    <span><a href="{{ route('status') }}">System Status</a></span>
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
        border: 1px solid rgba(220, 38, 38, 0.1);
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
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23dc2626' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
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
        background: #dc2626;
        top: -50px;
        right: -50px;
        animation-delay: 0s;
    }

    .shape-2 {
        width: 150px;
        height: 150px;
        background: #b91c1c;
        bottom: -30px;
        left: -30px;
        animation-delay: 2s;
    }

    .shape-3 {
        width: 100px;
        height: 100px;
        background: #ef4444;
        top: 30%;
        left: -30px;
        animation-delay: 4s;
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
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
        box-shadow: 0 20px 40px rgba(220, 38, 38, 0.3);
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
        background: radial-gradient(circle, rgba(220, 38, 38, 0.4) 0%, transparent 70%);
        filter: blur(15px);
        opacity: 0.6;
        animation: pulse 2s infinite;
        z-index: 1;
    }

    .error-icon-pulse {
        position: absolute;
        top: -20px;
        left: -20px;
        right: -20px;
        bottom: -20px;
        border: 2px solid rgba(220, 38, 38, 0.3);
        border-radius: 40px;
        animation: ring 2s infinite;
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

    @keyframes ring {
        0% {
            transform: scale(0.8);
            opacity: 1;
        }

        100% {
            transform: scale(1.5);
            opacity: 0;
        }
    }

    /* Error Code */
    .error-code {
        font-size: 8rem;
        font-weight: 800;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
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
        color: #dc2626;
        font-size: 1rem;
    }

    /* Status Dashboard */
    .status-dashboard {
        background: #f8fafc;
        border-radius: 20px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e2e8f0;
    }

    .status-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .status-item:last-child {
        border-bottom: none;
    }

    .status-label {
        font-weight: 500;
        color: #475569;
    }

    .status-value {
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 40px;
        font-size: 0.85rem;
    }

    .status-degraded {
        background: #fef3c7;
        color: #92400e;
    }

    .status-error {
        background: #fee2e2;
        color: #b91c1c;
    }

    .status-slow {
        background: #ffedd5;
        color: #b45309;
    }

    /* Estimate Card */
    .estimate-card {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 20px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        border: 1px solid #fde68a;
    }

    .estimate-card i {
        font-size: 2rem;
        color: #f59e0b;
    }

    .estimate-label {
        display: block;
        font-size: 0.75rem;
        color: #92400e;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .estimate-value {
        display: block;
        font-weight: 700;
        color: #b45309;
        font-size: 1.1rem;
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
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: white;
        border: none;
        border-radius: 60px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 15px 30px rgba(220, 38, 38, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(220, 38, 38, 0.4);
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
        border-color: #dc2626;
        color: #dc2626;
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

    /* Support Options */
    .support-options {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
        margin-bottom: 2rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 20px;
    }

    .support-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: #475569;
    }

    .support-item i {
        color: #10b981;
    }

    .support-item a {
        color: #dc2626;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .support-item a:hover {
        color: #b91c1c;
        text-decoration: underline;
    }

    /* Incident ID */
    .incident-id {
        background: #f1f5f9;
        padding: 0.75rem 1rem;
        border-radius: 60px;
        display: inline-flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        font-size: 0.85rem;
        color: #475569;
        font-family: monospace;
    }

    .incident-id i {
        color: #10b981;
    }

    .copy-id {
        background: white;
        padding: 0.25rem 0.75rem;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #10b981;
    }

    .copy-id:hover {
        background: #10b981;
        color: white;
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
        color: #dc2626;
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

        .support-options {
            flex-direction: column;
            align-items: flex-start;
        }

        .incident-id {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
</style>

<script>
    function copyIncidentId() {
        const incidentText = document.querySelector('.incident-id strong').innerText;
        navigator.clipboard.writeText(incidentText).then(() => {
            const copyBtn = document.querySelector('.copy-id');
            const originalText = copyBtn.innerText;
            copyBtn.innerText = 'Copied!';
            setTimeout(() => {
                copyBtn.innerText = originalText;
            }, 2000);
        });
    }
</script>
