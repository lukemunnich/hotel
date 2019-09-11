<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


<?php

require_once 'origin.php';

//create connection. First need to instantiate new mysqli class
$conn =  new mysqli("localhost", "root", "", "hotels");

if ($conn->connect_error){
    die("Connection failed:". $conn->connect_error);
}
echo "";

?>


</form>
</body>
</html>