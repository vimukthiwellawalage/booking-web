<?php
// Read endpoint powering the display panel: latest bus position, route
// stops (for the map), and previous/next stop + distance (for the panel).
// Polled every few seconds by display/index.php — GET ?bus_id=NC0909

header('Content-Type: application/json');
require_once __DIR__ . "/../db_conn.php";
require_once __DIR__ . "/../includes/geo-helpers.php";

$busID = $_GET['bus_id'] ?? null;

if (!$busID) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'bus_id is required']);
    exit;
}

$busIDEsc = mysqli_real_escape_string($conn, $busID);

$locSql = "SELECT busID, tripID, latitude, longitude, speedKmh, headingDegrees, recordedAt
           FROM bus_live_location
           WHERE busID = '$busIDEsc'
           ORDER BY recordedAt DESC
           LIMIT 1";
$locResult = mysqli_query($conn, $locSql);

if (!$locResult || mysqli_num_rows($locResult) === 0) {
    echo json_encode(['success' => true, 'has_location' => false, 'message' => 'No location data yet for this bus']);
    exit;
}

$location = mysqli_fetch_assoc($locResult);

// Prefer the route tied to the trip this ping was recorded against; fall
// back to the bus's assigned route if no trip is linked.
$routeID = null;
if (!empty($location['tripID'])) {
    $tripIDEsc = mysqli_real_escape_string($conn, $location['tripID']);
    $tripResult = mysqli_query($conn, "SELECT routeID FROM trip WHERE tripID = '$tripIDEsc'");
    if ($tripResult && mysqli_num_rows($tripResult) > 0) {
        $routeID = mysqli_fetch_assoc($tripResult)['routeID'];
    }
}
if ($routeID === null) {
    $routeResult = mysqli_query($conn, "SELECT routeID FROM standard_bus WHERE busID = '$busIDEsc'");
    if ($routeResult && mysqli_num_rows($routeResult) > 0) {
        $routeID = mysqli_fetch_assoc($routeResult)['routeID'];
    }
}

$routeInfo = null;
$routeStops = [];
$previousStop = null;
$nextStop = null;
$distanceToNextStopKm = null;

if ($routeID !== null) {
    $routeIDEsc = mysqli_real_escape_string($conn, $routeID);

    $routeResult = mysqli_query($conn, "SELECT routeID, routeNo, origin, destination FROM route WHERE routeID = '$routeIDEsc'");
    if ($routeResult && mysqli_num_rows($routeResult) > 0) {
        $routeInfo = mysqli_fetch_assoc($routeResult);
    }

    $stopsSql = "SELECT stop.stopID, stop.city, stop.latitude, stop.longitude, route_stop.`order` AS stop_order
                 FROM route_stop
                 INNER JOIN stop ON route_stop.stopID = stop.stopID
                 WHERE route_stop.routeID = '$routeIDEsc'
                 ORDER BY route_stop.`order` ASC";
    $stopsResult = mysqli_query($conn, $stopsSql);
    while ($row = mysqli_fetch_assoc($stopsResult)) {
        $routeStops[] = $row;
    }

    $stopsWithCoords = array_values(array_filter($routeStops, function ($stop) {
        return $stop['latitude'] !== null && $stop['longitude'] !== null;
    }));

    list($previousStop, $nextStop) = findPreviousAndNextStop(
        (float) $location['latitude'],
        (float) $location['longitude'],
        $stopsWithCoords
    );

    if ($nextStop !== null) {
        $distanceToNextStopKm = round(haversineDistanceKm(
            (float) $location['latitude'],
            (float) $location['longitude'],
            (float) $nextStop['latitude'],
            (float) $nextStop['longitude']
        ), 2);
    }
}

echo json_encode([
    'success' => true,
    'has_location' => true,
    'bus_id' => $location['busID'],
    'trip_id' => $location['tripID'],
    'route' => $routeInfo,
    'latitude' => (float) $location['latitude'],
    'longitude' => (float) $location['longitude'],
    'speed_kmh' => $location['speedKmh'] !== null ? (float) $location['speedKmh'] : null,
    'heading_degrees' => $location['headingDegrees'] !== null ? (float) $location['headingDegrees'] : null,
    'recorded_at' => $location['recordedAt'],
    'route_stops' => $routeStops,
    'previous_stop' => $previousStop ? ['stop_id' => $previousStop['stopID'], 'name' => $previousStop['city']] : null,
    'next_stop' => $nextStop ? ['stop_id' => $nextStop['stopID'], 'name' => $nextStop['city']] : null,
    'distance_to_next_stop_km' => $distanceToNextStopKm,
]);
