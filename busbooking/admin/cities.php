<?php
session_start();
require_once("../db_conn.php");
include("sidemenu.php");



if (isset($_POST["editStop"])) {
    if (isset($_POST["stopID"])) {
        $stopID = $_POST["stopID"];
        $oldStopID = $stopID;
        $overlayDisplay = 'block';
        $popupContainerDisplay = 'block';

        // Fetch route details from the database
        $sql = "SELECT * FROM stop WHERE stopID = '$stopID'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $city = $row["city"];
            }
        }


    }
}

if (isset($_POST["deleteStop"])) {
    $stopID = $_POST["stopID"];

    $sql = "DELETE FROM stop WHERE stopID = '$stopID'";

    mysqli_query($conn, $sql);

    
}

if (isset($_POST["addStopButtonBottom"])) {
    // Unset variables when Add Route button is clicked
    unset($stopID);
    unset($city);

    $overlayDisplay = 'block';
    $popupContainerDisplay = 'block';
}


?>


<div class="dashboard-content">

    <div class="heading-box">
        <div class="box-1">

            <div class="title">
                <p>Stops</p>
                <!-- <h2>Welcome To 4You</h2> -->
            </div>
        </div>
        <div class="box-1">
            <div class="search-bar">
                <ul>
                    <li class="search">
                        <!--Search bar-->
                        <form action="search.php" method="post">

                            <input type="text" placeholder="Search items" name="search" required id="search-input" />
                            <i class="bx bx-search-alt-2"></i>


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
                        <th>CITY ID</th>
                        <th>CITY NAME</th>
                        <th>EDIT</th>
                        <th>DELETE</th>
                    </tr>

                    <?php


                    $sql = "SELECT * FROM stop";


                    $result = mysqli_query($conn, $sql);
                    $queryResults = mysqli_num_rows($result);

                    if ($queryResults > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {

                    
                            echo "<form action='cities.php' method='post'>
                            <tr>
                          <td id='ID'>" . $row["stopID"] . "</td>
                          <td>" . $row["city"] . "</td>
                          <input type='hidden' name='stopID' value=" . $row["stopID"] . ">
                          <td><button id='update'  name='editStop'> Edit</button></td>
                          <td><button id='bin' name='deleteStop'><i class='ri-delete-bin-line'></i></button> </td>
                      </tr></form>";
                        }

                    }

                    ?>
                    
                </table>


            </div>


        </div>
    </div>
    <div class="bottom-box">
        <div class="button"><form action='cities.php' method='post'>
            <button name="addStopButtonBottom" id="popupButtonItem" class="submit">
                Add a Stop
            </button></form>
        </div>


    </div>
</div>

<div id="overlay-2"></div>
<div id="popupContainerItem">
    <div id="popupContent-item">
        <div class="popup-header-item">
            <div class="form-heading-popup-item">
                <?php if(isset($city) && isset($stopID)) : ?>
                    <p>Edit Stop</p>
                <?php else : ?>
                    <p>Add a Stop</p>
                <?php endif; ?>
            </div>
            <i onclick="closePopupItem()" class="bi bi-x"></i>
        </div>
        <form action="admin_db_model.php" method="post" id="addRouteForm" onsubmit="return generateStopID()">
            <div class="popup-content-item">
                <div class="add-category-form-item">
                    <div class="inputs-popup-item">
                        <div class="inputs-popup-item-box1">
                           
                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="stopID">Stop ID:</label><br>
                                <input class="divided-input-popup-item" placeholder="City ID" type="text"  <?php echo isset($stopID) ? "value='$stopID'" : ""; ?> name="stopID" id="stopID" />
                            </div>
                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="city">City :</label><br>
                                <input class="divided-input-popup-item" placeholder="City" type="text"  <?php echo isset($city) ? "value='$city'" : ""; ?> name="city" id="city" />
                            </div>
                            
                            <input type="hidden" name="newStopID" id="newStopID">
                            <input type="hidden" name="oldStopID" <?php echo isset($oldStopID) ? "value='$oldStopID'" : ""; ?> id="oldStopID">
                            
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="popup-footer">
                <div class="button-popup-footer">
                    
                    <?php
                        if (isset($_SESSION["errors_stop"])) {
                            $errors = $_SESSION["errors_stop"];
                            foreach ($errors as $error) {
                                echo '<p id="error" style="margin-bottom: 5px; font-size: 13px; text-align: center;">' . $error . '<p>';
                                break;
                            }
                            unset($_SESSION["errors_stop"]);
                        } else {
                        }
                        echo '<p id="error" style="margin-bottom: 5px; font-size: 13px; text-align: center;"><p>';

                    ?>
                

                    <button name="<?php echo isset($city) ? "updateStopButton" : "addStopButton"; ?>" class="button-popup">
                        <?php echo isset($city) ? "Update Stop" : "Add Stop"; ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    
function generateStopID() {
    const stopID = document.getElementById("stopID").value;
    const city = document.getElementById("city").value;

    if (stopID.trim() === "" || city.trim() === "") {
        document.getElementById("error").innerHTML = "Please fill in all required fields";
        return false;
    }

    
    const stopIDUpper = stopID.toUpperCase();
    
    
    document.getElementById("newStopID").value = stopIDUpper;
    return true;
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


</body>

</html>