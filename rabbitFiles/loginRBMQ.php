<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function login($username,$pass)
{
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	#$eClient = new rabbitMQClient("testRabbitMQ.ini","errorServer");
	$request1 = array();
	$request1['type'] = "login";
        $request1['username'] = $username;
	$request1['password'] = $pass;
	$response = $client->send_request($request1);
	return $response;
}
function register($userN,$email, $pass,$firstN,$lastN)
{
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	#$eClient = new rabbitMQClient("testRabbitMQ.ini","errorServer");
	$request2 = array();
	$request2['type']="register";
	$request2['username'] = $userN;
	$request2['email'] = $email;
	$request2['password']= $pass;
	$request2['firstName'] = $firstN;
	$request2['lastName'] = $lastN;
	$response = $client->send_request($request2);
	return $response;
}
function errorThrow($msg)
{
	$eClient = new rabbitMQClient("testRabbitMQ.ini","errorServer");
	$request3= array();
	$eDate = time();

	#$msg = " [$errorLev]".$errorMsg.$errorFile.$errorLine.$errorContext;
	$request3['type']= "error";
	$request3['date'] = $eDate;
	$request3['msg'] =$msg;
	$eClient->send_request($request3);
}
function validateSession($userName,$sessionID)
{
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	$request4= array();
	$request4['type']="validate";
	$request4['username']= $userName;
	$request4['sessionID']= $sessionID;
	$response= $client->send_request($request4);
	return $response;
}
function getDaily()
{
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	$request5 = array();
	$request5['type']="dailyMatchup";
	$response= $client->send_request($request5);
	return $response;
}
function getLB()
{
	$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
	$request7 = array();
	$request7['type']= "leaderboard";
	$response = $client->send_request($request7);
	return $response;
}
function vote($userName, $vote)
{
	$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");
	$request6= array();
	$request6['type']="vote";
	$request6['username']=$userName;
	$request6['vote']=$vote; 
	$response=$client->send_request($request6);
	return $response;

}

