<?php 
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/checkSession.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/rabbitFiles/loginRBMQ.php';
$userName= $_SESSION['username'];
$vote = $_POST['vote'];
$response = vote($userName,$vote);

if ($response != false) #vote successful! 
{
	$_SESSION['hasVoted'] = true;

	header("location: /loginFiles/dailyPage.php");
}
?>
