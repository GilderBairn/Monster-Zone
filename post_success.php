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
                <a class="dropdown-item" href="user.php">My profile</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </div>
     </nav>

  <?php
  include("connection.php");
  session_start();
  ?>


	<div class="Monster_search">
  <div class="post-form">
    <div class="post-form-backdrop closed"></div>
    <div class="post-section editor-title">

      <?php
      echo "<h4 class=\"page-title\">You posted a new sighting! Well Done :) ".$_SESSION["alias"]."</h4>";
      ?>

    </div>
    </div>

   </body>
</html>
