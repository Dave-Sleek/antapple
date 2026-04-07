<?php

use Torann\GeoIP\Facades\GeoIP;

if (!function_exists('getDeviceIcon')) {
    function getDeviceIcon(string $userAgent): string
    {
        if (stripos($userAgent, 'Windows') !== false) return 'laptop';
        if (stripos($userAgent, 'Mac') !== false) return 'laptop';
        if (stripos($userAgent, 'Android') !== false) return 'phone';
        if (stripos($userAgent, 'iPhone') !== false) return 'phone';
        if (stripos($userAgent, 'iPad') !== false) return 'tablet';
        return 'question-circle';
    }
}

if (!function_exists('getDeviceType')) {
    function getDeviceType(string $userAgent): string
    {
        if (stripos($userAgent, 'Windows') !== false) return 'Windows';
        if (stripos($userAgent, 'Mac') !== false) return 'Mac';
        if (stripos($userAgent, 'Android') !== false) return 'Android';
        if (stripos($userAgent, 'iPhone') !== false) return 'iPhone';
        if (stripos($userAgent, 'iPad') !== false) return 'iPad';
        return 'Unknown';
    }
}

if (!function_exists('getBrowser')) {
    function getBrowser(string $userAgent): string
    {
        if (stripos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (stripos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (stripos($userAgent, 'Safari') !== false) return 'Safari';
        if (stripos($userAgent, 'Edge') !== false) return 'Edge';
        if (stripos($userAgent, 'MSIE') !== false || stripos($userAgent, 'Trident') !== false) return 'Internet Explorer';
        return 'Unknown';
    }
}

if (!function_exists('getLocationFromIP')) {
    function getLocationFromIP(string $ip): ?string
    {
        try {
            $location = GeoIP::getLocation($ip);
            return $location->city . ', ' . $location->country;
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }
}
