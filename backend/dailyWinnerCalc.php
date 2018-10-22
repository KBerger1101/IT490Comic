#!/usr/bin/php
<?php
#require_once $_SERVER['DOCUMENT_ROOT'].'/rabbitFiles/head.php';
require_once  ('head.php');
function dailyWinner()
{
	$host = 'localhost';
	$user = 'admin';
	$pw = 'password';
	$db = 'testdb';
	$mysqli = new mysqli($host, $user, $pw, $db);
	$query = "SELECT * FROM PointTable WHERE vote = 'DC'";
	$DC = $mysqli->query($query);
	$query = "SELECT * FROM PointTable WHERE vote = 'Marvel'";
	$Marvel = $mysqli->query($query);
	$DCVotes = mysqli_num_rows($DC);
	echo $DCVotes;
	$MarVotes = mysqli_num_rows($Marvel);
	echo $MarVotes;
	#compare votes
	if ($DCVotes > $MarVotes)
	{
		$winner = "Team DC Comics";
		$query = "INSERT INTO winTable VALUES( CURDATE(), 'DC')";
		$mysqli->query($query);
		#give winners points
		while ($row = $DC->fetch_assoc())
		{
			$username = $row['userName'];
			$query = "UPDATE PointTable set totalPoints= totalPoints +100 where userName= '$username'";
			$mysqli->query($query);
		}
	}
	elseif ($MarVotes > $DCVotes)
	{
		$winner = "Team Marvel";
		$query = "INSERT INTO winTable VALUES( CURDATE(), 'Marvel')";
		$mysqli->query($query);
		#give winners points
		while ($row = $Marvel->fetch_assoc())
		{
			$username = $row['userName'];
			$query = "UPDATE PointTable set totalPoints = totalPoints + 100 where userName = '$username'";
			$mysqli->query($query);
		}
	}
	elseif ($MarVotes == $DCVotes)
	{
		$winner = "Tied!";
		$query = "INSERT INTO winTable VALUES( CURDATE(), 'Tied')";
		$mysqli->query($query);
		#give everyone points who voted
		$query = "UPDATE PointTable set totalPoints = totalPoints + 100 where vote != ''";
		$mysqli->query($query);
	}
	#email all whom voted
	$query = "Select * from PointTable where vote != ''";
	$partis = $mysqli->query($query);
	echo "Gathering emails of all whom voted".PHP_EOL;
	while ($row = $partis->fetch_assoc())
	{
		$username = $row['userName'];
		$query = "select * from users where userName= '$username'";
		$results = $mysqli->query($query);
		$result = $results->fetch_assoc();
		$email= $result['email'];
		echo "EMAILING $username at $email".PHP_EOL;
		mailVoters($email,$winner);
	}
	echo "DAILY WINNER FINISHED".PHP_EOL;
}
function mailVoters($email,$winner)
{
	$subject = "Daily Matchup Winner Results";

	$message = "The winner for todays matchup is $winner";
	mail($email, "$subject", $message);

}
#error_reporting (E_ALL);
#ini_set('display_errors',false);
#ini_set('log_errors',true);
#ini_set('error_log', 'home/kevin/git/IT490Comic/php-errors.log');
#ini_set('log_error_max_len', 1024);

echo "Starting vote count".PHP_EOL;
dailyWinner();
echo "FINISHED vote count".PHP_EOL;
exit();
?>
