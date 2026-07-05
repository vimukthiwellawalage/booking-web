<?php
require_once("db_conn.php");



if (isset($_POST["inquire-bus"])) {

    $busID = $_POST["busID"];
    
    $overlayDisplay = 'block';
    $popupContainerDisplay = 'block';

    

    
}

?>

<?php
$pageTitle = "Yamu - Special Buses";
$extraStyles = ["stylepopup.css"];
include("header.php");
?>
<main>

    <section class="find-bus-bar">
        <div class="find-bar">


            <form action="findbus.php" method="post" id="findBusForm" onsubmit="return validateInputs()">
                <div class="seat-booking-bar">

                    <div class="selection-bar">


                        <input <?php echo isset($from) ? "value='$from'" : ""; ?> type="text" placeholder="Search type, model or name" name="from" id="from" class="input-spec" />

                        
                        <button name="submit-index" class="input-submit" type="submit">Submit</button>

                    </div>

                </div>
                
            </form>




        </div>


    </section>
    

    

    <section class="bus-container" >
        <?php
        
        date_default_timezone_set("Asia/Colombo");
        $currentDateTime = date("H:i:s");


    
    $sql2 = "SELECT  bus.*, special_bus.* FROM special_bus
            INNER JOIN bus ON special_bus.busID = bus.busID";

    $result2 = mysqli_query($conn, $sql2);
    $queryResults2 = mysqli_num_rows($result2);

    if ($queryResults2 > 0) {
        while ($row = mysqli_fetch_assoc($result2)) {
            
            echo '
            <div class="bus-card">
            <div class="route-row-spec">
            <p>'.$row["name"].'</p>
            <form action="findspecialbus.php" method="post"><button type="submit" name="inquire-bus" class="inquire-spec-button">Inquire
            <input type="hidden" name="busID" value="' . $row["busID"] . '">
            </button>
            
            </form>

 
            </div>
            <div class="rule">

            </div>
            <div class="card-body-row-spec">
                <div class="wide-col">
                    <img class="bus-img" src="images/'.$row["image"].'">
                </div>
                <div class="wide-col-right">
                <div class="row-one">
                <div class="body-row-spec">
                    <p class="body-heading">
                        Name
                    </p>
                    <p class="body-context">'.$row["name"].'</p>

                </div>
                
                <div class="body-row-spec">
                    <p class="body-heading">
                        Model
                    </p>
                    <p class="body-context">'.$row["model"].'</p>

                </div>
                <div class="body-row-spec">
                    <p class="body-heading">
                        Type

                    </p>
                    <p class="body-context">'.$row["type"].'</p>

                </div>
                <div class="body-row-spec">
                    <p class="body-heading">
                        Capacity
                    </p>
                    <p class="body-context">
                    '.$row["capacity"].'

                    </p>

                </div>
                <div class="body-row-spec">
                    <p class="body-heading">
                        Rating
                    </p>
                    <p class="body-context">
                    '.$row["rate"].'

                    </p>

                </div>

            </div>
            
            <div class="row-one">
            <div class="body-row-spec-des">
                    <p class="body-heading">
                        Description
                    </p>
                    <p class="body-context">
                    '.$row["description"].'
                    </p>

                </div>
            
                
                
            </div>
            
            
                </div>
                
            </div>
            <div class="footer-row">

            </div>


        </div>
                            
                            ';
                            
                        }

                    }







        ?>

        


    </section>

    

<div id="overlay-2"></div>
<div id="popupContainerItem">
    <div id="popupContent-item">
        <div class="popup-header-item">
            <div class="form-heading-popup-item">
            
                    <p>Inquire</p>
                
            </div>
            <i onclick="closePopupItem()" class="bi bi-x"></i>

        </div>
        <form action="db_model.php" method="post" id="addStandardBusForm"  enctype="multipart/form-data"  onsubmit="return validateForm()">
            <div class="popup-content-item">



                <div class="add-category-form-item">

                    <div class="inputs-popup-item">
               
                        <div class="inputs-popup-item-box1">
                        <div class="col1-popup-item">
                                <label class="labels-popup-item" for="name">Customer Name:</label><br>
                                <input class="divided-input-popup-item" placeholder="Name" type="text" name="name" id="name" />
                            </div>
                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="nic">NIC:</label><br>
                                <input class="divided-input-popup-item" placeholder="NIC Number" type="text"  name="nic" id="nic" />
                            </div>
                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="email">Email:</label><br>
                                <input class="divided-input-popup-item" placeholder="Email" type="text"  name="email" id="email" />
                            </div>

                            <div class="col1-popup-item-form">
                                <div class="col1-popup-item-form-col">
                                    <label class="labels-popup-item" for="startDate">Start Date:</label><br>

                                    <input class="divided-input-popup-item-form" placeholder="Trip Date" type="date" min="<?php echo date('Y-m-d'); ?>"  name="startDate" id="startDate" />
                                </div>
                                <div class="col1-popup-item-form-col">
                                    <label class="labels-popup-item" for="endDate">End Date:</label><br>

                                    <input class="divided-input-popup-item-form" placeholder="Trip Date" type="date" min="<?php echo date('Y-m-d'); ?>"   name="endDate" id="endDate" />
                                </div>
                                
                            </div>

                            <div class="col1-popup-item">
                                <label class="labels-popup-item" for="contactNo">Contact No:</label><br>
                                <input class="divided-input-popup-item" placeholder="Contact No" type="text"  name="contactNo" id="contactNo" />
                            </div>

                            

                            

                            <input type="hidden" name="busID" <?php echo isset($busID) ? "value='$busID'" : ""; ?> id="busID">
                            


                            
                        </div>

                        



                    </div>


                </div>


            </div>

            <div class="popup-footer">
                <div class="button-popup-footer">
                <p id="error" style="margin-bottom: 5px; font-size: 13px; text-align: center;"></p>

                <button name="addInquiryButton" class="button-popup">
                        Inquire
                </button>
                    
                </div>
            </div>
        </form>

    </div>
</div>



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
function validateForm() {
    // Get values from the form
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let nic = document.getElementById("nic").value;
    let contactNo = document.getElementById("contactNo").value;
    let startDate = document.getElementById("startDate").value;
    let endDate = document.getElementById("endDate").value;
 
    

    // Check if any of the required fields are empty
    if (name.trim() === "" || email.trim() === "" || nic.trim() === ""|| contactNo.trim() === ""
    || startDate.trim() === ""|| endDate.trim() === "") {
        document.getElementById("error").innerHTML = "Please fill in all required fields";
        return false; // Prevent form submission if any field is empty
    }

    if (!validatePhoneNumber(contactNo)) {
        
        document.getElementById("error").innerHTML = "Phone Number is not valid";
        return false; // Prevent form submission if any field is empty
    }

    if (!validateEmail(email)) {
        
        document.getElementById("error").innerHTML = "Email is not valid";
        return false; // Prevent form submission if any field is empty
    }

    

    return true; // Allow form submission if all validation passes
}


function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function validatePhoneNumber(contactNo) {
    var re = /^\d{10}$/;
    return re.test(contactNo);
}


</script>


<script>
    function submitForm() {
        document.getElementById('searchForm').submit();
    }
</script>





    <?php include("footer.php"); ?>
</main>