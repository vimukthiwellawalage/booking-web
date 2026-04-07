<?php
session_start();
require_once("../db_conn.php");

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






                        <div class="table-section-item">


                            <div class="table-container-item">

                                <div class="table-box">

                                    <table id="rows-def">
                                    <tr id="table-head">
                                    <th>#</th>
                                    <th style="width: 100px;">TRIP DATE</th>
                        <th>ROUTE NO</th>
                        <th>DEPARTURE</th>
                        <th>ARRIVAL</th>
                        <th>DEPARTURE TIME</th>
                        <th>DURATION</th>
                        <th>PASSENGERS</th>
                        <th>STATUS</th>                       
                        <th>VIEW</th>

                    </tr>

                    <?php

$userID = $_SESSION["user"]["user_id"];

$sql = "SELECT turn.*,route.*, bus.*, standard_bus.*, trip.*, trip.tripID AS scheduleID FROM trip
INNER JOIN turn ON trip.turnID = turn.turnID
INNER JOIN route ON trip.routeID = route.routeID
INNER JOIN bus ON trip.busID = bus.busID
INNER JOIN standard_bus ON bus.busID = standard_bus.busID 
WHERE standard_bus.userID='$userID'";




$result = mysqli_query($conn, $sql);
$queryResults = mysqli_num_rows($result);
$i=1;
if ($queryResults > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $depTimeOri = $row["depTimeOri"];
        $depTimeDes = $row["depTimeDes"];
        $duration = $row["duration"];
        $capacity = intval($row["capacity"]) ;
        $avaSeats = intval($row["avaSeats"]);
        $bookedSeats = $capacity - $avaSeats;
        $secs = strtotime($duration)-strtotime("00:00:00");
        
        $arrivalTime = ($row["turnType"] === 'depart') ? date("H:i:s",strtotime($depTimeOri)+$secs) :date("H:i:s",strtotime($depTimeDes)+$secs) ;

        if ($row["turnType"] === 'depart' && strtotime($depTimeOri) + $secs >= strtotime('24:00:00')) {
            // Add 1 day to the date if arrival time exceeds 24 hours
            $arrivalDate = date('Y-m-d', strtotime($row["date"] . ' +1 day'));
        } elseif ($row["turnType"] === 'arrive' && strtotime($depTimeDes) + $secs >= strtotime('24:00:00')) {
            // Add 1 day to the date if arrival time exceeds 24 hours
            $arrivalDate = date('Y-m-d', strtotime($row["date"] . ' +1 day'));
        } else {
            $arrivalDate = $row["date"]; // Arrival date remains the same
        }

        echo "
        <tr>
        <td id='ID'>" . $i . "</td>
  <td id='ID'>" . $row["date"] . "</td>
  <td>" . $row["routeNo"] . "</td>
  <td>"; echo ($row["turnType"] === 'depart') ? $row["origin"] : $row["destination"]; echo "</td>
  <td>";  echo ($row["turnType"] === 'depart') ? $row["destination"] : $row["origin"]; echo "</td>
  <td>"; echo  ($row["turnType"] === 'depart') ? $row["depTimeOri"] : $row["depTimeDes"]; echo "</td>
  <td>" . $row["duration"] . "</td>
  <td>" . $bookedSeats . "</td>
  <td>" . $row["status"] . "</td>

  <input type='hidden' name='tripID' value='" . $row["tripID"] . "'>
  <input type='hidden' name='routeID' value='" . $row["routeID"] . "'>";
  echo "
  <form action='viewpassengerlist.php' method='post'><td>
  <input type='hidden' name='tripID' value=" . $row["tripID"] . ">

  <button id='update' name='viewPassengers'> View</button></td></form>
  


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