<?php
session_start();
require_once("../db_conn.php");

if (isset($_POST["viewPassengers"])) {
    $tripID = $_POST["tripID"];
}


?>

<?php include("header.php"); ?>

    <style>
        
.filter {
margin-left: 7.5px;
font-family: "Poppins", sans-serif;
font-weight: 400;
font-style: normal;
  font-size: 14px;
  height: 30px;
  background-color: var(--black);
  color: #ffffff;
  border: none;
  border-radius: 5px;
  
  padding: 5px 10px;
  cursor: pointer;
  width: auto;



}

.filter:hover {
  background-color: #333333;
}

    </style>

<main class="account-main">

    <section class="account-view">

        <div class=account-container>
            <div class="account-card">
                <div class="account-heading">
                    <p style="font-size: 2rem; font-weight: 500; ">
                        Trips
                    </p>

                </div>
                <div class="account-info">

                    <div class="account-summary">
                        <div class="account-box">
                            <div class="account-heading-box">
                                <p class="user-name">My Account</p>

                            </div>
                            <div class="account-icon-box">
                                <i class="bi bi-person-circle"></i>


                            </div>
                            <div class="account-username-box">
                                <p class="welcome">Welcome!</p>
                                <p class="name"><?php echo $_SESSION["user"]["user_name"]; ?></p>
                            </div>

                            <div class="button-box">
                                <a href="account.php"><button class="viewbutton">
                                    Account
                                </button></a>

                                <a href="feedbackform.php"><button class="viewbutton">
                                    View Feedback
                                </button></a>

                                <a href="../admin/logout.php"><button class="viewbutton">
                                    Log Out
                                </button></a>
                            </div>

                        </div>

                    </div>

                    <div class="account-table">




                    <div class="sort-button-box">


<form action="viewtrips.php"><button style="margin-left: 50px;" class="filter">Back</button></form>
</div>

                        <div class="table-section-item">


                            <div class="table-container-item">

                                <div class="table-box">

                                    <table id="rows-def">
                                    <tr id="table-head">
                                    <th>#</th>
                                    <th>SEAT NO</th>
                                    <th>NIC</th>
                        <th>NAME</th>
                        <th>PHONE NO</th>
                        <th>PICKUP</th>
                        <th>DROP</th>
                        
                        <th>STATUS</th>                       

                    </tr>

                    <?php

$userID = $_SESSION["user"]["user_id"];

$sql = "SELECT seat.*,booking.*,customer.*, trip_booking.* FROM trip_booking
INNER JOIN booking ON trip_booking.bookingID = booking.bookingID
INNER JOIN customer ON booking.customerID = customer.customerID
INNER JOIN seat ON trip_booking.bookingID = seat.bookingID
WHERE trip_booking.tripID='$tripID' ORDER BY seat.seatNo ASC";




$result = mysqli_query($conn, $sql);
$queryResults = mysqli_num_rows($result);
$i=1;
if ($queryResults > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        

        echo "
        <tr>
        <td id='ID'>" . $i . "</td>
  <td id='ID'>" . $row["seatNo"] . "</td>
  <td>" . $row["nic"] . "</td>
  <td>" . $row["name"] . "</td>
  <td>" . $row["phoneNo"] . "</td>
  <td>" . $row["pickup"] . "</td>
  <td>" . $row["dropPoint"] . "</td>
  <td>" . $row["status"] . "</td>


</tr>";
$i++;
    }
}
?>
                                        




                                    </table>


                                </div>




                            </div>
                        </div>






                        </body>

                        </html>


                    </div>



                </div>
            </div>



        </div>

    </section>
</main>