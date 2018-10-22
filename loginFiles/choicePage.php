<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/checkSession.php';
?>
<html>
<h1>Options</h1>
<body>

<div id="textResponse">
if you see this you should see options
<a href="logout.php"><button>LOGOUT</button></a>
</div>

<form action="/loginFiles/dailyPage.php">
<button type="submit" >View Daily Matchup</button>
</form>
<form action="/loginFiles/leaderboards.php">
<button type="submit" >View Leaderboards</button>
</form>
<form action="/loginFiles/prevMatchups.php">
<button type="submit" >View Previous Matchups</button>
</form>
</body>
</html>

