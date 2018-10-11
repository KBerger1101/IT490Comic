<?php
require ('rabbitFiles/loginRBMQ.php'); #contains register client function
$userName= $_POST('username');
$email = $_POST('email');
$firstN= $_POST('firstName');
$lastN= $_POST('lastName');
$pass= $_POST('password');
$response = register($userName,$email, $pass, $firstN, $lastN);

if ($response != false) #account creation successful, login!
{
	$sessionData= json_decode($response,true);
	$_SESSION['isLogged']=true;
	$_SESSION['userName']=$sessionData['username'];
	$_SESSION['firstName'] = $sessionData['firstname'];
	$_SESSION['lastName'] = $sessionData['lastname'];
	#if includes hasvoted set to false
	
	header("location: /loginFiles/choosePage.php");
}
else
{
	#handle error throwing
	$errorMSG= "Account for email already exists";
	errorThrow($errorMSG);

	header("location: index.php");
}
?>
