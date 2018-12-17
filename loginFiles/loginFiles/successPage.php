<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/checkSession.php';

?>
<html>
<h1>login page</h1>
<body>
<div id="textResponse">
if you see this you are logged in
<a href="logout.php"><button>LOGOUT</button></a>
</div>
</body>
</html>
~          
