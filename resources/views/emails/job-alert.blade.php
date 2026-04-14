<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Jobs For You</title>
</head>

<body style="margin:0; padding:0; background:#f3f4f6; font-family:Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0;">
        <tr>
            <td align="center">

                <table width="620" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 18px rgba(0,0,0,0.06);">

                    {{-- HEADER --}}
                    <tr>
                        <td align="center" style="background:#16a34a; padding:28px; color:#ffffff;">
                            <h1 style="margin:0; font-size:22px;">🍏 Sproutplex Jobs</h1>
                            <p style="margin:6px 0 0; font-size:14px;">
                                Fresh jobs matching your alert
                            </p>
                        </td>
                    </tr>


                    {{-- INTRO --}}
                    <tr>
                        <td style="padding:28px;">
                            <h2 style="margin:0 0 8px; font-size:18px; color:#111;">
                                Hi 👋
                            </h2>

                            <p style="margin:0; font-size:14px; color:#555;">
                                We found
                                <strong>{{ count($jobs) }} new job{{ count($jobs) > 1 ? 's' : '' }}</strong>
                                you might like.
                            </p>
                        </td>
                    </tr>


                    {{-- JOB LIST --}}
                    <tr>
                        <td style="padding:0 28px 20px;">

                            @foreach ($jobs as $job)
                                <table width="100%" cellpadding="0" cellspacing="0"
                                    style="border:1px solid #e5e7eb; border-radius:10px; margin-bottom:16px; padding:14px;">

                                    <tr>

                                        {{-- LOGO --}}
                                        <td width="70" valign="top" style="padding-right:12px;">

                                            @if ($job->company_logo)
                                                {{-- FIX 1: Use full URL with storage path --}}
                                                <img src="{{ $message->embed(public_path($job->company_logo)) }}"
                                                    width="56" height="56" alt="{{ $job->company_name }} logo"
                                                    style="border-radius:8px; object-fit:cover;">
                                            @else
                                                <div
                                                    style="
                                    width:56px;
                                    height:56px;
                                    border-radius:8px;
                                    background:#e5e7eb;
                                    text-align:center;
                                    line-height:56px;
                                    font-size:22px;">
                                                    🏢
                                                </div>
                                            @endif

                                        </td>


                                        {{-- CONTENT --}}
                                        <td valign="top">

                                            {{-- Title --}}
                                            <h3 style="margin:0 0 6px; font-size:16px;">
                                                <a href="{{ route('jobs.show', $job) }}"
                                                    style="color:#111827; text-decoration:none;">
                                                    {{ $job->title }}
                                                </a>
                                            </h3>

                                            {{-- Company --}}
                                            <p style="margin:0 0 6px; font-size:13px; color:#444;">
                                                {{ $job->company_name }}

                                                {{-- FIX 2: Replace Bootstrap icon with HTML/CSS verified badge --}}
                                                @if ($job->is_verified)
                                                    <span
                                                        style="display: inline-block; margin-left: 4px; color: #16a34a; font-size: 14px; line-height: 1;"
                                                        title="Verified Company">✅</span>
                                                    {{-- Alternative: Use SVG if you prefer --}}
                                                    {{-- <span style="display: inline-block; width: 16px; height: 16px; background: #16a34a; color: white; border-radius: 50%; text-align: center; line-height: 16px; font-size: 11px; margin-left: 4px;">✓</span> --}}
                                                @endif
                                            </p>

                                            {{-- Meta --}}
                                            <p style="margin:0 0 8px; font-size:12px; color:#6b7280;">
                                                📍 {{ $job->location }}
                                                • {{ ucfirst($job->job_type) }}
                                            </p>

                                            {{-- BADGES ROW --}}
                                            <table cellpadding="0" cellspacing="0">
                                                <tr>

                                                    {{-- Salary badge --}}
                                                    @if ($job->salary_range)
                                                        <td
                                                            style="
                                        background:#dcfce7;
                                        color:#166534;
                                        padding:4px 8px;
                                        border-radius:6px;
                                        font-size:11px;
                                        margin-right:6px;">
                                                            💰 {{ $job->salary_range }}
                                                        </td>
                                                    @endif

                                                    {{-- Featured badge --}}
                                                    @if ($job->is_featured)
                                                        <td
                                                            style="
                                        background:#fef3c7;
                                        color:#92400e;
                                        padding:4px 8px;
                                        border-radius:6px;
                                        font-size:11px;">
                                                            ⭐ Featured
                                                        </td>
                                                    @endif

                                                </tr>
                                            </table>

                                        </td>


                                        {{-- APPLY BUTTON --}}
                                        <td valign="middle" align="right">

                                            <a href="{{ route('jobs.apply', $job) }}"
                                                style="
                                    background:#16a34a;
                                    color:#ffffff;
                                    padding:8px 14px;
                                    border-radius:6px;
                                    font-size:12px;
                                    text-decoration:none;
                                    display:inline-block;">
                                                Apply →
                                            </a>

                                        </td>

                                    </tr>
                                </table>
                            @endforeach

                        </td>
                    </tr>


                    {{-- CTA --}}
                    <tr>
                        <td align="center" style="padding:15px 0 28px;">
                            <a href="{{ route('jobs.index') }}"
                                style="
                    background:#111827;
                    color:#fff;
                    padding:12px 24px;
                    border-radius:8px;
                    text-decoration:none;
                    font-size:14px;">
                                Browse All Jobs
                            </a>
                        </td>
                    </tr>


                    {{-- FOOTER --}}
                    <tr>
                        <td align="center" style="background:#f9fafb; padding:20px; font-size:12px; color:#6b7280;">

                            <p style="margin:0 0 6px;">
                                You’re receiving this because you subscribed to Sproutplex Job Alerts.
                            </p>

                            <p style="margin:0;">
                                <a href="{{ route('alerts.unsubscribe', $alert->unsubscribe_token) }}"
                                    style="color:#dc2626; text-decoration:none;">
                                    Unsubscribe
                                </a>
                                •
                                <a href="{{ route('privacy') }}" style="color:#6b7280;">Privacy</a>
                                •
                                <a href="{{ route('contact') }}" style="color:#6b7280;">Contact</a>
                            </p>

                            <p style="margin-top:10px; font-size:11px;">
                                © {{ date('Y') }} Sproutplex Jobs · Abuja, Nigeria
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
