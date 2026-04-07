@extends('layouts.app')

@section('title', 'Contact Us – AntApple Jobs')
@section('description', 'Contact AntApple Jobs for support, partnerships, or inquiries.')

@section('content')
    <div class="container py-5">

        {{-- Premium Header --}}
        <div class="contact-header mb-5">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center">
                    <div class="d-flex flex-column align-items-center">
                        <div class="header-icon-wrapper mb-4">
                            <div class="header-icon">
                                <i class="bi bi-chat-dots"></i>
                            </div>
                            <div class="header-icon-glow"></div>
                            <div class="header-icon-ring"></div>
                        </div>
                        <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-3">
                            <i class="bi bi-headset me-2"></i>GET IN TOUCH
                        </span>
                        <h1 class="display-4 fw-bold mb-3" style="color: #1e2937;">We'd Love to Hear <span
                                class="text-success">From You</span></h1>
                        <p class="text-muted lead mx-auto" style="max-width: 600px;">
                            Have a question, feedback, or a report? Send us a message and we'll get back to you within 24
                            hours.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Premium Contact Cards --}}
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="contact-info-card">
                    <div class="card-icon email">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <h5>Email Us</h5>
                    <p class="text-muted">Our support team is here to help</p>
                    <a href="mailto:support@antapplejobs.com" class="contact-link">support@antapplejobs.com</a>
                    <div class="card-glow"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-info-card">
                    <div class="card-icon phone">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <h5>Call Us</h5>
                    <p class="text-muted">Mon-Fri, 9am - 6pm</p>
                    <a href="tel:+23470445574466" class="contact-link">+234 704 455 74466</a>
                    <div class="card-glow"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-info-card">
                    <div class="card-icon location">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <h5>Visit Us</h5>
                    <p class="text-muted">Our headquarters</p>
                    <span class="contact-link">Abuja, Nigeria</span>
                    <div class="card-glow"></div>
                </div>
            </div>
        </div>

        <div class="row g-5 align-items-stretch">
            {{-- LEFT: Premium Contact Info --}}
            <div class="col-lg-5">
                <div class="premium-contact-card h-100">
                    <div class="card-pattern"></div>

                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="section-icon">
                                <i class="bi bi-info-circle"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-1">Contact Information</h4>
                                <p class="text-muted mb-0">Reach out through any of these channels</p>
                            </div>
                        </div>

                        <div class="contact-details">
                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="bi bi-envelope-fill"></i>
                                </div>
                                <div class="detail-content">
                                    <span class="detail-label">Email Address</span>
                                    <span class="detail-value">support@antapplejobs.com</span>
                                    <span class="detail-note">We typically respond within 24 hours</span>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="bi bi-telephone-fill"></i>
                                </div>
                                <div class="detail-content">
                                    <span class="detail-label">Phone Number</span>
                                    <span class="detail-value">+234 704 455 74466</span>
                                    <span class="detail-note">Monday - Friday, 9am - 6pm (WAT)</span>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-icon">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <div class="detail-content">
                                    <span class="detail-label">Office Address</span>
                                    <span class="detail-value">Abuja, Nigeria</span>
                                    <span class="detail-note">Central Business District</span>
                                </div>
                            </div>
                        </div>

                        <div class="business-hours mt-4">
                            <h6 class="fw-bold mb-3"><i class="bi bi-clock me-2 text-success"></i>Business Hours</h6>
                            <div class="hours-grid">
                                <div class="hour-item">
                                    <span>Monday - Friday</span>
                                    <span class="text-success">9:00 AM - 6:00 PM</span>
                                </div>
                                <div class="hour-item">
                                    <span>Saturday</span>
                                    <span class="text-muted">Closed</span>
                                </div>
                                <div class="hour-item">
                                    <span>Sunday</span>
                                    <span class="text-muted">Closed</span>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Premium Social Icons --}}
                        <div>
                            <h6 class="fw-bold mb-3">Connect With Us</h6>
                            <div class="social-links">
                                <a href="#" class="social-link twitter" title="Twitter">
                                    <i class="bi bi-twitter-x"></i>
                                </a>
                                <a href="#" class="social-link linkedin" title="LinkedIn">
                                    <i class="bi bi-linkedin"></i>
                                </a>
                                <a href="#" class="social-link facebook" title="Facebook">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a href="#" class="social-link instagram" title="Instagram">
                                    <i class="bi bi-instagram"></i>
                                </a>
                                <a href="#" class="social-link whatsapp" title="WhatsApp">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            </div>
                        </div>

                        {{-- Live Chat CTA --}}
                        <div class="live-chat-cta mt-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="chat-icon">
                                    <i class="bi bi-chat"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Need instant help?</h6>
                                    <p class="text-muted small mb-0">Our live chat support is online</p>
                                </div>
                                <button class="btn-chat ms-auto" onclick="startLiveChat()">
                                    <i class="bi bi-send"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Premium Contact Form --}}
            <div class="col-lg-7">
                <div class="premium-form-card">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="header-icon">
                                <i class="bi bi-envelope-paper"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-1">Send Us a Message</h4>
                                <p class="header-subtitle">Fill out the form below and we'll get back to you shortly</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- Success message --}}
                        @if (session('success'))
                            <div class="alert-premium-success mb-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="alert-icon">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        {{ session('success') }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Error messages --}}
                        @if ($errors->any())
                            <div class="alert-premium-danger mb-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="alert-icon">
                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <strong class="d-block mb-2">Please fix the following errors:</strong>
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.submit') }}" id="contactForm">
                            @csrf

                            {{-- Honeypot --}}
                            <input type="text" name="website" style="display:none" tabindex="-1"
                                autocomplete="off">

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="premium-input">
                                        <label class="form-label">Your Name</label>
                                        <div class="input-wrapper">
                                            <i class="bi bi-person"></i>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ old('name') }}" required placeholder="John Doe">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="premium-input">
                                        <label class="form-label">Email Address</label>
                                        <div class="input-wrapper">
                                            <i class="bi bi-envelope"></i>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ old('email') }}" required placeholder="john@example.com">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="premium-input">
                                        <label class="form-label">Subject (Optional)</label>
                                        <div class="input-wrapper">
                                            <i class="bi bi-tag"></i>
                                            <input type="text" name="subject" class="form-control"
                                                value="{{ old('subject') }}" placeholder="What is this regarding?">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="premium-input">
                                        <label class="form-label">Message</label>
                                        <div class="input-wrapper">
                                            <i class="bi bi-chat-text" style="top: 20px;"></i>
                                            <textarea name="message" rows="6" class="form-control" placeholder="Please describe your inquiry in detail..."
                                                required>{{ old('message') }}</textarea>
                                        </div>
                                        <span class="character-count">{{ strlen(old('message') ?? '') }}/1000</span>
                                    </div>
                                </div>

                                {{-- Quick Message Templates --}}
                                <div class="col-12">
                                    <div class="quick-templates">
                                        <span class="templates-label">Quick templates:</span>
                                        <button type="button" class="template-btn"
                                            onclick="setTemplate('support')">Support Request</button>
                                        <button type="button" class="template-btn"
                                            onclick="setTemplate('partnership')">Partnership</button>
                                        <button type="button" class="template-btn"
                                            onclick="setTemplate('report')">Report Issue</button>
                                    </div>
                                </div>

                                {{-- reCAPTCHA --}}
                                <div class="col-12">
                                    <div class="recaptcha-wrapper">
                                        {!! NoCaptcha::display() !!}
                                    </div>
                                </div>

                                {{-- Submit Button --}}
                                <div class="col-12">
                                    <button type="submit" class="btn-submit" id="submitBtn">
                                        <span class="btn-text">Send Message</span>
                                        <i class="bi bi-send ms-2"></i>
                                        <div class="btn-glow"></div>
                                    </button>
                                </div>

                                {{-- Privacy Notice --}}
                                <div class="col-12">
                                    <p class="privacy-notice text-center">
                                        <i class="bi bi-shield-check text-success me-1"></i>
                                        Your information is secure and will not be shared with third parties.
                                        By submitting, you agree to our <a href="{{ route('privacy') }}">Privacy
                                            Policy</a>.
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Premium FAQ Section --}}
        <div class="faq-premium-section mt-5">
            <div class="text-center mb-4">
                <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-3">
                    <i class="bi bi-question-circle me-2"></i>FAQ
                </span>
                <h3 class="fw-bold">Frequently Asked Questions</h3>
                <p class="text-muted">Quick answers to common inquiries</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="faq-item">
                        <h6><i class="bi bi-clock-history text-success me-2"></i> How quickly do you respond?</h6>
                        <p class="text-muted">We typically respond to all inquiries within 24 hours during business days.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="faq-item">
                        <h6><i class="bi bi-briefcase text-success me-2"></i> Do you offer partnership opportunities?</h6>
                        <p class="text-muted">Yes! We're always open to partnerships. Please use the form above with
                            "Partnership" as subject.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="faq-item">
                        <h6><i class="bi bi-flag text-success me-2"></i> How do I report a job posting?</h6>
                        <p class="text-muted">Use the contact form with "Report Issue" template or flag the job directly on
                            its page.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="faq-item">
                        <h6><i class="bi bi-cash text-success me-2"></i> I have a billing question</h6>
                        <p class="text-muted">For billing inquiries, please include your transaction reference for faster
                            assistance.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Premium Map Section --}}
        <div class="map-premium-section mt-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h4 class="fw-bold mb-3">Visit Our Office</h4>
                    <p class="text-muted mb-4">We'd love to meet you in person. Our doors are open during business hours.
                    </p>
                    <div class="office-details">
                        <div class="detail">
                            <i class="bi bi-building"></i>
                            <span>AntApple Jobs Headquarters</span>
                        </div>
                        <div class="detail">
                            <i class="bi bi-pin-map"></i>
                            <span>Central Business District, Abuja, Nigeria</span>
                        </div>
                        <div class="detail">
                            <i class="bi bi-clock"></i>
                            <span>Monday - Friday, 9:00 AM - 6:00 PM</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="map-placeholder">
                        <i class="bi bi-geo-alt"></i>
                        <span>Interactive Map</span>
                        <small>Abuja, Nigeria</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! NoCaptcha::renderJs() !!}
