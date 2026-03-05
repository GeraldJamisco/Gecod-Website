<?php
/**
 * GECOD Visitor Tracker
 * Logs each public page visit with IP geolocation (cached per IP).
 * Included at the top of includes/header.php.
 * Requires $conn (mysqli) to already be set.
 */

// Only run on public pages where $conn is available
if (!isset($conn)) return;

// Skip admin users
if (isset($_SESSION['gecodmail'])) return;

// Skip common bots/crawlers
$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
$bots = ['bot', 'crawler', 'spider', 'slurp', 'googlebot', 'bingbot', 'yandex', 'baidu', 'facebookexternalhit', 'curl', 'wget', 'python', 'java'];
foreach ($bots as $bot) {
    if (stripos($ua, $bot) !== false) return;
}

// Resolve real IP (handle reverse proxies)
$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $forwarded = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    $ip = trim($forwarded[0]);
}
$ip = filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';

$safeIp   = $conn->real_escape_string($ip);
$safePage = $conn->real_escape_string(substr($_SERVER['REQUEST_URI'] ?? '/', 0, 500));
$safeUa   = $conn->real_escape_string(substr($ua, 0, 500));

// Check geo cache first
$geo     = ['country' => '', 'country_code' => '', 'region' => '', 'city' => ''];
$geoRes  = $conn->query("SELECT country, country_code, region, city FROM ip_geo_cache WHERE ip_address='$safeIp'");
if ($geoRes && $geoRes->num_rows > 0) {
    $geo = $geoRes->fetch_assoc();
} else {
    // Not cached — look up via ip-api.com (free, no API key, ~50ms)
    $apiUrl  = "http://ip-api.com/json/{$ip}?fields=country,countryCode,regionName,city&lang=en";
    $apiData = '';

    if (function_exists('curl_init')) {
        $ch = curl_init($apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 2,
            CURLOPT_CONNECTTIMEOUT => 1,
        ]);
        $apiData = curl_exec($ch);
        curl_close($ch);
    } elseif (ini_get('allow_url_fopen')) {
        $ctx     = stream_context_create(['http' => ['timeout' => 2]]);
        $apiData = @file_get_contents($apiUrl, false, $ctx);
    }

    if ($apiData) {
        $parsed = json_decode($apiData, true);
        if (isset($parsed['country'])) {
            $geo = [
                'country'      => $parsed['country']    ?? '',
                'country_code' => $parsed['countryCode'] ?? '',
                'region'       => $parsed['regionName']  ?? '',
                'city'         => $parsed['city']        ?? '',
            ];
        }
    }

    // Cache result (even if empty — stops repeated API calls for same IP)
    $c  = $conn->real_escape_string($geo['country']);
    $cc = $conn->real_escape_string($geo['country_code']);
    $r  = $conn->real_escape_string($geo['region']);
    $ci = $conn->real_escape_string($geo['city']);
    $conn->query("INSERT IGNORE INTO ip_geo_cache (ip_address, country, country_code, region, city)
                  VALUES ('$safeIp', '$c', '$cc', '$r', '$ci')");
}

// Log the visit
$country     = $conn->real_escape_string($geo['country']);
$countryCode = $conn->real_escape_string($geo['country_code']);
$region      = $conn->real_escape_string($geo['region']);
$city        = $conn->real_escape_string($geo['city']);

$conn->query("INSERT INTO site_visitors
              (ip_address, country, country_code, region, city, page_visited, user_agent)
              VALUES ('$safeIp', '$country', '$countryCode', '$region', '$city', '$safePage', '$safeUa')");
