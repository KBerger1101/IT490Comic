#!/usr/bin/php
<?php 
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
	#email all whom won
	echo "Gathering emails of all whom won".PHP_EOL;
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
	echo "Weekly WINNER FINISHED".PHP_EOL;
}
function mailVoters($email,$winner)
{
	$subject = "Weekly Winner";

	$message = "Congrats you are the top weekly winner! You have been awarded your share of the jackpot!";
	mail($email, "$subject", $message);

}
echo "Checking leaderboards".PHP_EOL;
dailyWinner();
echo "Winners determined".PHP_EOL;
exit();
?>
