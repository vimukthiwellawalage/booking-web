<?php
include("connect.php");

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); 
        if ($user['type'] === 'admin') {
            echo '<script>alert("Admin login successful!");';
            echo 'window.location.href = "admin.php";</script>';
        } elseif($user['type'] === 'operator') {
            echo '<script>alert("operator login successful!");';
            echo 'window.location.href = "operator.php";</script>';
        }
    } else {
        echo '<script>alert("Login failed. User does not exist or incorrect password.");</script>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EzBusLK Login</title>
    <link rel="stylesheet" href="index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tomorrow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script>
        function validateForm() {
            var email = document.forms["form1"]["email"].value;
            var password = document.forms["form1"]["password"].value;
            if (email == "" || password == "") {
                alert("Please fill in all fields");
                return false;
            }
        }
    </script>
</head>
<body>
    <section class="form">
        <div class="inquire-form">
            <form id="form1" name="form1" action="login.php" method="post"onsubmit="return validateForm()">
                <div class="headings">
                    <p class="login-form-title">Login - EzBusLK</p>
                </div>
                <div class="form-details">
                    <div class="inputs-login">
                        <div class="average">
                            <div class="col1">
                                <label class="labels" for="email">Email:</label><br>
                                <input class="average-input" placeholder="Email" type="text" name="email" id="email" />
                            </div>
                        </div>
                        <div class="average">
                            <div class="col1">
                                <label class="labels" for="password">Password:</label><br>
                                <input class="average-input" placeholder="Password" type="password" name="password" id="password" />
                            </div>
                        </div>
                        <div class="login-button">
                        <button class="login" type="submit" name="login">Login</button>
                        </div>
                    </div>
                </div>
            </form>
           
    
        </div>
    </section>
</body>
</html>
