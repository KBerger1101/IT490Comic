#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
function authUser($username, $pass)
{
	//set up database
	$host = 'localhost';
	$user = 'root';
	$pw = 'password';
	$db = 'testdb';
	$mysqli = new mysqli($host, $user, $pw, $db);
	$userData = array();
	$un = $mysqli->escape_string($username);
	$pass = $mysqli->escape_string($pass);
        $statement = "select * from users where screenname = '$un'";
        $response = $mysqli->query($statement);
        while ($row = $response->fetch_assoc())
        {
                echo "checking password for $username".PHP_EOL;
                if ($row["password"] == $pass)
                {
			echo "passwords match for $username".PHP_EOL;
			$userData['username']=$response['userName'];
			$userData['firstName']=$response['firstName'];
			$userData['lastName']=$response['lastName'];
			$userData['email'] = $response['email'];
			$userData['session']="true";
			return json_encode($userData);
                }
                echo "passwords did not match for $username".PHP_EOL;
        }
        return false;//no users matched username

}
function regUser($username, $pass, $email, $firstN, $lastN)
{

}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "login":
      return authUser($request['username'],$request['password']);
    case "register":
      return regUser($request['username'], $request['password'], $request['email'], $request['firstName'], $request['lastName']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP.EOL;
exit();
?>

