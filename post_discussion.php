<html>
<body>
<?php
      // Initialize the session
      session_start();

      // Check if the user is already logged in, if yes then redirect him to welcome page
      if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
          header("location: login2.php");
          exit;
      }
      	include("connection.php");
  $post_title = $_POST["post_title"];
        //$post_time_date = $_POST["post_time_date"];
        $post_time_date = date("Y-m-d");
  $text = $_POST["text"];
	$post_media = $_POST["post_media"];
  //$monsterID = $_POST["monsterID"];
	//$user_name = $_POST["user_name"];
  $poster_name = $_SESSION["alias"];
  $monster_name = $_POST["monsterID"];

  $sqlID = "SELECT moID FROM monster_names WHERE mon_name = '".$monster_name."'";
  $IDresult = $mysqli_conn->query($sqlID);

  if ($IDresult->num_rows > 0)
  {
      $monsterID = $IDresult->fetch_assoc()["moID"];
	$sql = "INSERT INTO discussion_post values ('".$post_title."', '".$post_time_date."', '".$text."', '".$post_media."', '".$monsterID."', '".$poster_name."')";

	if ($mysqli_conn->query($sql) === TRUE) {
    		echo "New Discussion record created successfully";
       	 $_SESSION['title'] = $result;
        header('Location: post_discussion_success.php'); /* Redirect browser */
	} else if ($post_title) {/*Error if not found*/
	    echo "Error: " . $sql . "<br>" . $mysqli_conn->error;
    }
  }
  else
  {
      echo "Name not found";
  }


	$mysqli_conn->close();
?>
</body>
</html>
