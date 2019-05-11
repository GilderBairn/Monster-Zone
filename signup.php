<html>
<body>
<?php
      	include("connection.php");
        session_start();
	$alias = $_GET["alias"];
	$email = $_GET["email"];
  $pass = $_GET["pass"];
  $dob = $_GET["dob"];

	$sql = "INSERT INTO user values ('".$alias."', '".$email."', '".$pass."', '".$dob."')";

	if ($mysqli_conn->query($sql) === TRUE) {
    		echo "New record created successfully";
        $_SESSION['alias'] = $alias;
        header('Location: user.php'); /* Redirect browser */
	} else if ($alias || $email || $pass || $dob) {/*Error if not found*/
	    echo "Error: " . $sql . "<br>" . $mysqli_conn->error;
	}

	$mysqli_conn->close();
?>
</body>
</html>
