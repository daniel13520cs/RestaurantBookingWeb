<?php
require 'db.inc';
session_start();

$locolhostIP = "127.0.0.1";
$username = "root";
$password = "password";

// Connecting, selecting database
$link = mysql_connect($locolhostIP, $username, $password) or die('Could not connect: ' . mysql_error());

// echo 'Connected successfully';
$db = mysql_select_db('RestaurantBooking') or die('Could not select database');

//get the input values 
$customerName = mysqlclean($_POST, "customerName", 255, $link); 
$keyword = mysqlclean($_POST, "keyword", 255, $link);
$numOfPeople = mysqlclean($_POST, "numOfPeople", 10, $link);
$DateAndTime = mysqlclean($_POST, "DateAndTime", 19, $link);// timestamp size is 19!!
$schedule = mysqlclean($_POST, "schedule", 19, $link);

//passing variable values to session
$_SESSION["customerName"] = $customerName;
$_SESSION["keyword"] = $keyword;
$_SESSION["numOfPeople"] = $numOfPeople;
$_SESSION["DateAndTime"] = $DateAndTime;
$_SESSION["schedule"] = $schedule;

//typed date has higher priority over selected date
if($DateAndTime == NULL){
  $DateAndTime = $schedule;
}
/*
var_dump($customerName);
var_dump($keyword);
var_dump($numOfPeople);
var_dump($DateAndTime);
var_dump($schedule);*/

//check if there is any booking record with the request 
$isRecordInBooking = "select * from booking natural join restaurant where btime = \"$DateAndTime\"
                    and (rname LIKE \"%$keyword%\" or description LIKE \"%$keyword%\"); ";
$isRecordInBooking = mysql_query($isRecordInBooking) or die('Query failed: ' . mysql_error());

$numOfPeople = intval($numOfPeople);

//list all restaurants avaiable if record is not found in the db
if(isdbResultEmpty($isRecordInBooking)){
  $isAvaiable = "select * from restaurant
                where (rname LIKE \"%$keyword%\" or description LIKE \"%$keyword%\")
                and capacity >= $numOfPeople; ";
} else {
  //check btime and capacity if record is found in the db
  $isAvaiable = "select * from restaurant 
                 where (rname LIKE \"%$keyword%\" or description LIKE \"%$keyword%\") 
                 and capacity >= $numOfPeople
      
                 and rid not in (  
                 select rid from(
                 select rid, rname, btime, capacity, sum(quantity) 
                 from restaurant natural join booking
                 group by rid, btime 
                 having btime = \"$DateAndTime\" and capacity < (sum(quantity) + $numOfPeople) ) as notAvailAble
              )";
           
} 

$result = mysql_query($isAvaiable) or die('Query failed: ' . mysql_error());

//Printing results in HTML
dbResult($result);

// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($link);
?> 

<html>
<body>

<form method="POST" action="reserve.php">
  <tr>
    <td>Enter one available Restaurant from above you want to book</td>
    <td><input type="text" size="10" name="restaurantName" required></td>
  </tr>
  <p><input type="submit" value="Reserve">
</form> 

</body> 
</html>


