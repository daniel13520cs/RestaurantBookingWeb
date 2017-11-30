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

//passing variable values from the previous page via session
$customerName = $_SESSION["customerName"];
$keyword = $_SESSION["keyword"];
$numOfPeople = $_SESSION["numOfPeople"];
$DateAndTime = $_SESSION["DateAndTime"];
$schedule = $_SESSION["schedule"];

//get the input value
$restaurantName = mysqlclean($_POST, "restaurantName", 255, $link);

//typed date input value has priority over selected date input value 
if(($DateAndTime) == NULL){
	$DateAndTime = $schedule;
}



//get the primary key and convert it into integer value for futher use 
$cid = mysql_query("select cid from customer where cname = \"$customerName\"");
$cid = mysql_fetch_array($cid, MYSQL_ASSOC);
$cid = intval($cid["cid"]);


$rid = mysql_query("select rid from restaurant where rname = \"$restaurantName\"");
$rid = mysql_fetch_array($rid, MYSQL_ASSOC);
$rid = intval($rid["rid"]);
//var_dump($restaurantName);

$numOfPeople = intval($numOfPeople);

//update the database with new reservation record 
/*var_dump($cid);
var_dump($rid);
var_dump($numOfPeople);
var_dump($DateAndTime);*/
//$query = "INSERT INTO `booking` (cid, rid, btime, quantity) VALUES (1, 1, \"2017-11-05 01:00:00\", 5)";
$query = "INSERT INTO `booking` (cid, rid, btime, quantity) VALUES ($cid, $rid, \"$DateAndTime\", $numOfPeople);";
//echo "$query";
mysql_query($query) or die('Query failed: ' . mysql_error());    
   
//dbResult($result);
//passing the result to next page via session 
$_SESSION["customerName"] = $customerName;
//echo '<br /><a href="customerRecord.php">customerRecord.php</a>';
header("Location: customerRecord.php?");

?> 

