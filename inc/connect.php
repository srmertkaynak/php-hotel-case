<?php 

$host = "localhost";
$db_name = "mertkayn_hotelcase";
$db_user = "mertkayn_hotelcase";
$db_pass = "e2cea84ca99ea3040f79da846117943f793fbabd";

try{

	$db = new PDO("mysql:host=".$host.";dbname=".$db_name.";charset=utf8",$db_user,$db_pass);


}catch(PDOException $e) {

	die($e->getMessage());

}

$hotelManagement = new HotelManagement($db);

?>