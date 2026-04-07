<?php
// Include your database connection file
require_once("../db_conn.php");

// Check if the routeID parameter is set and not empty
if (isset($_GET['routeID']) && !empty($_GET['routeID'])) {
    // Sanitize the input
    $routeID = mysqli_real_escape_string($conn, $_GET['routeID']);

    $sql = "SELECT * FROM standard_bus
            INNER JOIN bus ON standard_bus.busID= bus.busID
            WHERE routeID = '$routeID'";

    
    $result = mysqli_query($conn, $sql);

    $buses = array();

    // Fetch associative array
    while ($row = mysqli_fetch_assoc($result)) {
        $busIDs = array( $row["busID"],$row["regNo"],$row["class"],$row["model"] );
        $busString = implode(" ",$busIDs );
        $buses[] = $busString;
    }

    // Construct the JSON response
    $bus_data = array($routeID => $buses);

    // Send JSON response
    echo json_encode($bus_data);
} else {
    // Handle the case when routeID parameter is not set or empty
    echo json_encode(array('error' => 'Route ID is missing'));
}
?>