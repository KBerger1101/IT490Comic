#!/usr/bin/php
<?php
#require_once $_SERVER['DOCUMENT_ROOT'].'/rabbitFiles/head.php';
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
function loginUser($username, $pass)
{
	//set up database
	$host = 'localhost';
	$user = 'admin';
	$pw = 'password';
	$db = 'testdb';
	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_error)
	{
		$eDate= time();
		echo "DB CONNECT ERROR".PHP_EOL;
		$eMSG= 'Connect Error in LOGIN, '.$mysqli->connect_errno.': ' . $mysqli->connect_error;
		dblogger($eDate, $eMSG);
		die('Connect Error, '.$mysqli->connect_errno.': 
' . $mysqli->connect_error);
	}
	$userData = array();
	$un = $mysqli->escape_string($username);
	$pass = $mysqli->escape_string($pass);
	#hash that shit
	$pass= hash('sha256', $pass);
        $query = "select * from users where userName = '$un' and password = '$pass'";
        $response = $mysqli->query($query);
        while ($row = $response->fetch_assoc())
        {
                echo "checking password for $username".PHP_EOL;
                if ($row["password"] == $pass)
                {
			echo "passwords match for $username".PHP_EOL;
			$userData['username']=$row['userName'];
			$userData['firstName']=$row['firstName'];
			$userData['lastName']=$row['lastName'];
			$userData['email'] = $row['email'];
			#UPDATE USER SESSION
			$sessionID = updateSession($row['userName']);
			$userData['sessionID']=$sessionID;
			#GET POINTS
			$query= "SELECT * from PointTable where userName='$un'";
			$response = $mysqli->query($query);
			while ($row1= $response->fetch_assoc())
			{
				$userData['points'] = $row1['totalPoints'];
			}
			#GET TOKENS
			$query= "SELECT * FROM TokenTable where userName='$un'";
			$response = $mysqli->query($query);
                        while ($row2= $response->fetch_assoc())
                        {
                                $userData['points'] = $row2['availTokens'];
                        }
			echo json_encode ($userData);
			return json_encode($userData);
                }
                echo "passwords did not match for $username".PHP_EOL;
        }
        return false;//no users matched username

}
function regUser($username, $pass, $email, $firstN, $lastN)
{
	//set up database
        $host = 'localhost';
        $user = 'admin';
        $pw = 'password';
        $db = 'testdb';
	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_error)
        {
                $eDate= time();
                echo "DB CONNECT ERROR".PHP_EOL;
                $eMSG= 'Connect Error in REGISTER, '.$mysqli->connect_errno.': ' . $mysqli->connect_error;
                dblogger($eDate, $eMSG);
                die('Connect Error, '.$mysqli->connect_errno.':
' . $mysqli->connect_error);
        }
        $userData = array();
        $un = $mysqli->escape_string($username);
	$pass = $mysqli->escape_string($pass);
	#hash that shit
	$pass = hash('sha256',$pass);
	$email= $mysqli->escape_string($email);
	$firstName = $mysqli->escape_string($firstN);
	$lastName = $mysqli->escape_string($lastN);
        $query = "select * from users where userName = '$un'";
	$response = $mysqli->query($query);
	if( $response->num_rows == 0)#account doesn't exist already, createone
	{
		$query="INSERT INTO users values('$email','$pass', '$firstName', '$lastName', '$un')";
		$mysqli->query($query) or die($mysqli->error);
		echo "Account created successfully".PHP_EOL;
		echo "passwords match for $username".PHP_EOL;
		$userData['username']=$un;
		$userData['firstName']=$firstName;
		$userData['lastName']=$lastName;
		$userData['email'] = $email;
		$sessionID= createSession($un);
		$userData['sessionID']=$sessionID;
		#insert tokens here 
		$userData['tokens']= 1000;
		$userData['points'] = 0;
		$query="INSERT INTO PointTable values('$un', 0, '')";
		$mysqli->query($query) or die($mysqli->error);
		$query="INSERT INTO TokenTable values ('$un', 1000)";
		$mysqli->query($query) or die($mysqli->error);

                echo json_encode ($userData);
                return json_encode($userData);
	}
	else #account already exists
	{
		echo "Account already exists you're beat".PHP_EOL;
		return false;
	}
}
function createSession($username)
{
	//set up database
        $host = 'localhost';
        $user = 'admin';
        $pw = 'password';
        $db = 'testdb';
	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_error)
        {
                $eDate= time();
                echo "DB CONNECT ERROR".PHP_EOL;
                $eMSG= 'Connect Error in CREATE SESSION, '.$mysqli->connect_errno.': ' . $mysqli->connect_error;
                dblogger( $eDate, $eMSG);
                die('Connect Error, '.$mysqli->connect_errno.': 
' . $mysqli->connect_error);
        }

	$sDate = time();
	$sessionKey= hash('sha256', $username.$sDate);
	$query = "insert into sessionTable values('$username','$sessionKey',$sDate, 'true')";
        $mysqli->query($query);
        return $sessionKey;

}
function updateSession($username)
{
	//set up database
        $host = 'localhost';
        $user = 'admin';
        $pw = 'password';
        $db = 'testdb';
	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_error)
        {
                $eDate= time();
                echo "DB CONNECT ERROR".PHP_EOL;
                $eMSG= 'Connect Error in UPDATE SESSION, '.$mysqli->connect_errno.': ' . $mysqli->connect_error;
                dblogger( $eDate, $eMSG);
                die('Connect Error, '.$mysqli->connect_errno.':
' . $mysqli->connect_error);
        }

	$sDate = time();
	$sessionKey = hash('sha256',$username.$sDate);
	$query = "update sessionTable set isValid='true', sessionKey = '$sessionKey', sessDate= '$sDate' where userName='$username'";
	$mysqli->query($query);
	return $sessionKey;
}
function dailyMatchup()
{
	//set up database
        $host = 'localhost';
        $user = 'admin';
        $pw = 'password';
        $db = 'testdb';
	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_error)
        {
                $eDate= time();
                echo "DB CONNECT ERROR".PHP_EOL;
                $eMSG= 'Connect Error in DAILY MATCHUP, '.$mysqli->connect_errno.': ' . $mysqli->connect_error;
                dblogger( $eDate, $eMSG);
                die('Connect Error, '.$mysqli->connect_errno.':
' . $mysqli->connect_error);
        }

	#get general info from charTable
	$idQuery= "SELECT * from MatchupTable  where  publisher = 'DC Comics' order by matchDate DESC limit 5";
	$DCHeroes = array();
	$results= $mysqli->query($idQuery) or die($mysqli->error);
	while ($char = $results->fetch_assoc())
	{
		$charID = $char['charID'];
		$heroQuery = "SELECT * from CharacterTable where charID = $charID";
		$powerQuery= "SELECT * from charPowerTable where charID = $charID";
		$powersArray =  array();
		$presult = $mysqli->query($powerQuery) or die($mysqli->error);
		if( $presult->num_rows == 0)
		{
			#no powers ):	
		}
		else
		{
			while($power = $presult->fetch_assoc())
			{
				$powerID = $power['powerID'];
				$descQuery = "SELECT * from PowerTable where powerID = $powerID";
				$dresult= $mysqli->query($descQuery) or die($mysqli->error);
				$wrapped= $dresult->fetch_assoc();
				array_push($powersArray, $wrapped);				
			}
		}
		$hresult = $mysqli->query($heroQuery) or die($mysqli->error);
		while($h  = $hresult->fetch_assoc())
		{
		
			$hero = new hero();
			$hero->charName=$h['charName'];
			$hero->imgURL=$h['imgURL'];
			$hero->powers= $powersArray;
			#$jHero = json_encode(var_dump($hero));
			array_push($DCHeroes,$hero); 
		}
	}
	$idQuery= "SELECT * from MatchupTable where publisher = 'Marvel' order by matchDate desc limit 5";
        $MarvelHeroes = array();
        $results= $mysqli->query($idQuery) or die($mysqli->error);
        while($char = $results->fetch_assoc())
        {
		$charID = $char['charID'];
		echo $charID;
                $heroQuery = "SELECT * from CharacterTable where charID = $charID";
                $powerQuery= "SELECT * from charPowerTable where charID = $charID";
                $powersArray = array();
                $presult = $mysqli->query($powerQuery) or die($mysqli->error);
                if( $presult->num_rows == 0)
                {
                        #no powers ):
                }
                else
                {
                        foreach($presult as $power)
                        {
                                $powerID = $power['powerID'];
                                $descQuery = "SELECT * from PowerTable where powerID = $powerID";
				$dresult= $mysqli->query($descQuery) or die($mysqli->error);
				$d= $dresult->fetch_assoc();
                                array_push($powersArray, $d);
                        }
                }
                $hresult = $mysqli->query($heroQuery) or die($mysqli->error);
		$hero = new hero();
		$h= $hresult->fetch_assoc();
                $hero->charName=$h['charName'];
                $hero->imgURL=$h['imgURL'];
		$hero->powers= $powersArray;
		#$jHero = json_encode($hero);
                array_push($MarvelHeroes,$hero);
	}
	$matchUp = new matchup();
	$matchUp->DC= $DCHeroes;
	$matchUp->Marvel= $MarvelHeroes;
	echo json_encode ($matchUp);
	$sMatchup= json_encode($matchUp);
	#echo json_decode ($sMatchup);
	return json_encode($matchUp);

}
function authUser($userName,$sessionID)
{
	 //set up database
        $host = 'localhost';
        $user = 'admin';
        $pw = 'password';
        $db = 'testdb';
	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_error)
        {
                $eDate= time();
                echo "DB CONNECT ERROR".PHP_EOL;
                $eMSG= 'Connect Error in AUTH USER, '.$mysqli->connect_errno.': ' . $mysqli->connect_error;
                dblogger($eDate, $eMSG);
                die('Connect Error, '.$mysqli->connect_errno.':
' . $mysqli->connect_error);
        }

	if($userName==NULL)
	{
		return false;
	}
	if($sessionID ==NULL)
	{
		return false;
	}
	$statement = "select * from sessionTable where userName = '$userName'";
        $response = $mysqli->query($statement);
        while ($row = $response->fetch_assoc())
        {
                if ($row["sessionKey"] == $sessionID)
                {
                        echo "sessionID match for $userName".PHP_EOL;
                        $userData['username']=$userName;
                        $userData['sessionID']=$sessionID;
                        echo json_encode ($userData);
                        return json_encode($userData);
		}
	}
	echo "sessionID did not match".PHP_EOL;
	return false;

}
function tokens($username)
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
                $eMSG= 'Connect Error in leaderboard, '.$mysqli->connect_errno.': ' . $mysqli->connect_error;
                dblogger($eDate, $eMSG);
                die('Connect Error, '.$mysqli->connect_errno.':
' . $mysqli->connect_error);
	}
	$query = "UPDATE TokenTable set availTokens = availTokens + 1000 where userName = '$username'";
	echo "ADDING TOKENS TO $username".PHP_EOL;
	$mysqli->query($query);
	$query = "Select * from	TokenTable where userName = '$username'";
	echo "returning total tokens to user".PHP_EOL;
	$result = $mysqli->query($query);
	$userData= array();
	while($row = $result->fetch_assoc())
	{
		$userData['username']= $row['userName'];
		$userData['totalTokens']= $row['availTokens'];

	}
	return json_encode($userData);
}
function vote($userName, $vote)
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
                $eMSG= 'Connect Error in VOTE, '.$mysqli->connect_errno.': ' . $mysqli->connect_error;
                dblogger( $eDate, $eMSG);
                die('Connect Error, '.$mysqli->connect_errno.':
' . $mysqli->connect_error);
        }

	#check if voted already
	$statement = "select * from PointTable where userName = '$userName'";
        $response = $mysqli->query($statement);
        while ($row = $response->fetch_assoc())
        {
                if ($row["vote"] == "")
                {
                        echo "user not voted, checking tokens".PHP_EOL;
			$query="select * from TokenTable where availTokens>=100";
			$response= $mysqli->query($query);
			while ($row1= $response->fetch_assoc())
			{
				if($row1["userName"]==$userName)
				{
					echo "enough tokens, submitting vote".PHP_EOL;
					$query="update TokenTable set availTokens= availTokens-100 where userName= '$userName'";
					$mysqli->query($query);
					$query="update PointTable set vote='$vote' where userName='$userName'";
					$mysqli->query($query);
					echo "submitted vote".PHP_EOL;
					$query="update jackpot set totalTokens=totalTokens+100";
					$mysqli->query($query);
					echo "added to jackpot";
					return true;
				}
				
			}
			echo "not enough tokens".PHP_EOL;
			return false;
                }
                else
                {
                        echo "user already voted, updating vote".PHP_EOL;
			$query = "update PointTable set vote='$vote' where userName = '$userName'";
			$mysqli->query($query);
			return true;
                }
        }
	#check if voted
	#check Tokens in TokenTable (availTokens)
	#remove 100 tokens in TokenTable
	#update (vote) in PointTable where userName = userName
	#update jackpot update totalTokens +=100
	
}
function getLeaderboard()
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
                $eMSG= 'Connect Error in leaderboard, '.$mysqli->connect_errno.': ' . $mysqli->connect_error;
                dblogger($eDate, $eMSG);
                die('Connect Error, '.$mysqli->connect_errno.':
' . $mysqli->connect_error);
	}
	$query= "Select * from PointTable order by totalPoints desc limit 10";
	$result = $mysqli->query($query);
	$leadbd = array();
	while ($u = $result->fetch_assoc())
	{
		$user  = new user();
		$user->userName=$u['userName'];
		$user->points=$u['totalPoints'];
		array_push($leadbd, $user);
	}
	$leaderB = new leaderbd();
	$leaderB->leaderboard=$leadbd;
	echo json_encode ($leaderB);
	return json_encode($leaderB);


}
class user
{
	public $userName;
	public $points;
}
class leaderbd
{
	public $leaderboard;
}

class hero
{
	public $charName;
	public $imgURL;
	public $powers;
	
}
class matchup
{
	public $DC;
	public $Marvel;
	function _construct(){}
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
	    return loginUser($request['username'],$request['password']);
    case "register":
	    return regUser($request['username'], $request['password'], $request['email'], $request['firstName'], $request['lastName']);
    case "dailyMatchup":
	    return dailyMatchup();
    case "previousMatchup":
	    return previousMatchup();
    case "leaderboard" :
	    return getLeaderboard();
    case "validate":
	    return authUser($request['username'],$request['sessionID']);
    case "vote":
	    return vote($request['username'], $request['vote']);
    case "tokens":
	    return tokens($request['username']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
echo "login BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "login END".PHP.EOL;
exit();
?>

