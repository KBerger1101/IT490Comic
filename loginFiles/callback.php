<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/rabbitFiles/loginRBMQ.php';

	$response = giveTokens($_SESSION['username']);
	if ($response!= false)
       	{
 		$sessionData= json_decode($response,true);
		$_SESSION['totalTokens'] = $sessionData['totalTokens'];
		header("location: /loginFiles/choicePage.php");
	}


	/*echo "Sending request";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "cmd=_notify-validate&" . http_build_query($_POST));
	$response = curl_exec($ch);
	curl_close($ch);
	echo var_dump($response);
	#header("location: /loginFiles/choicePage.php");
	 */
?>
