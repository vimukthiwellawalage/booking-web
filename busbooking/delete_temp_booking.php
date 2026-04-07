<?php
session_start();
require_once("db_conn.php");

// Check if the user is logged in or not
if (!isset($_SESSION['booking-info'])) {
    // Redirect to index.php or any other appropriate page if the user is not logged in
    header("Location: index.php");
    exit;
}

// Retrieve the temporary booking ID and the number of seats booked from the session
$tempBookingID = $_SESSION['booking-info']['tempBookingID'];
$seatsCount = $_SESSION['booking-info']['seatsCount'];

// Delete the temporary booking from the database
$sql = "DELETE FROM temp_booking WHERE tempBookingID = '$tempBookingID'";

if (mysqli_query($conn, $sql)) {
    // Update available seats by adding back the booked seats
    $tripID = $_SESSION['booking-info']['tripID'];
    $updateSql = "UPDATE trip SET avaSeats = avaSeats + $seatsCount WHERE tripID = '$tripID'";
    if (mysqli_query($conn, $updateSql)) {
        // Redirect to index.php
        header("Location: index.php");
        exit;
    } else {
        // Error occurred while updating available seats
        echo "Error updating available seats: " . mysqli_error($conn);
    }
} else {
    // Error occurred while deleting the temporary booking
    echo "Error deleting temporary booking: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>