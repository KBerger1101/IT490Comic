#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


function dblogger($eDate,$msg)
{
        echo "should send to rabbitMQ and locally".PHP_EOL;
        $eDate= date('Y-m-d H:i:s');
        file_put_contents('error.log', "[".$eDate."]".$msg.PHP_EOL,FILE_APPEND);
        echo "Should send to rabbit".PHP_EOL;
        $eClient = new rabbitMQClient("testRabbitMQ.ini","errorServer");
        $request = array();
        $request['type']= "error";
        $request['date']= $eDate;
        $request['msg']= $msg;
        $eClient->send_request($request);

}

function storeHeroes($charID, $name, $imgURL, $publisher, $powers, $date)
{

	#file_put_contents('char.log', $name.PHP_EOL, FILE_APPEND);
	$host = 'localhost';
        $user = 'admin';
        $pw = 'password';
        $db = 'testdb';
	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_error)
        {
                $eDate= time();
                echo "DB CONNECT ERROR".PHP_EOL;
                $eMSG= 'Connect Error in Store Heroes, '.$mysqli->connect_errno.': ' . $mysqli->connect_error;
                dblogger($eDate, $eMSG);
                die('Connect Error, '.$mysqli->connect_errno.': 
' . $mysqli->connect_error);
        }

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
function pickMix()
{
	$host = 'localhost';
        $user = 'admin';
        $pw = 'password';
        $db = 'testdb';
        $mysqli = new mysqli($host, $user, $pw, $db);
        if ($mysqli->connect_error)
        {
                $eDate= time();
                echo "DB CONNECT ERROR".PHP_EOL;
                $eMSG= 'Connect Error in Store Heroes, '.$mysqli->connect_errno.': ' . $mysqli->connect_error;
                dblogger($eDate, $eMSG);
                die('Connect Error, '.$mysqli->connect_errno.':
' . $mysqli->connect_error);
        }

	$date = time();
	#pick 5 from Character Table
	$mixQuery = "Select * from CharacterTable order by RAND() limit 5";
	$results = $mysqli->query($mixQuery) or die ($mysqli->error);
	while ($char = $results->fetch_assoc())
	{
		$charID = $char['charID'];
		$publisher= $char['publisher'];
		#add to mix matchup table
		storeMix($date, $charID, $publisher);
	}

}

function storePowers($charID, $powers)
{
 	$host = 'localhost';
        $user = 'admin';
        $pw = 'password';
        $db = 'testdb';
	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_error)
        {
                $eDate= time();
                echo "DB CONNECT ERROR".PHP_EOL;
                $eMSG= 'Connect Error in Store Powers, '.$mysqli->connect_errno.': ' . $mysqli->connect_error;
                dblogger( $eDate, $eMSG);
                die('Connect Error, '.$mysqli->connect_errno.': 
' . $mysqli->connect_error);
        }

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
	if ($mysqli->connect_error)
        {
                $eDate= time();
                echo "DB CONNECT ERROR".PHP_EOL;
                $eMSG= 'Connect Error in Store Matchup, '.$mysqli->connect_errno.': ' . $mysqli->connect_error;
                dblogger($eDate, $eMSG);
                die('Connect Error, '.$mysqli->connect_errno.': ' . $mysqli->connect_error);
        }

	$query="INSERT INTO MatchupTable values('$date', '$charID', '$pub')";
	$mysqli->query($query) or die($mysqli->error);
}
function storeMix($date,$charID, $pub)
{
	$host= 'localhost';
	$user = 'admin';
	$pw = 'password';
	$db = 'testdb';
	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_error)
	{
		$eDate= time();
                echo "DB CONNECT ERROR".PHP_EOL;
                $eMSG= 'Connect Error in Store Matchup, '.$mysqli->connect_errno.': ' . $mysqli->connect_error;
                dblogger($eDate, $eMSG);
                die('Connect Error, '.$mysqli->connect_errno.': ' . $mysqli->connect_error);
	}
	$query="INSERT INTO MixMatchupTable values('$date', '$charID', '$pub')";
	$mysqli->query($query) or die($mysqli->error);
}
function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
  	storeHeroes($request["charID"],$request["name"],$request["image"],$request["publisher"], $request["powers"], $request["date"]);
  }
  if(isset($request['type']))
  {
	pickMix();
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");

}

$server = new rabbitMQServer("testRabbitMQ.ini","heroServer");
echo "matchup catcher BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "matchup cather END".PHP.EOL;
exit();
?>

