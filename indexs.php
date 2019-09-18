
<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<!-- linking stylesheets and google fonts -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Bungee' rel='stylesheet'>
<link rel="stylesheet" href="css/style.css">

<title>hotel booking</title>
</head>

<body>

<!-- creating hotel options -->
<div class="image-holder">
<h1><b>choose your dream Holiday</b></h1>
<div class="row">
  <div class="col-md-3">
  <h2> City Lodge</h2>
     <p> R400 pp per night </p>
    <img id="images" src="/hotel/images/hotel2.jpg" alt="Holiday inn" style="width:100%" onclick="myFunction(this);">
  </div>
  <div class="col-md-3">
  <h2>Raddisson</h2>
  <p> R250 pp per night </p>
    <img id="images" src="/hotel/images/images.jpg" alt="Raddisson" style="width:100%" onclick="myFunction(this);">
</div>
  <div class="col-md-3">
  <h2> Holiday inn</h2>
  <p> R600 pp per night </p>
    <img id="images" src="/hotel/images/campsbay.jpg" alt="City Lodge" style="width:100%" onclick="myFunction(this);">
  </div>
  <div class="col-md-3">
  <h2>Town Lodge</h2>
  <p> 300 pp per night </p>
    <img id="images" src="/hotel/images/Raddisson.jpg" alt="Town lodge" style="width:100%" onclick="myFunction(this);">
  </div>
</div>
<div class="container">
  <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
  <img id="expandedImg" style="width:100%">
  <div id="imgtext"></div>
</div>
</div>



<script>
function myFunction(imgs) {
  var expandImg = document.getElementById("expandedImg");
  var imgText = document.getElementById("imgtext");
  expandImg.src = imgs.src;
  imgText.innerHTML = imgs.alt;
  expandImg.parentElement.style.display = "block";
}
</script>

<!-- creating a form -->
<div id='form'>
<form role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

<label>First Name<input type="text" name="firstname" placeholder='First Name' required></label><br>
<label>Surname<input type="text" name="surname"placeholder='surname' required></label><br>
<label>Hotel Name
<select name="hotelname" required>
  <option value="Holiday Inn">Holiday Inn</option>
  <option value="Radison">Radison</option>
  <option value="City Lodge">City Lodge</option>
  <option value="Town Lodge">Town Lodge</option>
</select>
</label><br>
<label>In Date<input type="date" name="indate" placeholder='indate' required></label><br>
<label>Out Date<input type="date" name="outdate" placeholder='outdate' required></label><br>
<button class="submit" name="submit" type="submit" style="vertical-align:middle"><span>submit</span>
</form>
</div>

<!-- using php to creat table in mysql -->
<?php
require_once "connect.php";
echo $conn->error;

$sql = "CREATE TABLE IF NOT EXISTS bookings (
   id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   firstname VARCHAR(50),
   surname VARCHAR(50),
   hotelname VARCHAR(50),
   indate VARCHAR(30),
   outdate VARCHAR(30),
   booked INT(4))";


$conn ->query($sql);

if (isset($_GET['error']) && $_GET['error'] == 'timestamp') {

 ?>

<div class='panel panel-default'>
   <h1>
      You must select at least  1 day 
   </h1>
      </div>

      <?php
   }

if (isset($_POST['submit'])) {
   $_SESSION['firstname']= $_POST['firstname'];
   $_SESSION['surname']= $_POST['surname'];
   $_SESSION['hotelname']= $_POST['hotelname'];
   $_SESSION['indate']= $_POST['indate'];
   $_SESSION['outdate']= $_POST['outdate'];

//calculate duration of user's stay at hotel
$datetime1 = new DateTime($_SESSION['indate']);
$datetime2 = new DateTime($_SESSION['outdate']);
$interval = $datetime1->diff($datetime2);

$interval->format('%d');

$checkInStamp = strtotime($_SESSION['indate']);
        $checkOutStamp = strtotime($_SESSION['outdate']);
        if ($checkInStamp - $checkOutStamp > 86400 || $checkInStamp == $checkOutStamp) {
            header("Location: ?error=timestamp");
        exit;
        }

//number of days booked 
$daysbooked = $interval->format('%d');
$value;

switch(isset($_SESSION['hotelname'])){
   case 'Holiday Inn':
   $value = $daysbooked * 200;
   break;

   case 'Radison':
   $value = $daysbooked * 100;
   break;

   case 'City Lodge':
   $value = $daysbooked * 400;
   break;

   case 'Town Lodge':
   $value = $daysbooked * 150;
   break;

   default:
   return "ERROR!";
}

$firstname = $_POST['firstname'];
$surname = $_POST['surname'];

$result = mysqli_query($conn,"SELECT hotelname, indate, outdate, firstname, surname FROM bookings WHERE firstname='$firstname' && surname='$surname'"); 
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {    
 echo "<div class='duplicate'> You already have a booking. <br> Firstname: ". $row['firstname'] . "<br>
Lastname: " . $row['surname'].
"<br> Start Date: " . $row['indate'].
"<br> End Date: " . $row['outdate'].
"<br> Hotel Name: " . $row['hotelname'].
"<br>" . $interval->format('%r%a days') . "<br> Total: R " . $value ."</div>";
    } 
}


echo '<div class="return">'. "<br> Firstname:".  $_SESSION['firstname']."<br>".
"surname:".  $_SESSION['surname']."<br>".
"Start Date:". $_SESSION['indate']."<br>".
"End Date:". $_SESSION['outdate']."<br>".
"Hotel Name:". $_SESSION['hotelname']."<br>".
"Total R" . $value ;

echo "<form role='form' action=" . htmlspecialchars($_SERVER['PHP_SELF']) . " method='post'>
<button name='confirm' type='submit'id='buttons> Confirm </button> </form>".'</div>';
}

// creating a method
if(isset($_POST['confirm'])){
$stmt=$conn->prepare("INSERT INTO bookings(firstname,surname,hotelname,indate,outdate) VALUES (?,?,?,?,?)");
$stmt->bind_param('sssss', $firstname,$surname,$hotelname,$indate,$outdate);
$firstname=$_SESSION['firstname'];
$surname=$_SESSION['surname'];
$hotelname=$_SESSION['hotelname'];
$indate=$_SESSION['indate'];
$outdate=$_SESSION['outdate'];
$stmt->execute();
echo '<div id="confirmed">'."Booking confirmed".'</div>';
}

?>





</body>
</html>
