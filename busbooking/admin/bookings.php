<?php
session_start();
require_once("../db_conn.php");
include("sidemenu.php");

if (isset($_POST["search"])) {
    $search = mysqli_real_escape_string($conn, $_POST["search"]);
}

if (isset($_POST["cancelBooking"])) {

    $bookingID = $_POST["bookingID"];


    $sql = "UPDATE booking SET status = 'cancelled' WHERE bookingID = $bookingID";

    mysqli_query($conn, $sql);
}



if (isset($_POST["deleteBooking"])) {
    $bookingID = $_POST["bookingID"];

    $sql = "DELETE FROM booking WHERE bookingID = '$bookingID'";
    mysqli_query($conn, $sql);

}


?>
<div class="dashboard-content">


    <div class="heading-box">
        <div class="box-1">

            <div class="title">
                <p>Trip Bookings</p>
                <!-- <h2>Welcome To 4You</h2> -->
            </div>
        </div>
        <div class="box-1">
            <div class="search-bar">
                <ul>
                    <li class="search">
                        <!--Search bar-->

                        <form action="bookings.php" method="post" id="searchForm">
                        <input type="text" <?php echo isset($_POST["search"]) ? "value='$search'" : ""; ?> placeholder="Search bookings" name="search" required id="search-input" />
                        <i onclick="submitForm()" class="bx bx-search-alt-2"></i>
                    </form>
                    </li>

                </ul>


            </div>
        </div>
    </div>

    <div class="table-section-item">


        <div class="table-container-item">

            <div class="table-box">

                <table id="rows-def">
                    <tr id="table-head">
                        <th>BOOKING ID</th>
                        <th>TRIP ID</th>
                        <th>PAYMENT ID</th>
                        <th>CUSTOMER ID</th>
                        <th>ORIGIN</th>  
                        <th>DESTINATION</th>
                        <th>NO OF SEATS</th> 
                        <th>BOOKED DATE</th>
                        <th>STATUS</th>                     
                        <th>EDIT</th>
                        <th>DELETE</th>
                    </tr>

                    <?php

                    if (isset($_POST["search"])) {
                                            
                        $sql = "SELECT * FROM trip_booking
                        INNER JOIN booking ON trip_booking.bookingID= booking.bookingID
                            
                        WHERE trip_booking.bookingID LIKE '%$search%' ";
                    }else {
                        $sql = "SELECT * FROM trip_booking
                            INNER JOIN booking ON trip_booking.bookingID= booking.bookingID
                            ";
                    }
                    


                    $result = mysqli_query($conn, $sql);
                    $queryResults = mysqli_num_rows($result);

                    if ($queryResults > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {

                            echo "<form action='bookings.php' method='post'>
                            <tr>
                      <td id='ID'>" . $row["bookingID"] . "</td>
                      <td>" . $row["tripID"] . "</td>
                      <td>" . $row["paymentID"] . "</td>
                      <td>" . $row["customerID"] . "</td>
                     <td>" . $row["pickup"] . "</td>
                      <td>" . $row["dropPoint"] . "</td>
                      <td>" . $row["noOfSeats"] . "</td>
                      <td>" . $row["bookedDate"] . "</td>
                      <td>" . $row["status"] . "</td>
                      <input type='hidden' name='bookingID' value='" . $row["bookingID"] . "'>
                      <td>";
                      if ($row["status"] == "active") {
                          echo "<button id='confirm' name='cancelBooking'>Cancel</button></td>";
                      } else if ($row["status"] == "cancelled") {
                          echo "<button id='confirmed' name='cancelBooking'>Cancelled</button></td>";
                      }
                    echo "<td><button id='bin' name='deleteBooking'><i class='ri-delete-bin-line'></i></button> </td>

                  </tr></form>";
                        }

                    }

                    ?>
                    

                           
                        




                </table>


            </div>




        </div>
    </div>
    <div class="bottom-box">
        

    </div>


</div>




</body>

</html>
<script>
    function submitForm() {
        document.getElementById('searchForm').submit();
    }
</script>