<?php
session_start();
require_once("../db_conn.php");
include("sidemenu.php");
$pointTypeStop = array();

if (isset($_POST["search"])) {
    $search = mysqli_real_escape_string($conn, $_POST["search"]);
    }

if (isset($_POST["editTrip"])) {
    if (isset($_POST["tripID"])) {
        $tripID = $_POST["tripID"];
        $routeID=$_POST["routeID"];
        $oldTripID = $tripID;
        $overlayDisplay = 'block';
        $popupContainerDisplay = 'block';

        // Fetch route details from the database
        $sql = "SELECT * FROM trip
                WHERE tripID = '$tripID'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $busID = $row["busID"];
                
                $turnID = $row["turnID"];
                $date = $row["date"];
                $turnType = $row["turnType"];
                $closingTime = $row["closingTime"];
                $status = $row["status"];

            }
        }

        $sql = "SELECT * FROM trip_stop
                WHERE tripID = '$tripID'
                ORDER BY order_id ASC;";
        $result = mysqli_query($conn, $sql);

   
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $pointTypeStop[] = $row["pointType"];


            }
        }
        $selectedTurnID = isset($turnID) ? $turnID : "";
        $selectedBusID = isset($busID) ? $busID : "";

       
        echo "<script>";
        echo "let selectedTurnID = '" . $selectedTurnID . "';";
        echo "let selectedBusID = '" . $selectedBusID . "';";
        echo "let pointTypeStop = " . json_encode($pointTypeStop) . ";";
        echo "</script>";

        // Call JavaScript function to populate stops
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                getTurns('$routeID');
            });
            </script>";


    }
}

if (isset($_POST["deleteTrip"])) {
    $tripID = $_POST["tripID"];

    $sql = "DELETE FROM trip WHERE tripID = '$tripID'";

    mysqli_query($conn, $sql);

    
}



if (isset($_POST["addTripButtonBottom"])) {
    // Unset variables when Add Route button is clicked
    unset($routeID);
    unset($busID);
    unset($turnID);
    unset($date);
    unset($turnType);
    unset($closingTime);
    unset($status);

    echo "<script>";
    echo "let selectedTurnID = '';";
    echo "let selectedBusID = '';";
    echo "let pointTypeStop = '';";
    echo "</script>";


   

    $overlayDisplay = 'block';
    $popupContainerDisplay = 'block';
}

?>
<div class="dashboard-content">


    <div class="heading-box">
        <div class="box-1">

            <div class="title">
                <p>Trips</p>
                <!-- <h2>Welcome To 4You</h2> -->
            </div>
        </div>
        <div class="box-1">
            <div class="search-bar">
                <ul>
                    <li class="search">
                        <!--Search bar-->

                        <form action="trips.php" method="post" id="searchForm">
                        <input type="text" <?php echo isset($_POST["search"]) ? "value='$search'" : ""; ?> placeholder="Search trips" name="search" required id="search-input" />
                        <i onclick="submitForm()" class="bx bx-search-alt-2"></i>
                    </form>
                        
                    </li>

                </ul>


            </div>
        </div>
    </div>

    <div class="table-section-item">


        <div class="table-container-item">

            <div class="table-box">

                <table id="rows-def">
                    <tr id="table-head">
                        <th>TRIP ID</th>
                        <th>BUS ID</th>
                        <th>ROUTE ID</th>
                        <th>TURN ID</th>
                        <th>TRIP DATE</th>
                        <th>TURN TYPE</th>
                        <th>CLOSING TIME</th> 
                        <th>STATUS</th>                       
                        <th>EDIT</th>
                        <th>DELETE</th>
                    </tr>

                    
                    <?php


                    if (isset($_POST["search"])) {
                        
                        $sql = "SELECT * FROM trip
                            
                        WHERE tripID LIKE '%$search%' OR  busID LIKE '%$search%'
                        OR  routeID LIKE '%$search%'
                        OR  turnID LIKE '%$search%'";
                    }else {
                        $sql = "SELECT * FROM trip
                            ";
                    }
                    


                    $result = mysqli_query($conn, $sql);
                    $queryResults = mysqli_num_rows($result);

                    if ($queryResults > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {

                            echo "<form action='trips.php' method='post'>
                            <tr>
                      <td id='ID'>" . $row["tripID"] . "</td>
                      <td>" . $row["busID"] . "</td>
                      <td>" . $row["routeID"] . "</td>
                      <td>" . $row["turnID"] . "</td>
                      <td>" . $row["date"] . "</td>
                      <td>" . $row["turnType"] . "</td>
                     <td>" . $row["closingTime"] . "</td>
                      <td>" . $row["status"] . "</td>
                      <input type='hidden' name='tripID' value='" . $row["tripID"] . "'>
                      <input type='hidden' name='routeID' value='" . $row["routeID"] . "'>
                    <td><button id='update' name='editTrip'> Edit</button></td>
                    <td><button id='bin' name='deleteTrip'><i class='ri-delete-bin-line'></i></button> </td>

                  </tr></form>";
                        }
                    }
                    ?>
                    

                           
                        




                </table>


            </div>




        </div>
    </div>
    <div class="bottom-box">
        <div class="button"><form action='trips.php' method='post'>
            <button name="addTripButtonBottom" id="popupButtonItem" class="submit">
                Add a new Trip
            </button></form>
        </div>

    </div>


