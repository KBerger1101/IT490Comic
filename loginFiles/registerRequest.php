<?php
require ('rabbitFiles/loginRBMQ.php'); #contains register client function
$username= $_POST['username'];
$email = $_POST['email'];
$firstN= $_POST['firstName'];
$lastN= $_POST['lastName'];
$pass= $_POST['password'];
$response = register($username,$email, $pass, $firstN, $lastN);

if ($response != false) #account creation successful, login!
{
	$sessionData= json_decode($response,true);
	$_SESSION['isLogged']=true;
	$_SESSION['username']=$sessionData['username'];
	$_SESSION['firstName'] = $sessionData['firstname'];
	$_SESSION['lastName'] = $sessionData['lastname'];
	$_SESSION['sessionID'] = $sessionData['sessionID'];
	#if includes hasvoted set to false
	
	header("location: /loginFiles/successPage.php");
}
else
{
	#handle error throwing
	$errorMSG= "Account name already exists, please try again";
	echo "<p>$errorMSG</p>";
	errorThrow($errorMSG);
	#header("location: index.php");
}

