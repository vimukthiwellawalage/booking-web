<?php
session_start();
require_once("../db_conn.php");
include("sidemenu.php");
if (isset($_POST["search"])) {
$search = mysqli_real_escape_string($conn, $_POST["search"]);
}

if (isset($_POST["editRoute"])) {
    if (isset($_POST["routeID"])) {
        $routeID = $_POST["routeID"];
        $oldRouteID = $routeID;
        $overlayDisplay = 'block';
        $popupContainerDisplay = 'block';

        // Fetch route details from the database
        $sql = "SELECT * FROM route WHERE routeID = '$routeID'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $routeNo = $row["routeNo"];
                $origin = $row["origin"];
                $destination = $row["destination"];
                $status = $row["status"];
            }
        }

        // Call JavaScript function to populate stops
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                getStops('$routeID');
            });
        </script>";
    }
}

if (isset($_POST["deleteRoute"])) {
    $routeID = $_POST["routeID"];

    $sql = "DELETE FROM route WHERE routeID = '$routeID'";

    mysqli_query($conn, $sql);

    
}

if (isset($_POST["addRouteButtonBottom"])) {
    // Unset variables when Add Route button is clicked
    unset($routeNo);
    unset($origin);
    unset($destination);
    unset($status);
    $overlayDisplay = 'block';
    $popupContainerDisplay = 'block';
}


?>


<div class="dashboard-content">

    <div class="heading-box">
        <div class="box-1">

            <div class="title">
                <p>Routes</p>
                <!-- <h2>Welcome To 4You</h2> -->
            </div>
        </div>
        <div class="box-1">
            <div class="search-bar">
                <ul>
                    <li class="search">
                        <!--Search bar-->
                    <form action="routes.php" method="post" id="searchForm">
                        <input type="text" <?php echo isset($_POST["search"]) ? "value='$search'" : ""; ?> placeholder="Search routes" name="search" required id="search-input" />
                        <i onclick="submitForm()" class="bx bx-search-alt-2"></i>
                    </form>
                    </li>




                </ul>


            </div>
        </div>
    </div>
    
    <div class="table-section">

    <div class="sort-button-box">

<form action="cities.php"><button class="filter">Cities</button></form>
<form action="routes.php"><button class="filter">Routes</button></form>
</div>


        <div class="table-container">

            <div class="table-box">

                <table id="rows-def">
                    <tr id="table-head">
                        <th>ROUTE ID</th>
                        <th>ROUTE NO</th>
                        <th>ORIGIN</th>
                        <th>DESTINATION</th>
                        <th>STATUS</th>
                        <th>UPDATE</th>
                        <th>DELETE</th>
                    </tr>



                    <?php

                    if (isset($_POST["search"])) {
                        
                        $sql = "SELECT * FROM route
                            
                        WHERE routeID LIKE '%$search%' OR  routeNO LIKE '%$search%'
                        OR  origin LIKE '%$search%'
                        OR  destination LIKE '%$search%'";
                    }else {
                        $sql = "SELECT * FROM route";
                    }



                    $result = mysqli_query($conn, $sql);
                    $queryResults = mysqli_num_rows($result);

                    if ($queryResults > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {

                    
                            echo "<form action='routes.php' method='post'>
                            <tr>
                          <td id='ID'>" . $row["routeID"] . "</td>
                          <td>" . $row["routeNo"] . "</td>
                          <td>" . $row["origin"] . "</td>
                          <td>" . $row["destination"] . "</td>
                          <td>" . $row["status"] . "</td>
                          <input type='hidden' name='routeID' value=" . $row["routeID"] . ">
                          <td><button id='update'  name='editRoute'> Edit</button></td>
                          <td><button id='bin' name='deleteRoute'><i class='ri-delete-bin-line'></i></button> </td>
                      </tr></form>";
                        }

                    }

                    ?>
                    

                        


                </table>


            </div>


        </div>
    </div>
    <div class="bottom-box">
        <div class="button"><form action='routes.php' method='post'>
            <button name="addRouteButtonBottom" id="popupButtonItem" class="submit">
                Add a Route
            </button></form>
        </div>


    </div>
</div>

