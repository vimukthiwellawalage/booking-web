<?php
// Include your database connection file
require_once("../db_conn.php");

// Check if the routeID parameter is set and not empty
if (isset($_GET['routeID']) && !empty($_GET['routeID'])) {
    // Sanitize the input
    $routeID = mysqli_real_escape_string($conn, $_GET['routeID']);

    // Query to fetch turns associated with the selected route ID
    $sql = "SELECT * FROM turn
            INNER JOIN route ON turn.routeID = route.routeID
            WHERE turn.routeID = '$routeID'";
    $result = mysqli_query($conn, $sql);

    $turns = array();

    // Fetch associative array
    while ($row = mysqli_fetch_assoc($result)) {
        $turnIDs = array( $row["turnID"],$row["routeNo"],$row["origin"],$row["destination"],$row["depTimeOri"],$row["depTimeDes"] );
        $turnString = implode(" ",$turnIDs );
        $turns[] = $turnString;
    }

    // Construct the JSON response
    $turn_data = array($routeID => $turns);

    // Send JSON response
    echo json_encode($turn_data);
} else {
    // Handle the case when routeID parameter is not set or empty
    echo json_encode(array('error' => 'Route ID is missing'));
}
?>