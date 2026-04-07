<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $payment->id }}</title>
    <style>
        /* Premium Invoice Styles for DOMPDF */
        @page {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            margin: 0;
            padding: 30px;
            color: #1e2937;
            line-height: 1.5;
        }

        /* Premium Invoice Container */
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 32px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }

        /* Decorative Elements */
        .invoice-container::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.05) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }

        .invoice-container::after {
            content: '';
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.05) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }

        /* Premium Header */
        .invoice-header {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            padding: 40px 40px 30px;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .invoice-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .header-content {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .invoice-title {
            margin: 0;
        }

        .invoice-title h1 {
            font-size: 48px;
            font-weight: 800;
            color: white;
            margin: 0 0 10px 0;
            letter-spacing: -1px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .invoice-title .subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .invoice-title .subtitle i {
            font-size: 16px;
        }

        .invoice-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 8px 20px;
            border-radius: 60px;
            color: white;
            font-weight: 600;
            font-size: 14px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Company Info */
        .company-info {
            background: white;
            padding: 30px 40px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .company-logo h2 {
            font-size: 28px;
            font-weight: 800;
            margin: 0 0 5px 0;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .company-details {
            text-align: right;
            color: #64748b;
            font-size: 13px;
            line-height: 1.6;
        }

        .company-details p {
            margin: 2px 0;
        }

        /* Invoice Details Grid */
        .invoice-details {
            padding: 30px 40px;
            background: white;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-bottom: 30px;
            background: #f8fafc;
            padding: 25px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: 8px;
        }

        .detail-value {
            font-size: 16px;
            font-weight: 600;
            color: #1e2937;
        }

        .detail-value.large {
            font-size: 24px;
            color: #10b981;
        }

        .detail-value .reference {
            font-family: monospace;
            background: white;
            padding: 4px 8px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            display: inline-block;
        }

        /* Premium Separator */
        .premium-separator {
            margin: 30px 0;
            position: relative;
            text-align: center;
        }

        .premium-separator::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, #10b981, #047857, #10b981, transparent);
            z-index: 1;
        }

        .premium-separator span {
            background: white;
            padding: 0 20px;
            color: #10b981;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            z-index: 2;
        }

        /* Payment Summary */
        .payment-summary {
            background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
            border-radius: 20px;
            padding: 25px;
            border: 1px solid rgba(16, 185, 129, 0.2);
            margin: 20px 0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px dashed #e2e8f0;
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-label {
            color: #64748b;
            font-size: 14px;
        }

        .summary-value {
            font-weight: 600;
            color: #1e2937;
        }

        .summary-row.total {
            margin-top: 10px;
            padding-top: 15px;
            border-top: 2px solid #10b981;
        }

        .summary-row.total .summary-label {
            font-size: 16px;
            font-weight: 600;
            color: #1e2937;
        }

        .summary-row.total .summary-value {
            font-size: 24px;
            font-weight: 800;
            color: #10b981;
        }

        /* Status Badge */
        .status-paid {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #d1fae5;
            color: #047857;
            padding: 8px 20px;
            border-radius: 60px;
            font-weight: 600;
            font-size: 14px;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .status-paid::before {
            content: '';
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            display: inline-block;
            animation: blink 2s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.3;
            }
        }

        /* Premium Footer */
        .invoice-footer {
            background: #f8fafc;
            padding: 30px 40px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }

        .footer-content {
            max-width: 500px;
            margin: 0 auto;
        }

        .footer-content p {
            color: #64748b;
            font-size: 12px;
            margin: 5px 0;
        }

        .footer-content .thank-you {
            font-size: 18px;
            font-weight: 700;
            color: #10b981;
            margin-bottom: 15px;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px 0;
        }

        .footer-links span {
            color: #94a3b8;
            font-size: 11px;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            bottom: 100px;
            right: 50px;
            opacity: 0.03;
            font-size: 80px;
            font-weight: 800;
            color: #10b981;
            transform: rotate(-15deg);
            z-index: 0;
            pointer-events: none;
        }

        /* Responsive */
        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .invoice-header {
                padding: 30px 20px;
            }

            .company-info {
                padding: 20px;
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .company-details {
                text-align: center;
            }

            .invoice-details {
                padding: 20px;
            }

            .details-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">

        {{-- Watermark --}}
        <div class="watermark">PAID</div>

        {{-- Premium Header --}}
        <div class="invoice-header">
            <div class="header-content">
                <div class="invoice-title">
                    <h1>INVOICE</h1>
                    <div class="subtitle">
                        <i>📄</i> Official Payment Receipt
                    </div>
                </div>
                <div class="invoice-badge">
                    #{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}
                </div>
            </div>
        </div>

        {{-- Company Info --}}
        <div class="company-info">
            <div class="company-logo">
                <h2>AntApple Jobs</h2>
                <div style="color: #64748b; font-size: 12px;">Verified Job Platform</div>
            </div>
            <div class="company-details">
                <p>123 Business Avenue</p>
                <p>Abuja, Nigeria</p>
                <p>hello@antapple.com</p>
                <p>+234 704 455 74466</p>
            </div>
        </div>

        {{-- Invoice Details --}}
        <div class="invoice-details">

            {{-- Details Grid --}}
            <div class="details-grid">
                <div class="detail-item">
                    <span class="detail-label">Invoice Number</span>
                    <span class="detail-value">#{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Invoice Date</span>
                    <span
                        class="detail-value">{{ \Carbon\Carbon::parse($payment->paid_at ?? $payment->created_at)->format('F d, Y') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Payment Method</span>
                    <span class="detail-value">Paystack / Card Payment</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Transaction Reference</span>
                    <span class="detail-value">
                        <span class="reference">{{ $payment->reference ?? $payment->payment_reference }}</span>
                    </span>
                </div>
            </div>

            {{-- Premium Separator --}}
            <div class="premium-separator">
                <span>PAYMENT SUMMARY</span>
            </div>

            {{-- Payment Summary --}}
            <div class="payment-summary">

                {{-- Plan Details --}}
                @if ($payment->subscription && $payment->subscription->plan)
                    <div class="summary-row">
                        <span class="summary-label">Plan:</span>
                        <span class="summary-value">{{ $payment->subscription->plan->name }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Billing Cycle:</span>
                        <span class="summary-value">{{ ucfirst($payment->subscription->plan->billing_cycle) }}</span>
                    </div>
                @endif

                {{-- Customer Details --}}
                <div class="summary-row">
                    <span class="summary-label">Customer:</span>
                    <span class="summary-value">{{ $payment->user->name ?? 'N/A' }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Email:</span>
                    <span class="summary-value">{{ $payment->user->email ?? 'N/A' }}</span>
                </div>

                {{-- Payment Details --}}
                <div class="summary-row">
                    <span class="summary-label">Subtotal:</span>
                    <span class="summary-value">₦{{ number_format($payment->amount, 0) }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Tax (0%):</span>
                    <span class="summary-value">₦0</span>
                </div>

                {{-- Total --}}
                <div class="summary-row total">
                    <span class="summary-label">Total Amount:</span>
                    <span class="summary-value">₦{{ number_format($payment->amount, 0) }}</span>
                </div>

                {{-- Status --}}
                <div style="margin-top: 25px; text-align: center;">
                    <span class="status-paid">
                        Payment Completed Successfully
                    </span>
                </div>
            </div>

            {{-- Additional Info --}}
            <div
                style="margin-top: 20px; background: #f1f5f9; padding: 15px; border-radius: 12px; font-size: 12px; color: #64748b;">
                <p style="margin: 0; display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 16px;">ℹ️</span>
                    This invoice serves as an official receipt for your payment. For any inquiries, please contact our
                    support team.
                </p>
            </div>

        </div>

        {{-- Premium Footer --}}
        <div class="invoice-footer">
            <div class="footer-content">
                <div class="thank-you">Thank you for choosing AntApple Jobs!</div>
                <p>This invoice was generated automatically. No signature required.</p>

                <div class="footer-links">
                    <span>support@antapple.com</span>
                    <span>•</span>
                    <span>antapple.com/terms</span>
                    <span>•</span>
                    <span>+234 704 455 74466</span>
                </div>

                <p style="font-size: 10px; color: #94a3b8;">
                    AntApple Jobs Ltd. - Registered in Nigeria
                </p>
                <p style="font-size: 10px; color: #94a3b8; margin-top: 10px;">
                    Invoice #{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }} | Generated on
                    {{ now()->format('F d, Y \a\t h:i A') }}
                </p>
            </div>
        </div>
    </div>
</body>

</html>
