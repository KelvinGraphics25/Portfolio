<?php
// Set cookie to avoid repeat notifications (1 day)
$cookieName = "visitor_notified";
$cookieTime = time() + (60 * 60 * 24); // 24 hours

if (isset($_COOKIE[$cookieName])) {
    exit; // Already notified
}

// Get visitor's IP address
$ip = $_SERVER['REMOTE_ADDR'];

// Use IP geolocation API (ipinfo.io is free and simple)
$location = "Unknown Location";
$geoResponse = @file_get_contents("https://ipinfo.io/{$ip}/json");

if ($geoResponse !== false) {
    $geoData = json_decode($geoResponse, true);
    if (isset($geoData['country'])) {
        $location = $geoData['country'];
    }
}

// Build message
$phone = "+254799800366";
$apikey = "7694151";
$message = urlencode("👀 A visitor viewed your portfolio from $location.");
$url = "https://api.callmebot.com/whatsapp.php?phone=$phone&text=$message&apikey=$apikey";

// Send WhatsApp notification
file_get_contents($url);

// Set 1-day cookie
setcookie($cookieName, "true", $cookieTime, "/");
?>
