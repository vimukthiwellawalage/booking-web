<?php
require_once("db_conn.php");

$to=$_POST["to"];

$sql = "SELECT * FROM stop 
        WHERE city like '$to%' LIMIT 7;";


$result = mysqli_query($conn,$sql);

$output='';

while($to=mysqli_fetch_array($result)) {

    $output.="<li onclick='putdataTo(this.innerHTML)'>".$to["city"]."</li>";
}

echo $output;
?>