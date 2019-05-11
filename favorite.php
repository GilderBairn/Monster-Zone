<html>
<?php 

include("connection.php");
session_start();

$monID = $_GET["MID"];

$sql = "INSERT INTO favorite (u_name, mons_ID) VALUES ('".$_SESSION["alias"]."', ".$monID.")";

$mysqli_conn->query($sql);

header("location: user.php");

?>
</html>
