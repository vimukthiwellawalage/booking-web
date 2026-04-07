
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - ezBusLK</title>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>



:root {
  --offwhite: #edebe6;
  --black: #000000;
  --white: #ffffff;
  --blue: #000b3d;
  --gray: rgb(115, 114, 114);
  --skyblue:  #113978;
  --skyblue2: rgb(13, 136, 188);
}
* {

  box-sizing: border-box;
  text-decoration: none;
  scroll-behavior: smooth;
  

}


.nav-bar {
    font-family: "Ubuntu", sans-serif;
  font-weight: 400;
  font-size: 15px;
  font-style: normal;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: var(--blue);
  color: #e0dcd7;
  height: 70px;
}

.box-1 {
  display: flex;
  justify-content: center;
  align-items: center;
 padding: 0px 10px;
  width: 15%;
  
}

.box-2 {
  
  padding: 0px 10px;
  width: 70%;
  display: flex;
  justify-content: center;
  align-items: center;
  align-content: center;
  
}


.box-3 {
  padding: 0px 10px;
  width: 15%;
  

  
}

.account-box {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.account-icon {
  display: block;

}
.account-name {
  display: block;
  text-align: center;

}

.box-2 ul{
  
 
  margin: 0px;
  padding: 0px;
  overflow: hidden;
  
}

.box-2 li {
  display: inline-block;
  padding: 5px 15px;
  
  
}

.logo {
  height: 70px;
}

a {
  color: #e0dcd7;

    font-weight: 500;
    font-size: 15px;
    font-style: normal;
}

/* visited link */
a:visited {
color: var(--white);
}

/* mouse over link */
a:hover {
color: var(--offwhite);
}

/* selected link */
a:active {
color: var(--offwhite);
}
        body {
            font-family: "Poppins", sans-serif;
    background-color: #000b3d;
    margin: 0;
    padding: 0;
    color: #f9f6f6;
    background-image: url('images/colombo2.jpg'); 
    background-size: cover;
    background-position: center;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background-color: #29569e; 
    background-image: url('images/colombo2.jpg'); 
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.header2 {
    text-align: center;
    margin-bottom: 30px;
}

h1 {
    color: var(--white);
}

.team-members {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.member {
    text-align: center;
    margin: 20px;
    padding: 20px;
    width: 250px;
    background-color: rgba(21, 101, 192, 0.9); /* Semi-transparent dark blue background */
    color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.member:hover {
    transform: translateY(-5px);
}

.member img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 20px;
    border: 4px solid #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.member h3 {
    font-size: 18px;
    margin-bottom: 10px;
}

.member p {
    font-size: 14px;
    line-height: 1.5;
}

@media (max-width: 1000px) {
    .member {
        width: 350px;
    }
}

@media (max-width: 800px) {
    .member {
        width: 100%;
        max-width: 400px;
    }
}

    </style>
</head>

<body>
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
    
    <div style="margin-top: 30px;" class="container">
        <div class="header2">
            <h1>About Us</h1>
        </div>

        <section class="about-us">
            <div class="info-box">
                <h2>About ezBusLK</h2>
                <p>Welcome to ezBusLK, your ultimate destination for convenient and hassle-free bus booking services in Sri Lanka. We provide a user-friendly platform that allows you to search, book, and manage bus journeys with ease. Whether it's a short commute or a long-distance trip, ezBusLK simplifies your travel experience.</p>
            </div>

            <div class="vision-box">
                <h2>Our Vision</h2>
                <p>To revolutionize the bus booking experience and make travel seamless for everyone by leveraging technology.</p>
            </div>

            <div class="mission-box">
                <h2>Our Mission</h2>
                <p>To provide a reliable and user-friendly platform for booking buses across Sri Lanka, connecting passengers with trusted bus operators.</p>
            </div>

            <div class="services-box">
                <h2>Our Services</h2>
                <ul>
                    <li>Search and browse buses based on origin, destination, and travel date.</li>
                    <li>Real-time tracking of buses during the journey.</li>
                    <li>Easy seat selection and booking process.</li>
                    <li>Secure payment options for booking confirmation.</li>
                    <li>Flexible cancellation and rescheduling of bookings.</li>
                </ul>
            </div>
        </section>
    </div>
    <header>
        <h1 style="margin-left: 60px;">Our Team</h1>
    </header>
        <section style="padding-bottom: 50px;" class="team-members">
            <div class="member">
                <img src="images/ashane.png" alt="Ashane Lakshitha">
                <h3>Ashane Lakshitha</h3>
                <p>Project Manager, Back End Developer, Front End Developer</p>
            </div>

            <div class="member">
                <img src="images/Tharuka.png" alt="Tharuka Premasiri">
                <h3>Tharuka Premasiri</h3>
                <p>Front End Developer, Back End Developer, UI/UX Designer</p>
            </div>

            <div class="member">
                <img src="images/Diberdan.png" alt="Thavarasa Diverdan">
                <h3>Thavarasa Diverdan</h3>
                <p>Back End Developer, System Analyst, Database Engineer, Scrum Master</p>
            </div>

            <div class="member">
                <img src="images/randeep.png" alt="Randeep Thambawita">
                <h3>Randeep Thambawita</h3>
                <p>UI/UX Designer, Quality Assurance Engineer, Front End Developer</p>
            </div>

            <div class="member">
                <img src="images/saru.png" alt="Ranjithkumar Sharneeshan">
                <h3>Ranjithkumar Sharneeshan</h3>
                <p>Back End Developer, Database Engineer, Technical Writer</p>
            </div>
        </section>
    </div>
</body>

</html>
