<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">


<?php
// linking to login credentials for database in origin.php
require_once 'origin.php';

//create connection. First need to instantiate new mysqli class
$conn =  new mysqli("localhost", "root", "", "hotels");

// setting up argument to the first condition
if ($conn->connect_error){
    die("Connection failed:". $conn->connect_error);
}
echo "";

?>


</form>
</body>
</html>