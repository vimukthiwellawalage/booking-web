<?php
// Location ingestion endpoint for the bus IoT GPS module.
//
// POST params:
//   device_uid       (or api_key)  - identifies which registered device is pinging
//   latitude         (required)
//   longitude        (required)
//   speed_kmh        (optional)
//   heading_degrees  (optional)
//   recorded_at      (optional, "Y-m-d H:i:s", defaults to server time)
//
// The real IoT device (once configured) posts here directly using the
// device_uid/api_key issued in the iot_device table. tools/simulate-gps.php
// posts here too, so this same endpoint is already fully tested.

header('Content-Type: application/json');
require_once __DIR__ . "/../../db_conn.php";

function respond($success, $data = [], $httpCode = 200) {
    http_response_code($httpCode);
    echo json_encode(array_merge(['success' => $success], $data));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, ['error' => 'Only POST requests are accepted'], 405);
}

$deviceUid = $_POST['device_uid'] ?? null;
$apiKey = $_POST['api_key'] ?? null;
$latitude = $_POST['latitude'] ?? null;
$longitude = $_POST['longitude'] ?? null;
$speedKmh = $_POST['speed_kmh'] ?? null;
$headingDegrees = $_POST['heading_degrees'] ?? null;
$recordedAt = $_POST['recorded_at'] ?? date('Y-m-d H:i:s');

if (!$deviceUid && !$apiKey) {
    respond(false, ['error' => 'device_uid or api_key is required'], 401);
}
if ($latitude === null || $longitude === null || !is_numeric($latitude) || !is_numeric($longitude)) {
    respond(false, ['error' => 'Valid latitude and longitude are required'], 400);
}

if ($apiKey) {
    $apiKeyEsc = mysqli_real_escape_string($conn, $apiKey);
    $deviceSql = "SELECT busID FROM iot_device WHERE apiKey = '$apiKeyEsc' AND status = 'active'";
} else {
    $deviceUidEsc = mysqli_real_escape_string($conn, $deviceUid);
    $deviceSql = "SELECT busID FROM iot_device WHERE deviceUID = '$deviceUidEsc' AND status = 'active'";
}

$deviceResult = mysqli_query($conn, $deviceSql);

if (!$deviceResult || mysqli_num_rows($deviceResult) === 0) {
    respond(false, ['error' => 'Invalid or inactive device credentials'], 401);
}

$busID = mysqli_fetch_assoc($deviceResult)['busID'];
$busIDEsc = mysqli_real_escape_string($conn, $busID);

// Best-effort association with today's active trip for this bus, if one exists.
$tripID = null;
$tripSql = "SELECT tripID FROM trip WHERE busID = '$busIDEsc' AND status = 'active' AND date = CURDATE() LIMIT 1";
$tripResult = mysqli_query($conn, $tripSql);
if ($tripResult && mysqli_num_rows($tripResult) > 0) {
    $tripID = mysqli_fetch_assoc($tripResult)['tripID'];
}

$latEsc = mysqli_real_escape_string($conn, $latitude);
$lngEsc = mysqli_real_escape_string($conn, $longitude);
$speedValue = ($speedKmh !== null && is_numeric($speedKmh)) ? "'" . mysqli_real_escape_string($conn, $speedKmh) . "'" : "NULL";
$headingValue = ($headingDegrees !== null && is_numeric($headingDegrees)) ? "'" . mysqli_real_escape_string($conn, $headingDegrees) . "'" : "NULL";
$recordedAtEsc = mysqli_real_escape_string($conn, $recordedAt);
$tripIDValue = $tripID !== null ? "'" . mysqli_real_escape_string($conn, $tripID) . "'" : "NULL";

$insertSql = "INSERT INTO bus_live_location (busID, tripID, latitude, longitude, speedKmh, headingDegrees, recordedAt)
              VALUES ('$busIDEsc', $tripIDValue, '$latEsc', '$lngEsc', $speedValue, $headingValue, '$recordedAtEsc')";

if (!mysqli_query($conn, $insertSql)) {
    respond(false, ['error' => 'Failed to record location'], 500);
}

mysqli_query($conn, "UPDATE iot_device SET lastPingAt = NOW() WHERE busID = '$busIDEsc'");

respond(true, ['bus_id' => $busID, 'trip_id' => $tripID]);
