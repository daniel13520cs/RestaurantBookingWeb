<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
                      "http://www.w3.org/TR/html401/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Login</title>
</head>
<body>
<h1>Restaurant Booking</h1>

<form method="POST" action="available.php">
<table>

  <tr>
    <td>Enter your customer name:</td>
    <td><input type="text" size="10" name="customerName" required></td>
  </tr>

  <tr>
    <td>Enter your keyword:</td>
    <td><input type="text" size="10" name="keyword" ></td>
  </tr>

  <tr>
    <td>Enter your number of Party:</td>
    <td><input type="text" size="10" name="numOfPeople" required></td>
  </tr>

  <tr>
    <td>Date and Time for Reservation:</td>
    <td><input type="text" size="19" name="DateAndTime"></td>
  </tr>
</table>

  <?php 
      date_default_timezone_set("America/New_York");
      echo "\nDate and Time for Reservation:"; 
      echo "<select name = \"schedule\">";
      $today = date("Y-m-d");
      for($i=0; $i<=23; $i++) {
        $endhour = $i + 1;
        echo "<option value = \"$today $i:00:00\">$today $i:00:00 - $today $endhour:00:00</option>\n"; 
      }
      echo "\t</select>\n"; 
  ?>

<p><input type="submit" value="Search">
</form>

</body>
</html>


