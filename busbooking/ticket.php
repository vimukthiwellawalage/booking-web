<?php
session_start();
require_once("db_conn.php");

$bookingID = $_GET["bookingID"];

   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Table Results</title>
    <link rel="stylesheet" href="stylesheetone.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tomorrow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    

    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&display=swap" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.5.2/dom-to-image.min.js"></script>
    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

    
</head>

<style media="screen">
@import url('https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&display=swap');

    :root {
--offwhite: #edebe6;
--black: #000000;
--white: #ffffff;
--blue: #000b3d;
--gray: rgb(115, 114, 114);
--skyblue:  #113978;
--skyblue2: rgb(13, 136, 188);
}

body {
    
    padding-bottom: 0px;
    margin-bottom: 0px;
    
}

main{
width: 100%;

margin: 0;
padding-top: 40px;
background-color: #113978;
padding-bottom: 40px;

}
.center{
    
padding: 0px 0px;
width: 100%;
justify-content: center;
align-items: center;
display: flex;
flex-direction: column;


}
.ticket{
  
width: 900px;
height: 350px;
background-color: #edebe6;
position: relative;
align-items: center;
display: flex;
justify-content: space-between;

overflow: hidden;
margin-bottom: 10px;
}
.left{
    
height: 100%;
width: 200px;
position: relative;
display: flex;
align-items: center;
justify-content: center;


}
.right{
    
width: 700px;
height: 100%;
padding-left: 20px;
padding-right: 20px;
background-image: linear-gradient(rgba(0, 12, 74, 0.7)45%, rgba(255,255,255,0)0%);
background-position: left;
background-size: 2px 25px;
background-repeat: repeat-y;
position: relative;
flex-direction: column;
 
}
.circle{
height: 40px;
width: 40px;
border-radius: 50%;
background:#113978;

}
.circles{
position: absolute;
width: fit-content;
height: 380px;
top: 50%;
transform: translate(0,-50%);
left: 180px;
display: flex;
align-items: center ;
justify-content: space-between;
flex-direction: column;

}

.number{
    
height: 300px;
width: 104px;
padding: 10px 23px 10px 20px;
border: 2px solid #000b3d;
border-radius: 1mm;
writing-mode: vertical-lr;
text-align: center;
line-height: 50px;
font-size: 30px;
color: #113978;



}
#left-title {
    text-align: center; 
    font-size: 30px; 
    color: var(--skyblue); 
    padding-bottom: 20px;
    font-family: "Poppins", sans-serif;
  font-weight: 600;
}
#left-id {
  
    font-size: 10px; 
    

  
}
.top-box{
    
display: flex;
flex-direction: row;
justify-content: space-between;
align-content: space-between;
height: 40px;

}

.pass-journey-container{
display: flex;
flex-direction: row;
width: 100%;
height: auto;


}
.des-ticket{
width: 60%;
height: 100%;
display: flex;
flex-direction: row;
padding-top: 10px; 


}
.box-journey{
display: flex;
flex-direction: column;



}

.ticket-title {
    text-align: center; 
    font-size: 35px; 
    color: var(--skyblue); 
    padding-bottom: 20px;
    font-family: "Poppins", sans-serif;
  font-weight: 600;

}

#ref-no {
      color: darkblue;
   float: right;
   font-weight: 500;
}

.box-context {
    padding: 10px 10px;
    
}

.des-journey{
display: flex;
flex-direction: column;
padding-left: 20px;
padding-bottom: 10px;


}
.des-title{
width: 130px;
padding-right: 10px;


}

.title-one h2 {
    font-family: "Poppins", sans-serif;
  font-weight: 600;
  font-size: 16px;
  font-style: normal;
  color: white;
}
.des-title h3{
    font-family: "Poppins", sans-serif;
  font-weight: 600;
  font-style: normal;
 font-size: 0.75rem;
font-weight: 800px;
color:#113978;
}

.des-title-passenger h3{
    font-family: "Poppins", sans-serif;
  font-weight: 600;
  font-style: normal;
font-size: 0.76rem;
padding-right: 5px;
color: var(--black);
}
.des-content-passenger h4{
     font-family: "Poppins", sans-serif;
  font-weight: 500;
  font-style: normal;
    font-size: 0.95rem;

padding-right: 5px;
color: var(--white);
}

.des-content h4{
    font-family: "Poppins", sans-serif;
  font-weight: 600;
  font-style: normal;
    font-size: 0.98rem;
padding: 1px 0px 5px 0px;
color: var(--skyblue);
}

.des-content-passenger-ticket h4{
    font-size: 22px;
    color: white;
    padding-left: 15px;
    font-family: "Poppins", sans-serif;
  font-weight: 600;
  font-style: normal;
  text-align: right;
}

.des-passenger{
width: 40%;
height: 245px;
background-color: rgb(15, 150, 190);
border-top-left-radius: 10px;
padding-top: 10px;
margin-left: 10px;


}

