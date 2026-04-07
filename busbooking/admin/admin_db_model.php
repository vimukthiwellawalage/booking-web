<?php
session_start();
require_once("../db_conn.php");


if (isset($_POST["addStopButton"])) {
    $stopID = $_POST["newStopID"];
    $city = $_POST["city"];

    $errors = [];
    $sql = "SELECT * FROM stop WHERE stopID='$stopID'";
    $result = mysqli_query($conn, $sql);

    $queryResults = mysqli_num_rows($result);
    if ($queryResults > 0) {
        $errors["already_exist"]= "StopID already Exist!";
    }


    if($errors) {
        $_SESSION["errors_stop"] =$errors;
        header("Location: cities.php?status=unsuccess");
        die();
    }

    $sql = "INSERT INTO stop (stopID, city) VALUES ('$stopID', '$city')";
    if (!mysqli_query($conn, $sql)) {
        die("Error inserting stop: " . mysqli_error($conn));
    }

    // Redirect to the routes.php page after adding the route
    header("Location: cities.php");
    exit(); // Ensure that no further code is executed after redirection
}



if (isset($_POST["updateStopButton"])) {
    $stopID = $_POST["newStopID"];
    $city = $_POST["city"];
    $oldStopID = $_POST["oldStopID"];

    $errors = [];
    $sql = "SELECT * FROM stop WHERE stopID='$stopID'";
    $result = mysqli_query($conn, $sql);

    $queryResults = mysqli_num_rows($result);
    if ($queryResults > 0) {
        $errors["already_exist"]= "StopID already Exist!";
    }


    if($errors) {
        $_SESSION["errors_stop"] =$errors;
        header("Location: cities.php?status=unsuccess");
        die();
    }

    $sql = "UPDATE stop SET  stopID = '$stopID', city= '$city'
    WHERE stopID = '$oldStopID'";
    if (!mysqli_query($conn, $sql)) {
        die("Error inserting stop: " . mysqli_error($conn));
    }
   


    // Redirect to the routes.php page after adding the route
    header("Location: cities.php");
    exit(); // Ensure that no further code is executed after redirection
}

if (isset($_POST["addRouteButton"])) {
    $routeNo = $_POST["routeNo"];
    $originStr = $_POST["origin"];
    $originArr = explode(",", $originStr);
    $originID = $originArr[0];
    $origin = $originArr[1];
    $desStr= $_POST["destination"];
    $desArr = explode(",", $desStr);
    $destinationID = $desArr[0];
    $destination = $desArr[1];
    $routeID = $_POST["routeID"];

    $sql = "INSERT INTO route (routeID, routeNo, origin, destination) VALUES ('$routeID', '$routeNo', '$origin', '$destination')";
    if (!mysqli_query($conn, $sql)) {
        die("Error inserting route: " . mysqli_error($conn));
    }

    $sql = "INSERT INTO route_stop (routeID, stopID, `order`) VALUES ('$routeID', '$originID', 1)";
    mysqli_query($conn, $sql);


    $x = 2;
    $i = 0;

    // Insert the stops into the route_stop table
    while ($i == 0) {
        $stopPoint = $_POST["stopPoint$x"];

        // Check if stopPoint is not null or empty before proceeding
        if (!empty($stopPoint)) {
            $stopPointArr = explode(",", $stopPoint);
            $stopID = $stopPointArr[0];
            $city = $stopPointArr[1];

            // Insert each stop into the route_stop table
            $sql = "INSERT INTO route_stop (routeID, stopID, `order`) VALUES ('$routeID', '$stopID', '$x')";
            if (!mysqli_query($conn, $sql)) {
                die("Error inserting stop: " . mysqli_error($conn));
            }
            $x++;

        } else {
            $i = 1;
        }
    }


    $sql = "INSERT INTO route_stop (routeID, stopID, `order`) VALUES ('$routeID', '$destinationID', $x)";
    mysqli_query($conn, $sql);

    // Redirect to the routes.php page after adding the route
    header("Location: routes.php");
    exit(); // Ensure that no further code is executed after redirection
}



