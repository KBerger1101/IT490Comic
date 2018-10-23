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
