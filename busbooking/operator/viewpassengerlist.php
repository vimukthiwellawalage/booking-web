<?php
session_start();
require_once("../db_conn.php");

if (isset($_POST["viewPassengers"])) {
    $tripID = $_POST["tripID"];
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

    <link rel="stylesheet" href="operatorstyle.css" />

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tomorrow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    

    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" 
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" 
    crossorigin="anonymous"></script>

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
    
</head>

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