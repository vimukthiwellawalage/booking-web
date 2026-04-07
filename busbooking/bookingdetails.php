<?php
session_start();
require_once("db_conn.php");
include("header.php");


if (isset($_POST["bookseat"])) {
     $tripID = mysqli_real_escape_string($conn, $_POST["tripID"]);
    $routeNo = mysqli_real_escape_string($conn, $_POST["routeNo"]);
    $via = mysqli_real_escape_string($conn, $_POST["via"]);
    $origin = mysqli_real_escape_string($conn, $_POST["origin"]);
    $destination = mysqli_real_escape_string($conn, $_POST["destination"]);
    $from = mysqli_real_escape_string($conn, $_POST["from"]);
    $to = mysqli_real_escape_string($conn, $_POST["to"]);
    $tripDate = mysqli_real_escape_string($conn, $_POST["tripDate"]);
    $regNo = mysqli_real_escape_string($conn, $_POST["regNo"]);
    $departTime = mysqli_real_escape_string($conn, $_POST["departTime"]);
    $arrivalTime = mysqli_real_escape_string($conn, $_POST["arrivalTime"]);
    $dur = mysqli_real_escape_string($conn, $_POST["dur"]);
    $selectedSeats = mysqli_real_escape_string($conn, $_POST["selectedSeats"]);
    $seatsCount = mysqli_real_escape_string($conn, $_POST["seatsCount"]);  
    $totalCost = mysqli_real_escape_string($conn, $_POST["totalCost"]);
    $fare = mysqli_real_escape_string($conn, $_POST["fare"]);

    $totalCost= doubleval($totalCost);
    $serviceCharge=100.00;
    $totalPayment = $totalCost+$serviceCharge;


    $sql4 = "INSERT INTO temp_booking ( tripID, noOfSeats) VALUES ('$tripID','$seatsCount')";
    if (!mysqli_query($conn, $sql4)) {
        die("Error inserting trip booking data: " . mysqli_error($conn));
    }

    $tempBookingID = mysqli_insert_id($conn);
    // Insert seat data
    $selectedSeatsArr = explode(",", $selectedSeats);
    foreach ($selectedSeatsArr as $seat) {
        $seatNo = mysqli_real_escape_string($conn, $seat);
        $sql5 = "INSERT INTO seat (tripID, tempBookingID, seatNo) VALUES ('$tripID', '$tempBookingID', '$seatNo')";
        if (!mysqli_query($conn, $sql5)) {
            die("Error inserting seat data: " . mysqli_error($conn));
        }
    }

    // Update available seats
    $sql6 = "UPDATE trip SET avaSeats = avaSeats - $seatsCount WHERE tripID = '$tripID'";
    if (!mysqli_query($conn, $sql6)) {
        die("Error updating available seats: " . mysqli_error($conn));
    }

    $_SESSION['booking-info'] = array(
        'tripID' => $tripID,
        'routeNo' => $routeNo,
        'via' => $via,
        'origin' => $origin,
        'destination' => $destination,
        'from' => $from,
        'to' => $to,
        'tripDate' => $tripDate,
        'regNo' => $regNo,
        'departTime' => $departTime,
        'arrivalTime' => $arrivalTime,
        'dur' => $dur,
        'tempBookingID' => $tempBookingID,
        'selectedSeats' => $selectedSeats,
        'seatsCount' => $seatsCount,
        'fare' => $fare,
        'totalPayment' => $totalPayment
    );
    
}
   