</div>



<div id="overlay-2"></div>
<div id="popupContainerItem">
    <div id="popupContent-item">
        <div class="popup-header-item">
            <div class="form-heading-popup-item">
            <?php if(isset($date) && isset($turnType)) : ?>
                    <p>Edit Trip</p>
                <?php else : ?>
                    <p>Add a Trip</p>
                <?php endif; ?>
            </div>
            <i onclick="closePopupItem()" class="bi bi-x"></i>

        </div>
        <form action="admin_db_model.php" method="post" id="addTripForm"  onsubmit="return generateTripID()">
            <div class="popup-content-item">



                <div class="add-category-form-item">

                    <div class="inputs-popup-item">

                        <div class="inputs-popup-item-box1">
                            
                            <div class="col1-popup-item">
                                <label class="labels-popup-item-trips" for="routeID">Select Route:</label><br>
                                <select class="average-dropdown-popup-trips" onchange="getTurns(this.value)" name="routeID" id="routeID">
                                <option selected="selected" value="" hidden>Select Route</option>
                                
                                <?php

                                $sql = "SELECT * FROM route";

                                $result = mysqli_query($conn, $sql);
                                $queryResults = mysqli_num_rows($result);

                                if ($queryResults > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $route = array( $row["routeNo"],$row["origin"],$row["destination"]);
                                        $routeString = implode(" ",$route );
                                        $selected = isset($routeID) && $routeID == $row["routeID"] ? "selected='selected'" : "";
                                        echo "<option value='" . $row["routeID"] . "' $selected> $routeString </option>";
                                    }

                                }

                                ?>

                                    
                                </select>
                            </div>

                            <div class="col1-popup-item">
                                <label class="labels-popup-item-trips" for="busID">Bus ID: </label><br>
                                <select class="average-dropdown-popup-trips" name="busID" id="busID" disabled>
                                <option selected="selected" value="" hidden>Select Bus ID</option>

                                
                                    
                                </select>
                            </div>

                            <div class="col1-popup-item">
                                <label class="labels-popup-item-trips" for="turnID">Turn ID:</label><br>
                                <select class="average-dropdown-popup-trips" name="turnID" id="turnID" disabled>
                                <option selected="selected" value="" hidden>Select Turn ID</option>
                                
                                    

                                    
                                </select>
                            </div>

                            <div class="col1-popup-item">
                                <label class="labels-popup-item-trips" for="date">Trip Date:</label><br>

                                <input class="divided-input-popup-item-trips" placeholder="Trip Date" type="date" <?php echo isset($date) ? "value='$date'" : ""; ?>  name="date" id="date" />
                            </div>

                            <div class="col1-popup-item">
                                <label class="labels-popup-item-trips" for="turnType">Turn Type:</label><br>
                                <select class="average-dropdown-popup-trips" name="turnType" id="turnType">
                                <option selected="selected" value="" hidden>Select Turn Type</option>
                                    
                                    <option value='depart' <?php echo isset($turnType) && $turnType=='depart' ?  "selected='selected'" : ""; ?>>Departure</option>
                                    <option value='arrive' <?php echo isset($turnType) && $turnType=='arrive' ?  "selected='selected'" : ""; ?>>Arrival</option>
                                </select>
                            </div>
                            

                             <div class="col1-popup-item">
                                <label class="labels-popup-item-trips" for="closingTime">Boooking Closing Time:</label><br>
                                <input class="divided-input-popup-item-trips" id="closingTime" name="closingTime" <?php echo isset($closingTime) ? "value='$closingTime'" : ""; ?> type="time" placeholder="Closing Time">
                                
                            </div>

                            
                        </div>

                        <div class="inputs-popup-item-box2">

                        <div  class="col1-popup-item">
                                <label class="labels-popup-item-trips" for="status">Status:</label><br>
                                <select class="average-dropdown-popup-trips" name="status" id="status" >
                                    <option value="" selected="selected" hidden>Select Status</option>
                                    <option value="active" <?php echo isset($status) && $status=='active' ?  "selected='selected'" : ""; ?>>active</option>
                                    <option value="deactive" <?php echo isset($status) && $status=='deactive' ?  "selected='selected'" : ""; ?>>deactive</option>
                                    
                                </select>
                            </div>

                           
                            
                            <div class="col1-popup-item" >
                            <div class="container-trip-stops-labels">
                                    <label class="labels-popup-item-trip-stops" for="categoryName">Trip Stops </label>
                                    <label class="labels-popup-item-point-type" for="categoryName">Pickup </label>
                                    <label class="labels-popup-item-point-type" for="categoryName">Drop </label><br>

                                </div>
                            </div>
                            
                            
                            
                            <div class="col1-popup-item" id="stopPointsContainer">

                            

                                
                            </div>
                            

                            

                            
                        </div>



                    </div>


                </div>


            </div>
            <input type="hidden" name="tripID" id="tripID">
            <input type="hidden" name="oldTripID" <?php echo isset($oldTripID) ? "value='$oldTripID'" : ""; ?> id="oldTripID">

            <div class="popup-footer">
                <div class="button-popup-footer">
                <p id="error" style="margin-bottom: 5px; font-size: 13px; text-align: center;"></p>
                    <button name="<?php echo isset($closingTime) ? "updateTripButton" : "addTripButton"; ?>" class="button-popup-trips">
                        <?php echo isset($closingTime) ? "Update Trip" : "Add Trip"; ?>
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>



