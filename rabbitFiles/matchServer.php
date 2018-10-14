#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


function storeHeroes($charID, $name, $imgURL, $publisher, $powers, $date)
{

	file_put_contents('char.log', $name.PHP_EOL, FILE_APPEND);
	$host = 'localhost';
        $user = 'root';
        $pw = 'password';
        $db = 'testdb';
	$mysqli = new mysqli($host, $user, $pw, $db);
	$query = "SELECT * from CharacterTable where charID='$charID'";
	$result = $mysqli->query($query);
	if ( $result->num_rows == 0)#user not inserted yet, add to character Table and charPower table
	{
	 $query ="INSERT INTO CharacterTable Values('$charID','$name','$imgURL', '$publisher')";
	 $mysqli->query($query) or die($mysqli->error);
	 storePowers($charID, $powers);
	}
	#add to matchup table
	storeMatchup($date,$charID, $publisher);
	
}
function storePowers($charID, $powers)
{
 	$host = 'localhost';
        $user = 'root';
        $pw = 'password';
        $db = 'testdb';
	$mysqli = new mysqli($host, $user, $pw, $db);
	foreach($powers as $power)
	{
		$query="INSERT INTO charPowerTable Values('$charID', '$power')";
		$mysqli->query($query) or die($mysqli->error);
	}
}
function storeMatchup($date, $charID, $pub)
{
	$host = 'localhost';
        $user = 'admin';
        $pw = 'password';
        $db = 'testdb';
        $mysqli = new mysqli($host, $user, $pw, $db);
	$query="INSERT INTO MatchupTable values('$date', '$charID', '$pub')";
	$mysqli->query($query) or die($mysqli->error);
}
function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  storeHeroes($request["charID"],$request["name"],$request["image"],$request["publisher"], $request["powers"], $request["date"]);
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","heroServer");
echo "matchup catcher BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "matchup cather END".PHP.EOL;
exit();
?>

