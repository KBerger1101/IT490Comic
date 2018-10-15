<?php
require ('../rabbitFiles/loginRBMQ.php');
$userName= $_SESSION['username'];
$sessionID= $_SESSION['sessionID'];
$response = validateSession($userName, $sessionID);

if ($response != false)#authentication successful!!
{
	echo "hooray!";
}
else
{
	sleep(5);
	header("location: ../index.php");
}