@endsection

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* Premium Contact Page Styles */

    /* Header */
    .contact-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        border-radius: 48px;
        padding: 3rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .header-icon-wrapper {
        position: relative;
        width: fit-content;
    }

    .header-icon {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.8rem;
        color: white;
        position: relative;
        z-index: 2;
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3);
    }

    .header-icon-glow {
        position: absolute;
        top: -10px;
        left: -10px;
        right: -10px;
        bottom: -10px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.4) 0%, transparent 70%);
        filter: blur(20px);
        opacity: 0.5;
        animation: pulse 2s infinite;
        z-index: 1;
    }

    .header-icon-ring {
        position: absolute;
        top: -15px;
        left: -15px;
        right: -15px;
        bottom: -15px;
        border: 2px solid rgba(16, 185, 129, 0.2);
        border-radius: 40px;
        animation: ring 3s infinite;
        z-index: 1;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 0.5;
            transform: scale(1);
        }

        50% {
            opacity: 0.8;
            transform: scale(1.1);
        }
    }

    @keyframes ring {
        0% {
            transform: scale(1);
            opacity: 0.5;
        }

        50% {
            transform: scale(1.2);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 0.5;
        }
    }

    /* Contact Info Cards */
    .contact-info-card {
        background: white;
        border-radius: 28px;
        padding: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(16, 185, 129, 0.1);
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }

    .contact-info-card:hover {
        transform: translateY(-5px);
        border-color: #10b981;
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.1);
    }

    .card-icon {
        width: 70px;
        height: 70px;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        margin: 0 auto 1.5rem;
        position: relative;
        z-index: 2;
    }

    .card-icon.email {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }

    .card-icon.phone {
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
    }

    .card-icon.location {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .contact-info-card h5 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #1e2937;
    }

    .contact-link {
        color: #10b981;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.1rem;
        display: inline-block;
        margin-top: 0.5rem;
        transition: color 0.3s ease;
    }

    .contact-link:hover {
        color: #047857;
    }

    .card-glow {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.05) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .contact-info-card:hover .card-glow {
        opacity: 1;
    }

    /* Premium Contact Card */
    .premium-contact-card {
        background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
        border-radius: 32px;
        padding: 2rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .card-pattern {
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.05) 0%, transparent 70%);
        border-radius: 50%;
    }

    .section-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.4rem;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    .contact-details {
        margin: 2rem 0;
    }

    .detail-item {
        display: flex;
        gap: 1rem;
        padding: 1.2rem 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-icon {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .detail-content {
        flex: 1;
    }

    .detail-label {
        display: block;
        color: #64748b;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .detail-value {
        display: block;
        font-weight: 600;
        color: #1e2937;
        font-size: 1.1rem;
        margin-bottom: 2px;
    }

    .detail-note {
        display: block;
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .hours-grid {
        background: white;
        border-radius: 18px;
        padding: 1rem;
        border: 1px solid #e2e8f0;
    }

    .hour-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        color: #475569;
    }

    /* Social Links */
    .social-links {
        display: flex;
        gap: 0.8rem;
    }

    .social-link {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 1.2rem;
    }

    .social-link.twitter {
        background: #000000;
    }

    .social-link.linkedin {
        background: #0A66C2;
    }

    .social-link.facebook {
        background: #1877F2;
    }

    .social-link.instagram {
        background: linear-gradient(45deg, #f09433, #d62976, #962fbf, #4f5bd5);
    }

    .social-link.whatsapp {
        background: #25D366;
    }

    .social-link:hover {
        transform: translateY(-5px) scale(1.1);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    /* Live Chat CTA */
    .live-chat-cta {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        border-radius: 20px;
        padding: 1.2rem;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .chat-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.4rem;
    }

    .btn-chat {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        border: none;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-chat:hover {
        transform: scale(1.1);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
    }

    /* Premium Form Card */
    .premium-form-card {
        background: white;
        border-radius: 32px;
        border: 1px solid rgba(16, 185, 129, 0.1);
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .premium-form-card .card-header {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        padding: 2rem;
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
    }

    .header-subtitle {
        color: #64748b;
        margin-bottom: 0;
    }

    .premium-form-card .card-body {
        padding: 2rem;
    }

    /* Alerts */
    .alert-premium-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 20px;
        padding: 1.2rem;
        color: #047857;
    }

    .alert-premium-danger {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border: 1px solid rgba(239, 68, 68, 0.2);
        border-radius: 20px;
        padding: 1.2rem;
        color: #b91c1c;
    }

    .alert-icon {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .alert-premium-success .alert-icon {
        color: #10b981;
    }

    .alert-premium-danger .alert-icon {
        color: #ef4444;
    }

    /* Premium Inputs */
    .premium-input {
        margin-bottom: 0;
    }

    .premium-input .form-label {
        color: #475569;
        font-weight: 500;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        z-index: 2;
        transition: color 0.3s ease;
    }

    .premium-input:focus-within i {
        color: #10b981;
    }

    .premium-input .form-control {
        height: 54px;
        padding-left: 48px;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .premium-input textarea.form-control {
        height: auto;
        padding-top: 16px;
    }

    .premium-input .form-control:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        background: white;
    }

    .character-count {
        display: block;
        text-align: right;
        font-size: 0.8rem;
        color: #94a3b8;
        margin-top: 4px;
    }

    /* Quick Templates */
    .quick-templates {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        flex-wrap: wrap;
        background: #f8fafc;
        padding: 1rem;
        border-radius: 60px;
    }

    .templates-label {
        color: #64748b;
        font-size: 0.9rem;
        margin-right: 0.5rem;
    }

    .template-btn {
        padding: 6px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 40px;
        background: white;
        color: #475569;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .template-btn:hover {
        border-color: #10b981;
        color: #10b981;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(16, 185, 129, 0.1);
    }

    /* reCAPTCHA */
    .recaptcha-wrapper {
        display: flex;
        justify-content: center;
        padding: 0.5rem 0;
    }

    /* Submit Button */
    .btn-submit {
        width: 100%;
        padding: 18px;
        background: linear-gradient(135deg, #10b981 0%, #047857 100%);
        color: white;
        border: none;
        border-radius: 60px;
        font-weight: 600;
        font-size: 1.1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
        cursor: pointer;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(16, 185, 129, 0.4);
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

    .btn-submit:hover .btn-glow {
        opacity: 1;
    }

    /* Privacy Notice */
    .privacy-notice {
        font-size: 0.85rem;
        color: #64748b;
        margin-top: 1rem;
    }

    .privacy-notice a {
        color: #10b981;
        text-decoration: none;
    }

    .privacy-notice a:hover {
        text-decoration: underline;
    }

    /* FAQ Section */
    .faq-premium-section {
        background: white;
        border-radius: 32px;
        padding: 3rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
    }

    .faq-item {
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 20px;
        transition: all 0.3s ease;
        height: 100%;
    }

    .faq-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.1);
        background: white;
    }

    .faq-item h6 {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #1e2937;
    }

    /* Map Section */
    .map-premium-section {
        background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        border-radius: 32px;
        padding: 2.5rem;
        border: 1px solid rgba(16, 185, 129, 0.1);
    }

    .office-details {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .office-details .detail {
        display: flex;
        align-items: center;
        gap: 1rem;
        color: #475569;
    }

    .office-details .detail i {
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

    .map-placeholder {
        background: #f1f5f9;
        border-radius: 24px;
        padding: 3rem;
        text-align: center;
        border: 2px dashed #e2e8f0;
    }

    .map-placeholder i {
        font-size: 3rem;
        color: #10b981;
        margin-bottom: 1rem;
        display: block;
    }

    .map-placeholder span {
        display: block;
        font-weight: 600;
        color: #1e2937;
        margin-bottom: 0.5rem;
    }

    .map-placeholder small {
        color: #64748b;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .contact-header {
            padding: 2rem;
        }

        .quick-templates {
            flex-direction: column;
            align-items: flex-start;
        }

        .social-links {
            flex-wrap: wrap;
        }

        .faq-premium-section {
            padding: 2rem;
        }

        .map-placeholder {
            margin-top: 2rem;
        }
    }
</style>


<script>
    // Character counter
    const messageField = document.querySelector('textarea[name="message"]');
    if (messageField) {
        messageField.addEventListener('input', function() {
            const count = this.value.length;
            const counter = this.closest('.premium-input').querySelector('.character-count');
            if (counter) {
                counter.textContent = `${count}/1000`;
            }
        });
    }

    // Quick message templates
    function setTemplate(type) {
        const messageField = document.querySelector('textarea[name="message"]');
        const subjectField = document.querySelector('input[name="subject"]');

        if (type === 'support') {
            subjectField.value = 'Support Request';
            messageField.value = 'I need assistance with...\n\nPlease provide details about your issue here.';
        } else if (type === 'partnership') {
            subjectField.value = 'Partnership Opportunity';
            messageField.value =
                'I would like to discuss a potential partnership with AntApple Jobs.\n\nCompany: \nProposal: ';
        } else if (type === 'report') {
            subjectField.value = 'Report an Issue';
            messageField.value = 'I would like to report the following issue:\n\nJob ID/URL: \nIssue Details: ';
        }

        // Trigger input event to update character count
        const event = new Event('input', {
            bubbles: true
        });
        messageField.dispatchEvent(event);
    }

    // Live chat placeholder
    function startLiveChat() {
        alert('Live chat feature coming soon! For immediate assistance, please use the contact form.');
    }

    // Form submission animation
    document.getElementById('contactForm')?.addEventListener('submit', function(e) {
        const btn = document.getElementById('submitBtn');
        btn.classList.add('loading');
        btn.querySelector('.btn-text').textContent = 'Sending...';
    });
</script>
