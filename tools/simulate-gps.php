<?php
/**
 * GPS simulator — feeds realistic, moving fake coordinates into the live
 * display panel pipeline for a given bus, by walking its route stop-to-stop
 * and POSTing each interpolated point to the real ingestion endpoint
 * (api/iot/update-location.php). This lets the whole feature (map, next/prev
 * stop, distance) be tested end-to-end before the physical GPS module is
 * configured — once the real IoT device is ready, just point it at the same
 * endpoint with its own device_uid/api_key; nothing else changes.
 *
 * Usage:
 *   php tools/simulate-gps.php --bus_id=NC0909
 *   php tools/simulate-gps.php --bus_id=NC0909 --interval=5 --steps=15 --loop=1
 *   php tools/simulate-gps.php --bus_id=NC0909 --base_url=http://localhost/ezbusLK/busbooking
 *
 * Options:
 *   --bus_id    (required) an existing busID with a registered iot_device row
 *   --interval  seconds between pings (default 5)
 *   --steps     interpolated points per stop-to-stop segment (default 10)
 *   --loop      1 to loop the route forever, 0 to run once and exit (default 0)
 *   --base_url  base URL of the busbooking app (default http://localhost/ezbusLK/busbooking)
 */

if (php_sapi_name() !== 'cli') {
    die("This script must be run from the command line (php tools/simulate-gps.php --bus_id=...).\n");
}

require_once __DIR__ . '/../busbooking/db_conn.php';

$options = getopt('', ['bus_id:', 'interval::', 'steps::', 'loop::', 'base_url::']);

if (empty($options['bus_id'])) {
    fwrite(STDERR, "Usage: php tools/simulate-gps.php --bus_id=NC0909 [--interval=5] [--steps=10] [--loop=0] [--base_url=...]\n");
    exit(1);
}

$busID = $options['bus_id'];
$intervalSeconds = isset($options['interval']) ? (int) $options['interval'] : 5;
$stepsPerSegment = isset($options['steps']) ? (int) $options['steps'] : 10;
$loopForever = isset($options['loop']) ? (bool) (int) $options['loop'] : false;
$baseUrl = $options['base_url'] ?? 'http://localhost/ezbusLK/busbooking';
$endpointUrl = rtrim($baseUrl, '/') . '/api/iot/update-location.php';

$busIDEsc = mysqli_real_escape_string($conn, $busID);

// Look up the device credentials registered for this bus.
$deviceResult = mysqli_query($conn, "SELECT deviceUID, apiKey FROM iot_device WHERE busID = '$busIDEsc' AND status = 'active' LIMIT 1");
if (!$deviceResult || mysqli_num_rows($deviceResult) === 0) {
    fwrite(STDERR, "No active iot_device is registered for bus_id '$busID'. Add one to the iot_device table first.\n");
    exit(1);
}
$device = mysqli_fetch_assoc($deviceResult);

// Look up the bus's route (via standard_bus), then its ordered stops with coordinates.
$routeResult = mysqli_query($conn, "SELECT routeID FROM standard_bus WHERE busID = '$busIDEsc' LIMIT 1");
if (!$routeResult || mysqli_num_rows($routeResult) === 0) {
    fwrite(STDERR, "Bus '$busID' has no route assigned in standard_bus.\n");
    exit(1);
}
$routeID = mysqli_fetch_assoc($routeResult)['routeID'];
$routeIDEsc = mysqli_real_escape_string($conn, $routeID);

$stopsSql = "SELECT stop.stopID, stop.city, stop.latitude, stop.longitude
             FROM route_stop
             INNER JOIN stop ON route_stop.stopID = stop.stopID
             WHERE route_stop.routeID = '$routeIDEsc'
               AND stop.latitude IS NOT NULL AND stop.longitude IS NOT NULL
             ORDER BY route_stop.`order` ASC";
$stopsResult = mysqli_query($conn, $stopsSql);

$stops = [];
while ($row = mysqli_fetch_assoc($stopsResult)) {
    $stops[] = $row;
}

if (count($stops) < 2) {
    fwrite(STDERR, "Route '$routeID' needs at least 2 stops with coordinates to simulate movement.\n");
    exit(1);
}

echo "Simulating bus '$busID' along route '$routeID' (" . count($stops) . " stops), pinging every {$intervalSeconds}s...\n";
echo "Ctrl+C to stop.\n\n";

function postLocation($endpointUrl, $deviceUid, $apiKey, $lat, $lng, $speedKmh, $headingDegrees) {
    $postFields = http_build_query([
        'device_uid' => $deviceUid,
        'api_key' => $apiKey,
        'latitude' => $lat,
        'longitude' => $lng,
        'speed_kmh' => $speedKmh,
        'heading_degrees' => $headingDegrees,
    ]);

    $ch = curl_init($endpointUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        return "cURL error: $error";
    }
    return $response;
}

function bearingDegrees($lat1, $lon1, $lat2, $lon2) {
    $lat1Rad = deg2rad($lat1);
    $lat2Rad = deg2rad($lat2);
    $deltaLon = deg2rad($lon2 - $lon1);
    $y = sin($deltaLon) * cos($lat2Rad);
    $x = cos($lat1Rad) * sin($lat2Rad) - sin($lat1Rad) * cos($lat2Rad) * cos($deltaLon);
    return fmod((rad2deg(atan2($y, $x)) + 360), 360);
}

do {
    for ($i = 0; $i < count($stops) - 1; $i++) {
        $stopA = $stops[$i];
        $stopB = $stops[$i + 1];
        $heading = bearingDegrees($stopA['latitude'], $stopA['longitude'], $stopB['latitude'], $stopB['longitude']);

        for ($step = 0; $step <= $stepsPerSegment; $step++) {
            $fraction = $step / $stepsPerSegment;
            $lat = $stopA['latitude'] + ($stopB['latitude'] - $stopA['latitude']) * $fraction;
            $lng = $stopA['longitude'] + ($stopB['longitude'] - $stopA['longitude']) * $fraction;
            $simulatedSpeedKmh = 40 + mt_rand(-5, 10);

            $response = postLocation($endpointUrl, $device['deviceUID'], $device['apiKey'], $lat, $lng, $simulatedSpeedKmh, $heading);

            $label = $step === 0 ? " (at {$stopA['city']})" : ($step === $stepsPerSegment ? " (arriving {$stopB['city']})" : '');
            echo sprintf("[%s] lat=%.6f lng=%.6f%s -> %s\n", date('H:i:s'), $lat, $lng, $label, $response);

            sleep($intervalSeconds);
        }
    }
} while ($loopForever);

echo "\nDone — reached the end of the route.\n";
