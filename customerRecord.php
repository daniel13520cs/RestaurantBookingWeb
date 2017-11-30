<?
require 'db.inc';
session_start();

$locolhostIP = "127.0.0.1";
$username = "root";
$password = "password";

$customerName = $_SESSION[customerName];

// Connecting, selecting database
$link = mysql_connect($locolhostIP, $username, $password) or die('Could not connect: ' . mysql_error());
// echo 'Connected successfully';
$db = mysql_select_db('RestaurantBooking') or die('Could not select database');

//show all previous bookings of the customer
echo "Customer: $customerName Reservation Records";
$result = mysql_query("select * from booking natural join customer where cname = \"$customerName\"") or die('Query failed: ' . mysql_error()); 
dbResult($result);

?>


