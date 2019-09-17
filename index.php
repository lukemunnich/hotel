
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
<link rel="stylesheet" href="css/hotel.css">
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

<title>hotel booking</title>
</head>

<body>

<!-- creating hotel options -->
<h1>choose your dream Holiday</h1>

<div class="price">
<p id="inn">Holiday Inn: R 200 pp per night</p>
<p id="rad">Ranger Bay Hotel: R 100 pp per night</p>
<p id="city">City Family lodge: R 400 per night 4(beds)</p>
<p id="town">City Main Town Lodge: R 150 pp per night</p>
</div>

<!-- creating a form -->
<div id='form'>
<form role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

<label>First Name<input type="text" name="firstname" placeholder='First Name' required></label><br>
<label>Surname<input type="text" name="surname"placeholder='surname' required></label><br>
<label>In Date<input type="date" name="indate" placeholder='indate' required></label><br>

<label>Out Date<input type="date" name="outdate" placeholder='outdate' required></label><br>
<select name="hotelname" >

<fieldset>

  <input type="radio" option value="Holiday Inn" name="hotelname" class="sr-only" id="one">
  holiday inn
  <label for="male">
    <img id="images" src="images/Raddisson.jpg" alt="two">
  </label>
  <input type="radio" option value="Radison" name="hotelname" class="sr-only" id="female">
  raddison
  <label for="female">
    <img id="images" src="images/hotel.jpeg" alt="three">
  </label>
  <input type="radio" option value="City lodge" name="hotelname" class="sr-only" id="male">
  city lodge
  <label for="male">
    <img id="images" src="images/campsbay.jpg.webp" alt="city lodge">
</label>
<input type="radio" option value="Town lodge" name="hotelname" class="sr-only" id="male">
town lodge
  <label for="male">
    <img id="images" src="images/city.jpg" alt="four">
</label>
  
</fieldset>
</select>
</label><br>
<button class="submit" name="submit" type="submit">Submit</button>


</form>

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
<button name='confirm' type='submit'> Confirm </button> </form>".'</div>';
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
