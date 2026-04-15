@extends('layouts.app')

@section('title', 'Account Suspended - Sproutplex Jobs')
@section('description', 'Your account has been temporarily suspended. Contact support for assistance.')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">

                {{-- Premium Card --}}
                <div class="suspended-card animate__animated animate__fadeInUp">
                    {{-- Animated Background --}}
                    <div class="suspended-bg-pattern"></div>
                    <div class="floating-shape shape-1"></div>
                    <div class="floating-shape shape-2"></div>
                    <div class="floating-shape shape-3"></div>

                    {{-- Icon --}}
                    <div class="suspended-icon-wrapper">
                        <div class="suspended-icon">
                            <i class="bi bi-shield-slash"></i>
                        </div>
                        <div class="suspended-icon-glow"></div>
                        <div class="suspended-icon-pulse"></div>
                    </div>

                    {{-- Title --}}
                    <h1 class="suspended-title">Account Suspended</h1>

                    {{-- Description --}}
                    <p class="suspended-description">
                        Your account has been temporarily suspended due to a policy violation or pending review.
                        If you believe this is a mistake, please contact our support team for assistance.
                    </p>

                    {{-- Suspension Details --}}
                    <div class="suspension-details">
                        <div class="detail-item">
                            <i class="bi bi-clock-history"></i>
                            <span>Suspended on: <strong>{{ now()->format('F d, Y') }}</strong></span>
                        </div>
                        <div class="detail-item">
                            <i class="bi bi-file-text"></i>
                            <span>Reason: <strong>Policy violation / Under review</strong></span>
                        </div>
                        <div class="detail-item">
                            <i class="bi bi-envelope"></i>
                            <span>Support response time: <strong>24-48 hours</strong></span>
                        </div>
                    </div>

                    {{-- Contact Options --}}
                    <div class="contact-options">
                        <h6 class="contact-title">Get in touch with support</h6>
                        <div class="contact-grid">
                            <a href="mailto:support@sproutplex.com" class="contact-card email">
                                <i class="bi bi-envelope-fill"></i>
                                <span>Email Support</span>
                                <small>support@sproutplex.com</small>
                                <div class="card-glow"></div>
                            </a>
                            <a href="https://wa.me/234XXXXXXXXXX" target="_blank" class="contact-card whatsapp">
                                <i class="bi bi-whatsapp"></i>
                                <span>WhatsApp</span>
                                <small>Click to chat</small>
                                <div class="card-glow"></div>
                            </a>
                        </div>
                    </div>

                    {{-- Appeal Form --}}
                    <div class="appeal-section">
                        <button class="btn-appeal" onclick="toggleAppealForm()">
                            <i class="bi bi-pencil-square"></i>
                            Submit an Appeal
                        </button>

                        <div id="appealForm" class="appeal-form" style="display: none;">
                            <form method="POST" action="">
                                @csrf
                                <textarea name="appeal_message" class="appeal-textarea" rows="4"
                                    placeholder="Please explain why you believe this suspension was made in error..."></textarea>
                                <button type="submit" class="btn-submit-appeal">
                                    Send Appeal
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- FAQ Section --}}
                    <div class="faq-section">
                        <div class="faq-header" onclick="toggleFaq()">
                            <i class="bi bi-question-circle"></i>
                            <span>Frequently Asked Questions</span>
                            <i class="bi bi-chevron-down faq-icon"></i>
                        </div>
                        <div class="faq-content" id="faqContent" style="display: none;">
                            <div class="faq-item">
                                <div class="faq-question">How long does a suspension last?</div>
                                <div class="faq-answer">Suspensions typically last 30 days, after which your account may be
                                    automatically reinstated depending on the violation.</div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">Can I create a new account?</div>
                                <div class="faq-answer">Creating a new account while suspended violates our terms of service
                                    and may result in permanent ban.</div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">Will I lose my data?</div>
                                <div class="faq-answer">Your data is preserved during the suspension period. If the
                                    suspension becomes permanent, you'll have 30 days to export your data.</div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="suspended-actions">
                        <a href="{{ route('contact') }}" class="btn-support">
                            <i class="bi bi-headset"></i>
                            Support Center
                        </a>
                        <a href="/jobs" class="btn-home">
                            <i class="bi bi-house-door"></i>
                            Return Home
                        </a>
                    </div>

                    {{-- Footer Note --}}
                    <div class="suspended-footer">
                        <i class="bi bi-shield-check"></i>
                        <span>Sproutplex Jobs Trust & Safety Team</span>
                    </div>
                </div>

                {{-- Footer Note --}}
                <div class="error-footer">
                    <span>Need immediate assistance? <a href="tel:+234XXXXXXXXXX">Call Support</a></span>
                    <span class="separator">•</span>
                    <span>Case Reference: <strong>#SUS{{ rand(10000, 99999) }}</strong></span>
                </div>

            </div>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Suspended Account Styles */

    .suspended-card {
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

    .suspended-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 60px 120px rgba(0, 0, 0, 0.15);
    }

    /* Background Pattern */
    .suspended-bg-pattern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ef4444' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }

    /* Floating Shapes */
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

    .shape-3 {
        width: 100px;
        height: 100px;
        background: #b91c1c;
        top: 30%;
        right: 10%;
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
    .suspended-icon-wrapper {
        position: relative;
        width: fit-content;
        margin: 0 auto 2rem;
    }

    .suspended-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        border-radius: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
        box-shadow: 0 20px 40px rgba(239, 68, 68, 0.3);
    }

    .suspended-icon i {
        font-size: 4rem;
        color: white;
    }

    .suspended-icon-glow {
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

    .suspended-icon-pulse {
        position: absolute;
        top: -20px;
        left: -20px;
        right: -20px;
        bottom: -20px;
        border: 2px solid rgba(239, 68, 68, 0.3);
        border-radius: 45px;
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

    /* Title */
    .suspended-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1e2937;
        margin-bottom: 1rem;
    }

    /* Description */
    .suspended-description {
        color: #64748b;
        font-size: 1rem;
        line-height: 1.6;
        max-width: 400px;
        margin: 0 auto 1.5rem;
    }

    /* Suspension Details */
    .suspension-details {
        background: #f8fafc;
        border-radius: 20px;
        padding: 1rem;
        margin-bottom: 2rem;
        text-align: left;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-item i {
        width: 24px;
        color: #ef4444;
    }

    .detail-item span {
        color: #475569;
        font-size: 0.9rem;
    }

    .detail-item strong {
        color: #1e2937;
    }

    /* Contact Options */
    .contact-options {
        margin-bottom: 2rem;
    }

    .contact-title {
        font-weight: 600;
        margin-bottom: 1rem;
        color: #1e2937;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .contact-card {
        position: relative;
        padding: 1rem;
        border-radius: 20px;
        text-decoration: none;
        transition: all 0.3s ease;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
    }

    .contact-card.email {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .contact-card.whatsapp {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .contact-card i {
        font-size: 1.8rem;
        margin-bottom: 0.25rem;
    }

    .contact-card.email i {
        color: #2563eb;
    }

    .contact-card.whatsapp i {
        color: #059669;
    }

    .contact-card span {
        font-weight: 600;
        font-size: 0.9rem;
    }

    .contact-card.email span {
        color: #1e40af;
    }

    .contact-card.whatsapp span {
        color: #047857;
    }

    .contact-card small {
        font-size: 0.7rem;
    }

    .contact-card.email small {
        color: #3b82f6;
    }

    .contact-card.whatsapp small {
        color: #10b981;
    }

    .contact-card:hover {
        transform: translateY(-5px);
    }

    .card-glow {
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

    .contact-card:hover .card-glow {
        opacity: 1;
    }

    /* Appeal Section */
    .appeal-section {
        margin-bottom: 2rem;
    }

    .btn-appeal {
        width: 100%;
        padding: 1rem;
        background: white;
        color: #ef4444;
        border: 1px solid #fee2e2;
        border-radius: 60px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-appeal:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(239, 68, 68, 0.2);
    }

    .appeal-form {
        margin-top: 1rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 20px;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .appeal-textarea {
        width: 100%;
        padding: 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        resize: vertical;
        font-family: inherit;
        margin-bottom: 1rem;
    }

    .appeal-textarea:focus {
        outline: none;
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .btn-submit-appeal {
        width: 100%;
        padding: 0.75rem;
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        color: white;
        border: none;
        border-radius: 60px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-submit-appeal:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(239, 68, 68, 0.2);
    }

    /* FAQ Section */
    .faq-section {
        background: #f8fafc;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .faq-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .faq-header:hover {
        background: #f1f5f9;
    }

    .faq-header i:first-child {
        color: #ef4444;
    }

    .faq-header span {
        flex: 1;
        font-weight: 500;
        color: #1e2937;
    }

    .faq-icon {
        transition: transform 0.3s ease;
    }

    .faq-header.active .faq-icon {
        transform: rotate(180deg);
    }

    .faq-content {
        padding: 0 1rem 1rem 1rem;
        border-top: 1px solid #e2e8f0;
    }

    .faq-item {
        padding: 0.75rem 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .faq-item:last-child {
        border-bottom: none;
    }

    .faq-question {
        font-weight: 600;
        color: #1e2937;
        margin-bottom: 0.25rem;
    }

    .faq-answer {
        font-size: 0.85rem;
        color: #64748b;
        line-height: 1.5;
    }

    /* Action Buttons */
    .suspended-actions {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .btn-support {
        flex: 1;
        padding: 0.75rem;
        background: white;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-support:hover {
        border-color: #ef4444;
        color: #ef4444;
        transform: translateY(-2px);
    }

    .btn-home {
        flex: 1;
        padding: 0.75rem;
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        color: white;
        border: none;
        border-radius: 60px;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(239, 68, 68, 0.2);
    }

    .btn-home:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(239, 68, 68, 0.3);
        color: white;
    }

    /* Footer */
    .suspended-footer {
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .suspended-footer i {
        color: #10b981;
    }

    /* Error Footer */
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
        .suspended-card {
            padding: 2rem 1.5rem;
        }

        .suspended-title {
            font-size: 2rem;
        }

        .contact-grid {
            grid-template-columns: 1fr;
        }

        .suspended-actions {
            flex-direction: column;
        }

        .suspended-icon {
            width: 90px;
            height: 90px;
        }

        .suspended-icon i {
            font-size: 3rem;
        }
    }
</style>

<script>
    function toggleAppealForm() {
        const form = document.getElementById('appealForm');
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }

    function toggleFaq() {
        const content = document.getElementById('faqContent');
        const header = document.querySelector('.faq-header');

        if (content.style.display === 'none') {
            content.style.display = 'block';
            header.classList.add('active');
        } else {
            content.style.display = 'none';
            header.classList.remove('active');
        }
    }
</script>