.des-journey-passenger{
display: flex;
justify-content: flex-end;
flex-direction: column;
padding-right: 10px;
padding-bottom: 10px;


}

#download {
    


font-family: "Ubuntu", sans-serif;
background-color:  rgb(8, 139, 199);
font-weight: 500;
font-size: 15px;
font-style: normal;
padding: 12px;
width: 200px;
height: 50px;
margin: 20px 0px 20px 0px;
border: none;
border-radius: 5px;
color: white;


}

.des-container{
display: flex;
flex-direction: column;

}
.price-box{
display: flex;
flex-direction: row;

}
.button-download{
font-family: "Ubuntu", sans-serif;
  background-color:  #000b3d;
  font-weight: 500;
  font-size: 15px;
  font-style: normal;
  padding: 10px 10px 10px 20px;
  width: 200px;
  height: 50px;
  margin: 40px 0px 20px 10px;
  border: none;
  border-radius: 5px;
  color: white;
}
</style>

<body   onload="autoClick();">
<header class="header">

        
<div class="nav-bar">
    <div class="box-1">
        <img class="logo" src="images/logo2.12.png">
    </div>
    <div class="box-2">
        <ul>
            <li><a  href="index.php">Home</a></li>
            <li><a href="viewSchedule.php">View Schedule</a></li>
            <li><a href="findspecialbus.php">Special Buses</a></li>
            <li><a href="aboutus.php">About Us</a></li>


        </ul>
    </div>
    <div class="box-3">
        <div class="account-box">
            <div class="account-icon">
            
                <a href="login.php"> &nbsp;<i class="bi bi-person-circle"></i></i></a>

            </div>
            <div class="account-name">
                <a id="name" href="login.php">Agent Login</a>
            </div>

        </div>

        
    </div>
    
</div>



