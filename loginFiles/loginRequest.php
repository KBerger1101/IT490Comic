<?php 
require ('rabbitFiles/loginRBMQ.php');#contains login client function

$userName= $_POST['uname'];
$pass= $_POST['pword'];
$response = login($userName,$pass);

if ($response != false)#login successful!
{
	$sessionData = json_decode($response, true); #get data from rabbitMQ
	$_SESSION['isLogged'] = true;
	$_SESSION['username'] = $sessionData['username'];
	$_SESSION['firstName'] = $sessionData['firstname'];
	$_SESSION['lastName'] = $sessionData['lastname'];
	$_SESSION['sessionID']=$sessionData['sessionID'];
	$_SESSION['tokens'] =$sessionData['tokens'];
	$_SESSION['points']= $sessionData['points'];
	#include hasvoted info here??


	header("location: /loginFiles/choicePage.php");
}
else
{
	#handle error throwing
	$errorMSG = "Login Failed!";
	echo "<p>$errorMSG</p>";
	#errorThrow($errorMSG);
	#header("location: index.php");
}

