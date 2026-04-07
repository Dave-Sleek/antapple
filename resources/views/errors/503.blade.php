@extends('layouts.app')

@section('title', '503 - Maintenance Mode')

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
                            <i class="bi bi-wrench-adjustable"></i>
                        </div>
                        <div class="error-icon-glow"></div>
                        <div class="error-icon-pulse"></div>
                    </div>

                    {{-- Error Code --}}
                    <div class="error-code">503</div>

                    {{-- Title --}}
                    <h1 class="error-title">Under Maintenance</h1>

                    {{-- Description --}}
                    <p class="error-description">
                        We're currently performing scheduled maintenance to improve your experience. We'll be back shortly.
                    </p>

                    {{-- Help Text --}}
                    <div class="help-text">
                        <i class="bi bi-info-circle"></i>
                        <span>We're making improvements to serve you better. Thank you for your patience.</span>
                    </div>

                    {{-- Maintenance Progress --}}
                    <div class="maintenance-progress">
                        <div class="progress-header">
                            <span class="progress-title">Maintenance Progress</span>
                            <span class="progress-percent" id="progressPercent">0%</span>
                        </div>
                        <div class="progress-bar-container">
                            <div class="progress-fill" id="progressFill" style="width: 0%;"></div>
                        </div>
                        <div class="progress-steps">
                            <span class="step completed">Planning</span>
                            <span class="step" id="step2">Updates</span>
                            <span class="step" id="step3">Testing</span>
                            <span class="step" id="step4">Complete</span>
                        </div>
                    </div>

                    {{-- Estimated Downtime --}}
                    <div class="estimate-card">
                        <i class="bi bi-clock-history"></i>
                        <div>
                            <span class="estimate-label">Estimated Downtime</span>
                            <span class="estimate-value">~ 2 hours</span>
                            <span class="estimate-note">Started: {{ now()->format('h:i A') }}</span>
                        </div>
                    </div>

                    {{-- What's Coming --}}
                    <div class="whats-coming">
                        <h6>✨ What's New in This Update</h6>
                        <div class="features-list">
                            <div class="feature-item">
                                <i class="bi bi-lightning-charge"></i>
                                <span>50% faster page loads</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-search-heart"></i>
                                <span>Improved job search algorithm</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-bell"></i>
                                <span>Real-time notifications</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-shield-check"></i>
                                <span>Enhanced security features</span>
                            </div>
                        </div>
                    </div>

                    {{-- Notification Form --}}
                    <div class="notification-form">
                        <p class="form-label">Get notified when we're back:</p>
                        <div class="form-group">
                            <input type="email" id="notifyEmail" placeholder="Enter your email">
                            <button class="btn-notify" onclick="notifyWhenLive()">
                                Notify Me
                                <i class="bi bi-bell"></i>
                            </button>
                        </div>
                        <div id="notifySuccess" class="notify-success" style="display: none;">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>We'll notify you when we're back!</span>
                        </div>
                    </div>

                    {{-- Social Updates --}}
                    <div class="social-updates">
                        <span>Follow for updates:</span>
                        <div class="social-links">
                            <a href="#" class="social-link twitter"><i class="bi bi-twitter-x"></i></a>
                            <a href="#" class="social-link linkedin"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="social-link github"><i class="bi bi-github"></i></a>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="error-actions">
                        <a href="javascript:location.reload()" class="btn-secondary">
                            <i class="bi bi-arrow-repeat me-2"></i>
                            Check Status
                        </a>
                        <a href="{{ route('status') }}" class="btn-primary">
                            <i class="bi bi-speedometer2 me-2"></i>
                            System Status
                            <div class="btn-glow"></div>
                        </a>
                    </div>

                    {{-- Security Note --}}
                    <div class="security-note">
                        <i class="bi bi-shield-check"></i>
                        <span>All data is safe and will be preserved during maintenance.</span>
                    </div>
                </div>

                {{-- Footer Note --}}
                <div class="error-footer">
                    <span>Questions about the maintenance? <a href="{{ route('contact') }}">Contact Support</a></span>
                    <span class="separator">•</span>
                    <span>Error Code: 503</span>
                    <span class="separator">•</span>
                    <span><a href="{{ route('status') }}">System Status Page</a></span>
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

    .shape-3 {
        width: 100px;
        height: 100px;
        background: #fbbf24;
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

    .error-icon-pulse {
        position: absolute;
        top: -20px;
        left: -20px;
        right: -20px;
        bottom: -20px;
        border: 2px solid rgba(245, 158, 11, 0.3);
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

    /* Maintenance Progress */
    .maintenance-progress {
        background: #f8fafc;
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
    }

    .progress-title {
        font-weight: 600;
        color: #1e2937;
    }

    .progress-percent {
        font-weight: 700;
        color: #f59e0b;
    }

    .progress-bar-container {
        height: 8px;
        background: #e2e8f0;
        border-radius: 100px;
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #f59e0b, #d97706);
        border-radius: 100px;
        transition: width 1s ease;
    }

    .progress-steps {
        display: flex;
        justify-content: space-between;
        margin-top: 1rem;
    }

    .step {
        font-size: 0.75rem;
        color: #94a3b8;
        position: relative;
    }

    .step.completed {
        color: #f59e0b;
    }

    .step.completed::before {
        content: '✓';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: -20px;
        width: 20px;
        height: 20px;
        background: #f59e0b;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
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

    .estimate-note {
        display: block;
        font-size: 0.7rem;
        color: #92400e;
        margin-top: 0.25rem;
    }

    /* What's Coming */
    .whats-coming {
        text-align: left;
        background: #f8fafc;
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .whats-coming h6 {
        font-weight: 700;
        margin-bottom: 1rem;
        color: #1e2937;
    }

    .features-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: #475569;
    }

    .feature-item i {
        color: #f59e0b;
        font-size: 1rem;
    }

    /* Notification Form */
    .notification-form {
        background: #f8fafc;
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        text-align: left;
    }

    .form-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #1e2937;
        margin-bottom: 0.75rem;
        display: block;
    }

    .form-group {
        display: flex;
        gap: 0.75rem;
    }

    .form-group input {
        flex: 1;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 60px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .form-group input:focus {
        outline: none;
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    .btn-notify {
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        border: none;
        border-radius: 60px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-notify:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
    }

    .notify-success {
        margin-top: 0.75rem;
        padding: 0.5rem;
        background: #d1fae5;
        border-radius: 12px;
        color: #047857;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Social Updates */
    .social-updates {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 2rem;
        font-size: 0.85rem;
        color: #475569;
    }

    .social-links {
        display: flex;
        gap: 0.5rem;
    }

    .social-link {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        background: #f59e0b;
        color: white;
        transform: translateY(-2px);
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
        border-color: #f59e0b;
        color: #f59e0b;
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

        .features-list {
            grid-template-columns: 1fr;
        }

        .form-group {
            flex-direction: column;
        }

        .progress-steps {
            font-size: 0.7rem;
        }

        .step.completed::before {
            display: none;
        }
    }
</style>

<script>
    // Simulated maintenance progress
    let progress = 0;
    const progressFill = document.getElementById('progressFill');
    const progressPercent = document.getElementById('progressPercent');
    const step2 = document.getElementById('step2');
    const step3 = document.getElementById('step3');
    const step4 = document.getElementById('step4');

    const interval = setInterval(() => {
        progress += Math.random() * 5;
        if (progress >= 100) {
            progress = 100;
            clearInterval(interval);

            // Mark all steps as completed
            step2.classList.add('completed');
            step3.classList.add('completed');
            step4.classList.add('completed');
        } else if (progress >= 75) {
            step4.classList.add('completed');
            step3.classList.add('completed');
            step2.classList.add('completed');
        } else if (progress >= 50) {
            step3.classList.add('completed');
            step2.classList.add('completed');
        } else if (progress >= 25) {
            step2.classList.add('completed');
        }

        progressFill.style.width = progress + '%';
        progressPercent.textContent = Math.floor(progress) + '%';
    }, 3000);

    function notifyWhenLive() {
        const email = document.getElementById('notifyEmail').value;
        if (!email) {
            alert('Please enter your email address');
            return;
        }

        const successMsg = document.getElementById('notifySuccess');
        successMsg.style.display = 'flex';

        // Here you would send the email to your backend
        console.log('Notify when live:', email);

        setTimeout(() => {
            successMsg.style.display = 'none';
            document.getElementById('notifyEmail').value = '';
        }, 3000);
    }
</script>
