<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/checkSession.php';
if ($_SESSION['lb'] ==null)
{
	require('getLead.php');
}
?>
<html>
<h1>Leaderboard</h1>

<body>
<div id="textResponse">
View Leaderboard Below
<a href="choicePage.php"><button>Home Page</button></a>
<a href="logout.php"><button>LOGOUT</button></a>
</div>

<?php
foreach ($_SESSION['lb']['leaderboard'] as $user)
{
	echo $user['userName'];
	echo " ";
	echo $user['points'];
	echo '<br>';
}
?>
</body>
