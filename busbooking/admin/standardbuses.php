<?php
session_start();
require_once("../db_conn.php");
include("sidemenu.php");

if (isset($_POST["search"])) {
    $search = mysqli_real_escape_string($conn, $_POST["search"]);
}


if (isset($_POST["editStandardBus"])) {
    if (isset($_POST["busID"])) {
        $busID = $_POST["busID"];
        $oldBusID = $busID;
        $overlayDisplay = 'block';
        $popupContainerDisplay = 'block';

        // Fetch route details from the database
        $sql = "SELECT * FROM standard_bus
                INNER JOIN bus ON standard_bus.busID = bus.busID 
                WHERE standard_bus.busID = '$busID'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $routeID = $row["routeID"];
                $userID = $row["userID"];
                $busClass = $row["class"];
                $type = $row["type"];
                $model = $row["model"];
                $regNo = $row["regNo"];
                $capacity = $row["capacity"];
                $image = $row["image"];
                $status = $row["status"];
            }
        }


    }
}


if (isset($_POST["deleteStandardBus"])) {
    $busID = $_POST["busID"];

    $sql = "DELETE FROM bus WHERE busID = '$busID'";

    mysqli_query($conn, $sql);

    
}

if (isset($_POST["addStandardBusButtonBottom"])) {
    // Unset variables when Add Route button is clicked
    unset($routeID);
    unset($userID);
    unset($busClass);
    unset($model);
    unset($type);
    unset($regNo);
    unset($capacity);
    unset($image);
    unset($status);
    $overlayDisplay = 'block';
    $popupContainerDisplay = 'block';
}

?>

<div class="dashboard-content">


    <div class="heading-box">
        <div class="box-1">

            <div class="title">
                <p>Standard Buses</p>
                <!-- <h2>Welcome To 4You</h2> -->
            </div>
        </div>
        <div class="box-1">
            <div class="search-bar">
                <ul>
                    <li class="search">
                        <!--Search bar-->

                        <form action="standardbuses.php" method="post" id="searchForm">
                        <input type="text" <?php echo isset($_POST["search"]) ? "value='$search'" : ""; ?> placeholder="Search buses" name="search" required id="search-input" />
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
                        <th>BUS ID</th>
                        <th>ROUTE ID</th>
                        <th>USER EMAIL</th>
                        <th>CLASS</th>
                        <th>TYPE</th>
                        <th>MODEL</th>
                        <th>REGNO</th>
                        <th>CAPACITY</th>
                        <th>STATUS</th>

                        <th>RATING</th>                       
                        <th>EDIT</th>
                        <th>DELETE</th>
                    </tr>

                    <?php

                    if (isset($_POST["search"])) {

                        $sql = "SELECT sb.*, b.*, user.*, b.status AS bus_status
                        FROM standard_bus sb
                        INNER JOIN bus b ON sb.busID = b.busID
                        INNER JOIN user ON sb.userID = user.userID
                        
                        WHERE sb.busID LIKE '%$search%' OR  routeID LIKE '%$search%'
                        OR  regNo LIKE '%$search%'
                        OR  email LIKE '%$search%'";
                                            
                       
                    }else {
                        $sql = "SELECT sb.*, b.*, user.*, b.status AS bus_status
                        FROM standard_bus sb
                        INNER JOIN bus b ON sb.busID = b.busID
                        INNER JOIN user ON sb.userID = user.userID";
                    }


                    


                    $result = mysqli_query($conn, $sql);
                    $queryResults = mysqli_num_rows($result);

                    if ($queryResults > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<form action='standardbuses.php' method='post'>
                            <tr>
                      <td id='ID'>" . $row["busID"] . "</td>
                      <td> " . $row["routeID"] . "</td>
                      <td>" . $row["email"] . "</td>
                      <td>" . $row["class"] . "</td>
                      <td>" . $row["type"] . "</td>
                      <td>" . $row["model"] . "</td>
                      <td>" . $row["regNo"] . "</td>
                      <td>" . $row["capacity"] . "</td>
                     <td>" . $row["bus_status"] . "</td>
                      <td>" . $row["rating"] . "</td>  
                      <input type='hidden' name='busID' value='". $row["busID"] ."'>
                    <td><button id='update' name='editStandardBus'> Edit</button></td>
                    <td><button id='bin' name='deleteStandardBus'><i class='ri-delete-bin-line'></i></button> </td>

                  </tr></form>";
                        }

                    }
                    ?>

                           
                        




                </table>


            </div>




        </div>
    </div>
    <div class="bottom-box">
        <div class="button"><form action='standardbuses.php' method='post'>
            <button name="addStandardBusButtonBottom" id="popupButtonItem" class="submit">
                Add a new Bus
            </button></form>
        </div>

    </div>


</div>



