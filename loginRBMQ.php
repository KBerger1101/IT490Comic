<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
if (!isset($_POST))
{
	$msg = "NO POST MESSAGE SET, POLITELY FUCK OFF";
	echo json_encode($msg);
	exit(0);
}
$request = $_POST;
$response = "unsupported request type, politely FUCK OFF";
switch ($request["type"])
{
	case "login":
		$response = "login, yeah we can do that";
		$request1 = array();
		$request1['type'] = $request["login"];
		$request1['username'] = $request["uname"];
		$request1['password'] = $request["pword"];
		$response = $client->send_request($request1);
		echo "client received response: ".PHP_EOL;
		print_r($response);
		//if response ==true, user found
		//if response ==false, user not found 
	break;
}
echo json_encode($response);
exit(0);