<div id="overlay-2"></div>
<div id="popupContainerItem">
    <div id="popupContent-item">
        <div class="popup-header-item">
            <div class="form-heading-popup-item">
                <?php if(isset($routeNo) && isset($origin)) : ?>
                    <p>Edit Route</p>
                <?php else : ?>
                    <p>Add a Route</p>
                <?php endif; ?>
            </div>
            <i onclick="closePopupItem()" class="bi bi-x"></i>
        </div>
        <form action="admin_db_model.php" method="post" id="addRouteForm" onsubmit="return generateRouteID()">
            <div class="popup-content-item">
                <div class="add-category-form-item">
                    <div class="inputs-popup-item">
                        <div class="inputs-popup-item-box1">
                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="routeNo">Route No:</label><br>
                                <input class="divided-input-popup-item" placeholder="Route No"  <?php echo isset($routeNo) ? "value='$routeNo'" : ""; ?> type="text" name="routeNo" id="routeNo" />
                            </div>
                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="origin">Origin:</label><br>
                                
                                <select class="average-dropdown-popup" name="origin" id="origin">
                                    <option value="" selected="selected" hidden>Select Stops</option>
                                    <?php
                                    $sql = "SELECT city, stopID FROM stop";
                                    $result = mysqli_query($conn, $sql);
                                    $queryResults = mysqli_num_rows($result);
                                    if ($queryResults > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $cityID = array( $row["stopID"],$row["city"]);
                                            $stopString = implode(",",$cityID );
                                            $selected = isset($origin) && $origin == $row["city"] ? "selected='selected'" : "";
                                            echo "<option value='$stopString' $selected>" . $row["city"] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="destination">Destination:</label><br>
                                <input type="hidden" name="desHid" <?php echo isset($destination) ? "value='$destination'" : ""; ?> id="desHid">
                                <select class="average-dropdown-popup" name="destination" id="destination">
                                    <option value="" selected="selected" hidden>Select Stops</option>
                                    <?php
                                    $sql = "SELECT city, stopID FROM stop";
                                    $result = mysqli_query($conn, $sql);
                                    $queryResults = mysqli_num_rows($result);
                                    if ($queryResults > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $cityID = array( $row["stopID"],$row["city"]);
                                            $stopString = implode(",",$cityID );
                                            $selected = isset($destination) && $destination == $row["city"] ? "selected='selected'" : "";
                                            echo "<option value='$stopString' $selected>" . $row["city"] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div <?php echo !isset($status) ? "hidden" : ""; ?> class="col1-popup-item">
                                <label class="labels-popup-item" for="status">Status:</label><br>
                                
                                <select class="average-dropdown-popup" name="status" id="status" >
                                    <option value="" selected="selected" hidden>Select Status</option>
                                    <option value="active" <?php echo isset($status) && $status=='active' ?  "selected='selected'" : ""; ?>>active</option>
                                    <option value="deactive" <?php echo isset($status) && $status=='deactive' ?  "selected='selected'" : ""; ?>>deactive</option>
                                    
                                </select>
                            </div>
                            <input type="hidden" name="routeID" id="routeID">
                            <input type="hidden" name="oldRouteID" <?php echo isset($oldRouteID) ? "value='$oldRouteID'" : ""; ?> id="oldRouteID">
                            <input type="hidden" name="stopCount" id="stopCount">
                        </div>
                        <div class="inputs-popup-item-box2">
                            <div class="col1-popup-item-stop">
                                <label class="labels-popup-item" for="stopPoint">Stops:</label><br>
                                <button type="button" id="addStopButton">Add Stop<i class="bi bi-plus"></i></button>
                            </div>
                            <div class="col1-popup-item-dropdown-box" id="stopPointsContainer">
                                <!-- Stop points will be added dynamically here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup-footer">
                <div class="button-popup-footer">
                    <p id="error" style="margin-bottom: 5px; font-size: 13px; text-align: center;"></p>
                    <button name="<?php echo isset($routeNo) ? "updateRouteButton" : "addRouteButton"; ?>" class="button-popup">
                        <?php echo isset($routeNo) ? "Update Route" : "Add Route"; ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const addStopButton = document.getElementById("addStopButton");
    const stopPointsContainer = document.getElementById("stopPointsContainer");
    let totalStops = 2; // You can adjust this based on your initial setup
    const maxStops = 10;

    let stopsList = "<?php
        $sql = "SELECT city, stopID FROM stop";
        $result = mysqli_query($conn, $sql);
        $queryResults = mysqli_num_rows($result);
        if ($queryResults > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $cityID = array( $row["stopID"],$row["city"]);
                $stopString = implode(",",$cityID );
                echo "<option value='$stopString'>".$row["city"] . "</option>";
            }
        }
    ?>";

    addStopButton.addEventListener("click", function () {
        if (totalStops < maxStops) { // Check if the stop count is less than the maximum
             // Increment stop count
            addStopInput(totalStops);
            totalStops++;
        } else {
            alert("You can only add up to 8 stops.");
        }
    });

    function addStopInput(stopCount) {
        const newStopInput = document.createElement("div");
        newStopInput.classList.add("stopInput");

        const selectStop = document.createElement("select");
        selectStop.classList.add("average-dropdown-popup-stops");
        selectStop.setAttribute("name", `stopPoint${stopCount}`);
        selectStop.innerHTML = `
            <option selected="selected" value=''; hidden>Select Stops</option>
            ` + stopsList;

        const removeButton = document.createElement("button");
        removeButton.innerHTML = `<i class="bi bi-dash"></i>`;
        removeButton.setAttribute("id", `stopRemoveButton`);
        removeButton.addEventListener("click", function () {
            totalStops--; // Decrement stop count
            stopPointsContainer.removeChild(newStopInput);
            updateStopNames();
        });

        newStopInput.appendChild(selectStop);
        newStopInput.appendChild(removeButton);
        stopPointsContainer.appendChild(newStopInput);
        updateStopNames()
    }

    function updateStopNames() {
        const stopInputs = document.getElementsByClassName("stopInput");
        for (let i = 0; i < stopInputs.length; i++) {
            stopInputs[i].getElementsByTagName("select")[0].setAttribute("name", `stopPoint${i + 2}`);
        }
    }
});


    
function generateRouteID() {
    const routeNo = document.getElementById("routeNo").value;
    const origin = document.getElementById("origin").value;
    const destination = document.getElementById("destination").value;

    if (routeNo.trim() === "" || origin.trim() === "" || destination.trim() === "") {
        document.getElementById("error").innerHTML = "Please fill in all required fields";
        return false;
    }

    const selectedStops = new Set(); // Using Set to store unique values

    // Add origin and destination to selected stops set
    selectedStops.add(origin);
    selectedStops.add(destination);

    const stopInputs = document.getElementsByClassName("stopInput");
    for (let i = 0; i < stopInputs.length; i++) {
        const stopSelect = stopInputs[i].getElementsByTagName("select")[0];
        const selectedStop = stopSelect.value;
        
        if (selectedStop === "") {
            document.getElementById("error").innerHTML = "Please select all stops";
            return false;
        }

        if (selectedStops.has(selectedStop)) {
            document.getElementById("error").innerHTML = "Please select each stop only once";
            return false;
        }

        selectedStops.add(selectedStop);
    }

    const originStop = origin.charAt(0).toUpperCase();
    const destinationStop = destination.charAt(0).toUpperCase();

    const routeID = routeNo + originStop + destinationStop;
    
    document.getElementById("routeID").value = routeID;
    document.getElementById("stopCount").value = stopInputs.length + 1; // +1 for origin
    return true;
}



