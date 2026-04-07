<?php
session_start();
require_once("db_conn.php");

// Check if the user is logged in or not
if (!isset($_SESSION['booking-info'])) {
    // Redirect to index.php or any other appropriate page if the user is not logged in
    header("Location: index.php");
    exit;
}

// Get the current trip ID
$tripID = $_SESSION['booking-info']['tripID'];

// Calculate the timestamp 5 minutes ago
$expiryTime = time() - (10 * 60);
echo "Expiry Time: " . $expiryTime . "<br>";


$getSeatsSql = "SELECT noOfSeats FROM temp_booking WHERE tripID = '$tripID' AND UNIX_TIMESTAMP(bookedTime) < $expiryTime";
$result = mysqli_query($conn, $getSeatsSql);

$deletedSeats = 0; // Initialize deletedSeats variable

// Check if the query was successful and if rows were returned
if ($result && mysqli_num_rows($result) > 0) {
    // Loop through each row to fetch the noOfSeats
    while ($row = mysqli_fetch_assoc($result)) {
        // Add the noOfSeats of each row to the deletedSeats variable
        $deletedSeats += $row['noOfSeats'];
    }
} else {
    // Handle the case when the query fails or no rows are returned
    echo "Error fetching noOfSeats: " . mysqli_error($conn);
}


// Prepare and execute the SQL query to delete expired bookings for the specific trip
$sql = "DELETE FROM temp_booking WHERE tripID = '$tripID' AND UNIX_TIMESTAMP(bookedTime) < $expiryTime";
echo "SQL Query: " . $sql . "<br>";

if (mysqli_query($conn, $sql)) {
    // Count the number of rows deleted

    // Update available seats
    $updateSql = "UPDATE trip SET avaSeats = avaSeats + $deletedSeats WHERE tripID = '$tripID'";
    echo "Update SQL Query: " . $updateSql . "<br>";

    if (mysqli_query($conn, $updateSql)) {
        // Redirect to index.php
        
    } else {
        // Error occurred while updating available seats
        echo "Error updating available seats: " . mysqli_error($conn);
    }
} else {
    // Log or display an error message if deletion fails
    echo "Error deleting expired bookings: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>