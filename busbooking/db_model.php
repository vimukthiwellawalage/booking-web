<?php
session_start();
require_once("db_conn.php");
require 'PHPMailerAutoload.php';

if(isset($_POST["paymentdetails"])){

    // Sanitize user inputs
    $tripID =  $_SESSION['booking-info']["tripID"];
    $origin = $_SESSION['booking-info']["origin"];
    $tempBookingID = $_SESSION['booking-info']["tempBookingID"];
    $destination = $_SESSION['booking-info']["destination"];
    $from = $_SESSION['booking-info']["from"];
    $to = $_SESSION['booking-info']["to"];
    $tripDate = $_SESSION['booking-info']["tripDate"];
    $regNo = $_SESSION['booking-info']["regNo"];
    $departTime = $_SESSION['booking-info']["departTime"];
    $arrivalTime = $_SESSION['booking-info']["arrivalTime"];
    $selectedSeats = $_SESSION['booking-info']["selectedSeats"];
    $seatsCount = $_SESSION['booking-info']["seatsCount"];
    $totalPayment = $_SESSION['booking-info']["totalPayment"];
    $namePass = $_SESSION['booking-info']["namePass"];
    $nic = $_SESSION['booking-info']["nic"];
    $phoneNo =$_SESSION['booking-info']["phoneNo"];
    $email = $_SESSION['booking-info']["email"];
    $bookingID =  uniqid('b_');

    // Insert customer data
    $sql1 = "INSERT INTO customer (nic, email, phoneNo, name) VALUES ('$nic', '$email', '$phoneNo', '$namePass')";
    if (!mysqli_query($conn, $sql1)) {
        die("Error inserting customer data: " . mysqli_error($conn));
    }
    $customerID = mysqli_insert_id($conn);

    // Insert payment data
    $sql2 = "INSERT INTO payment (totalPayment) VALUES ('$totalPayment')";
    if (!mysqli_query($conn, $sql2)) {
        die("Error inserting payment data: " . mysqli_error($conn));
    }
    $paymentID = mysqli_insert_id($conn);

    // Insert booking data
    $sql3 = "INSERT INTO booking (bookingID, paymentID, customerID) VALUES ('$bookingID','$paymentID','$customerID')";
    if (!mysqli_query($conn, $sql3)) {
        die("Error inserting booking data: " . mysqli_error($conn));
    }
    

    // Insert trip booking data
    $sql4 = "INSERT INTO trip_booking (bookingID, tripID, pickup, dropPoint, noOfSeats) VALUES ('$bookingID','$tripID','$from','$to',$seatsCount)";
    if (!mysqli_query($conn, $sql4)) {
        die("Error inserting trip booking data: " . mysqli_error($conn));
    }

    // Insert seat data
    $selectedSeatsArr = explode(",", $selectedSeats);
    foreach ($selectedSeatsArr as $seat) {
        $seatNo = mysqli_real_escape_string($conn, $seat);
        $sql5 = "INSERT INTO seat (tripID, bookingID, seatNo) VALUES ('$tripID', '$bookingID', '$seatNo')";
        if (!mysqli_query($conn, $sql5)) {
            die("Error inserting seat data: " . mysqli_error($conn));
        }
    }

    // Update available seats
    $sql6 = "DELETE FROM temp_booking WHERE tempBookingID = '$tempBookingID'";
    if (!mysqli_query($conn, $sql6)) {
        die("Error updating available seats: " . mysqli_error($conn));
    }



    $mail = new PHPMailer;

                              

    $mail->isSMTP();                                      
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;                               
    $mail->Username = 'sharneeshan1001@gmail.com';               
    $mail->Password = 'hhjzffsksjqjgfvr';                           
    $mail->SMTPSecure = 'ssl';                            
    $mail->Port = 465;                                    
    
    $mail->setFrom('sharneeshan1001@gmail.com', 'ezBusLK');
    $mail->addAddress($email, 'Recipient Name'); 
    
    $mail->isHTML(true);                                
    
    $baseUrl = "http://localhost/busbooking/";
    
    
    $mail->Subject = 'Your Booking Confirmation';
    $mail->Body = "Thank you for your booking!<br><br>
                  <b>Booking Details:</b><br>
                  Destination: $destination<br>
                  From: $from<br>
                  To: $to<br>
                  Trip Date: $tripDate<br>
                  Departure Time: $departTime<br>
                  Arrival Time: $arrivalTime<br>
                  Selected Seats: $selectedSeats<br>
                  Seats Count: $seatsCount<br>
                  Total Payment: $totalPayment<br><br>
                  Click <a href='" . $baseUrl . "ticket.php?bookingID=$bookingID'>here</a> to view your ticket.";
    $mail->AltBody = "Your Booking Confirmation.\n\nBooking Details:\n
                      Destination: $destination\n
                      From: $from\n
                      To: $to\n
                      Trip Date: $tripDate\n
                      Departure Time: $departTime\n
                      Arrival Time: $arrivalTime\n
                      Selected Seats: $selectedSeats\n
                      Seats Count: $seatsCount\n
                      Total Payment: $totalPayment\n\n
                      Visit " . $baseUrl . "ticket.php?bookingID=$bookingID to view your ticket.";
    
    
    
    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
      
        header("Location: ticket.php?bookingID=$bookingID");
        exit(); 
    }
    
    
    
    }







