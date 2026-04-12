<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New Opportunities</title>
</head>

<body style="margin:0; padding:0; background:#f4f6f8; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8; padding:20px;">
        <tr>
            <td align="center">

                <!-- Main Container -->
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:10px; overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background:#16a34a; color:#ffffff; padding:20px; text-align:center;">
                            <h2 style="margin:0;">🎯 New Opportunities for You</h2>
                            <p style="margin:5px 0 0;">Stay ahead. Don’t miss out.</p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:20px;">

                            @foreach ($opportunities as $item)
                                <table width="100%" cellpadding="0" cellspacing="0"
                                    style="margin-bottom:20px; border:1px solid #eee; border-radius:8px;">

                                    <tr>
                                        <td style="padding:15px;">

                                            <!-- Title -->
                                            <h3 style="margin:0 0 5px; color:#111;">
                                                {{ $item->title }}
                                            </h3>

                                            <!-- Organization -->
                                            <p style="margin:0 0 10px; color:#555;">
                                                {{ $item->organization ?? 'Unknown Organization' }}
                                            </p>

                                            <!-- Meta -->
                                            <p style="margin:0 0 10px; font-size:13px; color:#777;">
                                                📍 {{ $item->location ?? 'Remote' }} <br>
                                                📅 Deadline:
                                                {{ $item->deadline ? \Carbon\Carbon::parse($item->deadline)->format('M d, Y') : 'N/A' }}
                                            </p>

                                            <!-- Button -->
                                            <a href="{{ route('opportunities.show', [$item->uuid, $item->slug]) }}"
                                                style="display:inline-block; padding:10px 16px; background:#16a34a; color:#fff; text-decoration:none; border-radius:5px; font-size:14px;">
                                                View Opportunity →
                                            </a>

                                        </td>
                                    </tr>
                                </table>
                            @endforeach

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:20px; text-align:center; font-size:12px; color:#888;">

                            <p style="margin-bottom:10px;">
                                You’re receiving this because you subscribed to opportunity alerts.
                            </p>

                            <!-- Unsubscribe -->
                            <p style="margin-bottom:10px;">
                                <a href="{{ route('alerts.unsubscribe', $alert->unsubscribe_token) }}"
                                    style="color:#dc2626; text-decoration:none;">
                                    Unsubscribe
                                </a>
                                •
                                <a href="{{ route('privacy') }}" style="color:#6b7280;">Privacy</a>
                                •
                                <a href="{{ route('contact') }}" style="color:#6b7280;">Contact</a>
                            </p>

                            <p style="margin:0;">
                                © {{ date('Y') }} Your Platform. All rights reserved.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
