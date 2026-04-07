<?php
session_start();
require_once("../db_conn.php");
include("sidemenu.php");

if (isset($_POST["search"])) {
    $search = mysqli_real_escape_string($conn, $_POST["search"]);
}


if (isset($_POST["editUser"])) {
    if (isset($_POST["userID"])) {
        $userID = $_POST["userID"];
        
        $overlayDisplay = 'block';
        $popupContainerDisplay = 'block';

        // Fetch route details from the database
        $sql = "SELECT * FROM user
                WHERE userID = '$userID'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $email = $row["email"];
                $name = $row["name"];
                
                $type = $row["type"];
                $status = $row["status"];
                
                
            }
        }


    }
}


if (isset($_POST["deleteUser"])) {
    $userID = $_POST["userID"];

    $sql = "DELETE FROM user WHERE userID = '$userID'";
    mysqli_query($conn, $sql);

    
}



if (isset($_POST["addUserButtonBottom"])) {
    // Unset variables when Add Route button is clicked
    unset($email);
    unset($name);
    unset($type);
    unset($status);


    $overlayDisplay = 'block';
    $popupContainerDisplay = 'block';
}

?>
<div class="dashboard-content">


    <div class="heading-box">
        <div class="box-1">

            <div class="title">
                <p>User</p>
                <!-- <h2>Welcome To 4You</h2> -->
            </div>
        </div>
        <div class="box-1">
            <div class="search-bar">
                <ul>
                    <li class="search">
                        <!--Search bar-->
                        <form action="useraccounts.php" method="post" id="searchForm">
                        <input type="text" <?php echo isset($_POST["search"]) ? "value='$search'" : ""; ?> placeholder="Search users" name="search" required id="search-input" />
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
                        <th>USER ID</th>
                        <th>TYPE</th>
                        <th>EMAIL</th>
                        <th>NAME</th>
                        <th>STATUS</th>
                        <th>EDIT</th>
                        <th>DELETE</th>
                    </tr>
                    
                    <?php

                    if (isset($_POST["search"])) {
                                            
                        $sql = "SELECT * FROM user
                            
                        WHERE userID LIKE '%$search%' OR  email LIKE '%$search%'
                        ";
                    }else {
                        $sql = "SELECT * FROM user
                            ";
                    }

                    


                    $result = mysqli_query($conn, $sql);
                    $queryResults = mysqli_num_rows($result);

                    if ($queryResults > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {

                            echo "<form action='useraccounts.php' method='post'>
                            <tr>
                      <td id='ID'>" . $row["userID"] . "</td>
                      <td>" . $row["type"] . "</td>
                      <td>" . $row["email"] . "</td>
                      <td>" . $row["name"] . "</td>
                     <td>" . $row["status"] . "</td>
                      <input type='hidden' name='userID' value='" . $row["userID"] . "'>
                    <td><button id='update' name='editUser'> Edit</button></td>
                    <td><button id='bin' name='deleteUser'><i class='ri-delete-bin-line'></i></button> </td>

                  </tr></form>";
                        }
                    }

                           
?>


                </table>


            </div>



        </div>
    </div>
    <div class="bottom-box">
        <div class="button"><form action='useraccounts.php' method='post'>
            <button name="addUserButtonBottom" id="popupButtonItem" class="submit">
                Add a new User
            </button></form>
        </div>

    </div>


</div>



<div id="overlay-2"></div>
<div id="popupContainerItem">
    <div id="popupContent-item">
        <div class="popup-header-item">
            <div class="form-heading-popup-item">
            <?php if(isset($email) && isset($name)) : ?>
                    <p>Edit User</p>
                <?php else : ?>
                    <p>Add a User</p>
                <?php endif; ?>
            </div>
            <i onclick="closePopupItem()" class="bi bi-x"></i>

        </div>
        <form action="admin_db_model.php" method="post" id="addUserForm"  onsubmit="return validateForm()">
            <div class="popup-content-item">

                <div class="add-category-form-item">

                    <div class="inputs-popup-item">

                        <div class="inputs-popup-item-box1">
                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="name">Name:</label><br>

                                <input class="divided-input-popup-item" placeholder="Name" type="text" name="name" <?php echo isset($name) ? "value='$name'" : ""; ?> id="name" />
                            </div>


                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="email">Email:</label><br>

                                <input class="divided-input-popup-item" placeholder="Email" type="text" name="email" <?php echo isset($email) ? "value='$email'" : ""; ?> id="email" />
                            </div>

                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="password">Password:</label><br>

                                <input class="divided-input-popup-item" placeholder="Password" type="text" name="password" <?php echo isset($password) ? "value='$password'" : ""; ?> id="password" />
                            </div>
                            

                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="type">User Type:</label><br>
                                <select class="average-dropdown-popup" name="type" id="type" >
                                    <option value="" selected="selected" hidden>Select Type</option>
                                    <option value="admin" <?php echo isset($type) && $type=='admin' ?  "selected='selected'" : ""; ?>>Admin</option>
                                    <option value="operator" <?php echo isset($type) && $type=='operator' ?  "selected='selected'" : ""; ?>>Bus Operator</option>
                                    
                                </select>
                            </div>
                        </div>

                        <div class="inputs-popup-item-box2">

                            

                            <div <?php echo !isset($status) ? "hidden" : ""; ?> class="col1-popup-item">
                                <label class="labels-popup-item" for="status">Status:</label><br>
                                <select class="average-dropdown-popup" name="status" id="status" >
                                    <option value="" selected="selected" hidden>Select Status</option>
                                    <option value="active" <?php echo isset($status) && $status=='active' ?  "selected='selected'" : ""; ?>>active</option>
                                    <option value="deactive" <?php echo isset($status) && $status=='deactive' ?  "selected='selected'" : ""; ?>>deactive</option>
                                    
                                </select>
                            </div>

                            
                            <input type="hidden" <?php echo isset($userID) ? "value='$userID'" : ""; ?> name="userID" id="userID">
                            
                        </div>
                        



                    </div>


                </div>


            </div>

            <div class="popup-footer">
                <div class="button-popup-footer">
                <p id="error" style="margin-bottom: 5px; font-size: 13px; text-align: center;"></p>
                <button name="<?php echo isset($email) ? "updateUserButton" : "addUserButton"; ?>" class="button-popup">
                        <?php echo isset($email) ? "Update User" : "Add User"; ?>
                </button>
                </div>
            </div>
        </form>

    </div>
</div>



<script>
function validateForm() {
        // Get values from the form
    let email = document.getElementById("email").value;
    let name = document.getElementById("name").value;
    let password = document.getElementById("password").value;
    let type = document.getElementById("type").value;

    // Check if any field is empty
    if (email === "" || name === "" || password === ""|| type === "") {
        document.getElementById("error").innerHTML = "Please fill in all required fields";
        return false; // Prevent form submission
    }
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Check if email is empty or doesn't match the regex
        if (email === "" || !emailRegex.test(email)) {
            document.getElementById("error").innerHTML = "Please enter a valid email address";
            return false; // Prevent form submission
        }

        // Check if password is empty or shorter than 8 characters
        if (password === "" || password.length < 8) {
            document.getElementById("error").innerHTML = "Password must be at least 8 characters long";
            return false; // Prevent form submission
        }

        // Clear any previous error message
        document.getElementById("error").innerHTML = "";

        // Allow form submission
        return true;
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