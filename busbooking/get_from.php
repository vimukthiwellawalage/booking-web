<?php
require_once("db_conn.php");

$from=$_POST["from"];

$sql = "SELECT * FROM stop 
        WHERE city like '$from%' LIMIT 7;";


$result = mysqli_query($conn,$sql);

$output='';

while($from=mysqli_fetch_array($result)) {

    $output.="<li onclick='putdataFrom(this.innerHTML)'>".$from["city"]."</li>";
}

echo $output;
?>