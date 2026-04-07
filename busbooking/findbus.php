<?php
require_once("db_conn.php");
include("header.php");
if (isset($_POST["submit-index"])) {
    $from = $_POST["from"];
    $to = $_POST["to"];
    $date = $_POST["date"];
    
}
?>
<main>

    <section class="find-bus-bar">
        <div class="find-bar">


            <form action="findbus.php" method="post" id="findBusForm" onsubmit="return validateInputs()">
                <div class="seat-booking-bar">

                    <div class="selection-bar">


                        <input <?php echo isset($from) ? "value='$from'" : ""; ?> type="text" placeholder="From" name="from" id="from" class="input" />

                        <input <?php echo isset($to) ? "value='$to'" : ""; ?> type="text" placeholder="To" name="to" id="to" class="input" />




                        <input <?php echo isset($date) ? "value='$date'" : ""; ?> name="date" id="date" class="input-date" placeholder="Travel Date" value="" type="date" min="<?php echo date('Y-m-d'); ?>">
                        <button name="submit-index" class="input-submit" type="submit">Submit</button>

                    </div>

                </div>
                <div class="suggestion-box-from-findbus">
                    <ul id="dropdatafrom" class="suggestion-list">


                    </ul>
                </div>
                <div class="suggestion-box-to-findbus">
                    <ul id="dropdatato" class="suggestion-list">

                    </ul>
                </div>
            </form>




        </div>


    </section>
    <script>
        // Function to hide suggestion boxes
        function hideSuggestionBoxes() {
            $(".suggestion-box-from-findbus").hide();
            $(".suggestion-box-to-findbus").hide();
        }

        // Attach scroll event listener to window
        window.addEventListener('scroll', function() {
            // Call hideSuggestionBoxes function when scroll event occurs
            hideSuggestionBoxes();
        });

        // Rest of your existing script
        $("#from").keyup(function() {
            $(".suggestion-box-to-findbus").hide();
            $from = $("#from").val();

            $.ajax({
                url: 'get_from.php',
                method: 'POST',
                data: {
                    'from': $from
                },
                success: function(response) {
                    $("#dropdatafrom").html(response);
                }
            });

            if ($("#from").val() != '') {
                $(".suggestion-box-from-findbus").show();
            } else {
                $(".suggestion-box-from-findbus").hide();
            }
        });

        $("#to").keyup(function() {
            $(".suggestion-box-from-findbus").hide();
            $to = $("#to").val();

            $.ajax({
                url: 'get_to.php',
                method: 'POST',
                data: {
                    'to': $to
                },
                success: function(response) {
                    $("#dropdatato").html(response);
                }
            });

            if ($("#to").val() != '') {
                $(".suggestion-box-to-findbus").show();
            } else {
                $(".suggestion-box-to-findbus").hide();
            }
        });

        function putdataFrom(data) {
            $("#from").val(data);
            hideSuggestionBoxes();
        }

        function putdataTo(data) {
            $("#to").val(data);
            hideSuggestionBoxes();
        }
    </script>

    <section class="sort-bar">
        <div class="sort-box">
            <ul>
                <li><a href="index.php">Sort</a></li>
                <li><a href="promotions.php">Departure Time</a></li>
                <li><a href="location.php">Arrival Time</a></li>
                <li><a href="services.php">Available Seats</a></li>


            </ul>

        </div>
    </section>

    <section class="bus-container" >
        <?php
        
        date_default_timezone_set("Asia/Colombo");
        $currentDateTime = date("H:i:s");

        $sql = "SELECT DISTINCT trip_stop.tripID FROM trip_stop
        INNER JOIN trip ON trip_stop.tripID = trip.tripID
        INNER JOIN bus ON trip.busID = bus.busID
        INNER JOIN standard_bus ON bus.busID = standard_bus.busID 
        INNER JOIN stop ON trip_stop.stopID = stop.stopID 
        WHERE (stop.city LIKE '$from' AND trip_stop.pointType = 'start')
        AND trip.tripID IN (
            SELECT tripID FROM trip_stop
            INNER JOIN stop ON trip_stop.stopID = stop.stopID
            WHERE stop.city LIKE '$to' AND trip_stop.pointType = 'end'
        )
        AND trip.date = '$date'";

    if ($date === date("Y-m-d")) {
        // If selected date matches the current date, consider closing time
        $sql .= " AND trip.closingTime > '$currentDateTime'";
    }


            $result = mysqli_query($conn, $sql);
            $queryResults = mysqli_num_rows($result);


            if ($queryResults > 0) {
                while ($rows=mysqli_fetch_array($result)) {
                    $tripID= $rows["tripID"];
                    
                    $sql2 = "SELECT turn.*,route.*, bus.*, standard_bus.*, trip.*, trip.tripID AS scheduleID FROM trip 
                            INNER JOIN turn ON trip.turnID = turn.turnID
                            INNER JOIN route ON trip.routeID = route.routeID
                            INNER JOIN bus ON trip.busID = bus.busID
                            INNER JOIN standard_bus ON bus.busID = standard_bus.busID 
                            WHERE trip.tripID='$tripID'";

                    $result2 = mysqli_query($conn, $sql2);
                    $queryResults2 = mysqli_num_rows($result2);

                    if ($queryResults2 > 0) {
                        while ($row = mysqli_fetch_assoc($result2)) {
                            $depTimeOri = $row["depTimeOri"];
                            $depTimeDes = $row["depTimeDes"];
                            $duration = $row["duration"];
                            $avaSeats = $row["avaSeats"]; // Get available seats
                            $secs = strtotime($duration)-strtotime("00:00:00");
                            $buttonDisabled = ($avaSeats == 0) ? 'disabled' : '';
                            $arrivalTime = ($row["turnType"] === 'depart') ? date("H:i:s",strtotime($depTimeOri)+$secs) :date("H:i:s",strtotime($depTimeDes)+$secs) ;

                            // Check if the arrival time exceeds 24 hours
                            if ($row["turnType"] === 'depart' && strtotime($depTimeOri) + $secs >= strtotime('24:00:00')) {
                                // Add 1 day to the date if arrival time exceeds 24 hours
                                $arrivalDate = date('Y-m-d', strtotime($row["date"] . ' +1 day'));
                            } elseif ($row["turnType"] === 'arrive' && strtotime($depTimeDes) + $secs >= strtotime('24:00:00')) {
                                // Add 1 day to the date if arrival time exceeds 24 hours
                                $arrivalDate = date('Y-m-d', strtotime($row["date"] . ' +1 day'));
                            } else {
                                $arrivalDate = $row["date"]; // Arrival date remains the same
                            }
                            echo '
                            <div class="bus-card">
            <div class="route-row">
                <p>Route '.$row["routeNo"].'</p>
            </div>
            <div class="rule">

            </div>
            <div class="card-body-row">
                <div class="wide-col">
                    <img class="bus-img" src="images/'.$row["image"].'">
                </div>
                <div class="normal-col">
                    <div class="body-row">
                        <p class="body-heading">
                            Departure
                        </p>
                        <p class="body-context">';
                        echo ($row["turnType"] === 'depart') ? $row["origin"] : $row["destination"];

                        echo '</p>

                    </div>
                    <div class="body-row">
                        <p class="body-heading">
                            Date
                        </p>
                        <p class="body-context">
                        '.$row["date"].'
                        </p>

                    </div>
                    <div class="body-row">
                        <p class="body-heading">
                            Time
                        </p>
                        <p class="body-context">';
                        echo ($row["turnType"] === 'depart') ? $row["depTimeOri"] : $row["depTimeDes"];

                        echo '</p>

                    </div>

                </div>
                <div class="thin-col">
                    <img class="bus-img" src="images/arrow.png">
                </div>
                <div class="normal-col">
                    <div class="body-row">
                        <p class="body-heading">
                            Arrival

                        </p>
                        <p class="body-context">';
                        echo ($row["turnType"] === 'depart') ? $row["destination"] : $row["origin"];


                        echo '</p>

                    </div>
                    <div class="body-row">
                        <p class="body-heading">
                            Date
                        </p>
                        <p class="body-context">
                        '.$arrivalDate.'

                        </p>

                    </div>
                    <div class="body-row">
                        <p class="body-heading">
                            Time
                        </p>
                        <p class="body-context">
                        '.$arrivalTime.'

                        </p>

                    </div>
                </div>
                <div class="medium-col">
                    <div class="body-row">
                        <p class="body-heading">
                            Bus Type
                        </p>
                        <p class="body-context">
                        '.$row["type"].'

                        </p>

                    </div>
                    <div class="body-row">
                        <p class="body-heading">
                            Model
                        </p>
                        <p class="body-context">
                        '.$row["model"].'

                        </p>

                    </div>
                    <div class="body-row">
                        <p class="body-heading">
                            Bus Schedule ID
                        </p>
                        <p class="body-context">
                        '.$row["scheduleID"].'

                        </p>

                    </div>
                </div>
                <div class="medium-col">
                    <div class="body-row">
                        <p class="body-heading">
                            Boooking Closing Date
                        </p>
                        <p class="body-context">
                        '.$row["date"].'

                        </p>

                    </div>
                    <div class="body-row">
                        <p class="body-heading">
                            Boooking Closing Time
                        </p>
                        <p class="body-context">
                        '.$row["closingTime"].'

                        </p>

                    </div>

                </div>
                <div class="wide-col">
                    <div class="wide-row">
                        <p class="ava-seats">
                            Available Seats: '.$row["avaSeats"].'

                        </p>

                    </div>
                    <div class="wide-row">
                        <p class="body-price">
                            Rs '.$row["fare"].'
                        </p>

                    </div>';
                    echo '
    <div class="wide-row">
        <a href="bookseat.php?from='.$from.'&to='.$to.'&tripID='.$tripID.'">
            <button class="book-seat" '.$buttonDisabled.'>Book Seat</button>
        </a>
    </div>
    ';

               echo '</div>
            </div>
            <div class="footer-row">

            </div>


        </div>
                            
                            ';
                            
                        }

                    }


                
                    
                }
            }




        ?>

        


    </section>

    <footer>

