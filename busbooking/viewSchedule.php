<?php
require_once("db_conn.php");
$pageTitle = "Yamu - View Schedule";
$extraStyles = ["stylesheet2.css"];
include("header.php");
?>
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