if (isset($_POST["updateRouteButton"])) {
    $routeNo = $_POST["routeNo"];
    $originStr = $_POST["origin"];
    $originArr = explode(",", $originStr);
    $originID = $originArr[0];
    $origin = $originArr[1];
    $desStr= $_POST["destination"];
    $desArr = explode(",", $desStr);
    $destinationID = $desArr[0];
    $destination = $desArr[1];
    $routeID = $_POST["routeID"];
    $status = $_POST["status"];
    $oldRouteID = $_POST["oldRouteID"];

    $sql3 = "DELETE FROM route_stop WHERE routeID = '$oldRouteID'";
    mysqli_query($conn, $sql3);


    $sql = "UPDATE route SET routeID = '$routeID', routeNo = '$routeNo',
    origin = '$origin', destination = '$destination', status = '$status'
     WHERE routeID = '$oldRouteID'";

    mysqli_query($conn, $sql);


    
    $sql = "INSERT INTO route_stop (routeID, stopID, `order`) VALUES ('$routeID', '$originID', 1)";
    mysqli_query($conn, $sql);


    $x = 2;
    $i = 0;

    // Insert the stops into the route_stop table
    while ($i == 0) {
        $stopPoint = $_POST["stopPoint$x"];

        // Check if stopPoint is not null or empty before proceeding
        if (!empty($stopPoint)) {
            $stopPointArr = explode(",", $stopPoint);
            $stopID = $stopPointArr[0];
            $city = $stopPointArr[1];

            // Insert each stop into the route_stop table
            $sql = "INSERT INTO route_stop (routeID, stopID, `order`) VALUES ('$routeID', '$stopID', '$x')";
            if (!mysqli_query($conn, $sql)) {
                die("Error inserting stop: " . mysqli_error($conn));
            }
            $x++;

        } else {
            $i = 1;
        }
    }


    $sql = "INSERT INTO route_stop (routeID, stopID, `order`) VALUES ('$routeID', '$destinationID', $x)";
    mysqli_query($conn, $sql);

    // Redirect to the routes.php page after adding the route
    header("Location: routes.php");
    exit(); // Ensure that no further code is executed after redirection
}




if (isset($_POST["addStandardBusButton"])) {
    $busID = $_POST["busID"];
    $userID = $_POST["userID"];
    $routeID = $_POST["routeID"];
    $busClass = $_POST["busClass"];
    $type = $_POST["type"];
    $regNo = $_POST["regNo"];
    $model = $_POST["model"];
    $capacity = $_POST["capacity"];

    $img_name = $_FILES["itemImg"]["name"];

    if (!empty($img_name)) {
        $img_name = $_FILES["itemImg"]["name"];
        $img_size = $_FILES["itemImg"]["size"];
        $tmp_name = $_FILES["itemImg"]["tmp_name"];
        $error = $_FILES["itemImg"]["error"];
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);

        $allowed_exs = array("jpg", "jpeg", "png", "webp");

        if (in_array($img_ex_lc, $allowed_exs)) {
            $new_img_name = uniqid("IMG-", true) . "." . $img_ex_lc;
            $img_upload_path = "../images/" . $new_img_name;
            move_uploaded_file($tmp_name, $img_upload_path);

            $sql = "INSERT INTO bus (busID, type, model, regNo, capacity, image)
            VALUES ('$busID', '$type', '$model', '$regNo', '$capacity', '$new_img_name');
            
            INSERT INTO standard_bus (busID, routeID, userID, class)
            VALUES ('$busID', '$routeID', '$userID', '$busClass')";

            // Execute the multi-table INSERT query
            mysqli_multi_query($conn, $sql);


        } else {
            $em = "You can't upload files of this type";
            header("Location: item.php?error=$em");
        }
    } else {

        $sql = "INSERT INTO bus (busID, type, model, regNo, capacity)
            VALUES ('$busID', '$type', '$model', '$regNo', '$capacity');
            
            INSERT INTO standard_bus (busID, routeID, userID, class)
            VALUES ('$busID', '$routeID', '$userID', '$busClass')";

            // Execute the multi-table INSERT query
            mysqli_multi_query($conn, $sql);

 
    }
    header("Location: standardbuses.php");
    exit(); 
}