<div class="footer-row-logo">

</div>
<div class="footer-row-context">
    <div class="footer-column">
        <h1 class="footer-title">
            Contact Info
        </h1>
        <p class="footer-context">
            Contact No
            011 23 45 567
            011 45 67 890
        </p>
        <p class="footer-context">
            Address
            No 131/5A, Colombo 01.
        </p>
        <p class="footer-context">
            Email
            ezbuslkinfo@gmail.com
        </p>

    </div>
    <div class="footer-column">
        <h1 class="footer-title">
            Quick Links
        </h1>
        <p class="footer-context">
            Home
        </p>
        <p class="footer-context">
            Services

        </p>
        <p class="footer-context">
            Contact

        </p>
        <p class="footer-context">
            View Schedule

        </p>
        <p class="footer-context">
            Help Service

        </p>
        <p class="footer-context">
            Book Seat
        </p>

    </div>
    <div class="footer-column">
        <h1 class="footer-title">
            Follow Us
        </h1>
        <p class="footer-context">
            Privacy & Policy
        </p>
        <p class="footer-context">
            Terms & Conditions
        </p>
    </div>
    <div class="footer-column">
        <h1 class="footer-title">
            National Transport Commision
        </h1>
        <p class="footer-context">
            Park Rd, Colombo 05.

        </p>
        <p class="footer-context">

            +94 011-2587372
        </p>
    </div>
</div>
<div class="footer-row">
    <img class="footer-logo" src="images/logo2.12.png">
    <p style="font-size: 0.8rem; margin-right: 20px;">&copy; All Rights Reserved</p>
    <p style="font-size: 0.8rem;">Designed & Developed by InnovateSoft Solutions</p>
</div>




<script>
    localStorage.removeItem("count_timer");
    localStorage.removeItem("count_timer_2");
    localStorage.removeItem("count_timer_3");

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "delete_temp_booking10.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            
            
        }
    };
    xhr.send();
</script>




</footer>

</main>