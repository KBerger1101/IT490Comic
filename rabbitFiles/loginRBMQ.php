<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function login($username,$pass)
{
	$request1 = array();
	$request1['type'] = "login";
	$request1['username'] = $username;
        $request1['password'] = $pass;

	if (!isset($_SESSION['backup']))
	{
	
		$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
		#$bClient = new rabbitMQClient("testRabbitMQ.ini","backupServer");
		$response = $client->send_request($request1);
		if ($response == 69)
		{
			$_SESSION['backup'] = true;
	                $bClient = new rabbitMQClient("backupMQ.ini","testServer");
	                $response= $bClient->send_request($request1);
		}
	}
	else
	{
		$bClient= new rabbitMQClient("backupMQ.ini", "testServer");
		$response = $bClient->send_request($request1);
	}


	return $response;
}
function register($userN,$email, $pass,$firstN,$lastN)
{
	$request2 = array();
        $request2['type']="register";
        $request2['username'] = $userN;
        $request2['email'] = $email;
        $request2['password']= $pass;
        $request2['firstName'] = $firstN;
        $request2['lastName'] = $lastN;

	
	if (!isset($_SESSION['backup']))
        {

	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	$response = $client->send_request($request2);
	if ($response == 69)
	{
		$_SESSION['backup'] = true;
                $bClient = new rabbitMQClient("backupMQ.ini","testServer");
                $response= $bClient->send_request($request2);
	}
	}
	else
        {
                $bClient= new rabbitMQClient("backupMQ.ini", "testServer");
                $response = $bClient->send_request($request2);
        }


	return $response;
}
function errorThrow($msg)
{
	$request3 = array();
	$eDate= time();
	$request3['type']= "error";
        $request3['date'] = $eDate;
        $request3['msg'] =$msg;

	if (!isset($_SESSION['backup']))
        {

	$eClient = new rabbitMQClient("testRabbitMQ.ini","errorServer");
	$eClient->send_request($request3);
	if ($response == 69)
	{
		echo "backup set error";
		$_SESSION['backup'] = true;
                $bClient = new rabbitMQClient("backupMQ.ini","errorServer");
                $response= $bClient->send_request($request3);
	}
	}
	else
        {
                $bClient= new rabbitMQClient("backupMQ.ini", "testServer");
                $response = $bClient->send_request($request3);
        }


}
function validateSession($userName,$sessionID)
{
	$request4= array();
        $request4['type']="validate";
        $request4['username']= $userName;
        $request4['sessionID']= $sessionID;

	if (!isset($_SESSION['backup']))
        {

	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	$response= $client->send_request($request4);	
	if ($response == 69)
	{
		echo "backup set in validate session";
		$_SESSION['backup'] = true;
		$bClient = new rabbitMQClient("backupMQ.ini","testServer");
		$response= $bClient->send_request($request4);
	}
	}
	else
	{
                $bClient= new rabbitMQClient("backupMQ.ini", "testServer");
		$response = $bClient->send_request($request4);
		
        }

	return $response;
}
function getDaily()
{
	$request5 = array();
        $request5['type']="dailyMatchup";

	if (!isset($_SESSION['backup']))
        {

	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	$response= $client->send_request($request5);
	if ($response == 69)
	{
		echo "backup getDaily()";
		$_SESSION['backup'] = true;
                $bClient = new rabbitMQClient("backupMQ.ini","testServer");
                $response= $bClient->send_request($request5);
	}
	}
	else
        {
                $bClient= new rabbitMQClient("backupMQ.ini", "testServer");
                $response = $bClient->send_request($request5);
        }


	return $response;
}
function getLB()
{
	$request7 = array();
	$request7['type']= "leaderboard";
	if (!isset($_SESSION['backup']))
        {

	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	$response = $client->send_request($request7);
	if($respone == 69)
	{
		echo "backup set lb";
		$_SESSION['backup'] = true;
                $bClient = new rabbitMQClient("backupMQ.ini","testServer");
                $response= $bClient->send_request($request7);
	}
	}
	else
        {
                $bClient= new rabbitMQClient("backupMQ.ini", "testServer");
                $response = $bClient->send_request($request7);
        }


	return $response;
}
function vote($userName, $vote)
{
	$request6= array();
        $request6['type']="vote";
        $request6['username']=$userName;
        $request6['vote']=$vote;


	$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");
	$response=$client->send_request($request6);

	return $response;

}
function giveTokens($userName)
{
	$request= array();
        $request['type'] = "tokens";
        $request['username']= $userName;

	if (!isset($_SESSION['backup']))
        {

	$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");
	$response = $client->send_request($request);
	if ($response == 69)
	{
		echo "backup set giveTokens";
		$_SESSION['backup'] = true;
                $bClient = new rabbitMQClient("backupMQ.ini","testServer");
                $response= $bClient->send_request($request);
	}
	}
	else
        {
                $bClient= new rabbitMQClient("backupMQ.ini", "testServer");
                $response = $bClient->send_request($request);
        }

	return $response;
}

