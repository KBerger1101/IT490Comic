<?php
require ('../rabbitFiles/loginRBMQ.php');
$userName= $_SESSION['username'];
$sessionID= $_SESSION['sessionID'];
$response = validateSession($userName, $sessionID);

if ($response == false)#authentication successful!!
{
	header("location: ../index.php");
}