if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['login'])) {

        $email = $_POST["email"];
        $password = $_POST["password"];
        $errors = [];
        $sql = "SELECT * FROM user WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if($result) {
            $row = mysqli_fetch_assoc($result);

            if (!password_verify($password,$row["password"])) {
                $errors["login_incorrect"]= "Incorrect login Info!";
            } 
            
        }else {
            $errors["login_incorrect"]= "Incorrect login Info!";
        }

        if($errors) {
            $_SESSION["errors_login"] =$errors;
            header("Location: login.php?login=unsuccess");
            die();
        }
        
        $user_id=$row["userID"];
        $user_email= htmlspecialchars($row["email"]);
        $user_type=htmlspecialchars($row["type"]);
        $user_name=htmlspecialchars($row["name"]);



        $userarray=array (
            "user_id"=>$user_id,"user_email"=> $user_email,"user_name"=>$user_name, "user_type"=>$user_type
        );


        $_SESSION["user"]=$userarray;
        if ($user_type === 'admin') {
           
            echo '<script>window.location = "admin/routes.php";</script>';
        } elseif($user_type === 'operator') {
            
            echo '<script>window.location = "operator/account.php";</script>';
        }
        die();

    }


} else {
    header(" Location:index.php");
    die();
}




if (isset($_POST["addInquiryButton"])) {
    $busID = $_POST["busID"];

    $name = $_POST["name"];
    $nic=$_POST["nic"];
    $email = $_POST["email"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $contactNo = $_POST["contactNo"];



    $sql = "INSERT INTO bus_booking (busID,name,nic, email, contactNo, startDate,endDate) 
            VALUES ('$busID','$name','$nic','$email','$contactNo','$startDate','$endDate')";

    mysqli_query($conn, $sql);

    header("Location: findspecialbus.php");

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


    $mail->Subject = 'Request For Bus';
    $mail->Body = "Dear $name,<br><br>Thank you for your bus request with ezBusLK.<br><br>
                    Details of your request:<br>
                    Name: $name<br>
                    NIC: $nic<br>
                    Email: $email<br>
                    Contact Number: $contactNo<br>
                    Start Date: $startDate<br>
                    End Date: $endDate<br><br>
                    We will respond to your request soon.";
    $mail->AltBody = "Dear $name,\n\nThank you for your bus request with ezBusLK.\n\n
                    Details of your request:\n
                    Name: $name\n
                    NIC: $nic\n
                    Email: $email\n
                    Contact Number: $contactNo\n
                    Start Date: $startDate\n
                    End Date: $endDate\n\n
                    We will respond to your request soon.";

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }





if (!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
}




?>


?>