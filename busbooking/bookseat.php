<?php
session_start();
require_once("db_conn.php");
include("header.php");

$tripID = $_GET["tripID"];
$from = $_GET["from"];
$to = $_GET["to"];

$_SESSION['booking-info']['tripID']=$tripID ;


?>
<main>
    <section class="sort-bar">
        <div class="sort-box">


        </div>
    </section>

    <section class="bus-container">

        <?php
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
                $destination = ($row["turnType"] === 'depart') ? $row["destination"] : $row["origin"];
                $origin = ($row["turnType"] === 'depart') ? $row["origin"] : $row["destination"];
                $departTime = ($row["turnType"] === 'depart') ? $row["depTimeOri"] : $row["depTimeDes"];
                $depTimeOri = $row["depTimeOri"];
                $depTimeDes = $row["depTimeDes"];
                $duration = $row["duration"];
                $regNo = $row["regNo"];
                $routeNo = $row["routeNo"];
                $via = $row["via"];
                $tripDate = $row["date"];
                $fare = $row["fare"];
                $secs = strtotime($duration) - strtotime("00:00:00");

                $arrivalTime = ($row["turnType"] === 'depart') ? date("H:i:s", strtotime($depTimeOri) + $secs) : date("H:i:s", strtotime($depTimeDes) + $secs);

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
                <p>Route ' . $row["routeNo"] . '</p>
                </div>
                <div class="rule">

                </div>
                <div class="card-body-row">
                <div class="wide-col">
                <img class="bus-img" src="images/' . $row["image"] . '">
                </div>
                <div class="normal-col">
                <div class="body-row">
                <p class="body-heading">
                Departure
                </p>
                <p class="body-context">
                ' . $origin . '
                </p>

                </div>
                <div class="body-row">
                <p class="body-heading">
                Date
                </p>
                <p class="body-context">
                ' . $tripDate . '
                </p>

                </div>
                <div class="body-row">
                <p class="body-heading">
                Time
                </p>
                <p class="body-context">' . $departTime . '</p>

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
                <p class="body-context">
                ' . $destination . '
                </p>

                </div>
                <div class="body-row">
                <p class="body-heading">
                Date
                </p>
                <p class="body-context">
                ' . $arrivalDate . '

                </p>

                </div>
                <div class="body-row">
                <p class="body-heading">
                Time
                </p>
                <p class="body-context">
                ' . $arrivalTime . '

                </p>

                </div>
                </div>
                <div class="medium-col">
                <div class="body-row">
                <p class="body-heading">
                Bus Type
                </p>
                <p class="body-context">
                ' . $row["type"] . '

                </p>

                </div>
                <div class="body-row">
                <p class="body-heading">
                Model
                </p>
                <p class="body-context">
                ' . $row["model"] . '

                </p>

                </div>
                <div class="body-row">
                <p class="body-heading">
                Bus Schedule ID
                </p>
                <p class="body-context">
                ' . $row["scheduleID"] . '

                </p>

                </div>
                </div>
                <div class="medium-col">
                <div class="body-row">
                <p class="body-heading">
                Boooking Closing Date
                </p>
                <p class="body-context">
                ' . $row["date"] . '

                </p>

                </div>
                <div class="body-row">
                <p class="body-heading">
                Boooking Closing Time
                </p>
                <p class="body-context">
                ' . $row["closingTime"] . '

                </p>

                </div>

                </div>
                <div class="wide-col">
                <div class="wide-row">
                <p class="ava-seats">
                Available Seats: ' . $row["avaSeats"] . '

                </p>

                </div>
                <div class="wide-row">
                <p class="body-price">
                Rs ' . $row["fare"] . '
                </p>

                </div>
                <div class="wide-row">
                <a href="bookseat.php?from=' . $from . '&to=' . $to . '&tripID=' . $tripID . '"><button class="book-seat">Book Seat

                </button></a>

                </div>

                </div>
                </div>
                <div class="footer-row">

                </div>


                </div>

                ';
                echo "<script>";
                echo "let busFare = '" . $row["fare"] . "';";

                echo "</script>";
            }
        }










        ?>

    </section>

    <section class="seat-booking">

        <div class="legend">

            <div class="legend-box">
                <div class="legend-inbox">
                    <div class="legend-container">
                        <div class="legend-square already-booked"></div>
                        <p>Available Seats</p>
                    </div>
                    <div class="legend-container">
                        <div class="legend-square available">
                        </div>
                        <p>Processing Seats</p>
                    </div>
                    <div class="legend-container">
                        <div class="legend-square booking-in-progress"></div>
                        <p>Unavailable Seats</p>
                    </div>

                    <div class="legend-container">
                        <div class="legend-square booked"></div>

                        <p>Booked Seats</p>
                    </div>
                </div>

            </div>
            <div class="time-box">
                <div class="time-container">
                <p id="timer"></p>
                </div>
            </div>




        </div>


        <div class="seat-selection">
            <div class="seat-structure">

                <div class="front" data-placement="above">Front</div>
                <div class="wheel">

                    <img src="kisspng-car-motor-vehicle-steering-wheels-rim-hydrol-5ce5e7f4c6f5f2.957653511558570996815.png" alt="">
                </div>
                <?php
                // Fetch booked seats
                $bookedSeats = array();
                $sql2 = "SELECT seatNo FROM seat WHERE tripID='$tripID' AND status = 'booked'";
                $result2 = mysqli_query($conn, $sql2);
                while ($row = mysqli_fetch_assoc($result2)) {
                    $bookedSeats[] = $row['seatNo'];
                }


                ?>
                <?php
                $rowCounter = 1;
                $seat = 1;
                for ($row = 1; $row <= 11; $row++) {

                    echo '<div class="row">';
                    if ($row <= 9) {

                        // First 9 rows have 5 seats with an empty spot at the 3rd position
                        for ($spot = 1; $spot <= 6; $spot++) {

                            if ($spot == 3) {
                                echo '<div class="emp"></div>';
                            } else {
                                $isBooked = in_array($seat, $bookedSeats);
                                $style = $isBooked ? 'style="background-color: red; pointer-events: none;"' : '';
                                echo '<div class="seat" data-id="' . $seat . '" ' . $style . '>' . $seat . '</div>';
                                $seat++;
                            }
                        }
                    } elseif ($row == 10) {
                        // 10th row has first 3 spots empty and next 3 are seats
                        for ($spot = 1; $spot <= 6; $spot++) {
                            if ($spot <= 3) {
                                echo '<div class="emp"></div>';
                            } else {
                                $isBooked = in_array($seat, $bookedSeats);
                                $style = $isBooked ? 'style="background-color: red; pointer-events: none;"' : '';
                                echo '<div class="seat" data-id="' . $seat . '" ' . $style . '>' . $seat . '</div>';
                                $seat++;
                            }
                        }
                    } elseif ($row == 11) {
                        // 11th row has all spots as seats
                        for ($spot = 1; $spot <= 6; $spot++) {
                            $isBooked = in_array($seat, $bookedSeats);
                                $style = $isBooked ? 'style="background-color: red; pointer-events: none;"' : '';
                            echo '<div class="seat" data-id="' . $seat . '" ' . $style . '>' . $seat . '</div>';
                            $seat++;
                        }
                    }
                    echo '</div>';
                    $rowCounter++;
                }
                ?>

            </div>


            <div class="seat-details-form">
                <h1 class="booking-forrm-title">Seat Details</h1>
                <form action="bookingdetails.php" method="post" id="bookSeatForm" onsubmit="return validateForm()">
                    <div class="seat-detals-form-row">

                        <p>Seats ID: <span id="selected-seats"></span></p>
                    </div>
                    <div class="seat-detals-form-row">
                        <p>Total: <span id="total-cost">0</span></p>
                    </div>
                    <input type="hidden" name="tripID" value="<?php echo $tripID ?>" id="tripID">
                    <input type="hidden" name="origin" value="<?php echo $origin ?>" id="origin">
                    <input type="hidden" name="destination" value="<?php echo $destination ?>" id="destination">
                    <input type="hidden" name="arrivalTime" value="<?php echo $arrivalTime ?>" id="arrivalTime">
                    <input type="hidden" name="dur" value="<?php echo $duration ?>" id="dur">
                    <input type="hidden" name="departTime" value="<?php echo $departTime ?>" id="departTime">
                    <input type="hidden" name="tripDate" value="<?php echo $tripDate ?>" id="tripDate">
                    <input type="hidden" name="routeNo" value="<?php echo $routeNo ?>" id="routeNo">
                    <input type="hidden" name="via" value="<?php echo $via ?>" id="via">
                    <input type="hidden" name="regNo" value="<?php echo $regNo ?>" id="regNo">
                    <input type="hidden" name="fare" value="<?php echo $fare ?>" id="fare">
                    <input type="hidden" name="selectedSeats" id="selected-seats-input">
                    <input type="hidden" name="seatsCount" id="selected-seats-count-input">
                    <input type="hidden" name="totalCost" id="total-cost-input">
                    <div class="seat-detals-form-row">
                        <p>Boarding Point</p>
                        <select name="from" class="seat-details-form-input">
                            <?php


                            // Query to fetch cities associated with the selected route ID
                            $sql = "SELECT * FROM trip_stop
                                        INNER JOIN stop ON trip_stop.stopID = stop.stopID
                                        WHERE tripID = '$tripID' AND pointType='start'
                                        ORDER BY trip_stop.order_id";
                            $result = mysqli_query($conn, $sql);

                            $queryResults = mysqli_num_rows($result);
                            if ($queryResults > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $selected = isset($from) && $from == $row["city"] ? "selected='selected'" : "";
                                    echo "<option value='" . $row["city"] . "' $selected>" . $row["city"] . "</option>";
                                }
                            }

                            ?>
                        </select>
                    </div>
                    <div class="seat-detals-form-row">
                        <p>Dropping Point</p>
                        <select name="to" class="seat-details-form-input">
                            <?php

                            // Query to fetch cities associated with the selected route ID
                            $sql = "SELECT * FROM trip_stop
                                        INNER JOIN stop ON trip_stop.stopID = stop.stopID
                                        WHERE tripID = '$tripID' AND pointType='end'
                                        ORDER BY trip_stop.order_id";
                            $result = mysqli_query($conn, $sql);

                            $queryResults = mysqli_num_rows($result);
                            if ($queryResults > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $selected = isset($to) && $to == $row["city"] ? "selected='selected'" : "";
                                    echo "<option value='" . $row["city"] . "' $selected>" . $row["city"] . "</option>";
                                }
                            }

                            ?>
                        </select>
                    </div>




                    <button type="submit" name="bookseat" class="payment">Proceed</button>
                </form>
            </div>



        </div>











        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectedSeats = new Set(); // Store selected seat IDs

                // Function to toggle seat selection
                function toggleSeatSelection(seatId) {
                    const seat = document.querySelector(`.seat[data-id="${seatId}"]`);
                    if (selectedSeats.has(seatId)) {
                        selectedSeats.delete(seatId);
                        seat.style.backgroundColor = 'white'; // Deselect seat
                    } else {
                        if (selectedSeats.size < 6) {
                            selectedSeats.add(seatId);
                            seat.style.backgroundColor = '#4CAF50'; // Select seat (green)
                        } else {
                            alert('You can select up to 6 seats.');
                        }
                    }
                    updateSelectedSeatsDisplay();
                }

                function updateSelectedSeatsDisplay() {
                    const selectedSeatsElement = document.getElementById('selected-seats');
                    const seatsCountElement = document.getElementById('selected-seats-count-input');
                    const seatsCount = selectedSeats.size;
                    selectedSeatsElement.innerText = Array.from(selectedSeats).join(', ');
                    document.getElementById('selected-seats-input').value = Array.from(selectedSeats).join(',');
                    seatsCountElement.value = seatsCount;
                    calculateTotalCost();
                }

                // Calculate total cost based on selected seats count
                function calculateTotalCost() {
                    const totalCostElement = document.getElementById('total-cost');
                    const totalCost = selectedSeats.size * busFare;
                    totalCostElement.innerText = totalCost;
                    document.getElementById('total-cost-input').value = totalCost;
                }

                // Add click event listener to each seat
                document.querySelectorAll('.seat').forEach(seat => {
                    const seatId = seat.getAttribute('data-id');
                    seat.addEventListener('click', function() {
                        toggleSeatSelection(seatId);
                    });
                });

                // Add click event listener to payment button (just for example)
                document.querySelector('.payment').addEventListener('click', function() {
                    // You can perform payment-related actions here

                });

            });

            function validateForm() {
                // Get selected seats

                const selectedSeatsCount = document.getElementById('selected-seats-count-input').value;

                // Check if any seats are selected
                if (selectedSeatsCount == 0) {
                    alert('Please select at least one seat.');
                    return false; // Prevent form submission
                }

                return true; // Allow form submission
            }
        </script>
        
