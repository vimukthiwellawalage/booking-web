<?php
session_start();
unset($_SESSION['booking-info']);
require_once("db_conn.php");
include("header.php");
if (isset($_POST["submit-index"])) {
    $from = $_POST["from"];
    $to = $_POST["to"];
    $date = $_POST["date"];
    
}
?>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<main>
    <section class="seat-booking-background">
        <div class="cover-image">


            <div class="title">
                <h1>Online Seat Booking</h1>
            </div>
            <div class="seat-booking-bar">
                <form action="findbus.php" method="post" id="findBusForm" onsubmit="return validateInputs()">
                    <div class="selection-bar">


                        <input type="text" placeholder="From" name="from" id="from" class="input" />

                        <input type="text" placeholder="To" name="to" id="to" class="input" />




                        <input name="date" id="date" class="input-date" placeholder="Travel Date" value="" type="date" min="<?php echo date('Y-m-d'); ?>">
                        <button name="submit-index" class="input-submit" type="submit">Submit</button>

                    </div>
                </form>
                <div class="suggestion-box-from">
                    <ul id="dropdatafrom" class="suggestion-list">


                    </ul>
                </div>
                <div class="suggestion-box-to">
                    <ul id="dropdatato" class="suggestion-list">

                    </ul>
                </div>
            </div>




        </div>


    </section>
    <script>
        // Function to hide suggestion boxes
        function hideSuggestionBoxes() {
            $(".suggestion-box-from").hide();
            $(".suggestion-box-to").hide();
        }

        // Attach scroll event listener to window
        window.addEventListener('scroll', function() {
            // Call hideSuggestionBoxes function when scroll event occurs
            hideSuggestionBoxes();
        });

        // Rest of your existing script
        $("#from").keyup(function() {
            $(".suggestion-box-to").hide();
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
                $(".suggestion-box-from").show();
            } else {
                $(".suggestion-box-from").hide();
            }
        });

        $("#to").keyup(function() {
            $(".suggestion-box-from").hide();
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
                $(".suggestion-box-to").show();
            } else {
                $(".suggestion-box-to").hide();
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


    <section class="block">
        <h1 class="block-heading">Welcome to EzBusLk</h1>
        <div class="block-container">
            <div class="sub-block">
                <p>ezBusLK is a pioneering online platform revolutionizing the bus ticket booking experience in Sri Lanka.
                    With a user-centric approach, ezBusLK offers a seamless solution for passengers to secure their bus
                    seats conveniently and efficiently, eliminating the hassle of traditional ticket booking methods.
                    The platform's intuitive interface empowers users to browse through a wide range of bus operators, routes,
                    and schedules, allowing them to select their preferred journey with ease. </p>
            </div>
            <div class="sub-block">
                <p>
                    Beyond its user-friendly interface, ezBusLK prioritizes reliability and customer satisfaction,
                    aiming to enhance the overall travel experience for its users. With features like real-time bus tracking,
                    passengers can stay informed about their journey's progress, minimizing uncertainties and delays. Moreover,
                    ezBusLK's commitment to transparency and accessibility extends to its customer support system, where
                    dedicated assistance is available to address any queries or concerns promptly.
                </p>
            </div>

        </div>
        <a href="viewSchedule.php"><button class="button-main">View Schedule</button></a>


    </section>

    <section class="chatbot1971">
    <div class="main-div">
        <div class="menuToggle">
            <i class='bx bx-help-circle'></i>
        </div>
        <div class="container">
            <div class="top-part">
                <div class="agent-details">
                <img src="ezbus.jpg" alt="">
                <div class="agent-text">
                <h3>EZ Bus</h3>
                <p>Chat bot <span>(Online)</span></p>
            </div>
        </div>
        <i class='bx bx-x' ></i>
        </div>
        <ul class ="chatbox">
            <li class="chat incoming">
                <P>Hi there 👋 </P>
            </li>
        </ul>
        <div class="chat-input">
            <textarea id="messageInput" placeholder="Enter a message...." required></textarea>
            <i class='bx bx-send'></i>
        </div>
       
    </div>

    </section>
    <style>
@import url('https://fonts.googleapis.com/css?family=Poppins');



.chatbot1971 .menuToggle {
    position: fixed; 
    bottom: 10px;
    height: 30px;
    width: 30px;
    right: 10px;
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 0 10px #000;
    border-radius: 50%;
    cursor: pointer;
}

.chatbot1971 .menuToggle i{
    font-size: 20px;
    color: #0f0f20;
}

.chatbot1971 .container {
    height: 0%;
    width: 0%;
    border: 3px solid rgba(0, 0, 0, 0.5);
    border-radius: 20px;
    background: #fff;
    overflow: hidden;
    position: fixed; 
    right: 10px;
    bottom: 1px;
    transition: 5s, height 0.5s, width 0.5s;
}

.chatbot1971 .active {
    height: 500px;
    width: 320px;
    z-index: 1;
}

.chatbot1971 .top-part {
    height: 90px;
    background: #0f0f20;
    display: flex;
    justify-content: space-around;
    align-items: center;
}

.chatbot1971 .top-part i{
    font-size: 20px;
    cursor: pointer;
    color: #ffff;
}

.chatbot1971 .agent-details{
    display: flex;
    align-items: center;
}

.chatbot1971 .agent-details img{
    height: 50px;
    border: 2px solid #fff;
    border-radius: 50%;
    background: #fff;
}

.chatbot1971 .agent-text{
    margin-left: 15px;
}

.chatbot1971 .agent-text h3{
    color: #ffff;
    font-size: 12px;
}

.chatbot1971 .agent-text p{
    font-size: 10px;
    color: #ffff;
}

.chatbot1971 .agent-text span{
    color: #0f0;
}

.chatbot1971 .chat-section{
    position: relative;
}

.chatbot1971 .left-part{
    margin: 22px 0;
    max-width: 260px;
}

.chatbot1971 .left-part img{
    height: 10px;
    background: #0f0f20;
    border-radius: 50%;
}

.chatbot1971 .left-part p{
    font-size: 10px;
    color: #555;
}

.chatbot1971 .agent-chart{
    display: flex;
    align-items: center;
}

.chatbot1971 .img1{
    height: 35px;
    background: #0f0f20;
    border-radius: 50%;
}

.chatbot1971 .left-part p{
    color: #000000;
    font-weight: 400;
    font-size: 12px;
    background: rgb(114, 114, 114);
    border-radius: 10px;
    padding: 10px;
    margin-left: 10px;
}

.chatbot1971 .bottom-section{
    position: absolute;
    bottom: 10px;
    height: 30px;
    display: flex;
    justify-content: space-around;
    align-items: center;
    width: 100%;
    border-top: 2px solid rgba(0, 0, 0, 0.1);
    padding: 10px;
}

.chatbot1971 .bottom-section i{
    color: #0f0f20;
    font-size: 20px;
}

.chatbot1971 .bottom-section textarea{
    height: 28px;
    width: 80%;
    color: #0f0f20;
    padding: 0 5px;
    resize: none;
    outline: none;
    border: none;
    text-transform: capitalize;
}
.chatbot1971 .right-part {
    display: none; 
    display: flex;
    justify-content: flex-end;
    margin: 10px 0;
    max-width: 150px;
    margin-right: -300px;
}

.chatbot1971 .right-part .agent-chart {
    display: flex;
    flex-direction: row-reverse; 
    text-align: right;
}

.chatbot1971 .right-part .agent-chart img {
    height: 35px;
    background: #0f0f20;
    border-radius: 50%;
    margin-right: -160px;
}

.chatbot1971 .right-part .agent-chart p2 {
    color: #ffffff;
    max-width: 180px;
    text-align: left;
    font-size: 12px;
    background: rgb(0, 0, 0);
    border-radius: 10px;
    padding: 10px;
    margin-right: 10px;
}

.chatbot1971 .more-options-container {
    margin-top: 10px; 
}

.chatbot1971 .more-options-container button {
    margin-right: 5px; 
    font-size: 12px;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
}

.chatbot1971 .more-options-container button:hover {
    background-color: #0056b3;
}

.chatbot1971 .chatbox {
    height: 420px;
    overflow-y: auto;
    padding: 15px 20px 100px;
}

.chatbot1971 .chatbox .chat {
    display: flex;
}

.chatbot1971 .chatbox .chat p {
    color: #fff;
    font-size: 12px;
    white-space: pre-wrap;
    padding: 12px 16px;
    border-radius: 10px 10px 0px 10px;
    background-color: #0f0f20;
}

.chatbot1971 .chatbox .incoming p {
    color: #000;
    max-width: 200px;
    text-align: left;
    background: #9e9a9a;
    border-radius: 10px 10px 10px 0;
}

.chatbot1971 .chatbox .incoming p1 {
    color: #000;
    max-width: 200px;
    background: #9e9a9a;
    border-radius: 10px 10px 10px 0;
}

.chatbot1971 .chatbox .incoming p3 {
    color: #0f0f20;
    max-width: 200px;
    font-size: 16px;
    text-align: center;
    margin-bottom: 10px;
    font-weight: bold;
    background: #9e9a9a;
    border-radius: 10px 10px 10px 0;
}

.chatbot1971 .chatbox .incoming .span {
    height: 32px;
    width: 32px;
    color: #fff;
    align-self: flex-end;
    background: #724ae8;
    text-align: center;
    line-height: 32px;
    border-radius: 4px;
    margin: 0 10px 7px 0;
}

.chatbot1971 .chatbox .outgoing {
    margin: 20px 0;
    max-width: 250px;
    justify-content: flex-end;
}

.chatbot1971 .chat-input {
    position: absolute;
    bottom: 0;
    width: 100%;
    display: flex;
    gap: 5px;
    background: #fff;
    padding: 5px 20px;
    border-top: 1px solid #ccc;
}

.chatbot1971 .chat-input textarea {
    height: 55px;
    width: 100%;
    border: none;
    outline: none;
    color: #0f0f20;
    font-size: 0.95rem;
    resize: none;
    padding: 16px 15px 16px 0;
}

.chatbot1971 .chat-input i {
    align-self: flex-end;
    height: 55px;
    line-height: 55px;
    color: #724ae8;
    font-size: 1.35rem;
    cursor: pointer;
    visibility: hidden;
}

.chatbot1971 .chat-input textarea:valid ~ i {
    visibility: visible;
}
.chatbot1971 .chatbox .incoming button {
    display: block;
    width: 100%;
    padding: 10px;
    margin-top: 7px;
    background-color: #606560; 
    border: black;
    border-radius: 5px;
    color: white;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
}

.chatbot1971 .chatbox .incoming button:hover {
    background-color: #3d3f3d;
}

.chatbot1971 .chatbox .incoming button + button {
    margin-top: 10px;
}

.chatbot1971 .button {
    display: block;
    width: 100%;
    padding: 10px;
    margin-top: 7px;
    background-color: #606560; 
    border: black;
    border-radius: 5px;
    color: white;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
}

.chatbot1971 .button:hover {
    background-color: #3d3f3d;
}

        
        </style>
    <script>


        document.addEventListener("DOMContentLoaded", function() {

        var messageInput = document.getElementById("messageInput");

        messageInput.value = "Hi chatbot I want a Help..";
    });

        const chatInput = document.querySelector(".chat-input textarea");
        const sendChatBtn = document.querySelector(".chat-input i");
        const chatbox = document.querySelector(".chatbox");
    
        let userMessage;
        const createChatLi = (message, className) => {
    const chatLi = document.createElement("li");
    chatLi.classList.add("chat", className);
    chatLi.innerHTML = `<p>${message}</p>`;
    return chatLi;
}
        const handleChat = () => {
            userMessage = chatInput.value.trim();
            if (!userMessage) return;
            const isOutgoing = chatbox.lastElementChild && chatbox.lastElementChild.classList.contains("outgoing");
            chatbox.appendChild(createChatLi(userMessage, "outgoing"));
            setTimeout(() => {
                if (userMessage.toLowerCase() === "hi chatbot i want a help.." || isOutgoing) {
                    const buttonLi = createChatLi("<p1>Dear passenger<br>Choose an option.</p1> <button>Booking</button> <button>Tracking</button> <button>Payment</button> <button>Contact The Admin</button>", "incoming");
                    chatbox.appendChild(buttonLi);
                    buttonLi.querySelectorAll('button').forEach(button => {
                        button.addEventListener('click', handleButtonClick);
                    });
                } else {
                    setTimeout(() => {
                        chatbox.appendChild(createChatLi("Thinking....", "incoming"));
                    }, 1000);
                }
            }, 1000);
            chatInput.value = "";
        }
        let bookingInitiated = false;

const handleButtonClick = (event) => {
    const buttonText = event.target.textContent;
    chatbox.appendChild(createChatLi(buttonText, "outgoing")); 
    setTimeout(() => {
        if (!bookingInitiated) {
            switch(buttonText.toLowerCase()) {
                case "booking":
                    chatbox.appendChild(createChatLi("<p3>....Booking....</p3> <button>Make Booking</button> <button>View Booking</button> <button>View Schedule</button>", "incoming")); // Change "outgoing" to "incoming"
                    bookingInitiated = true;
                    break;
                case "tracking":
                    chatbox.appendChild(createChatLi("Dear passenger,<br><br>Firstly, book your bus seat. Following this, we'll provide you with a tracking ID and a link via email. You can utilize this information to track your traveling bus.<br><br>Thank You,<br><a href=\"https://mail.google.com/mail/u/0/#search/l.sharneesh%40gmail.com\" class=\"button\" target=\"_blank\">Go To Gmail and Search</a>", "incoming"));
                    break;
                case "payment":
                    chatbox.appendChild(createChatLi("Dear passenger,<br><br>we only accept card payments for Ezbus bookings. In the future, we aim to enhance our payment options to include QR payments. When using a Commerce Bank card, there will be no additional tax of 30/=. However, if any other card is used, a tax of 30/= will apply.<br><br>Thank You.<br>", "incoming")); // Change "outgoing" to "incoming"
                    break;
                    case "contact the admin":
                    chatbox.appendChild(createChatLi("Dear Passenger,<br><br>If you're unable to click the button below, please send an email request directly to the admin to initiate contact.<br><br><a href=\"https://mail.google.com/mail/?view=cm&fs=1&to=l.sharneesh@gmail.com&su=Message%20from%20ChatBot&body=Dear%20Admin,%0D%0A%0D%0AI%20am%20interested%20in%20obtaining%20more%20information%20about%20EZbuslk.%20Could%20you%20please%20contact%20me%20at%20your%20earliest%20convenience%20to%20provide%20further%20details%3F%0D%0A%0D%0AThank%20you.\" class=\"button\" target=\"_blank\">Go To Gmail</a><br><br>Thank you.", "incoming")); // Change "outgoing" to "incoming"
                    break;
                default:
                    break;
            }
        } else {

            switch(buttonText.toLowerCase()) {
                case "make booking":
                    chatbox.appendChild(createChatLi("Booking in progress...", "incoming"));
                    break;
                case "view booking":
                    chatbox.appendChild(createChatLi("Viewing booking...", "incoming"));
                    break;
                case "view schedule":
                    chatbox.appendChild(createChatLi("Viewing schedule...", "incoming"));
                    break;
                default:
                    break;
            }
        }
    }, 1000);
}




        sendChatBtn.addEventListener("click", handleChat);
        document.addEventListener("DOMContentLoaded", function() {
    const menuToggle = document.querySelector('.menuToggle');
    const closeButton = document.querySelector('.container .bx-x'); 
    const container = document.querySelector('.container');
    
    menuToggle.onclick = function() {
        container.classList.toggle('active');
    };

    closeButton.onclick = function() {
        container.classList.remove('active'); 
    };
            document.getElementById("leftPart").style.display = "none";
        });

        window.addEventListener('scroll', function() {
    var container = document.querySelector('.container');
    var menuToggle = document.querySelector('.menuToggle');
    
    if (window.scrollY > 100) { 
        container.style.bottom = '10px';
        menuToggle.style.bottom = '20px';
    } else {
        container.style.bottom = '1px';
        menuToggle.style.bottom = '10px';
    }
});


    </script>

    



    <section class="blue-block">

        <div class="img-text-block-container">

            <div class="img-subblock">
                <img class="subblock-img" src="images/BusSeatBooking.png">
            </div>
            <div class="text-subblock">
                <h1 class="subblock-heading">Your Seat, Your Journey - Book Hassle-Free</h1>
                <p class="subblock-paragraph">


                    With ezBusLK's bus seat booking service, passengers can reserve their desired seats for
                    their journey with utmost convenience. Whether it's a window seat for scenic views or
                    an aisle seat for easy access, travelers can choose their preferred spot with just a few clicks.
                    Say goodbye to long queues and last-minute rushes – ezBusLK ensures a seamless booking experience
                    for every passenger.
                </p>

                <div style="float: right;" class="link-box">
                    <a href="#">Book Seat</a>
                </div>
            </div>
        </div>



    </section>


    <section class="skyblue-block">

        <div class="img-text-block-container">


            <div class="text-subblock">
                <h1 class="skyblue-subblock-heading">View Bus Schedule
                    Plan Your Journey, Your Way</h1>
                <p class="subblock-paragraph">



                    With ezBusLK's bus seat booking service, passengers can reserve their desired seats
                    for their journey with utmost convenience. Whether it's a window seat for scenic views
                    or an aisle seat for easy access, travelers can choose their preferred spot with just
                    a few clicks. Say goodbye to long queues and last-minute rushes – ezBusLK ensures a
                    seamless booking experience for every passenger.
                </p>

                <div style="float: left;" class="link-box">
                    <a href="viewSchedule.php">View Schedule</a>
                </div>
            </div>
            <div class="img-subblock">
                <img class="subblock-img" src="images/BusShedule.png">
            </div>
        </div>



    </section>
    <section class="blue-block">

        <div class="img-text-block-container">

            <div class="img-subblock">
                <img class="subblock-img" src="images/BusTracking.png">
            </div>
            <div class="text-subblock">
                <h1 class="subblock-heading">Real-Time Tracking
                    Stay Informed, Every Step of the Way</h1>
                <p class="subblock-paragraph">




                    With ezBusLK's bus seat booking service, passengers can reserve their desired
                    seats for their journey with utmost convenience. Whether it's a window seat
                    for scenic views or an aisle seat for easy access, travelers can choose their
                    preferred spot with just a few clicks. Say goodbye to long queues and last-minute rushes
                    – ezBusLK ensures a seamless booking experience for every passenger.
                </p>

            </div>
        </div>



    </section>


    <section class="skyblue-block">

        <div class="img-text-block-container">


            <div class="text-subblock">
                <h1 class="skyblue-subblock-heading">Instant Assistance, Anytime, Anywhere</h1>
                <p class="subblock-paragraph">

                    With ezBusLK's bus seat booking service, passengers can reserve their desired seats for their
                    journey with utmost convenience. Whether it's a window seat for scenic views or an aisle seat
                    for easy access, travelers can choose their preferred spot with just a few clicks. Say goodbye
                    to long queues and last-minute rushes – ezBusLK ensures a seamless booking experience for
                    every passenger.
                </p>
                <div style="float: left;" class="link-box">
                    <a href="#">Help</a>
                </div>

            </div>

            <div class="img-subblock">
                <img class="subblock-img" src="images/chatBot.png">
            </div>
        </div>



    </section>


    <section class="block">
        <h1 class="block-heading">Subscribe to our Newsletter</h1>
        <div class="block-container">
            <div class="newsletter">
                <input class="input-email" type="text" placeholder="Email">
                <button class="button-subscribe">Subscribe</button>

            </div>

        </div>



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









    </footer>
</main>


</body>
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
<script>
    function validateInputs() {
        const from = document.getElementById("from").value;
        const to = document.getElementById("to").value;
        const date = document.getElementById("date").value;
  

        // Get today's date
        const today = new Date();
        // Convert the date to the same format as the input value (YYYY-MM-DD)
        const formattedToday = today.toISOString().split('T')[0];

        if (from.trim() === "") {
            document.getElementById("from").focus();
            return false;
        }

        if (to.trim() === "") {

            document.getElementById("to").focus();
            return false;
        }

        if (date.trim() === "") {

            document.getElementById("date").focus();
            return false;
        }

        // Check if selected date is before today's date
        if (date < formattedToday) {

            document.getElementById("date").focus();
            return false;
        }

        return true;
    }
</script>

</html>