if (isset($_POST["updateStandardBusButton"])) {
    $busID = $_POST["busID"];
    $oldBusID = $_POST["oldBusID"];
    $userID = $_POST["userID"];
    $routeID = $_POST["routeID"];
    $busClass = $_POST["busClass"];
    $type = $_POST["type"];
    $regNo = $_POST["regNo"];
    $model = $_POST["model"];
    $status = $_POST["status"];
    $capacity = $_POST["capacity"];

    $img_name = $_FILES["itemImg"]["name"];

    if (!empty($img_name)) {
        $img_name = $_FILES["itemImg"]["name"];
        $img_size = $_FILES["itemImg"]["size"];
        $tmp_name = $_FILES["itemImg"]["tmp_name"];
        $error = $_FILES["itemImg"]["error"];
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);

        $allowed_exs = array("jpg", "jpeg", "png", "webp");

        if (in_array($img_ex_lc, $allowed_exs)) {
            $new_img_name = uniqid("IMG-", true) . "." . $img_ex_lc;
            $img_upload_path = "../images/" . $new_img_name;
            move_uploaded_file($tmp_name, $img_upload_path);

            $sql = "UPDATE bus b
            JOIN standard_bus sb ON b.busID = sb.busID
            SET b.busID = '$busID',
                b.type = '$type',
                b.model = '$model',
                b.regNo = '$regNo',
                b.capacity = '$capacity',
                b.image= '$new_img_name',
                b.status = '$status',
                sb.busID = '$busID',
                sb.routeID = '$routeID',
                sb.userID = '$userID',
                sb.class = '$busClass'
            WHERE b.busID = '$oldBusID'";

            mysqli_query($conn, $sql);

        } else {
            $em = "You can't upload files of this type";
            header("Location: item.php?error=$em");
        }
    } else {

        $sql = "UPDATE bus b
            JOIN standard_bus sb ON b.busID = sb.busID
            SET b.busID = '$busID',
                b.type = '$type',
                b.model = '$model',
                b.regNo = '$regNo',
                b.capacity = '$capacity',
                b.status = '$status',
                sb.busID = '$busID',
                sb.routeID = '$routeID',
                sb.userID = '$userID',
                sb.class = '$busClass'
            WHERE b.busID = '$oldBusID'";

        mysqli_query($conn, $sql);

 
    }
    header("Location: standardbuses.php");
    exit(); 
}





if (isset($_POST["addTurnButton"])) {
    $turnID = $_POST["turnID"];

    $routeID = $_POST["routeID"];

    $depTimeOri = $_POST["depTimeOri"];
    $depTimeDes = $_POST["depTimeDes"];
    $dur = $_POST["dur"];
    $via = $_POST["via"];
    $fare = $_POST["fare"];


    $sql = "INSERT INTO turn (turnID,routeID,depTimeOri,depTimeDes, duration,via, fare) 
            VALUES ('$turnID','$routeID','$depTimeOri','$depTimeDes','$dur','$via','$fare')";

    mysqli_query($conn, $sql);

    header("Location: turns.php");
}





if (isset($_POST["updateTurnButton"])) {
    $turnID = $_POST["turnID"];
    $oldTurnID = $_POST["oldTurnID"];
    $routeID = $_POST["routeID"];
    $depTimeOri = $_POST["depTimeOri"];
    $depTimeDes = $_POST["depTimeDes"];
    $dur = $_POST["dur"];
    $via = $_POST["via"];
    $fare = $_POST["fare"];
    $status = $_POST["status"];

    $sql = "UPDATE turn
            SET turnID = '$turnID',
                routeID = '$routeID',
                depTimeOri = '$depTimeOri',
                depTimeDes = '$depTimeDes',
                duration = '$dur',
                via= '$via',
                status = '$status',
                fare = '$fare'
            WHERE turnID = '$oldTurnID'";


    mysqli_query($conn, $sql);

    header("Location: turns.php");
}


