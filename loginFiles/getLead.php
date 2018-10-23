<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/rabbitFiles/loginRBMQ.php';
$leaderbd = getLB();

if ($leaderbd != false)#message returned successful
{
	$sessionData= json_decode($leaderbd,true);
	$_SESSION['lb'] = $sessionData;
}
