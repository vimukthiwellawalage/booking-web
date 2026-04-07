<?php
session_start();
require_once("db_conn.php");
include("header.php");

if (isset($_POST["bookingdetails"])) {
  
  
    
    $namePass = mysqli_real_escape_string($conn, $_POST["namePass"]);
    $nic = mysqli_real_escape_string($conn, $_POST["nic"]);
    $phoneNo = mysqli_real_escape_string($conn, $_POST["phoneNo"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);

    $_SESSION['booking-info']["namePass"] = $namePass;
    $_SESSION['booking-info']["nic"] = $nic;
    $_SESSION['booking-info']["phoneNo"] = $phoneNo;
    $_SESSION['booking-info']["email"] = $email;

    
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
                    <span class="dot"><i id="check" class="bi bi-check"></i></span>
                    <div class="flow-line"></div>
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
            <div class="time-box-3">
                <div class="time-container">
                <p id="timer-3"></p>
                </div>
            </div>


        </section>



        <section class="payment-form">
            <h1 class="booking-form-title" style="color: white;">Enter Your Payment Details</h1>
            <form action="db_model.php" method="post" onsubmit="return validatePayment()">
            <div class="payment-details">
                
                <div class="payment-details-form-row">

                    <label class="payment-details-form-label">Card Type</label>
                    <input class="payment-details-form-input-radio" name="card-type" type="radio" value="visa" ><img class="cards" src="images/visa.jpg"/><p class="cardname">Visa</p>
                    <input class="payment-details-form-input-radio" name="card-type" type="radio" value="mastercard" ><img class="cards" src="images/mastercard.webp"/><p class="cardname">MasterCard</p>
                </div>
                <p id="error-cardtype" class="error-payment"></p>
                <div class="payment-details-form-row">

                    <label class="payment-details-form-label">Card Number</label>
                    <input class="payment-details-form-input-long" placeholder="Card Number" id="cardNo" type="text" >
                </div>
                
                <p id="error-cardnumber" class="error-payment"></p>
               
                <div class="payment-details-form-row">

                    <label class="payment-details-form-label">Expiry Date</label>
                    <input class="payment-details-form-input-medium" placeholder="MM/DD" id="exp" type="text" >
                </div>
                <p id="error-expdate" class="error-payment"></p>
                <div class="payment-details-form-row">

                    <label class="payment-details-form-label">CVV</label>
                    <input class="payment-details-form-input-short" placeholder="CVV" id="cvv"  type="text" >
                    <img class="cards" src="images/cvv.png"/>
                </div>
                <p id="error-cvv" class="error-payment"></p>
                <input type="hidden" name="tripID" value="<?php echo $tripID ?>">
                    
                <div class="payment-details-form-row-button">

                    <button name="paymentdetails" type="submit" class="payment-details-submit-button">Pay</button>
                </div>
                
            </div>
            </form>

        </section>
    </main>
</body>

<script>
function validatePayment() {

    var cardNo = document.getElementById("cardNo").value;
    var exp = document.getElementById("exp").value;
    var cvv = document.getElementById("cvv").value;

    // Card type validation
    var cardTypeChecked = false;
    var cardTypeRadios = document.getElementsByName("card-type");
    for (var i = 0; i < cardTypeRadios.length; i++) {
        if (cardTypeRadios[i].checked) {
            cardTypeChecked = true;
            break;
        }
    }
    if (!cardTypeChecked) {
        document.getElementById("error-cardtype").innerHTML = "Please select a card type";
        return false;
    } else {
        document.getElementById("error-cardtype").innerHTML = ""; // Clear error message if a card type is selected
    }

    // Card number validation
    var cardNoRegex = /^\d{4}(?:\s\d{4}){3}$/;
if (!cardNoRegex.test(cardNo)) {
    document.getElementById("error-cardnumber").innerHTML = "Please enter a valid card number";
    document.getElementById("cardNo").focus();
    return false;
} else {
    document.getElementById("error-cardnumber").innerHTML = ""; // Clear error message if card number is valid
}

    // Expiry date validation (assuming format MM/YY)
    var expRegex = /^(0[1-9]|1[0-2])\/[0-9]{2}$/;
    if (!expRegex.test(exp)) {
        document.getElementById("error-expdate").innerHTML = "Please enter a valid expiry date (MM/YY format).";
        document.getElementById("exp").focus();
        return false;
    } else {
        document.getElementById("error-expdate").innerHTML = ""; // Clear error message if expiry date is valid
    }

    // CVV validation
    var cvvRegex = /^[0-9]{3}$/;
    if (!cvvRegex.test(cvv)) {
        document.getElementById("error-cvv").innerHTML = "Please enter a valid CVV (3 digits).";
        document.getElementById("cvv").focus();
        return false;
    } else {
        document.getElementById("error-cvv").innerHTML = ""; // Clear error message if CVV is valid
    }

    return true; // Form submission allowed
}

// Function to add automatic spacing after every 4 characters in the card number input
document.getElementById("cardNo").addEventListener("input", function() {
    var cardNoInput = this.value.replace(/\s+/g, ''); // Remove any existing spaces
    var formattedCardNo = cardNoInput.replace(/(\d{4})/g, '$1 ').trim(); // Add space after every 4 characters
    this.value = formattedCardNo;
});
</script>



 
<script>


    localStorage.removeItem("count_timer_2");
    localStorage.removeItem("count_timer");
 

    // Initialize countdown timer from localStorage or set to default of 5 minutes
    var count_timer_3 = localStorage.getItem("count_timer_3") || 60 * 5;

    function countDownTimer() {
    var minutes = parseInt(count_timer_3 / 60); // Calculate minutes
    var seconds = count_timer_3 % 60; // Calculate seconds

    // Format minutes and seconds with leading zeros if necessary
    var formattedMinutes = minutes < 10 ? "0" + minutes : minutes;
    var formattedSeconds = seconds < 10 ? "0" + seconds : seconds;

    // Update timer display
    document.getElementById("timer-3").innerHTML = formattedMinutes + ":" + formattedSeconds;

    // Store countdown value in localStorage
    localStorage.setItem("count_timer_3", count_timer_3);

    // Check if countdown reached zero
    if (count_timer_3 <= 0) {
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
        count_timer_3--;

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