<div id="overlay-2"></div>
<div id="popupContainerItem">
    <div id="popupContent-item">
        <div class="popup-header-item">
            <div class="form-heading-popup-item">
            <?php if(isset($regNo) && isset($type)) : ?>
                    <p>Edit Bus</p>
                <?php else : ?>
                    <p>Add a Bus</p>
                <?php endif; ?>
            </div>
            <i onclick="closePopupItem()" class="bi bi-x"></i>

        </div>
        <form action="admin_db_model.php" method="post" id="addStandardBusForm"  enctype="multipart/form-data"  onsubmit="return generateBusID()">
            <div class="popup-content-item">



                <div class="add-category-form-item">

                    <div class="inputs-popup-item">

                        <div class="inputs-popup-item-box1">
                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="routeID">Select Route:</label><br>
                                <select class="average-dropdown-popup" name="routeID" id="routeID">
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
                                <label class="labels-popup-item" for="userID">Select User:</label><br>
                                <select class="average-dropdown-popup" name="userID" id="userID">
                                <option selected="selected" value="" hidden>Select User</option>
                                
                                <?php

                                $sql = "SELECT * FROM user WHERE type='operator'";

                                $result = mysqli_query($conn, $sql);
                                $queryResults = mysqli_num_rows($result);

                                if ($queryResults > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $user = array( $row["userID"],$row["type"],$row["email"]);
                                        $userString = implode(" ",$user );
                                        $selected = isset($userID) && $userID == $row["userID"] ? "selected='selected'" : "";
                                        echo "<option value='" . $row["userID"] . "' $selected> $userString </option>";
                                    }

                                }

                                ?>

                                    
                                </select>
                            </div>

                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="busClass">Class:</label><br>
                                <select class="average-dropdown-popup" name="busClass" id="busClass">
                                    <option selected="selected" value="" hidden>Select Class</option>
                                    <option value='Normal' <?php echo isset($busClass) && $busClass=='Normal' ?  "selected='selected'" : ""; ?>>Normal</option>
                                    <option value='Semi Luxury' <?php echo isset($busClass) && $busClass=='Semi Luxury' ?  "selected='selected'" : ""; ?>>Semi Luxury</option>
                                    <option value='Luxury' <?php echo isset($busClass) && $busClass=='Luxury' ?  "selected='selected'" : ""; ?>>Luxury</option>

                                </select>
                            </div>

                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="type">Type:</label><br>
                                <select class="average-dropdown-popup" name="type" id="type">
                                    <option selected="selected" value="" hidden>Select Type</option>
                                    <option  value='AC' <?php echo isset($type) && $type=='AC' ?  "selected='selected'" : ""; ?>>AC</option>
                                    <option  value='Non AC' <?php echo isset($type) && $type=='Non AC' ?  "selected='selected'" : ""; ?>>Non AC</option>
                                </select>
                            </div>

                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="model">Model:</label><br>
                                <input class="divided-input-popup-item" placeholder="Model" type="text"  <?php echo isset($model) ? "value='$model'" : ""; ?> name="model" id="model" />
                            </div>

                            
                        </div>

                        <div class="inputs-popup-item-box2">
                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="regNo">Registration Number:</label><br>

                                <input class="divided-input-popup-item" placeholder="Registration Number" type="text" <?php echo isset($regNo) ? "value='$regNo'" : ""; ?> name="regNo" id="regNo" />
                            </div>

                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="itemImg">Item Image:</label><br>
                                <input class="divided-input-popup-file" type="file" <?php echo isset($image) ? "value='$image'" : ""; ?> name="itemImg" id="itemImg" />
                                
                            </div>

                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="capacity">Capacity:</label><br>
                                <input class="divided-input-popup-item" placeholder="Capacity" <?php echo isset($capacity) ? "value='$capacity'" : ""; ?> type="text" name="capacity" id="capacity" />
                                
                            </div>

                            <div <?php echo !isset($status) ? "hidden" : ""; ?> class="col1-popup-item">
                                <label class="labels-popup-item" for="status">Status:</label><br>
                                <select class="average-dropdown-popup" name="status" id="status" >
                                    <option value="" selected="selected" hidden>Select Status</option>
                                    <option value="active" <?php echo isset($status) && $status=='active' ?  "selected='selected'" : ""; ?>>active</option>
                                    <option value="deactive" <?php echo isset($status) && $status=='deactive' ?  "selected='selected'" : ""; ?>>deactive</option>
                                    
                                </select>
                            </div>

                            <input type="hidden" name="busID" id="busID">
                            <input type="hidden" name="oldBusID" <?php echo isset($oldBusID) ? "value='$oldBusID'" : ""; ?> id="oldBusID">

                            
                        </div>



                    </div>


                </div>


            </div>

            <div class="popup-footer">
                <div class="button-popup-footer">
                <p id="error" style="margin-bottom: 5px; font-size: 13px; text-align: center;"></p>

                <button name="<?php echo isset($regNo) ? "updateStandardBusButton" : "addStandardBusButton"; ?>" class="button-popup">
                        <?php echo isset($regNo) ? "Update Bus" : "Add Bus"; ?>
                </button>
                    
                </div>
            </div>
        </form>

    </div>
</div>




<script>
function generateBusID() {
    // Get values from the form
    let routeID = document.getElementById("routeID").value;
    let busClass = document.getElementById("busClass").value;
    let type = document.getElementById("type").value;
    let regNumber = document.getElementById("regNo").value;
    let model = document.getElementById("model").value;
    let capacity = document.getElementById("capacity").value;
    let userID = document.getElementById("userID").value;
    

    // Check if any of the required fields are empty
    if (regNumber.trim() === "" || model.trim() === "" || capacity.trim() === ""|| routeID.trim() === ""
    || busClass.trim() === ""|| type.trim() === ""|| userID.trim() === "") {
        document.getElementById("error").innerHTML = "Please fill in all required fields";
        return false; // Prevent form submission if any field is empty
    }

    // Remove spaces from the registration number
    let regNoNoSpace = regNumber.split(" ").join("");

    // Generate bus ID using the first two characters of the registration number
    // and make them uppercase
    const busID = regNoNoSpace.substring(0, 2).toUpperCase() + regNoNoSpace.substring(2);

    // Assign the generated bus ID to a hidden input field in the form
    document.getElementById("busID").value = busID;

    return true; // Allow form submission if all validation passes
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