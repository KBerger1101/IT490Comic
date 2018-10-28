#!/usr/bin/php
<?php 
function weeklyWinner()
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
                $eMSG= 'Connect Error in weeklyWinner, '.$mysqli->connect_errno.': ' . $mysqli->connect_error;
                dblogger($eDate, $eMSG);
                die('Connect Error, '.$mysqli->connect_errno.':
' . $mysqli->connect_error);
        }

	$query = "SELECT * FROM jackpot";
	$jackpot = $mysqli->query($query);
	$query = "SELECT * from PointTable where totalPoints = (SELECT MAX(totalPoints) from PointTable)";
	$allWinners = $mysqli->query($query);
	#$winners = $allWinners->fetch_assoc();
	$numWinners = mysqli_num_rows($allWinners);
	#check if more than one winner, if so, divide tokens evenly
	if ( $numWinners > 1)
	{
		echo "More than one winner, dividing pot evenly".PHP_EOL;
		$jackpot = $jackpot->fetch_assoc();
		echo $jackpot['totalTokens'].PHP_EOL;
		$totalTokens= $jackpot['totalTokens'];
		$leftover = $totalTokens % $numWinners;
		$evenSplit = ($totalTokens-$leftover) / $numWinners;
		echo "each user receiving $evenSplit tokens".PHP_EOL;
		while ($row = $allWinners->fetch_assoc())
		{
			$username= $row['userName'];
			$query = "update TokenTable set availTokens= availTokens + $evenSplit where userName = '$username'";
			$mysqli->query($query);
                        echo "emailing winners".PHP_EOL;
                        $query ="select * from users where userName= '$username'";
                        $results = $mysqli->query($query);
                        $result = $results->fetch_assoc();
			$email =$result['email'];
			echo "emailing $username at $email".PHP_EOL;
                        mailVoters($email);

		}
		echo "Tokens distributed, restarting week stats".PHP_EOL;
		$query = "update jackpot set totalTokens= $leftover";
		$mysqli->query($query);
		$query = "update PointTable set totalPoints = 0, vote= ''";
		$mysqli->query($query);
		echo "Points reset".PHP_EOL;
	}
	elseif ($numWinners ==1)
	{
		echo "Only one winner, keeping the pot!".PHP_EOL;
		$jackpot = $jackpot->fetch_assoc();
                echo $jackpot['totalTokens'].PHP_EOL;
                $totalTokens= $jackpot['totalTokens'];
                echo "each user receiving $totalTokens tokens".PHP_EOL;
                while ($row = $allWinners->fetch_assoc())
                {
                        $username= $row['userName'];
                        $query = "update TokenTable set availTokens= availTokens + $totalTokens where userName = '$username'";
			$mysqli->query($query);
                        echo "emailing winners".PHP_EOL;
                        $query ="select * from users where userName= '$username'";
                        $results = $mysqli->query($query);
                        $result = $results->fetch_assoc();
			$email =$result['email'];
			echo "emailing $username at $email".PHP_EOL;
                        mailVoters($email);

                }
                echo "Tokens distributed, restarting week stats".PHP_EOL;
                $query = "update jackpot set totalTokens= 0";
                $mysqli->query($query);
                $query = "update PointTable set totalPoints = 0, vote= ''";
                $mysqli->query($query);
		echo "Points reset".PHP_EOL;
		echo "emailing winner".PHP_EOL;

	}
	#email all whom won
	#echo "Gathering emails of all whom won".PHP_EOL;
	/*
	while ($row = $allWinners->fetch_assoc())
	{
		$username = $row['userName'];
		$query = "select * from users where userName= '$username'";
		$results = $mysqli->query($query);
		$result = $results->fetch_assoc();
		$email= $result['email'];
		echo "EMAILING $username at $email".PHP_EOL;
		mailVoters($email);
	}*/
	echo "Weekly WINNER FINISHED".PHP_EOL;
}
function mailVoters($email)
{
	$subject = "Weekly Winner";

	$message = "Congrats you are the top weekly winner! You have been awarded your share of the jackpot!";
	mail($email, "$subject", $message);

}
echo "Checking leaderboards".PHP_EOL;
weeklyWinner();
echo "Winners determined".PHP_EOL;
exit();
?>
