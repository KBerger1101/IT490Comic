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
	$errorMSG ="Failed to authenticate session, please login!";
	echo "<p>$errorMSG</p>";
	errorThrow($errorMSG);
	sleep(5);
	header("location: ../index.php");
}
