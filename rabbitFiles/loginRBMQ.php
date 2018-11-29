<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function login($username,$pass)
{
	if (!isset($_SESSION['backup']))
	{
	
		$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
		#$bClient = new rabbitMQClient("testRabbitMQ.ini","backupServer");
		$request1 = array();
		$request1['type'] = "login";
       		$request1['username'] = $username;
		$request1['password'] = $pass;
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
	if (!isset($_SESSION['backup']))
        {

	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	#$bClient = new rabbitMQClient("testRabbitMQ.ini","backupServer");
	$request2 = array();
	$request2['type']="register";
	$request2['username'] = $userN;
	$request2['email'] = $email;
	$request2['password']= $pass;
	$request2['firstName'] = $firstN;
	$request2['lastName'] = $lastN;
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
	if (!isset($_SESSION['backup']))
        {

	$eClient = new rabbitMQClient("testRabbitMQ.ini","testServer");
	$request3= array();
	$eDate = time();

	#$msg = " [$errorLev]".$errorMsg.$errorFile.$errorLine.$errorContext;
	$request3['type']= "error";
	$request3['date'] = $eDate;
	$request3['msg'] =$msg;
	$eClient->send_request($request3);
	if ($response == 69)
	{
		$_SESSION['backup'] = true;
                $bClient = new rabbitMQClient("backupMQ.ini","testServer");
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
	if (!isset($_SESSION['backup']))
        {

	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	#$bClient = new rabbitMQClient("testRabbitMQ.ini","backupServer");
	$request4= array();
	$request4['type']="validate";
	$request4['username']= $userName;
	$request4['sessionID']= $sessionID;
	$response= $client->send_request($request4);	
	if ($response == 69)
	{
		$request4= array();
        $request4['type']="validate";
        $request4['username']= $userName;
        $request4['sessionID']= $sessionID;

		$_SESSION['backup'] = true;
		$bClient = new rabbitMQClient("backupMQ.ini","testServer");
		$response= $bClient->send_request($request4);
	}
	}
	else
	{
		$request4= array();
        $request4['type']="validate";
        $request4['username']= $userName;
        $request4['sessionID']= $sessionID;

                $bClient= new rabbitMQClient("backupMQ.ini", "testServer");
		$response = $bClient->send_request($request4);
		
        }

	return $response;
}
function getDaily()
{
	if (!isset($_SESSION['backup']))
        {

	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	#$bClient = new rabbitMQClient("testRabbitMQ.ini","backupServer");
	$request5 = array();
	$request5['type']="dailyMatchup";
	$response= $client->send_request($request5);
	if ($response == 69)
	{
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
	if (!isset($_SESSION['backup']))
        {

	$client = new rabbitMQClient("backupMQ.ini","testServer");
	#$bClient = new rabbitMQClient("testRabbitMQ.ini","backupServer");
	$request7 = array();
	$request7['type']= "leaderboard";
	$response = $client->send_request($request7);
	if ($response == 69)
	{
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
	if (!isset($_SESSION['backup']))
        {

	$client = new rabbitMQClient("backupMQ.ini", "testServer");
	#$bClient = new rabbitMQClient("testRabbitMQ.ini","backupServer");
	$request6= array();
	$request6['type']="vote";
	$request6['username']=$userName;
	$request6['vote']=$vote; 
	$response=$client->send_request($request6);
	if ($response == 69)
	{
		$_SESSION['backup'] = true;
                $bClient = new rabbitMQClient("backupMQ.ini","testServer");
                $response= $bClient->send_request($request6);
	}
	}
	else
        {
                $bClient= new rabbitMQClient("backupMQ.ini", "testServer");
                $response = $bClient->send_request($request6);
        }

	return $response;

}
function giveTokens($userName)
{
	if (!isset($_SESSION['backup']))
        {

	$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");
	#$bClient = new rabbitMQClient("testRabbitMQ.ini","backupServer");
	$request= array();
	$request['type'] = "tokens";
	$request['username']= $userName;
	$response = $client->send_request($request);
	if ($response == 69)
	{
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

