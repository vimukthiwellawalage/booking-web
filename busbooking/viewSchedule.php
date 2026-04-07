<?php
require_once("db_conn.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Table Results</title>
    <link rel="stylesheet" href="stylesheetone.css">
    <link rel="stylesheet" href="stylesheet2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tomorrow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
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

                <div class="seat-booking-bar">
                    <div class="title">
                        
                    </div>
                    <form action="schedule.php" method="post" id="findBusForm" onsubmit="return validateInputs()">
                    <div class="selection-bar">
                        <select id="from" name="from" class="input-select-schedule">
                            <option value="" hidden>From</option>
                            <?php
                                $sql = "SELECT city, stopID FROM stop";
                                $result = mysqli_query($conn, $sql);
                                $queryResults = mysqli_num_rows($result);
                                if ($queryResults > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        
                                        $selected = isset($destination) && $destination == $row["city"] ? "selected='selected'" : "";
                                        echo "<option value='" . $row["city"] . "' $selected>" . $row["city"] . "</option>";
                                    }
                                }
                            ?>
                        </select>
                        <select id="to" name="to" class="input-select-schedule">
                            <option value="" hidden>To</option>
                            <?php
                                $sql = "SELECT city, stopID FROM stop";
                                $result = mysqli_query($conn, $sql);
                                $queryResults = mysqli_num_rows($result);
                                if ($queryResults > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {

                                        $selected = isset($destination) && $destination == $row["city"] ? "selected='selected'" : "";
                                        echo "<option value='" . $row["city"] . "' $selected>" . $row["city"] . "</option>";
                                    }
                                }
                                ?>
                            
                        </select>
                        <select id="startTime" name="startTime" class="input-select-schedule">
                            <option value="" hidden>Start Time</option>
                            <?php
                                // Generating time options in 30-minute intervals from 6:00 AM to 11:30 PM
                                for ($hours = 0; $hours < 24; $hours++) {
                                    for ($minutes = 0; $minutes < 60; $minutes += 5) {
                                        // Adjusting the time format
                                        $time = sprintf('%02d:%02d', $hours, $minutes);
                                        echo "<option value='$time'>$time</option>";
                                    }
                                }
                            ?>
                        </select> 
                        <select id="endTime" name="endTime" class="input-select-schedule">
                            <option hidden>End Time</option>
                            <?php
                                // Generating time options in 30-minute intervals from 6:00 AM to 11:30 PM
                                for ($hours = 0; $hours < 24; $hours++) {
                                    for ($minutes = 0; $minutes < 60; $minutes += 5) {
                                        // Adjusting the time format
                                        $time = sprintf('%02d:%02d', $hours, $minutes);
                                        echo "<option value='$time'>$time</option>";
                                    }
                                }
                            ?>
                        </select> 
                        
                        
                        <button name="submit-schedule" class="input-submit-schedule" type="submit">Submit</button>
                    </div>
                    
                    </form>
                    
                </div>  
            </div> 
        </section>
        <section class="schedule-background">
        <div class="cover-image-schedule">
                            </section>
    </main>
</body>
<script>
    function validateInputs() {
        const from = document.getElementById("from").value;
        const to = document.getElementById("to").value;
        const startTime = document.getElementById("startTime").value;
        const endTime = document.getElementById("endTime").value;
        


        

        if (from.trim() === "") {
            document.getElementById("from").focus();
            return false;
        }

        if (to.trim() === "") {

            document.getElementById("to").focus();
            return false;
        }

        if (startTime.trim() === "") {

            document.getElementById("startTime").focus();
            return false;
        }

        if (endTime.trim() === "") {

        document.getElementById("endTime").focus();
        return false;
        }

        




        return true;
    }
</script>
</html>

