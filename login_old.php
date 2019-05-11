<html>
<body>
<?php
      	include("connection.php");
        session_start();
	$email = $_GET["email"];
  	$pass = $_GET["pass"];

	$sql = "SELECT * FROM user WHERE email='%".$email."%' AND password = '".$pass."'";
	$result = mysql_query($sql) or die("Login Failed");
	if (mysql_num_rows($result)==1)	{
		$_SESSION['alias'] = $result;
		header('Location: user.php'); /* Redirect browser */
	}
	else{
		echo "Login Failed";
	}
	$mysqli_conn->close();
?>
</body>
</html>
