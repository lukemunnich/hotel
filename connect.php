<!DOCTYPE html>
<html>
<body>



<?php

require_once 'base.php';

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