</header>
    <main >
        <div class="center">
            
            <div id="htmlContent" >
                <?php
                    $sql2 = "SELECT booking.*, trip_booking.*, turn.*, customer.*,route.*, bus.*, standard_bus.*, trip.*,seat.*, trip.tripID AS scheduleID FROM booking
                    INNER JOIN trip_booking ON booking.bookingID = trip_booking.bookingID
                    INNER JOIN seat ON booking.bookingID = seat.bookingID
                    INNER JOIN customer ON booking.customerID = customer.customerID
                    INNER JOIN trip ON trip_booking.tripID = trip.tripID
                    INNER JOIN turn ON trip.turnID = turn.turnID
                    INNER JOIN route ON trip.routeID = route.routeID
                    INNER JOIN bus ON trip.busID = bus.busID
                    INNER JOIN standard_bus ON bus.busID = standard_bus.busID 
                    WHERE booking.bookingID='$bookingID'";

                    $result2 = mysqli_query($conn, $sql2);
                    $queryResults2 = mysqli_num_rows($result2);

                    if ($queryResults2 > 0) {
                        while ($row = mysqli_fetch_assoc($result2)) {
                            $depTimeOri = $row["depTimeOri"];
                            $depTimeDes = $row["depTimeDes"];
                            $duration = $row["duration"];
                            $secs = strtotime($duration)-strtotime("00:00:00");
                            
                            $arrivalTime = ($row["turnType"] === 'depart') ? date("H:i:s",strtotime($depTimeOri)+$secs) :date("H:i:s",strtotime($depTimeDes)+$secs) ;

                            // Check if the arrival time exceeds 24 hours
                            if ($row["turnType"] === 'depart' && strtotime($depTimeOri) + $secs >= strtotime('24:00:00')) {
                                // Add 1 day to the date if arrival time exceeds 24 hours
                                $arrivalDate = date('Y-m-d', strtotime($row["date"] . ' +1 day'));
                            } elseif ($row["turnType"] === 'arrive' && strtotime($depTimeDes) + $secs >= strtotime('24:00:00')) {
                                // Add 1 day to the date if arrival time exceeds 24 hours
                                $arrivalDate = date('Y-m-d', strtotime($row["date"] . ' +1 day'));
                            } else {
                                $arrivalDate = $row["date"]; // Arrival date remains the same
                            }
                            echo '<div class="ticket">

                            <div class="left">
                                <div class="number">
                                    <p id="left-title" >Ticket</p>
                                   
                                    <p id="left-id" > '.$bookingID.'</p>
                                </div>
                            </div>
                            <div class="right">
                                <div class="top-box">
                                    <div class="box-heading-ticket">
                                        <img src="images/logoV3.4.png" alt="logo" style="height: 80px; width: 150px; ">
                                    </div>
                                    <div class="box-context">
                                     
                                        <p id="ref-no" >Ref No : '.$bookingID.'</p>
                                    </div>
            
                                </div>
            
                                <div class="ticket-title" >
                                    Ticket
                                </div>
            
            
                                <div class="pass-journey-container">
                                    <div class="des-container">
            
                                        <div class="title-one">
                                            <h2 style="background: #113978; width: 400px; padding: 5px 10px 5px 10px;">Journey Info</h2>
                                        </div>
                                
                                        <div class="des-ticket">
                                            
                                            <div class="box-journey">
                                                
                                                <div class="des-journey">
                                                    
                                                    <div class="des-title">
                                                        <h3 >Departure</h3>
                                                    </div>
                                                    <div class="des-content">
                                                        <h4> ';echo ($row["turnType"] === 'depart') ? $row["origin"] : $row["destination"]; echo ' </h4>
                                                    </div>
                                                </div>
                                                <div class="des-journey">
                                                    <div class="des-title">
                                                        <h3>Departure Time</h3>
                                                    </div>
                                                    <div class="des-content">
                                                        <h4>';
                                                        echo ($row["turnType"] === 'depart') ? $row["depTimeOri"] : $row["depTimeDes"];
                                                        echo '</h4>
                                                    </div>
                                                </div>
                                                <div class="des-journey">
                                                    <div class="des-title">
                                                        <h3>Date</h3>
                                                    </div>
                                                    <div class="des-content">
                                                        <h4>'.$row["date"].'</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="box-journey">
                                                <div class="des-journey">
                                                    <div class="des-title">
                                                        <h3>Arrival</h3>
                                                    </div>
                                                    <div class="des-content">
                                                    <h4>';
                                                    echo ($row["turnType"] === 'depart') ? $row["destination"] : $row["origin"];
                                                    echo '</h4>
                                                    </div>
                                                </div>
                                                <div class="des-journey">
                                                    <div class="des-title">
                                                        <h3>Arrival Time</h3>
                                                    </div>
                                                    <div class="des-content">
                                                        <h4>'.$arrivalTime.'</h4>
                                                    </div>
                                                </div>
                                                <div class="des-journey">
                                                    <div class="des-title">
                                                        <h3>Travel Duration</h3>
                                                    </div>
                                                    <div class="des-content">
                                                        <h4>'.$row["duration"].'</h4>
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="box-journey">
                                                <div class="des-journey">
                                                    <div class="des-title">
                                                        <h3>Route No</h3>
                                                    </div>
                                                    <div class="des-content">
                                                        <h4>'.$row["routeNo"].'</h4>
                                                    </div>
                                                </div>
                                                <div class="des-journey">
                                                    <div class="des-title">
                                                        <h3>Via</h3>
                                                    </div>
                                                    <div class="des-content">
                                                        <h4>'.$row["via"].'</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="des-passenger">
                                    <div class="des-container">
                                        <div class="title-one">
                                            <h2 style="padding-left: 10px;">Passenger Info</h2>
                                        </div>
                            
                                    <div class="des-ticket">
                                        
                                        <div class="box-journey">
                                            
                                            <div class="des-journey">
                                                
                                                <div class="des-title-passenger">
                                                    <h3 >Passenger Name</h3>
                                                </div>
                                                <div class="des-content-passenger">
                                                    <h4>'.$row["name"].'</h4>
                                                </div>
                                            </div>
                                            <div class="des-journey">
                                                <div class="des-title-passenger">
                                                    <h3>NIC</h3>
                                                </div>
                                                <div class="des-content-passenger">
                                                    <h4>'.$row["nic"].'</h4>
                                                </div>
                                            </div>
                                            <div class="des-journey">
                                                <div class="des-title-passenger">
                                                    <h3>Seat No</h3>
                                                </div>
                                                <div class="des-content-passenger">
                                                    <h4>'.$row["seatNo"].'</h4>
                                                </div>
                                            </div>
                                            
                                            <div class="des-journey-passenger" style="padding-top: 0px; flex-direction: row; width:220px; ">
                                                
                                                    <div class="des-title-passenger">
                                                       
                                                    </div>
                                                    <div class="des-content-passenger-ticket">
                                                        <h4>LKR '.$row["fare"].'/=</h4>
                                                    </div>
            
                                            
                                                
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                                </div>
                            </div>    
                                
                            </div>
                            <div class="circles">
                                <div class="circle">
            
                                </div>
                                <div class="circle">
                                    
                                </div>
                            </div>
            
                            </div>';
                        }
                    }
                ?>
                

                
            
           
            
            

            

            

        </div>
        <button id="download" onclick="downloadTicket()">Download</button>

    </main>

    
</body>
<script>

    $(document).ready(function () {

                

        $('#download').click(function () {
            domtoimage
                .toJpeg(document.getElementById('htmlContent'), {
                    quality: 0.95
                })
                .then(function (dataUrl) {
                    let link = document.createElement('a')
                    link.download = 'ticket.jpeg'
                    link.href = dataUrl
                    link.click()
                })
        })

    })
    
   

   
</script>
    

</html>