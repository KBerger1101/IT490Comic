<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
</head>

<?php
session_start();
if( $_SERVER['REQUEST_METHOD'] == 'POST') 
{
	if (isset($_POST['login']))
	{
		echo "should have worked";
		require 'loginFiles/loginRequest.php';
	}
	if (isset($_POST['register']))
	{
		require 'loginFiles/registerRequest.php';
	}
}
?>
<body>
<form action="index.php" method="POST">
<label>
Email
</label>
<input type ="text" required name="uname"/>
<label>
Password
<input type= "password" required name="pword"/>
</label>
<button name="login">LOGIN</button>
</form>


<form action="index.php" method="POST">
<label>
Username
</label>
<input type="text" required name="username"/>
<label>
First Name
</label>
<input type="text" required name="firstName"/>
<label>
Last Name
</label>
<input type="text" required name="lastName"/>
<label>
Email
</label>
<input type="email" required name="email"/>
<label>
Password
</label>
<input type="password" required name="password"/>
<button name="register">Register</button>
</form>

</body>

</html>
