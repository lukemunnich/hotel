
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
    <link rel="stylesheet" href="css/style.css">
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <title>hotel booking</title>
</head>
<body>
<h1>choose your dream Holiday</h1>
<div class="price">
<p id="inn">Holiday Inn: R 200 pp per night</p>
<p id="rad">Ranger Bay Hotel: R 100 pp per night</p>
<p id="city">City Family lodge: R 400 per night 4(beds)</p>
<p id="town">City Main Town Lodge: R 150 pp per night</p>
</div>

<div id='form'>
<form role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

<label>First Name<input type="text" name="firstname" placeholder='First Name' required></label><br>
<label>Surname<input type="text" name="surname"placeholder='surname' required></label><br>
<label>Hotel Name
<select name="hotelname" required>
  <option value="Holiday Inn">Holiday Inn</option>
  <option value="Radison">Ranger</option>
  <option value="City Lodge">City Family Lodge</option>
  <option value="Town Lodge">City Main Town Lodge</option>
</select>
</label><br>

<label>In Date<input type="date" name="indate" placeholder='indate' required></label><br>
<label>Out Date<input type="date" name="outdate" placeholder='outdate' required></label><br>
<button class="submit" name="submit" type="submit">Submit</button>


</form>
</div>

</body>
</html>