<script>
    localStorage.removeItem("count_timer_2");
    localStorage.removeItem("count_timer_3");
    // Initialize countdown timer from localStorage or set to default of 5 minutes
    var count_timer = localStorage.getItem("count_timer") || 60 * 5;

    function countDownTimer() {
        var minutes = parseInt(count_timer / 60); // Calculate minutes
        var seconds = count_timer % 60; // Calculate seconds

        // Format minutes and seconds with leading zeros if necessary
        var formattedMinutes = minutes < 10 ? "0" + minutes : minutes;
        var formattedSeconds = seconds < 10 ? "0" + seconds : seconds;

        // Update timer display
        document.getElementById("timer").innerHTML = formattedMinutes + ":" + formattedSeconds;

        // Store countdown value in localStorage
        localStorage.setItem("count_timer", count_timer);

        // Check if countdown reached zero
        if (count_timer <= 0) {
            

            count_timer = 60 * 5;
            location.reload();
            countDownTimer();
        } else {
            // Decrement countdown and update minutes and seconds accordingly
            count_timer--;
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_temp_booking10.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    
                    
                }
            };
            xhr.send();
            // Call countDownTimer function again after 1 second
            setTimeout(countDownTimer, 1000);
        }
    }

    // Start countdown timer
    countDownTimer();

  
</script>
    </section>


</main>