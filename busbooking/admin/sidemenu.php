<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

    <link rel="stylesheet" href="admin.css" />
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

<body>

    <div class="dashboard-container">

        <div class="sidemenu">
            <div class="logo">
                
                <img class="sub-logo" src="../images/logo2.12.png">
                
                
            </div>
            <ul class="sidemenu-list">
                <!-- <li>
                <a href=""><img src="./images/4ulk.png" alt="" /></a>
              </li> -->
                <li>
                    <a href="routes.php"><i class="bx bxs-dashboard"></i>&nbsp; Routes</a>
                </li>
                <li>
                    <a href="standardbuses.php"><i class="bx bxs-category"></i>&nbsp; Standard Buses</a>
                </li>
                <li id="active-main">
                    <a id="active-sub" href="turns.php"><i class="bx bxs-tv"></i>&nbsp; Turns</a>
                </li>
                <li>
                    <a href="trips.php"><i class="bx bxs-cart-alt"></i>&nbsp; Trips</a>
                </li>
                <li>
                    <a href="bookings.php"><i class="bx bxs-user-pin"></i>&nbsp; Bookings</a>
                </li>
                <li>
                    <a href="useraccounts.php"><i class='bx bxs-category-alt'></i>&nbsp; User Accounts</a>
                </li>
                <li>
                    <a href="specialbuses.php"><i class='bx bxs-category-alt'></i>&nbsp; Special Buses</a>
                </li>

                <li>
                    <a href="businquiry.php"><i class="bx bxs-cog"></i>&nbsp; Bus Requests</a>
                </li>



                <li>
                    <a href="logout.php"><i class="bx bxs-log-out"></i>&nbsp; Logout</a>
                </li>
            </ul>

            <div class="email">
                <a href=""><i id="ac" class="bx bxs-user-circle"></i>&nbsp;
                <?php echo '' . $_SESSION["user"]["user_email"] . '';?></a>
            </div>
        </div>
    