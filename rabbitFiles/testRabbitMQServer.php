#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('login.php.inc');

function authUser($username, $pass)
{
	//set up database
	$host = 'localhost';
	$user = 'root';
	$pw = 'password';
	$db = 'testdb';
	$mysqli = new mysqli($host, $user, $pw, $db);
	$userInfo = array();
	$un = $mysqli->escape_string($username);
	/*$results = $mysqli->query("SELECT * FROM users WHERE screenname='$username' and password='$pass'");
	$user = $results->fetch_assoc();
	if( $results->num_rows == 0 ) 
	{
		echo "WRONG INPUTS IDIOT";
		return false;
	}
	else 
	{
		echo "CORRECT INPUTS GENIUS";
		return true;
	}*/
	//$un = $this->logindb->real_escape_string($username);
        //$pw = $this->logindb->real_escape_string($password);
        $statement = "select * from users where screenname = '$un'";
        $response = $mysqli->query($statement);
        while ($row = $response->fetch_assoc())
        {
                echo "checking password for $username".PHP_EOL;
                if ($row["password"] == $pass)
                {
                        echo "passwords match for $username".PHP_EOL;
			return 1;// password match
                }
                echo "passwords did not match for $username".PHP_EOL;
        }
        return false;//no users matched username

}

function doLogin($username,$password)
{
    // lookup username in databas
    // check password
    $login = new loginDB();
    $response =  $login->validateLogin($username,$password);
    echo $response;
    return $response;
    //return false if not valid
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
    case "validate_session":
      return doValidate($request['sessionId']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP.EOL;
exit();
?>

