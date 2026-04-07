<?php
session_start();
require_once("../db_conn.php");
require 'PHPMailerAutoload.php';
include("sidemenu.php");

if (isset($_POST["search"])) {
    $search = mysqli_real_escape_string($conn, $_POST["search"]);
}

if (isset($_POST["confirmInquiry"])) {

    $inquiryID = $_POST["inquiryID"];


    $sql = "UPDATE bus_booking SET status = 'confirmed' WHERE inquiryID = $inquiryID";

    mysqli_query($conn, $sql);

    $query = "SELECT name, email, busID, startDate, endDate FROM bus_booking WHERE inquiryID = $inquiryID";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row["name"];
        $email = $row["email"];
        $busID = $row["busID"];
        $startDate = $row["startDate"];
        $endDate = $row["endDate"];

        // Send email
        $mail = new PHPMailer;

        $mail->isSMTP();                                      
        $mail->Host = 'smtp.gmail.com';  
        $mail->SMTPAuth = true;                               
        $mail->Username = 'sharneeshan1001@gmail.com';               
        $mail->Password = 'hhjzffsksjqjgfvr';                           
        $mail->SMTPSecure = 'ssl';                            
        $mail->Port = 465;     

        $mail->setFrom('sharneeshan1001@gmail.com', 'ezBusLK');
        $mail->addAddress($email, $name); 

        $mail->isHTML(true);    

        $mail->Subject = 'Confirm The Bus';
        $mail->Body = "Dear $name,<br><br>Your bus request for bus ID $busID has been confirmed.<br><br>Start Date: $startDate<br>End Date: $endDate<br><br>Thank you for choosing ezBusLK.";
        $mail->AltBody = "Dear $name,\n\nYour bus request for bus ID $busID has been confirmed.\n\nStart Date: $startDate\nEnd Date: $endDate\n\nThank you for choosing ezBusLK.";

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            
        }
    } else {
        echo "No details found for the provided inquiryID";
    }


}



if (isset($_POST["deleteInquiry"])) {
    $inquiryID = $_POST["inquiryID"];

    $sql = "DELETE FROM bus_booking WHERE inquiryID = '$inquiryID'";
    mysqli_query($conn, $sql);

}


?>
<div class="dashboard-content">


    <div class="heading-box">
        <div class="box-1">

            <div class="title">
                <p>Bus Inquiries</p>
                <!-- <h2>Welcome To 4You</h2> -->
            </div>
        </div>
        <div class="box-1">
            <div class="search-bar">
                <ul>
                    <li class="search">
                        <!--Search bar-->

                        <form action="businquiry.php" method="post" id="searchForm">
                        <input type="text" <?php echo isset($_POST["search"]) ? "value='$search'" : ""; ?> placeholder="Search inquiries" name="search" required id="search-input" />
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
                        <th>INQUIRY ID</th>
                        <th>BUS ID</th>
                        <th>NAME</th>
                        <th style="width: 30px;">NIC</th>
                        <th style="width: 30px;">EMAIL</th>
                        <th>CONTACT NO</th>  
                        <th>START DATE</th>
                        <th>END DATE</th> 
                        <th>ADDED DATE</th>
                        <th>STATUS</th> 
                        <th>CONFIRM</th>                     
                        <th>DELETE</th>

                    </tr>

                    <?php

                    if (isset($_POST["search"])) {
                                            
                        $sql = "SELECT * FROM bus_booking
                        WHERE bus_booking.inquiryID LIKE '%$search%' ";
                    }else {
                        $sql = "SELECT * FROM bus_booking
                            ";
                    }
                    


                    $result = mysqli_query($conn, $sql);
                    $queryResults = mysqli_num_rows($result);

                    if ($queryResults > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {

                            echo "<form action='businquiry.php' method='post'>
                            <tr>
                      <td id='ID'>" . $row["inquiryID"] . "</td>
                      <td>" . $row["busID"] . "</td>
                      <td>" . $row["name"] . "</td>
                      <td>" . $row["nic"] . "</td>
                      <td>" . $row["email"] . "</td>
                     <td>" . $row["contactNo"] . "</td>
                      <td>" . $row["startDate"] . "</td>
                      <td>" . $row["endDate"] . "</td>
                      <td>" . $row["addedDate"] . "</td>
                      <td>" . $row["status"] . "</td>
                      <input type='hidden' name='inquiryID' value='" . $row["inquiryID"] . "'>
                      <td>";
                      if ($row["status"] == "pending") {
                          echo "<button id='confirm' name='confirmInquiry'>Confirm</button></td>";
                      } else if ($row["status"] == "confirmed") {
                          echo "<button id='confirmed' name='confirmInquiry'>Confirmed</button></td>";
                      }
                    echo "<td><button id='bin' name='deleteInquiry'><i class='ri-delete-bin-line'></i></button> </td>

                  </tr></form>";
                        }

                    }

                    ?>
                    

                           
                        




                </table>


            </div>




        </div>
    </div>
    <div class="bottom-box">
        

    </div>


</div>




</body>

</html>
<script>
    function submitForm() {
        document.getElementById('searchForm').submit();
    }
</script>