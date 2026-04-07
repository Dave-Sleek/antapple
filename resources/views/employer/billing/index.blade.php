@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- Premium Header --}}
        <div class="billing-header mb-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-4">
                        <div class="header-icon-wrapper">
                            <div class="header-icon">
                                <i class="bi bi-credit-card"></i>
                            </div>
                            <div class="header-icon-glow"></div>
                        </div>
                        <div>
                            <span class="badge bg-success-subtle text-success px-4 py-2 rounded-pill mb-2">
                                <i class="bi bi-receipt me-2"></i>FINANCIAL OVERVIEW
                            </span>
                            <h1 class="display-5 fw-bold mb-1" style="color: #1e2937;">Billing & <span
                                    class="text-success">Subscription</span></h1>
                            <p class="text-muted lead mb-0">Manage your subscription and view billing history</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="header-stats">
                        @if ($subscription)
                            <div class="stat-badge">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>Active Subscription</span>
                            </div>
                        @endif
                        <div class="stat-badge">
                            <i class="bi bi-receipt"></i>
                            <span>{{ $payments->total() }} Transactions</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Active Subscription Card --}}
        @if ($subscription)
            <div class="subscription-active-card mb-5">
                <div class="subscription-glow"></div>
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-4">
                            <div class="subscription-icon">
                                <i class="bi bi-gem"></i>
                            </div>
                            <div class="subscription-info">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <h4 class="fw-bold mb-0">{{ $subscription->plan->name }}</h4>
                                    <span class="status-badge active">
                                        <span class="status-dot"></span>
                                        Active
                                    </span>
                                </div>
                                <div class="subscription-meta">
                                    <div class="meta-item">
                                        <i class="bi bi-calendar-check"></i>
                                        <span>Started:
                                            <strong>{{ \Carbon\Carbon::parse($subscription->starts_at ?? $subscription->created_at)->format('M d, Y') }}</strong></span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="bi bi-calendar-x"></i>
                                        <span>Expires:
                                            <strong>{{ \Carbon\Carbon::parse($subscription->ends_at)->format('M d, Y') }}</strong></span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="bi bi-currency-dollar"></i>
                                        <span>Amount:
                                            <strong>₦{{ number_format($subscription->plan->price, 0) }}/{{ $subscription->plan->billing_cycle }}</strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="subscription-actions">
                            <form method="POST" action="{{ route('subscription.cancel') }}" id="cancelSubscriptionForm">
                                @csrf
                                <button type="button" class="btn-cancel-subscription" onclick="confirmCancellation()">
                                    <i class="bi bi-x-circle me-2"></i>
                                    Cancel Subscription
                                </button>
                            </form>
                            <a href="{{ route('pricing') }}" class="btn-change-plan">
                                <i class="bi bi-arrow-repeat me-2"></i>
                                Change Plan
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Subscription Progress Bar --}}
                @php
                    $start = \Carbon\Carbon::parse($subscription->starts_at ?? $subscription->created_at);
                    $end = \Carbon\Carbon::parse($subscription->ends_at);
                    $now = now();
                    $totalDays = $start->diffInDays($end);
                    $daysLeft = $now->diffInDays($end);
                    $percentUsed = $totalDays > 0 ? (($totalDays - $daysLeft) / $totalDays) * 100 : 0;
                    $percentLeft = 100 - $percentUsed;
                @endphp
                <div class="subscription-progress mt-4">
                    <div class="progress-label">
                        <span><i class="bi bi-calendar-week"></i> Billing Cycle Progress</span>
                        <span class="days-left">{{ round($daysLeft) }} days remaining</span>
                    </div>
                    <div class="progress premium-progress">
                        <div class="progress-bar used" role="progressbar"
                            style="width: {{ $percentUsed }}%; background: linear-gradient(90deg, #10b981, #047857);"
                            aria-valuenow="{{ $percentUsed }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                        <div class="progress-bar left" role="progressbar"
                            style="width: {{ $percentLeft }}%; background: #e2e8f0;" aria-valuenow="{{ $percentLeft }}"
                            aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <div class="progress-markers">
                        <span class="marker start">{{ $start->format('M d') }}</span>
                        <span class="marker today">Today</span>
                        <span class="marker end">{{ $end->format('M d') }}</span>
                    </div>
                </div>
            </div>
        @else
            {{-- No Subscription Card --}}
            <div class="no-subscription-card mb-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-4">
                            <div class="no-sub-icon">
                                <i class="bi bi-exclamation-circle"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-2">No Active Subscription</h4>
                                <p class="text-muted mb-0">You don't have an active subscription. Choose a plan to start
                                    posting jobs.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ route('pricing') }}" class="btn-choose-plan">
                            <i class="bi bi-rocket me-2"></i>
                            Choose a Plan
                            <div class="btn-glow"></div>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- Billing History Card --}}
        <div class="billing-history-card">
            <div class="card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Billing History</h5>
                        <p class="header-subtitle">Complete record of your payment transactions</p>
                    </div>
                </div>
                <div class="header-actions">
                    <div class="payment-summary">
                        <span class="summary-label">Total Spent</span>
                        <span class="summary-value">₦{{ number_format($payments->sum('amount'), 0) }}</span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @if ($payments->count() > 0)
                    <div class="table-premium-wrapper">
                        <table class="table-premium">
                            <thead>
                                <tr>
                                    <th>Date & Time</th>
                                    <th>Reference</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th class="text-end">Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr class="payment-row">
                                        <td>
                                            <div class="payment-date">
                                                <span
                                                    class="date">{{ \Carbon\Carbon::parse($payment->paid_at ?? $payment->created_at)->format('M d, Y') }}</span>
                                                <span
                                                    class="time">{{ \Carbon\Carbon::parse($payment->paid_at ?? $payment->created_at)->format('h:i A') }}</span>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="reference-wrapper">
                                                <span
                                                    class="reference">{{ $payment->reference ?? $payment->reference }}</span>
                                                <button class="copy-ref"
                                                    onclick="copyReference('{{ $payment->reference ?? $payment->reference }}')"
                                                    title="Copy reference">
                                                    <i class="bi bi-files"></i>
                                                </button>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="payment-description">
                                                @if ($payment->subscription && $payment->subscription->plan)
                                                    <span
                                                        class="plan-name">{{ $payment->subscription->plan->name }}</span>
                                                    <span
                                                        class="billing-cycle">{{ $payment->subscription->plan->billing_cycle }}
                                                        subscription</span>
                                                @else
                                                    <span class="plan-name">Payment</span>
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            <span class="payment-amount">₦{{ number_format($payment->amount, 0) }}</span>
                                        </td>

                                        <td>
                                            <span class="status-badge paid">
                                                <span class="status-dot"></span>
                                                Paid
                                            </span>
                                        </td>

                                        <td class="text-end">
                                            <a href="{{ route('invoice.download', $payment) }}"
                                                class="btn-download-invoice">
                                                <i class="bi bi-download me-2"></i>
                                                Invoice
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Premium Pagination --}}
                    @if ($payments->hasPages())
                        <div class="pagination-premium mt-4">
                            {{ $payments->withQueryString()->links() }}
                        </div>
                    @endif
                @else
                    {{-- Empty State --}}
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <h5 class="fw-bold mb-2">No Payment History</h5>
                        <p class="text-muted mb-0">Your billing history will appear here once you make your first payment.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Payment Methods Card (Optional) --}}
        <div class="payment-methods-card mt-5">
            <div class="card-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon">
                        <i class="bi bi-credit-card-2-front"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Payment Methods</h5>
                        <p class="header-subtitle">Manage your saved payment methods</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-4">

                    <div class="row g-4">
                        @if ($methods->count())
                            @foreach ($methods as $method)
                                <div class="col-md-6">
                                    <div class="payment-method-card">

                                        <div class="method-icon">
                                            <i class="bi bi-credit-card"></i>
                                        </div>

                                        <div class="method-details">
                                            <span class="method-type">
                                                {{ strtoupper($method->card_type ?? 'Card') }}
                                            </span>

                                            <span class="method-info">
                                                •••• •••• •••• {{ $method->last4 }}
                                            </span>

                                            <span class="method-expiry">
                                                Expires {{ $method->exp_month }}/{{ $method->exp_year }}
                                            </span>
                                        </div>

                                        <div class="method-actions">

                                            @if ($method->is_default)
                                                <span class="default-badge">Default</span>
                                            @else
                                                <form method="POST"
                                                    action="{{ route('payment.methods.default', $method) }}">
                                                    @csrf
                                                    <button class="btn btn-sm btn-light">Make Default</button>
                                                </form>
                                            @endif

                                            <form method="POST" action="{{ route('payment.methods.delete', $method) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm text-danger">Remove</button>
                                            </form>

                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No saved payment methods. Add a payment method to make payments faster.
                            </p>
                        @endif
                        <div class="col-md-6">
                            <div class="add-payment-method" id="addPaymentMethodBtn">
                                <i class="bi bi-plus-circle"></i>
                                <span>Add Payment Method</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Need Help Section --}}
            <div class="help-card mt-5">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center gap-4">
                            <div class="help-icon">
                                <i class="bi bi-headset"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Need Help with Billing?</h5>
                                <p class="text-muted mb-0">Our support team is available 24/7 to assist with any billing
                                    questions</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('contact') }}" class="btn-contact-support">
                            <i class="bi bi-envelope me-2"></i>
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://js.paystack.co/v1/inline.js"></script>
        <script>
            document.getElementById('addPaymentMethodBtn')
                .addEventListener('click', function() {

                    let handler = PaystackPop.setup({
                        key: "{{ config('services.paystack.public_key') }}",
                        email: "{{ auth()->user()->email }}",
                        amount: 5000, // 50 NGN in kobo (small authorization charge)
                        currency: "NGN",

                        callback: function(response) {

                            fetch("{{ route('payment.save') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                    },
                                    body: JSON.stringify({
                                        reference: response.reference
                                    })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    location.reload();
                                });
                        },

                        onClose: function() {
                            console.log("Payment window closed");
                        }
                    });

                    handler.openIframe();
                });
        </script>


        <script>
            // Copy reference function
            function copyReference(ref) {
                navigator.clipboard.writeText(ref).then(() => {
                    // Show temporary tooltip or notification
                    alert('Reference copied to clipboard!');
                });
            }

            // Cancel subscription confirmation
            function confirmCancellation() {
                if (confirm(
                        'Are you sure you want to cancel your subscription? You will lose access to premium features at the end of your billing period.'
                    )) {
                    document.getElementById('cancelSubscriptionForm').submit();
                }
            }

            // Add payment method placeholder
            document.querySelector('.add-payment-method')?.addEventListener('click', function() {
                alert('Add payment method feature coming soon!');
            });
        </script>

    @endsection

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Premium Billing & Subscription Styles */

        /* Header */
        .billing-header {
            background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
            border-radius: 32px;
            padding: 2rem;
            border: 1px solid rgba(16, 185, 129, 0.1);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
        }

        .header-icon-wrapper {
            position: relative;
        }

        .header-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            color: white;
            position: relative;
            z-index: 2;
            box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
        }

        .header-icon-glow {
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.4) 0%, transparent 70%);
            filter: blur(15px);
            opacity: 0.5;
            animation: pulse 2s infinite;
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

        .header-stats {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .stat-badge {
            background: white;
            padding: 10px 20px;
            border-radius: 60px;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            font-weight: 500;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
        }

        .stat-badge i {
            color: #10b981;
        }

        /* Active Subscription Card */
        .subscription-active-card {
            background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
            border-radius: 32px;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(16, 185, 129, 0.2);
            box-shadow: 0 25px 50px rgba(16, 185, 129, 0.1);
        }

        .subscription-glow {
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.05) 0%, transparent 70%);
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

        .subscription-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
            position: relative;
            z-index: 2;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 16px;
            border-radius: 60px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-badge.active {
            background: #d1fae5;
            color: #047857;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
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

        .subscription-meta {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #475569;
        }

        .meta-item i {
            color: #10b981;
        }

        .subscription-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        .btn-cancel-subscription {
            padding: 14px 28px;
            background: white;
            color: #ef4444;
            border: 1px solid #fee2e2;
            border-radius: 60px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            position: relative;
            z-index: 999;
            cursor: pointer;
        }

        .btn-cancel-subscription:hover {
            background: #ef4444;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.2);
        }

        .btn-change-plan {
            padding: 14px 28px;
            background: white;
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 60px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-change-plan:hover {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
        }

        /* Subscription Progress */
        .subscription-progress {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            margin-top: 2rem !important;
            border: 1px solid rgba(16, 185, 129, 0.1);
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            color: #475569;
        }

        .progress-label i {
            color: #10b981;
            margin-right: 4px;
        }

        .days-left {
            font-weight: 600;
            color: #10b981;
        }

        .premium-progress {
            height: 10px;
            border-radius: 100px;
            background: #e2e8f0;
            overflow: hidden;
            display: flex;
        }

        .premium-progress .progress-bar.used {
            border-radius: 100px 0 0 100px;
        }

        .premium-progress .progress-bar.left {
            border-radius: 0 100px 100px 0;
        }

        .progress-markers {
            display: flex;
            justify-content: space-between;
            margin-top: 8px;
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .marker.today {
            color: #10b981;
            font-weight: 600;
        }

        /* No Subscription Card */
        .no-subscription-card {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 28px;
            padding: 2rem;
            border: 1px solid rgba(245, 158, 11, 0.2);
            position: relative;
            overflow: hidden;
        }

        .no-sub-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
        }

        .btn-choose-plan {
            position: relative;
            padding: 14px 32px;
            background: white;
            color: #f59e0b;
            border-radius: 60px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .btn-choose-plan:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(245, 158, 11, 0.2);
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

        .btn-choose-plan:hover .btn-glow {
            opacity: 1;
        }

        /* Billing History Card */
        .billing-history-card {
            background: white;
            border-radius: 32px;
            border: 1px solid rgba(16, 185, 129, 0.1);
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.02);
        }

        .billing-history-card .card-header {
            background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
            padding: 1.8rem;
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header-icon {
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

        .header-subtitle {
            color: #64748b;
            margin-bottom: 0;
            font-size: 0.95rem;
        }

        .payment-summary {
            text-align: right;
        }

        .summary-label {
            display: block;
            color: #64748b;
            font-size: 0.85rem;
            margin-bottom: 4px;
        }

        .summary-value {
            display: block;
            font-size: 1.8rem;
            font-weight: 700;
            color: #10b981;
            line-height: 1.2;
        }

        /* Premium Table */
        .table-premium-wrapper {
            overflow-x: auto;
        }

        .table-premium {
            width: 100%;
            border-collapse: collapse;
        }

        .table-premium th {
            text-align: left;
            padding: 1.2rem 1rem;
            color: #64748b;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .table-premium td {
            padding: 1.2rem 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .payment-row {
            transition: all 0.3s ease;
        }

        .payment-row:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        }

        /* Payment Date */
        .payment-date {
            text-align: center;
        }

        .payment-date .date {
            display: block;
            font-weight: 500;
            color: #1e2937;
            margin-bottom: 2px;
        }

        .payment-date .time {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        /* Reference */
        .reference-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .reference {
            font-family: monospace;
            font-size: 0.85rem;
            color: #475569;
            background: #f8fafc;
            padding: 4px 8px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .copy-ref {
            width: 30px;
            height: 30px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .copy-ref:hover {
            border-color: #10b981;
            color: #10b981;
        }

        /* Payment Description */
        .payment-description {
            display: flex;
            flex-direction: column;
        }

        .plan-name {
            font-weight: 600;
            color: #1e2937;
            margin-bottom: 2px;
        }

        .billing-cycle {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        /* Payment Amount */
        .payment-amount {
            font-weight: 700;
            color: #1e2937;
            font-size: 1.1rem;
        }

        /* Status Badge */
        .status-badge.paid {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 16px;
            background: #d1fae5;
            color: #047857;
            border-radius: 60px;
            font-size: 0.85rem;
            font-weight: 500;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .status-badge.paid .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #10b981;
        }

        /* Download Button */
        .btn-download-invoice {
            padding: 8px 16px;
            background: white;
            color: #475569;
            border: 1px solid #e2e8f0;
            border-radius: 40px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .btn-download-invoice:hover {
            border-color: #10b981;
            color: #10b981;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(16, 185, 129, 0.1);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            background: #f8fafc;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #94a3b8;
            margin: 0 auto 1.5rem;
            border: 1px solid #e2e8f0;
        }

        /* Pagination */
        .pagination-premium {
            display: flex;
            justify-content: center;
        }

        .pagination-premium .pagination {
            gap: 0.5rem;
        }

        .pagination-premium .page-link {
            border: 1px solid #e2e8f0;
            border-radius: 12px !important;
            color: #475569;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .pagination-premium .page-link:hover {
            border-color: #10b981;
            color: #10b981;
        }

        .pagination-premium .page-item.active .page-link {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            border-color: transparent;
            color: white;
            box-shadow: 0 5px 10px rgba(16, 185, 129, 0.3);
        }

        /* Payment Methods Card */
        .payment-methods-card {
            background: white;
            border-radius: 32px;
            border: 1px solid rgba(16, 185, 129, 0.1);
            overflow: hidden;
        }

        .payment-methods-card .card-header {
            background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
            padding: 1.5rem;
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
        }

        .payment-methods-card .card-body {
            padding: 1.5rem;
        }

        .payment-method-card {
            background: #f8fafc;
            border-radius: 20px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            position: relative;
        }

        .payment-method-card:hover {
            border-color: #10b981;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.1);
        }

        .method-icon {
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

        .method-details {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .method-type {
            font-weight: 600;
            color: #1e2937;
            margin-bottom: 2px;
        }

        .method-info {
            color: #475569;
            font-size: 0.9rem;
            margin-bottom: 2px;
        }

        .method-expiry {
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .method-default {
            position: absolute;
            top: 1rem;
            right: 1rem;
        }

        .default-badge {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .add-payment-method {
            background: white;
            border: 2px dashed #e2e8f0;
            border-radius: 20px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            color: #94a3b8;
            transition: all 0.3s ease;
            cursor: pointer;
            height: 100%;
            justify-content: center;
        }

        .add-payment-method:hover {
            border-color: #10b981;
            color: #10b981;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.02) 0%, rgba(4, 120, 87, 0.02) 100%);
        }

        .add-payment-method i {
            font-size: 2rem;
        }

        /* Help Card */
        .help-card {
            background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
            border-radius: 28px;
            padding: 2rem;
            border: 1px solid rgba(16, 185, 129, 0.1);
        }

        .help-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8rem;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
        }

        .btn-contact-support {
            padding: 12px 28px;
            background: white;
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 60px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .btn-contact-support:hover {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-stats {
                justify-content: flex-start;
                margin-top: 1rem;
            }

            .subscription-actions {
                justify-content: flex-start;
                margin-top: 1.5rem;
            }

            .subscription-meta {
                flex-direction: column;
                gap: 0.5rem;
            }

            .billing-history-card .card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .payment-summary {
                text-align: left;
                width: 100%;
            }

            .payment-method-card {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
    <script>
        // Copy reference function
        function copyReference(ref) {
            navigator.clipboard.writeText(ref).then(() => {
                // Show temporary tooltip or notification
                alert('Reference copied to clipboard!');
            });
        }

        // Cancel subscription confirmation
        function confirmCancellation() {
            if (confirm(
                    'Are you sure you want to cancel your subscription? You will lose access to premium features at the end of your billing period.'
                )) {
                document.getElementById('cancelSubscriptionForm').submit();
            }
        }

        // Add payment method placeholder
        document.querySelector('.add-payment-method')?.addEventListener('click', function() {
            alert('Add payment method feature coming soon!');
        });
    </script>
