<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
//require_once('testRabbitMQ.ini');
$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
//$eClient = new rabbitMQClient("testRabbitMQ.ini","errorServer");
if (!isset($_POST))
{
	$msg = "NO POST MESSAGE SET, POLITELY FUCK OFF";
	//echo json_encode($msg);
	//$response = $client ->send_request($msg);
	echo $response;
	exit(0);
}
$request = $_POST;
$response = "unsupported request type, politely FUCK OFF";
switch ($request["type"])
{
	case "login":
		$response = "login, yeah we can do that";
		$request1 = array();
		$request1['type'] = "login";
		$request1['username'] = $request["uname"];
		$request1['password'] = $request["pword"];
		$response = $client->send_request($request1);
		
		//print_r($response);
		if($response)
		{
			$response=true;
			echo $response;
			exit(0);
		}
		else{
		
			//$requestE = array();
			//$requestE['type'] = 'error';
			//$requestE['message'] = 'not valid user';
			//$response = $eClient->send_request($requestE);
			$response= false;
			echo $response;
			exit(0);
		}
		//if response ==true, user found
		//if response ==false, user not found 
	break;
}
echo json_encode($response);
exit(0);