if (isset($_POST["addTripButton"])) {
    $tripID = $_POST["tripID"];
    $routeID = $_POST["routeID"];
    $closingTime = $_POST["closingTime"];
    $turnID = $_POST["turnID"];
    $busID = $_POST["busID"];
    $date = $_POST["date"];
    $status = $_POST["status"];
    $turnType = $_POST["turnType"];



    $sql = "INSERT INTO trip (tripID, busID, routeID,turnID,date,turnType, closingTime,status) 
    VALUES ('$tripID', '$busID','$routeID', '$turnID','$date', '$turnType','$closingTime','$status')";
    if (!mysqli_query($conn, $sql)) {
        die("Error inserting route: " . mysqli_error($conn));
    }



    // Insert the stops into the route_stop table
    for ($x = 0; $x<=10;$x++) {

        if (isset($_POST["pointTypeStop$x"])) {
            $pointTypeStop = $_POST["pointTypeStop$x"];

            // Check if stopPoint is not null or empty before proceeding
            if (!empty($pointTypeStop)) {
                $pointTypeStopArr = explode(",", $pointTypeStop);
                $stopID = $pointTypeStopArr[0];
                $city = $pointTypeStopArr[1];
                $pointType = $pointTypeStopArr[2];

                $sql2 = "INSERT INTO trip_stop (tripID, stopID, pointType,order_id) VALUES ('$tripID', '$stopID', '$pointType',$x)";
                if (!mysqli_query($conn, $sql2)) {
                    die("Error inserting stop: " . mysqli_error($conn));
                }
                
            } 
        }
        

    }
    header("Location: trips.php");
    
}


if (isset($_POST["updateTripButton"])) {
    $tripID = $_POST["tripID"];
    $oldTripID = $_POST["oldTripID"];
    $routeID = $_POST["routeID"];
    $closingTime = $_POST["closingTime"];
    $turnID = $_POST["turnID"];
    $busID = $_POST["busID"];
    $date = $_POST["date"];
    $status = $_POST["status"];
    $turnType = $_POST["turnType"];



    $sql_delete_stops = "DELETE FROM trip_stop WHERE tripID = '$oldTripID'";
if (!mysqli_query($conn, $sql_delete_stops)) {
    die("Error deleting stops: " . mysqli_error($conn));
}



// Proceed with updating the trip information
$sql_update_trip = "UPDATE trip
                    SET tripID = '$tripID',
                        routeID = '$routeID',
                        closingTime = '$closingTime',
                        turnID = '$turnID',
                        busID= '$busID',
                        date= '$date',
                        turnType= '$turnType',
                        status= '$status'
                    WHERE tripID = '$oldTripID'";

if (!mysqli_query($conn, $sql_update_trip)) {
    die("Error updating trip: " . mysqli_error($conn));
}

// Then, insert new stops for the updated trip
for ($x = 0; $x <= 10; $x++) {
    if (isset($_POST["pointTypeStop$x"])) {
        $pointTypeStop = $_POST["pointTypeStop$x"];

        // Check if stopPoint is not null or empty before proceeding
        if (!empty($pointTypeStop)) {
            $pointTypeStopArr = explode(",", $pointTypeStop);
            $stopID = $pointTypeStopArr[0];
            $city = $pointTypeStopArr[1];
            $pointType = $pointTypeStopArr[2];

            $sql_insert_stop = "INSERT INTO trip_stop (tripID, stopID, pointType,order_id)
                                VALUES ('$tripID', '$stopID', '$pointType',$x)";
            if (!mysqli_query($conn, $sql_insert_stop)) {
                die("Error inserting stop: " . mysqli_error($conn));
            }
        }
    }
}
header("Location: trips.php");
    
}





if (isset($_POST["addUserButton"])) {


    $name = $_POST["name"];

    $email = $_POST["email"];
    $password = $_POST["password"];
    $type = $_POST["type"];
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (name,email,password,type) 
            VALUES ('$name','$email','$hashed_password','$type')";

    mysqli_query($conn, $sql);

    header("Location: useraccounts.php");
}



