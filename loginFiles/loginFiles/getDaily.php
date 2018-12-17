<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/rabbitFiles/loginRBMQ.php';
$matchup = getDaily();

if ($matchup != false) #message returned successful
{
	$sessionData= json_decode($matchup,true);
	$_SESSION['heroData'] = $sessionData;
}

