<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login2.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
    <title>User Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>
  <?php
  include("connection.php");
  session_start();
  ?>
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="search.php">Monster Zone</a>
        <a class="navbar-brand" >cataloging the unknown</a>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Posting options
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="http://student2.cs.appstate.edu/classes/3430/184/team6/search.php">Search</a>
                <a class="dropdown-item" href="http://student2.cs.appstate.edu/classes/3430/184/team6/post_sighting.html">Post Sighting</a>
                <a class="dropdown-item" href="http://student2.cs.appstate.edu/classes/3430/184/team6/post_discussion.html">Post Discussion</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </div>
     </nav>

    <div class="monster-info">
<!--
  <div class="post-form">
    <div class="post-form-backdrop closed"></div>
    <div class="post-section editor-title">
-->
        <div style="height: 100%; overflow-y: scroll;">
<?php
    echo "<h1 class=\"page-title\" style=\"margin-bottom: 2rem; text-align: center;\">Welcome ".$_SESSION["alias"]."</h1>";

  $sqlDiss = "SELECT post_title, user_name, post_time_date, mon_name
      FROM discussion_post, monster_names
      WHERE moID = monsterID
      AND discussion_post.user_name = '".$_SESSION["alias"]."'";

  $sqlSight = "SELECT postnum, mon_name, time_date, poster_name
        FROM sighting, monster_names
        WHERE monster_names.moID = sighting.monster_id
        AND poster_name = '".$_SESSION["alias"]."'";

  $sqlFav = "SELECT ID, mon_name, type, description
      FROM (monster LEFT OUTER JOIN traits ON monID = ID), favorite, monster_names
      WHERE monster_names.moID = ID
      AND favorite.mons_ID = ID
      AND favorite.u_name = '".$_SESSION["alias"]."'
      GROUP BY  mon_name";

  $result = $mysqli_conn->query($sqlDiss);

      echo "<h2>Your discussion posts</h2>";
  if ($result->num_rows > 0)
  {
        echo "<ul class=\"list-group\" style=\"max-height: 16rem; overflow-y: scroll;\">";
      while ($row = $result->fetch_assoc())
      {
          echo "<li class =\"list-group-item\"><a href=\"discussion.php?ID=".$row["post_title"]."\">".$row["post_title"]." - ".$row["user_name"]." - ".$row["post_time_date"]." - ".$row["mon_name"]."</a></li>";
      }
      echo "</ul>";
  }
  else
  {
    echo "<div class=\"alert alert-warning\" role=\"alert\">
        No discussion posts yet
        </div>";
  }

  $result = $mysqli_conn->query($sqlSight);

  echo "<h2>Your reported sightings</h2>";
  if ($result->num_rows > 0)
  {
        echo "<ul class=\"list-group\" style=\"max-height: 16rem; overflow-y: scroll;\">";
      while ($row = $result->fetch_assoc())
      {
          echo "<li class=\"list-group-item\">
              <a href=\"sighting.php?ID=".$row["postnum"]."\">".$row["mon_name"]."
              - ".$row["time_date"]." - ".$row["poster_name"]."</a></li>";
      }
      echo "</ul>";
  }
  else
  {
    echo "<div class=\"alert alert-warning\" role=\"alert\">
        No sightings yet
        </div>";
  }

    $result = $mysqli_conn->query($sqlFav);
  echo"<h2>Favorite monsters</h2>";
  if ($result->num_rows > 0)
  {
        echo "<ul class=\"list-group\" style=\"max-height: 16rem; overflow-y: scroll;\">";
      while ($row = $result->fetch_assoc())
      {
          $desc = $row["description"];
          if ($desc == null)
          {
              $desc = "Unknown";
          }
          echo "<li class =\"list-group-item\">
                    <a href=\"monster.php?ID=".$row["ID"]."\">"
                    .$row["mon_name"]." - ".$row["type"]." - ".$desc.
                    "</a></li>";
      }
      echo "</ul>";
  }
  else
  {
    echo "<div class=\"alert alert-warning\" role=\"alert\">
        No favorite monsters yet
        </div>";
  }

?>
      <!--<h5>Favorite monsters</h5>
	<button type="submit" class="btn btn-success" action="post_sighting.html">
		<a href="post_sighting.php" style="color:#FFFFFF;">Post</a>
	</button>
    </div> -->
        </div>
    </div>

   </body>
</html>
