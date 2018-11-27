<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/rabbitFiles/loginRBMQ.php';
$userName= $_SESSION['username'];
$vote = $_POST['vote'];
$response = vote($userName,$vote);

if ($response != false) #vote successful! 
{
	echo "<p>Vote Successful! Good Luck!</p>";
	$_SESSION['hasVoted'] = true;
	#$_SESSION['tokens'] = $_SESSION['tokens'] - 100;
	#sleep(5);
	header("location: /loginFiles/dailyPage.php");
}
else
{
	$errorMSG="Voting failed! No tokens were removed, please try again in a moment";
	echo "<p>$errorMSG</p>";
	#errorThrow($errorMSG);
	#sleep(5);
	header("location: /loginFiles/dailyPage.php");
}