?>
    <main>

        <section class="flow">
            <div class="flow-bar">
                <div class="flow-visual">
                    <div class="flow-line"></div>
                    <span class="dot"><i id="check" class="bi bi-check"></i></span>
                    <div class="flow-line"></div>
                    <span class="dot"><i id="check" class="bi bi-check"></i></span>
                    <div class="flow-line"></div>
                    <span class="emp-dot"><i id="emp-check" class="bi bi-check"></i></span>
                    <div class="emp-flow-line"></div>
                    <span class="emp-dot"><i id="emp-check" class="bi bi-check"></i></span>
                    <div class="emp-flow-line"></div>
                </div>
                <div class="flow-titles">
                    <div class="flow-title-1">
                        <p>
                            Find Bus
                        </p>

                    </div>
                    <div class="flow-title-1">
                        <p>
                            Select Seat
                        </p>

                    </div>
                    <div class="flow-title-1">
                        <p>
                            Booking Details
                        </p>

                    </div>
                    <div class="flow-title-1">
                        <p>
                            Checkout
                        </p>

                    </div>
                    
                    
                    
                    
                </div>

            </div>
            

            <div class="time-box-2">
                <div class="time-container">
                <p id="timer-2"></p>
                </div>
            </div>
        </section>

        <section class="booking-forms">
            <div class="booking-form">
                
                    <h1 class="booking-form-title">Booking Details</h1>
                    <form action="paymentdetails.php" method="post" id="bookingdetails" onsubmit="return validateForm()">
                    <div class="seat-detals-form-row">
    
                        <label class="form-label">Name</label>
                        <input class="seat-details-form-input" name="namePass" id="namePass" type="text" placeholder="Name">
                    </div>
                    <div class="seat-detals-form-row">
                        <label class="form-label">NIC</label>
                        <input class="seat-details-form-input" name="nic" id="nic" type="text" placeholder="NIC">
                    </div>
                    <div class="seat-detals-form-row">
                        <label class="form-label">Phone Number</label>
                        <input class="seat-details-form-input" name="phoneNo" id="phoneNo" type="text" placeholder="Phone No">
                    </div>
                    <div class="seat-detals-form-row">
                        <label class="form-label">Email</label>
                        <input class="seat-details-form-input" name="email" id="email" type="text" placeholder="Email">
                    </div>
                    
                    
                    <button type="submit" name="bookingdetails" class="payment">Proceed</button></form>
                

            </div>
            <div class="journey-summary">
                <div class="booked-seats-summary">
                    <p class="booking-form-sub-title-seats">Seat No: </p>
                    <p class="booking-form-sub-title-seats"><?php echo $selectedSeats?></p>
                    
                    

                </div>
                <div class="journey-information-summary">
                    
                        <p class="booking-form-sub-title">Journey Summary</p>

                        <div class="journey-summary-form-row">
    
                            <p class="summary-title">Bus Number</p>
                            <p class="summary-sub-title"><?php echo $regNo ?></p>
                            
                        </div>
                        
                        <div class="journey-summary-main-box">
                            <div class="journey-summary-sub-box">
                                <p class="summary-sub-box-title">Departure</p>
                                <p class="summary-sub-box-context"><?php echo $origin ?></p>
                                <p class="summary-sub-box-title">Time</p>
                                <p class="summary-sub-box-context"><?php echo $departTime ?></p>

                            </div>
                            <div class="journey-summary-sub-box">
                                <p class="summary-sub-box-title">Arrival</p>
                                <p class="summary-sub-box-context"><?php echo $destination ?></p>
                                <p class="summary-sub-box-title">Time</p>
                                <p class="summary-sub-box-context"><?php echo $arrivalTime ?></p>

                            </div>
                            
                        </div>
                        <div class="journey-summary-form-row">
    
                            <p class="summary-title">Date</p>
                            <p class="summary-sub-title"><?php echo $tripDate ?></p>
                            
                        </div>
                        
                        
    
                    </div>
                    <div class="fare-breakdown">
                        <p class="booking-form-sub-title-fare">Fare Breakdown</p>
                        <div class="fare-calculation">
                            <div class="fare-breakdown-form-column">
        
                                <p class="summary-sub-box-title">Bus Fare</p>
                                <p class="summary-sub-box-title">Service Charge</p>
                                <p class="summary-sub-box-title">Total payment</p>

                                
                            </div>
                            <div class="fare-breakdown-form-column">
        
                                <p class="summary-sub-box-context-fare-breakdown">Rs <?php echo $totalCost ?>.00</p>
                                <p class="summary-sub-box-context-fare-breakdown">Rs <?php echo $serviceCharge ?>.00</p>
                                <p class="summary-sub-box-context-fare-breakdown">Rs <?php echo $totalPayment ?>.00</p>
                                
                            </div>

                        </div>
    
                            
                            
                            
                            
    
                    </div>

            </div>
                

            

        </section>
    </main>
    </body>

    <script>


function validateForm() {
    var namePass = document.getElementById("namePass").value;
    var nic = document.getElementById("nic").value;
    var phoneNo = document.getElementById("phoneNo").value;
    var email = document.getElementById("email").value;

    if (namePass.trim() === "") {

        document.getElementById("namePass").focus();
        return false;
    }

    if (nic.trim() === "") {

        document.getElementById("nic").focus();
        return false;
    }

    if (phoneNo.trim() === "") {
    
        document.getElementById("phoneNo").focus();
        return false;
    }

    if (!validatePhoneNumber(phoneNo)) {
        
        document.getElementById("phoneNo").focus();
        return false;
    }

    if (email.trim() === "") {
        
        document.getElementById("email").focus();
        return false;
    }

    if (!validateEmail(email)) {
        
        document.getElementById("email").focus();
        return false;
    }

    return true;
}

function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function validatePhoneNumber(phoneNo) {
    var re = /^\d{10}$/;
    return re.test(phoneNo);
}





</script>




 
<script>


    localStorage.removeItem("count_timer");
    localStorage.removeItem("count_timer_3");

    // Initialize countdown timer from localStorage or set to default of 5 minutes
    var count_timer_2 = localStorage.getItem("count_timer_2") || 60 * 5;

    function countDownTimer() {
    var minutes = parseInt(count_timer_2 / 60); // Calculate minutes
    var seconds = count_timer_2 % 60; // Calculate seconds

    // Format minutes and seconds with leading zeros if necessary
    var formattedMinutes = minutes < 10 ? "0" + minutes : minutes;
    var formattedSeconds = seconds < 10 ? "0" + seconds : seconds;

    // Update timer display
    document.getElementById("timer-2").innerHTML = formattedMinutes + ":" + formattedSeconds;

    // Store countdown value in localStorage
    localStorage.setItem("count_timer_2", count_timer_2);

    // Check if countdown reached zero
    if (count_timer_2 <= 0) {
        // If timer is over, delete temp booking and redirect to index.php
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_temp_booking.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Redirect to index.php
                window.location.href = "index.php";
            }
        };
        xhr.send();
    } else {
        // Decrement countdown and update minutes and seconds accordingly
        count_timer_2--;

        // Execute the XMLHttpRequest in every second
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_temp_booking10.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle the response if needed
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

</html>