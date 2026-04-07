<?php
session_start();
require_once("../db_conn.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

    <link rel="stylesheet" href="operatorstyle.css" />

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tomorrow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    

    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" 
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" 
    crossorigin="anonymous"></script>
    
</head>

<body style="overflow: auto;">

    <main class="account-main">

        <section class="account-view">

            <div class=account-container>
                <div class="account-card">
                    <div class="account-heading">
                        
<p id="title-menu">Bus Operator Menu</p>
                    </div>
                    <div class="account-info">

                        <div class="account-summary">
                            <div class="account-box">
                                <div class="account-heading-box">
                                    <p class="user-name">My Account</p>

                                </div>
                                <div class="account-icon-box">
                                    <i class="bi bi-person-circle"></i>


                                </div>
                                <div class="account-username-box">
                                    <p class="welcome">Welcome!</p>
                                    <p class="name"><?php echo $_SESSION["user"]["user_name"]; ?></p>
                                </div>

                                <div class="button-box">
                                    <a href="viewtrips.php"><button class="viewbutton">
                                        View Trips
                                    </button></a>

                                    <a href="feedbackform.php"><button class="viewbutton">
                                        View Feedback
                                    </button></a>

                                    <a href="../admin/logout.php"><button class="viewbutton">
                                        Log Out
                                    </button></a>
                                </div>

                            </div>

                        </div>

                        <div class="account-form">
                            <form id="form1" name="form1" method="post" action="">

                                <div class="account-form-details">

                                    <div class="inputs">
                                        <div class="account-heading-box">
                                            <p class="form-heading">Profile</p>

                                        </div>
                                        <div class="divided">
                                            <div class="col1">
                                                <label class="labels" for="firstName">First Name:</label><br>
                                                <input class="divided-input-account" value="<?php echo $_SESSION["user"]["user_name"]; ?>" placeholder="First Name" type="text" name="firstName" id="firstName" />
                                            </div>

                                        </div>

                                        


                                        <div class="divided">
                                            <div class="col1">
                                                <label class="labels" for="email">Email:</label><br>
                                                <input class="divided-input-account" type="text" value="<?php echo $_SESSION["user"]["user_email"]; ?>" placeholder="Email" name="email" id="email" />
                                            </div>

                                        </div>

                                        <div class="account-heading-box">
                                            <p class="form-heading-2">Change Password</p>

                                        </div>

                                        <div class="divided">
                                            <div class="col1">
                                                <label class="labels" for="currentpassword">Current Password:</label><br>
                                                <input class="divided-input-account" placeholder="Current Password" type="text" name="currentpassword" id="currentpassword" />
                                            </div>

                                        </div>

                                        <div class="divided">
                                            <div class="col1">
                                                <label class="labels" for="newpassword">New Password:</label><br>
                                                <input class="divided-input-account" placeholder="New Password" type="text" id="newpassword" />
                                            </div>

                                        </div>


                                        <div class="divided">
                                            <div class="col1">
                                                <label class="labels" for="confirmpassword">Confirm Password:</label><br>
                                                <input class="divided-input-account" type="text" placeholder="Confirm Password" name="confirmpassword" id="confirmpassword" />
                                            </div>

                                        </div>
                                        <div class="save-button">
                                            <button class="savechanges">
                                                Save Changes
                                            </button>
                                        </div>


                                    </div>

                                </div>








                            </form>


                        </div>



                    </div>
                </div>



            </div>

        </section>
    </main>