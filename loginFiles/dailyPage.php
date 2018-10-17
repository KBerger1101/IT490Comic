<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/checkSession.php';
require('getDaily.php');
?>
<html>
<h1>matchup</h1>
<body>
<div id="textResponse">
if you see this you should see matchup
<a href="logout.php"><button>LOGOUT</button></a>
</div>
</body>
</html>


