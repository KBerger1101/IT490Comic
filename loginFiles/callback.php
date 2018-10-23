<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/rabbitFiles/loginRBMQ.php';
	if($_SERVER['REQUEST_METHOD'] != 'POST') {
		header(string: 'Location: choicePage.php');
		exit();
	}

	$ch = curl_init();
	curl_setopt($ch, option:CURLOPT_URL, value: 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr');
	curl_setopt($ch, option:CURLOPT_RETURNTRANSFER, value:1);
	curl_setopt($ch, option:CURLOPT_SSL_VERIFYHOST, value:0);
	curl_setopt($ch, option:CURLOPT_SSL_VERIFYPEER, value:0);
	curl_setopt($ch, option:CURLOPT_POST, value:1);
	curl_setopt($ch, option:CURLOPT_POSTFIELDS, value: "cmd=_notify-validate&" . http_build_query($_POST));
	$response = curl_exec($ch);
	curl_close($ch);

	if ($response == "VERIFIED" && $_POST['receiver_email'] == 'thegreattober@gmail.com') { 
		$cEmail = $_POST['payer_email'];
		$name = $_POST['first_name'] . " " $_POST['last_name'];


		$price = $_POST['mc_gross'];
		$currency = $_POST['mc_currency'];
		$item = $_POST['item_number'];
		$paymentStatus = $_POST['payment_status'];

		if($item == "bettingTokens" && $currency == "USD" && $paymentStatus == "Completed" && $price == 1){
			$response = giveTokens($_SESSION['username']);
			if ($response!= false)
			{
				$sessionData= json_decode($response,true);
				$_SESSION['totalTokens'] = $sessionData['totalTokens'];
				header("location: /loginFiles/choicePage.php");
				
			}
		}
	}
?>
