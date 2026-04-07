<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Outer Clove</title>
    <link rel="stylesheet" href="formstyle.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text&family=Julius+Sans+One&family=Mulish:wght@200&family=Quattrocento&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/tw-cen-mt-std" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tomorrow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <script src="hamburger.js" defer></script>
</head>

<body>

    <header class="header">


        <div class="nav-bar-form">
            <div class="heading">
                <a href="index.php"><img class="logo" src="images/logo2.12.png"></a>
            </div>
            <div class="links">
                <a class="active" id="active" href="functions.php">Back</a>
            </div>


        </div>





    </header>

    <main class="inquire-form-main">
        <section class="form">
            <div class="inquire-form">
                <form id="form1" name="form1" method="post" action="db_model.php" onsubmit="return validateForm()">
                    <div class="headings">
                        <p class="title">Inquire</p>
                        <p class="description">We look Forward For Your Event</p>
                    </div>
                    <div class="form-details">
                        
                            <div class="merged">
                                <label class="labels" for="email">Email:</label><br>
                                <input class="merged-input" type="text" placeholder="Email" name="email" id="email" />
                            </div>
                            <div class="divided">
                                <div class="col1">
                                    <label class="labels" for="firstName">First Name:</label><br>
                                    <input class="divided-input" placeholder="First Name" type="text" name="fName" id="firstName" />
                                </div>
                                <div class="col2">
                                    <label class="labels" for="lastName">Last Name:</label><br>
                                    <input class="divided-input" placeholder="Last Name" type="text" name="lName" id="lastName" />
                                </div>
                            </div>
                            <div class="divided">
                                <div class="col1">
                                    <label class="labels" for="phonenumber">Phone Number:</label><br>
                                    <input class="divided-input" placeholder="Phone Number" type="text" name="phoneNo" id="phonenumber" />
                                </div>
                                <div class="col2">
                                    <label class="labels" for="nic">NIC Number:</label><br>
                                    <input class="divided-input" placeholder="NIC Number" type="text" id="nic" name="nic" />
                                </div>
                            </div>
                            <div class="divided">
                                <div class="col1">
                                    <label class="labels" for="venue">Venue:</label><br>
                                    <select class="dropdown" name="venue" id="venue">
                                        <option selected="selected" hidden>Desired Space/ Venue</option>
                                        <option value="Private Dining Room">Private Dining Room</option>
                                        <option value="Clove Lounge">Clove Lounge</option>
                                        <option value="Main Dining Room">Main Dining Room</option>
                                    </select>
                                </div>
                                <div class="col2">
                                    <label class="labels" for="date">Event Date:</label><br>
                                    <input class="divided-input" type="date" name="date" id="date" />
                                </div>
                            </div>

                            <div class="divided">
                                <div class="col1">
                                    <label class="labels" for="starttime">Start Time:</label><br>
                                    <select class="dropdown" id="starttime" name="starttime" required>
                                        <?php
                                        // Generating time options in 30-minute intervals from 6:00 AM to 11:30 PM
                                        for ($hours = 6; $hours <= 23; $hours++) {
                                            for ($minutes = 0; $minutes < 60; $minutes += 30) {
                                                // Adjusting the time format
                                                $time = sprintf('%02d:%02d', $hours, $minutes);
                                                echo "<option value='$time'>$time</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col2">
                                    <label class="labels" for="endtime">End Time:</label><br>
                                    <select class="dropdown" id="endtime" name="endtime" required>
                                        <?php
                                        // Generating time options in 30-minute intervals from 6:00 AM to 11:30 PM
                                        for ($hours = 6; $hours <= 23; $hours++) {
                                            for ($minutes = 0; $minutes < 60; $minutes += 30) {
                                                // Adjusting the time format
                                                $time = sprintf('%02d:%02d', $hours, $minutes);
                                                echo "<option value='$time'>$time</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="divided">
                                <div class="col1">
                                    <label class="labels" for="eventtype">Type of Event:</label><br>
                                    <select class="dropdown" name="type" id="eventtype">
                                        <option selected="selected" hidden>Type of Event</option>
                                        <option value="Wedding">Wedding</option>
                                        <option value="Birthday">Birthday Party</option>
                                        <option value="Private Dinner">Private Dinner</option>
                                        <option value="Bachelor/ Bachelorette">Bachelor/ Bachelorette</option>
                                    </select>
                                </div>
                                <div class="col2">
                                    <label class="labels" for="noofpeople">Number of People:</label><br>
                                    <input class="divided-input" placeholder="Number of People" type="text" id="noofpeople" name="noPeople" />
                                </div>
                            </div>

                            <div class="merged">
                                <label class="labels" for="additional">Additional Information:</label><br>
                                <textarea class="additional" name="additional" id="additional" placeholder="Additional Information"></textarea>
                            </div>
                            <div class="errors-box">
                                <div class="errors">
                                    <?php
                                    if($_GET["inquiry"] == "success") {
                                        echo '<p id="correct">Inquiry Successful
                                        <p>';
                                    }
                                    ?>
                                    
                                    <p id="error">
                                    <p>
                                </div>

                            </div>
                            <div class="button">
                                <button name="inquire" class="submit">
                                    Submit
                                </button>
                            </div>

                   



                    </div>








                </form>
                <script>
                    function validateForm() {
                        var email = document.getElementById("email").value;
                        var fName = document.getElementById("firstName").value;
                        var lName = document.getElementById("lastName").value;
                        var phoneNo = document.getElementById("phonenumber").value;
                        var nic = document.getElementById("nic").value;
                        var venue = document.getElementById("venue").value;
                        var date = document.getElementById("date").value;
                        var startTime = document.getElementById("starttime").value;
                        var endTime = document.getElementById("endtime").value;
                        var type = document.getElementById("eventtype").value;
                        var noOfPeople = document.getElementById("noofpeople").value;
                        var additionalInfo = document.getElementById("additional").value;

                        var errorElement = document.getElementById("error");
                        errorElement.innerHTML = ""; 

                        
                        if (email === "" || fName === "" || lName === "" || phoneNo === "" || nic === "" || noOfPeople === "" || date ==="" || venue ==="" || type ==="") {
                            errorElement.innerHTML = "Please fill in all required fields";
                            return false;
                        }

                       
                        var emailFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailFormat.test(email)) {
                            errorElement.innerHTML = "Invalid email address";
                            return false;
                        }


                        var phoneNoFormat = /^\d+$/;
                        if (!phoneNoFormat.test(phoneNo)) {
                            errorElement.innerHTML = "Phone number should contain only numbers";
                            return false;
                        }



                        return true; 
                    }
                </script>
            </div>


        </section>
    </main>