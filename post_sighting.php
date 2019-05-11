<html>
<body>
<?php
      // Initialize the session
      session_start();

      // Check if the user is already logged in, if no redirect to login page
      if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
          header("location: login2.php");
          exit;
      }
      	include("connection.php");
        //$postnum = $_POST["postnum"];
        $postnum = rand(1, 1000000000);
  $sighting_media = $_POST["sighting_media"];
  $description = $_POST["description"];
	$title = $_POST["title"];
  //$time_date = $_POST["time_date"];
  $time_date = date("Y-m-d");
	$monster_name = $_POST["monster_id"];
	//$poster_name = $_POST["poster_name"];
  $poster_name = $_SESSION["alias"];
  $location_name = $_POST["location_name"];

  //echo $poster_name;
  $sqlID = "SELECT moID FROM monster_names WHERE mon_name = '".$monster_name."'";
  $IDresult = $mysqli_conn->query($sqlID);

  if ($IDresult->num_rows > 0)
  {
      $monster_id = $IDresult->fetch_assoc()["moID"];

	$sql = "INSERT INTO sighting values ('".$postnum."', '".$sighting_media."', '".$description."', '".$title."', '".$time_date."', '".$monster_id."', '".$poster_name."', '".$location_name."')";

	if ($mysqli_conn->query($sql) === TRUE) {
    		echo "New Sighting record created successfully";
       	 $_SESSION['title'] = $result;
        header('Location: post_success.php'); /* Redirect browser */
	} else if ($title) {/*Error if not found*/
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
