<?php
require_once("db_conn.php");



if (isset($_POST["inquire-bus"])) {

    $busID = $_POST["busID"];
    
    $overlayDisplay = 'block';
    $popupContainerDisplay = 'block';

    

    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="stylesheetone.css">
    <link rel="stylesheet" href="stylepopup.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tomorrow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js" 
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" 
    crossorigin="anonymous"></script>
    
</head>
<body>
    
    <header class="header">

        
        <div class="nav-bar">
            <div class="box-1">
                <img class="logo" src="images/logo2.12.png">
            </div>
            <div class="box-2">
                <ul>
                    <li><a  href="index.php">Home</a></li>
                    <li><a href="viewSchedule.php">View Schedule</a></li>
                    <li><a href="findspecialbus.php">Special Buses</a></li>
                    <li><a href="aboutus.php">About Us</a></li>


                </ul>
            </div>
            <div class="box-3">
                <div class="account-box">
                    <div class="account-icon">
                    
                        <a href="login.php"> &nbsp;<i class="bi bi-person-circle"></i></i></a>
    
                    </div>
                    <div class="account-name">
                        <a id="name" href="login.php">Agent Login</a>
                    </div>

                </div>

                
            </div>
            
        </div>

        

    </header>
    
<main>

    <section class="find-bus-bar">
        <div class="find-bar">


            <form action="findbus.php" method="post" id="findBusForm" onsubmit="return validateInputs()">
                <div class="seat-booking-bar">

                    <div class="selection-bar">


                        <input <?php echo isset($from) ? "value='$from'" : ""; ?> type="text" placeholder="Search type, model or name" name="from" id="from" class="input-spec" />

                        
                        <button name="submit-index" class="input-submit" type="submit">Submit</button>

                    </div>

                </div>
                
            </form>




        </div>


    </section>
    

    

    <section class="bus-container" >
        <?php
        
        date_default_timezone_set("Asia/Colombo");
        $currentDateTime = date("H:i:s");


    
    $sql2 = "SELECT  bus.*, special_bus.* FROM special_bus
            INNER JOIN bus ON special_bus.busID = bus.busID";

    $result2 = mysqli_query($conn, $sql2);
    $queryResults2 = mysqli_num_rows($result2);

    if ($queryResults2 > 0) {
        while ($row = mysqli_fetch_assoc($result2)) {
            
            echo '
            <div class="bus-card">
            <div class="route-row-spec">
            <p>'.$row["name"].'</p>
            <form action="findspecialbus.php" method="post"><button type="submit" name="inquire-bus" class="inquire-spec-button">Inquire
            <input type="hidden" name="busID" value="' . $row["busID"] . '">
            </button>
            
            </form>

 
            </div>
            <div class="rule">

            </div>
            <div class="card-body-row-spec">
                <div class="wide-col">
                    <img class="bus-img" src="images/'.$row["image"].'">
                </div>
                <div class="wide-col-right">
                <div class="row-one">
                <div class="body-row-spec">
                    <p class="body-heading">
                        Name
                    </p>
                    <p class="body-context">'.$row["name"].'</p>

                </div>
                
                <div class="body-row-spec">
                    <p class="body-heading">
                        Model
                    </p>
                    <p class="body-context">'.$row["model"].'</p>

                </div>
                <div class="body-row-spec">
                    <p class="body-heading">
                        Type

                    </p>
                    <p class="body-context">'.$row["type"].'</p>

                </div>
                <div class="body-row-spec">
                    <p class="body-heading">
                        Capacity
                    </p>
                    <p class="body-context">
                    '.$row["capacity"].'

                    </p>

                </div>
                <div class="body-row-spec">
                    <p class="body-heading">
                        Rating
                    </p>
                    <p class="body-context">
                    '.$row["rate"].'

                    </p>

                </div>

            </div>
            
            <div class="row-one">
            <div class="body-row-spec-des">
                    <p class="body-heading">
                        Description
                    </p>
                    <p class="body-context">
                    '.$row["description"].'
                    </p>

                </div>
            
                
                
            </div>
            
            
                </div>
                
            </div>
            <div class="footer-row">

            </div>


        </div>
                            
                            ';
                            
                        }

                    }







        ?>

        


    </section>

    

<div id="overlay-2"></div>
<div id="popupContainerItem">
    <div id="popupContent-item">
        <div class="popup-header-item">
            <div class="form-heading-popup-item">
            
                    <p>Inquire</p>
                
            </div>
            <i onclick="closePopupItem()" class="bi bi-x"></i>

        </div>
        <form action="db_model.php" method="post" id="addStandardBusForm"  enctype="multipart/form-data"  onsubmit="return validateForm()">
            <div class="popup-content-item">



                <div class="add-category-form-item">

                    <div class="inputs-popup-item">
               
                        <div class="inputs-popup-item-box1">
                        <div class="col1-popup-item">
                                <label class="labels-popup-item" for="name">Customer Name:</label><br>
                                <input class="divided-input-popup-item" placeholder="Name" type="text" name="name" id="name" />
                            </div>
                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="nic">NIC:</label><br>
                                <input class="divided-input-popup-item" placeholder="NIC Number" type="text"  name="nic" id="nic" />
                            </div>
                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="email">Email:</label><br>
                                <input class="divided-input-popup-item" placeholder="Email" type="text"  name="email" id="email" />
                            </div>

                            <div class="col1-popup-item-form">
                                <div class="col1-popup-item-form-col">
                                    <label class="labels-popup-item" for="startDate">Start Date:</label><br>

                                    <input class="divided-input-popup-item-form" placeholder="Trip Date" type="date" min="<?php echo date('Y-m-d'); ?>"  name="startDate" id="startDate" />
                                </div>
                                <div class="col1-popup-item-form-col">
                                    <label class="labels-popup-item" for="endDate">End Date:</label><br>

                                    <input class="divided-input-popup-item-form" placeholder="Trip Date" type="date" min="<?php echo date('Y-m-d'); ?>"   name="endDate" id="endDate" />
                                </div>
                                
                            </div>

                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="contactNo">Contact No:</label><br>
                                <input class="divided-input-popup-item" placeholder="Contact No" type="text"  name="contactNo" id="contactNo" />
                            </div>

                            

                            

                            <input type="hidden" name="busID" <?php echo isset($busID) ? "value='$busID'" : ""; ?> id="busID">
                            


                            
                        </div>

                        



                    </div>


                </div>


            </div>

            <div class="popup-footer">
                <div class="button-popup-footer">
                <p id="error" style="margin-bottom: 5px; font-size: 13px; text-align: center;"></p>

                <button name="addInquiryButton" class="button-popup">
                        Inquire
                </button>
                    
                </div>
            </div>
        </form>

    </div>
</div>



<script>
    var overlayDisplay = '<?php echo $overlayDisplay; ?>';
    var popupContainerDisplay = '<?php echo $popupContainerDisplay; ?>';
    var popupButtonItem = document.getElementById('popupButtonItem');

    var overlay2 = document.getElementById('overlay-2');
    var popupContainerItem = document.getElementById('popupContainerItem');

    overlay2.style.display = overlayDisplay;
    popupContainerItem.style.display = popupContainerDisplay;

    

    function closePopupItem() {
        overlay2.style.display = 'none';
        popupContainerItem.style.display = 'none';
    }


    overlay2.addEventListener('click', function() {
        closePopupItem();

    });

    
</script>



<script>
function validateForm() {
    // Get values from the form
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let nic = document.getElementById("nic").value;
    let contactNo = document.getElementById("contactNo").value;
    let startDate = document.getElementById("startDate").value;
    let endDate = document.getElementById("endDate").value;
 
    

    // Check if any of the required fields are empty
    if (name.trim() === "" || email.trim() === "" || nic.trim() === ""|| contactNo.trim() === ""
    || startDate.trim() === ""|| endDate.trim() === "") {
        document.getElementById("error").innerHTML = "Please fill in all required fields";
        return false; // Prevent form submission if any field is empty
    }

    if (!validatePhoneNumber(contactNo)) {
        
        document.getElementById("error").innerHTML = "Phone Number is not valid";
        return false; // Prevent form submission if any field is empty
    }

    if (!validateEmail(email)) {
        
        document.getElementById("error").innerHTML = "Email is not valid";
        return false; // Prevent form submission if any field is empty
    }

    

    return true; // Allow form submission if all validation passes
}


function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function validatePhoneNumber(contactNo) {
    var re = /^\d{10}$/;
    return re.test(contactNo);
}


</script>


<script>
    function submitForm() {
        document.getElementById('searchForm').submit();
    }
</script>





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