function getStops(routeID) {
    console.log("Function called with routeID: " + routeID);

    const stopPointsContainer = document.getElementById("stopPointsContainer");
    let stopCount = 1;
    var stopsList = "<?php

        $sql = "SELECT city, stopID FROM stop";

        $result = mysqli_query($conn, $sql);
        $queryResults = mysqli_num_rows($result);

        if ($queryResults > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $cityID = array( $row["stopID"],$row["city"]);
                $stopString = implode(",",$cityID );
                echo "<option value='$stopString'>".$row["city"] . "</option>";
            }
        }
    
        ?>";


    fetch('get_stops.php?routeID=' + routeID)
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            let stops = data[routeID];
            stops = stops.slice(1, -1);
            for (let stop of stops) {
                if (stopCount < 9) { 
                    stopCount++;
                    const newStopInput = document.createElement("div");
                    newStopInput.classList.add("stopInput");

                    let stopArr = stop.split(" ");
                    const selectStop = document.createElement("select");
                    selectStop.classList.add("average-dropdown-popup-stops");
                    selectStop.setAttribute("name", `stopPoint${stopCount}`);
                    selectStop.innerHTML = `
                        <option value='${stopArr[0]},${stopArr[1]}' selected="selected" hidden>${stopArr[1]}</option>` +
                        stopsList;

                    const removeButton = document.createElement("button");
                    removeButton.innerHTML = `<i class="bi bi-dash"></i>`;
                    removeButton.setAttribute("id", `stopRemoveButton`);
                    removeButton.addEventListener("click", function() {
                        stopPointsContainer.removeChild(newStopInput);
                    });

                    newStopInput.appendChild(selectStop);
                    newStopInput.appendChild(removeButton);
                    stopPointsContainer.appendChild(newStopInput);
                } else {
                    alert("You can only add up to 8 stops.");
                    break;
                }

            }
            totalStops=stopCount;
        });
}
</script>

<script>
    var overlayDisplay = '<?php echo $overlayDisplay; ?>';
    var popupContainerDisplay = '<?php echo $popupContainerDisplay; ?>';
    var popupButtonItem = document.getElementById('popupButtonItem');
    var popupButtonItemEdit = document.getElementById('popupButtonItemEdit');
    var overlay2 = document.getElementById('overlay-2');
    var popupContainerItem = document.getElementById('popupContainerItem');

    overlay2.style.display = overlayDisplay;
    popupContainerItem.style.display = popupContainerDisplay;

    

    function closePopupItem() {
        overlay2.style.display = 'none';
        popupContainerItem.style.display = 'none';
    }

    function closePopupItemEdit() {
        overlay2.style.display = 'none';
        popupContainerItemEdit.style.display = 'none';
    }

    overlay2.addEventListener('click', function() {
        closePopupItem();
        closePopupItemEdit();
    });
</script>
<script>
    function submitForm() {
        document.getElementById('searchForm').submit();
    }
</script>

</body>

</html>