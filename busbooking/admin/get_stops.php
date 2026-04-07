<?php
// Include your database connection file
require_once("../db_conn.php");

// Check if the routeID parameter is set and not empty
if (isset($_GET['routeID']) && !empty($_GET['routeID'])) {
    // Sanitize the input
    $routeID = mysqli_real_escape_string($conn, $_GET['routeID']);

    // Query to fetch cities associated with the selected route ID
    $sql = "SELECT * FROM route_stop
            INNER JOIN stop ON route_stop.stopID = stop.stopID
            WHERE routeID = '$routeID'
            ORDER BY route_stop.order";
    $result = mysqli_query($conn, $sql);

    $stops = array();
    

    // Fetch associative array
    while ($row = mysqli_fetch_assoc($result)) {
        $cityID = array( $row["stopID"],$row["city"]);
        $stopString = implode(" ",$cityID );
        $stops[] = $stopString;
    }

    // Construct the JSON response with routeID as key and stops array as value
    $stop_data = array($routeID => $stops);

    // Send JSON response
    echo json_encode($stop_data);
} else {
    // Handle the case when routeID parameter is not set or empty
    echo json_encode(array('error' => 'Route ID is missing'));
}
?>