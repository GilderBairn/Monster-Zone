<html>
<body>
<?php
      	include("connection.php");
        session_start();
	$email = $_GET["email"];
  	$pass = $_GET["pass"];

    $sql = "SELECT * FROM user WHERE email='".$email."' AND password = '".$pass."'";
    $result = $mysqli_conn->query($sql);// or die("Login Failed");
    if ($result->num_rows == 1)	{
        $row = $result->fetch_assoc();
        $_SESSION['alias'] = $row["alias"];
        echo "getting there";
		header('Location: user.php'); /* Redirect browser */
	}
	else{
		echo "Login Failed";
	}
	$mysqli_conn->close();
?>
</body>
</html>