<script>



    
  let durationIn = document.getElementById("duration-input");
  let resultP = document.getElementById("output");
  
  durationIn.addEventListener("change", function (e) {
    resultP.textContent = "";
    durationIn.checkValidity();
  });
  
  durationIn.addEventListener("invalid", function (e) {
    resultP.textContent = "Invalid input";
  });



function generateTripID() {

    let routeID = document.getElementById("routeID").value;
    let closingTime = document.getElementById("closingTime").value;
    // Get values from the form
    const turnID = document.getElementById("turnID").value;
    const busID = document.getElementById("busID").value;
    let date = document.getElementById("date").value;

    let turnType = document.getElementById("turnType").value;
       
    if (routeID === "" || closingTime === "" || turnID === ""|| busID === ""
    || date === ""|| turnType === "") {
        document.getElementById("error").innerHTML = "Please fill in all required fields";
        return false; // Prevent form submission
    }

         // Extracting hours and minutes from departure times
        let dateNoSpace = date.replaceAll("-", "");
        
        
        const dateSub = dateNoSpace.substring(2);
        const turnTypeSub = turnType.substring(0, 3).toUpperCase();

        // Concatenate routeNo, originInitial, and destinationInitial to generate routeID
        const tripID = turnID +"-"+ busID +"-"+ dateSub+turnTypeSub;
        

        // Assign the generated routeID to a hidden input field in the form
        document.getElementById("tripID").value = tripID;
        return true; 
    }




function getTurns(routeID) {
    console.log("Function called with routeID: " + routeID);
    let turnsDropDown = document.querySelector("#turnID");
    let busesDropDown = document.querySelector("#busID");
    let divElement = document.getElementById("stopPointsContainer");
    divElement.innerHTML=``;


    if(routeID.trim() === "") {
        turnsDropDown.disabled = true;
        busesDropDown.disabled = true;
        turnsDropDown.selectIndex=0;
        busesDropDown.selectIndex=0;
        return false;

    }


    fetch('get_buses.php?routeID=' + routeID)
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        let buses = data[routeID];
        let out ="";
        out += `<option value="">Choose a Bus</option>`;
        for (let bus of buses) {
            let busArr = bus.split(" ");
            out += `<option value="${busArr[0]}" ${selectedBusID && selectedBusID === busArr[0] ? 'selected' : ''}>${busArr[1] + " " + busArr[2] + " " + busArr[3]}</option>`;
        }
        busesDropDown.innerHTML=out;
        busesDropDown.disabled=false;
    })


    fetch('get_turns.php?routeID=' + routeID)
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        let turns = data[routeID];
        let out ="";
        out += `<option value="">Choose a turn</option>`;
        for (let turn of turns) {
            let turnArr = turn.split(" ");
            out += `<option value="${turnArr[0]}" ${selectedTurnID && selectedTurnID === turnArr[0] ? 'selected' : ''}>${turnArr[1] + " " + turnArr[2] + " " + turnArr[3] + " " + turnArr[4] + " " + turnArr[5]}</option>`;
        }
        turnsDropDown.innerHTML=out;
        turnsDropDown.disabled=false;
    })


    

    fetch('get_stops.php?routeID=' + routeID)
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        let stops = data[routeID];
        let out ="";
        let i=0;
        for (let stop of stops) {
            let stopArr=stop.split(" ");
            let div = document.createElement('div');
            div.className = "container-trip-stops";
            div.innerHTML = `
                <label class="labels-popup-item-trip-stops" for="pointType">${stopArr[1]}</label>
                <div class="labels-popup-item-point-type">
                    <input class="" type="radio" checked ${pointTypeStop[i] && pointTypeStop[i] === 'start' ? 'checked' : ''} value="${stopArr[0]},${stopArr[1]},start" name="pointTypeStop${i}" >
                </div>
                <div class="labels-popup-item-point-type">
                    <input class="" type="radio" ${pointTypeStop[i] && pointTypeStop[i] === 'end' ? 'checked' : ''} value="${stopArr[0]},${stopArr[1]},end" name="pointTypeStop${i}" >
                </div>`;
            i++;
            divElement.appendChild(div);
        }
    });

    

    

}
   
</script>





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
    function submitForm() {
        document.getElementById('searchForm').submit();
    }
</script>

</body>

</html>