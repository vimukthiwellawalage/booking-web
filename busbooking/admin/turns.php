<?php
session_start();
require_once("../db_conn.php");
include("sidemenu.php");

if (isset($_POST["search"])) {
    $search = mysqli_real_escape_string($conn, $_POST["search"]);
}


if (isset($_POST["editTurn"])) {
    if (isset($_POST["turnID"])) {
        $turnID = $_POST["turnID"];
        $oldTurnID = $turnID;
        $overlayDisplay = 'block';
        $popupContainerDisplay = 'block';

        // Fetch route details from the database
        $sql = "SELECT * FROM turn
                WHERE turnID = '$turnID'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $routeID = $row["routeID"];
                $depTimeOri = $row["depTimeOri"];
                $depTimeDes = $row["depTimeDes"];
                $dur = $row["duration"];
                $via = $row["via"];
                $status = $row["status"];
                $fare = $row["fare"];

            }
        }


    }
}


if (isset($_POST["deleteTurn"])) {
    $turnID = $_POST["turnID"];

    $sql = "DELETE FROM turn WHERE turnID = '$turnID'";
    mysqli_query($conn, $sql);

    
}



if (isset($_POST["addTurnButtonBottom"])) {
    // Unset variables when Add Route button is clicked
    unset($routeID);
    unset($depTimeOri);
    unset($depTimeOri);
    unset($dur);
    unset($via);
    unset($status);
    unset($fare);

    $overlayDisplay = 'block';
    $popupContainerDisplay = 'block';
}

?>
<div class="dashboard-content">


    <div class="heading-box">
        <div class="box-1">

            <div class="title">
                <p>Turns</p>
                <!-- <h2>Welcome To 4You</h2> -->
            </div>
        </div>
        <div class="box-1">
            <div class="search-bar">
                <ul>
                    <li class="search">
                        <!--Search bar-->
                        <form action="turns.php" method="post" id="searchForm">
                        <input type="text" <?php echo isset($_POST["search"]) ? "value='$search'" : ""; ?> placeholder="Search turns" name="search" required id="search-input" />
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
                        <th>TURN ID</th>
                        <th>ROUTE ID</th>
                        <th>DEP TIME ORIGIN</th>
                        <th>DEP TIME DESTINATION</th>
                        <th>DURATION</th>
                        <th>VIA</th>  
                        <th>FARE</th>    
                        <th>STATUS</th>
                        <th>EDIT</th>
                        <th>DELETE</th>
                    </tr>
                    
                    <?php

                    if (isset($_POST["search"])) {
                                            
                        $sql = "SELECT * FROM turn
                            
                        WHERE turnID LIKE '%$search%' OR  routeID LIKE '%$search%'
                        ";
                    }else {
                        $sql = "SELECT * FROM turn
                            ";
                    }

                    


                    $result = mysqli_query($conn, $sql);
                    $queryResults = mysqli_num_rows($result);

                    if ($queryResults > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {

                            echo "<form action='turns.php' method='post'>
                            <tr>
                      <td id='ID'>" . $row["turnID"] . "</td>
                      <td>" . $row["routeID"] . "</td>
                      <td>" . $row["depTimeOri"] . "</td>
                      <td>" . $row["depTimeDes"] . "</td>
                     <td>" . $row["duration"] . "</td>
                      <td>" . $row["via"] . "</td>
                      <td>" . $row["fare"] . "</td>
                      <td>" . $row["status"] . "</td>
                      <input type='hidden' name='turnID' value='" . $row["turnID"] . "'>
                    <td><button id='update' name='editTurn'> Edit</button></td>
                    <td><button id='bin' name='deleteTurn'><i class='ri-delete-bin-line'></i></button> </td>

                  </tr></form>";
                        }
                    }

                           
                        

?>


                </table>


            </div>




        </div>
    </div>
    <div class="bottom-box">
        <div class="button"><form action='turns.php' method='post'>
            <button name="addTurnButtonBottom" id="popupButtonItem" class="submit">
                Add a new Turn
            </button></form>
        </div>

    </div>


</div>



