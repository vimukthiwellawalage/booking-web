<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : "Yamu | යමු"; ?></title>
    <link rel="stylesheet" href="stylesheetone.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tomorrow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <?php if (!empty($extraStyles)) { foreach ($extraStyles as $extraStyle) { echo '<link rel="stylesheet" href="' . htmlspecialchars($extraStyle) . '">' . "\n    "; } } ?>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

</head>
<body>

    <header class="header">


        <div class="nav-bar">
            <div class="box-1">
                <a href="index.php"><img class="logo" src="images/yamu-logo.png" alt="Yamu Logo"></a>
            </div>
            <div class="box-2">
                <ul>
                    <li><a  href="index.php">Home</a></li>
                    <li><a href="viewSchedule.php">View Schedule</a></li>
                    <li><a href="findspecialbus.php">Special Buses</a></li>


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
    