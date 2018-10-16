<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
<title>LOGGED OUT</title>
</head>
<body>
<p>YOU HAVE BEEN LOGGED OUT, CLICK BELOW TO LOG BACK IN</p>
<a href='../index.php'><button>Login Page</button></a>
</body>
</html>