if (isset($_POST["updateUserButton"])) {

    $userID = $_POST["userID"];
    $name = $_POST["name"];
    $status = $_POST["status"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $type = $_POST["type"];
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE user
                SET
                name = '$name',
                email = '$email',
                password = '$hashed_password',
                type = '$type',
                status= '$status'
            WHERE userID = '$userID'";

    

    mysqli_query($conn, $sql);

    header("Location: useraccounts.php");
}







if (isset($_POST["addSpecialBusButton"])) {
    $busID = $_POST["busID"];
    $userID = $_POST["userID"];
    $name = $_POST["name"];
    $des = $_POST["des"];
    $type = $_POST["type"];
    $regNo = $_POST["regNo"];
    $model = $_POST["model"];
    $capacity = $_POST["capacity"];

    $img_name = $_FILES["itemImg"]["name"];

    if (!empty($img_name)) {
        $img_name = $_FILES["itemImg"]["name"];
        $img_size = $_FILES["itemImg"]["size"];
        $tmp_name = $_FILES["itemImg"]["tmp_name"];
        $error = $_FILES["itemImg"]["error"];
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);

        $allowed_exs = array("jpg", "jpeg", "png", "webp");

        if (in_array($img_ex_lc, $allowed_exs)) {
            $new_img_name = uniqid("IMG-", true) . "." . $img_ex_lc;
            $img_upload_path = "../images/" . $new_img_name;
            move_uploaded_file($tmp_name, $img_upload_path);

            $sql = "INSERT INTO bus (busID, type, model, regNo, capacity, image)
            VALUES ('$busID', '$type', '$model', '$regNo', '$capacity', '$new_img_name');
            
            INSERT INTO special_bus (busID, name, userID, description)
            VALUES ('$busID', '$name', '$userID', '$des')";

            // Execute the multi-table INSERT query
            mysqli_multi_query($conn, $sql);


        } else {
            $em = "You can't upload files of this type";
            header("Location: item.php?error=$em");
        }
    } else {

        $sql = "INSERT INTO bus (busID, type, model, regNo, capacity)
            VALUES ('$busID', '$type', '$model', '$regNo', '$capacity');
            
            INSERT INTO special_bus (busID, name, userID, description)
            VALUES ('$busID', '$name', '$userID', '$des')";

            // Execute the multi-table INSERT query
            mysqli_multi_query($conn, $sql);

 
    }
    header("Location: specialbuses.php");
    exit(); 
}



if (isset($_POST["updateSpecialBusButton"])) {
    $busID = $_POST["busID"];
    $oldBusID = $_POST["oldBusID"];
    $userID = $_POST["userID"];
    $name = $_POST["name"];
    $des = $_POST["des"];
    $type = $_POST["type"];
    $regNo = $_POST["regNo"];
    $model = $_POST["model"];
    $status = $_POST["status"];
    $capacity = $_POST["capacity"];

    $img_name = $_FILES["itemImg"]["name"];

    if (!empty($img_name)) {
        $img_name = $_FILES["itemImg"]["name"];
        $img_size = $_FILES["itemImg"]["size"];
        $tmp_name = $_FILES["itemImg"]["tmp_name"];
        $error = $_FILES["itemImg"]["error"];
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);

        $allowed_exs = array("jpg", "jpeg", "png", "webp");

        if (in_array($img_ex_lc, $allowed_exs)) {
            $new_img_name = uniqid("IMG-", true) . "." . $img_ex_lc;
            $img_upload_path = "../images/" . $new_img_name;
            move_uploaded_file($tmp_name, $img_upload_path);

            $sql = "UPDATE bus b
            JOIN special_bus sb ON b.busID = sb.busID
            SET b.busID = '$busID',
                b.type = '$type',
                b.model = '$model',
                b.regNo = '$regNo',
                b.capacity = '$capacity',
                b.image= '$new_img_name',
                b.status = '$status',
                sb.busID = '$busID',
                sb.name = '$name',
                sb.userID = '$userID',
                sb.description = '$des'
            WHERE b.busID = '$oldBusID'";

            mysqli_query($conn, $sql);

        } else {
            $em = "You can't upload files of this type";
            header("Location: item.php?error=$em");
        }
    } else {

        $sql = "UPDATE bus b
            JOIN special_bus sb ON b.busID = sb.busID
            SET b.busID = '$busID',
                b.type = '$type',
                b.model = '$model',
                b.regNo = '$regNo',
                b.capacity = '$capacity',
                b.status = '$status',
                sb.busID = '$busID',
                sb.name = '$name',
                sb.userID = '$userID',
                sb.description = '$des'
            WHERE b.busID = '$oldBusID'";

        mysqli_query($conn, $sql);

 
    }
    header("Location: specialbuses.php");
    exit(); 
}





?>