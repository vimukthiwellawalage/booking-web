<?php

function haversineDistanceKm($lat1, $lon1, $lat2, $lon2) {
    $earthRadiusKm = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2)
        + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
        * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earthRadiusKm * $c;
}

/**
 * Given the bus's current position and an ordered list of stops (each with
 * at least latitude/longitude), find which consecutive pair of stops the
 * bus currently sits between. The segment whose two endpoints have the
 * smallest combined distance to the bus is taken as the current segment —
 * a simple approximation that works well when stops are reasonably spaced.
 *
 * Returns [previousStop, nextStop], either of which may be null if there
 * are fewer than 2 stops with coordinates.
 */
function findPreviousAndNextStop($busLat, $busLng, $orderedStops) {
    $stopCount = count($orderedStops);

    if ($stopCount === 0) {
        return [null, null];
    }
    if ($stopCount === 1) {
        return [null, $orderedStops[0]];
    }

    $bestSegmentIndex = 0;
    $bestSegmentScore = null;

    for ($i = 0; $i < $stopCount - 1; $i++) {
        $stopA = $orderedStops[$i];
        $stopB = $orderedStops[$i + 1];

        $distToA = haversineDistanceKm($busLat, $busLng, $stopA['latitude'], $stopA['longitude']);
        $distToB = haversineDistanceKm($busLat, $busLng, $stopB['latitude'], $stopB['longitude']);
        $segmentScore = $distToA + $distToB;

        if ($bestSegmentScore === null || $segmentScore < $bestSegmentScore) {
            $bestSegmentScore = $segmentScore;
            $bestSegmentIndex = $i;
        }
    }

    return [$orderedStops[$bestSegmentIndex], $orderedStops[$bestSegmentIndex + 1]];
}