<div id="overlay-2"></div>
<div id="popupContainerItem">
    <div id="popupContent-item">
        <div class="popup-header-item">
            <div class="form-heading-popup-item">
            <?php if(isset($depTimeOri) && isset($depTimeDes)) : ?>
                    <p>Edit Turn</p>
                <?php else : ?>
                    <p>Add a Turn</p>
                <?php endif; ?>
            </div>
            <i onclick="closePopupItem()" class="bi bi-x"></i>

        </div>
        <form action="admin_db_model.php" method="post" id="addTurnForm"  onsubmit="return generateTurnID()">
            <div class="popup-content-item">



                <div class="add-category-form-item">

                    <div class="inputs-popup-item">

                        <div class="inputs-popup-item-box1">
                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="routeID">Route ID:</label><br>
                                <select class="average-dropdown-popup" name="routeID" id="routeID">
                                <option selected="selected" value="" hidden>Route ID</option>
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
                                <label class="labels-popup-item" for="depTimeOri">Departure Time From Origin:</label><br>

                                <input class="divided-input-popup-item" placeholder="Model" type="time" name="depTimeOri" <?php echo isset($depTimeOri) ? "value='$depTimeOri'" : ""; ?> id="depTimeOri" />
                            </div>

                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="depTimeDes">Departure Time From Destination:</label><br>

                                <input class="divided-input-popup-item" placeholder="Model" type="time" name="depTimeDes" <?php echo isset($depTimeDes) ? "value='$depTimeDes'" : ""; ?> id="depTimeDes" />
                            </div>
                            

                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="dur">Duration:</label><br>
                                <input class="divided-input-popup-item" id="duration-input" name="dur" type="text" <?php echo isset($dur) ? "value='$dur'" : ""; ?> required pattern="[0-9]{2}:[0-9]{2}:[0-9]{2}" placeholder="hh:mm:ss">
                                
                            </div>
                        </div>

                        <div class="inputs-popup-item-box2">

                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="via">Via:</label><br>
                                <input class="divided-input-popup-item" type="text" name="via" <?php echo isset($via) ? "value='$via'" : ""; ?> id="via" placeholder="Via">
                                
                            </div>

                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="fare">Fare:</label><br>
                                <input class="divided-input-popup-item" id="fare" name="fare" <?php echo isset($fare) ? "value='$fare'" : ""; ?> type="text" placeholder="Fare">
                                
                            </div>

                            <div <?php echo !isset($status) ? "hidden" : ""; ?> class="col1-popup-item">
                                <label class="labels-popup-item" for="status">Status:</label><br>
                                <select class="average-dropdown-popup" name="status" id="status" >
                                    <option value="" selected="selected" hidden>Select Status</option>
                                    <option value="active" <?php echo isset($status) && $status=='active' ?  "selected='selected'" : ""; ?>>active</option>
                                    <option value="deactive" <?php echo isset($status) && $status=='deactive' ?  "selected='selected'" : ""; ?>>deactive</option>
                                    
                                </select>
                            </div>

                            

                            
                        </div>
                        <input type="hidden" name="turnID" id="turnID">
                        <input type="hidden" name="oldTurnID" <?php echo isset($oldTurnID) ? "value='$oldTurnID'" : ""; ?> id="oldTurnID">



                    </div>


                </div>


            </div>

            <div class="popup-footer">
                <div class="button-popup-footer">
                <p id="error" style="margin-bottom: 5px; font-size: 13px; text-align: center;"></p>
                <button name="<?php echo isset($depTimeOri) ? "updateTurnButton" : "addTurnButton"; ?>" class="button-popup">
                        <?php echo isset($depTimeOri) ? "Update Turn" : "Add Turn"; ?>
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


  function generateTurnID() {
    // Get values from the form
    let routeID = document.getElementById("routeID").value;
    let depTimeOri = document.getElementById("depTimeOri").value;
    let depTimeDes = document.getElementById("depTimeDes").value;
    let dur = document.getElementById("duration-input").value;
    let via = document.getElementById("via").value;
    let fare = document.getElementById("fare").value;

    // Check if any field is empty
    if (routeID === "" || depTimeOri === "" || depTimeDes === ""|| dur === ""
    || via === ""|| fare === "") {
        document.getElementById("error").innerHTML = "Please fill in all required fields";
        return false; // Prevent form submission
    }

    let depTimeOriSub = depTimeOri.substring(0,5);
    let depTimeDesSub = depTimeDes.substring(0,5);
    // Extracting hours and minutes from departure times
    let depTimeOriNoSpace = depTimeOriSub.replace(":", "");
    let depTimeDesNoSpace = depTimeDesSub.replace(":", "");

    // Generating turnID in the format '01CM-09000100'
    const turnID = routeID + "-" + depTimeOriNoSpace + depTimeDesNoSpace;

    // Assign the generated turnID to a hidden input field in the form
    document.getElementById("turnID").value = turnID;

    return true; // Allow form submission
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