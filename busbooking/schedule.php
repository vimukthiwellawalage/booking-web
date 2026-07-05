<?php
require_once("db_conn.php");
if (isset($_POST["submit-schedule"])) {
    $from = $_POST["from"];
    $to = $_POST["to"];
    $startTime = $_POST["startTime"];
    $endTime = $_POST["endTime"];

    
}
?>

<?php
$pageTitle = "Yamu - Schedule Results";
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
                                        
                                        $selected = isset($from) && $from == $row["city"] ? "selected='selected'" : "";
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

                                        $selected = isset($to) && $to == $row["city"] ? "selected='selected'" : "";
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
                                        $selected = isset($startTime) && $startTime == $time ? "selected='selected'" : "";
                                        echo "<option value='$time' $selected>$time</option>";
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
                                        $selected = isset($endTime) && $endTime == $time ? "selected='selected'" : "";
                                        echo "<option value='$time' $selected>$time</option>";
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

        <section class="time-table">
            <div class="title-panel">
                Search Results Bus Time Table
            </div>
            <div class="table-results">
                <table>
                    <tr id="table-head">
                      <th>Departure</th>
                      <th>Arrival</th>
                      <th>Route No</th>
                      <th>Via</th>

                    </tr>
                    <!-- Rows -->
                    <?php

$sql = "SELECT DISTINCT route.routeID FROM route
INNER JOIN turn ON route.routeID = turn.routeID
WHERE (origin='$from' AND destination='$to' AND depTimeOri BETWEEN '$startTime' AND '$endTime')
OR route.routeID IN (
    SELECT route.routeID FROM stop
    INNER JOIN turn ON route.routeID = turn.routeID
    WHERE origin='$to' AND destination='$from'
    AND depTimeDes BETWEEN '$startTime' AND '$endTime'
)";



        $result = mysqli_query($conn, $sql);
            $queryResults = mysqli_num_rows($result);


            if ($queryResults > 0) {
                while ($rows=mysqli_fetch_array($result)) {
                    $routeID= $rows["routeID"];
                    
                    $sql2 = "SELECT * FROM route
                INNER JOIN turn ON route.routeID = turn.routeID
                WHERE route.routeID='$routeID'
                AND ((origin='$from' AND destination='$to' AND depTimeOri BETWEEN '$startTime' AND '$endTime')
                OR (origin='$to' AND destination='$from' AND depTimeDes BETWEEN '$startTime' AND '$endTime'))";

                    $result2 = mysqli_query($conn, $sql2);
                    $queryResults2 = mysqli_num_rows($result2);

                    if ($queryResults2 > 0) {
                        while ($row = mysqli_fetch_assoc($result2)) {

                            $depTimeOri = $row["depTimeOri"];
                            $depTimeDes = $row["depTimeDes"];
                            $duration = $row["duration"];
                            $secs = strtotime($duration)-strtotime("00:00:00");
                            
                            $arrivalTimeDes =  date("H:i:s",strtotime($depTimeOri)+$secs) ;
                            $arrivalTimeOri =  date("H:i:s",strtotime($depTimeDes)+$secs) ;

                            echo "<tr>
                            <td style='color: #9d0202;'>" .($from == $row["origin"] ? $row["origin"] .' | '. $row["depTimeOri"] : $row["destination"] .' | '. $row["depTimeDes"] ). "</td>
                            <td style='color:  #113978;'>" .($to == $row["destination"] ? $row["destination"] .' | '. $arrivalTimeDes :  $row["origin"] .' | '. $arrivalTimeOri).  "</td>
                            <td>" . $row["routeNo"] . "</td>
                            <td>via " . $row["via"] . "</td>

                          </tr>";
                        }


                    }
                }
            }

                    ?>
                    
                        

                    
                    
                    
                  </table>
            </div>

        </section>
        
        
    </body>
    </html>

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

    </main>
   