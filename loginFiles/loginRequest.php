<?php 
require ('../rabbitFiles/loginRBMQ.php');#contains login client function
$request= $_POST;
$userName= $request['uname'];
$pass= $request['pword'];
$response = login($userName,$pass);

if ($response != false)#login successful!
{
	$sessionData = json_decode($response, true); #get data from rabbitMQ
	$_SESSION['isLogged'] = true;
	$_SESSION['userName'] = $sessionData['username'];
	$_SESSION['firstName'] = $sessionData['firstname'];
	$_SESSION['lastName'] = $sessionData['lastname'];
	#include hasvoted info here??


	header("location: /loginFiles/successPage.html");
}
else
{
	#handle error throwing
	$errorMSG = "Login Failed!";
	errorThrow($errorMSG);
	header("location: index.php");
}

