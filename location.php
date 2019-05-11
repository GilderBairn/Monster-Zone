<html>
<head>
    <title>Monster Zone - Monster Codex</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">    
    <link rel="stylesheet" href="main.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>
<?php 
    session_start();
?>
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="search.php">Monster Zone</a>
        <a class="navbar-brand" >cataloging the unknown</a>
<?php
    if ($_SESSION["alias"] == null)
    {
        echo "
        <form class=\"form-inline\">
            <a style=\"{color: #28a745;} :hover {color: #ffffff;}\" class=\"btn btn-outline-success my-2 my-sm-0\" href=\"login2.php\">Log in</a>
            <div style=\"width: 8px\"></div>
            <a style=\"color: #ffffff;\" class=\"btn btn-success my-2 my-sm-0\" href=\"signup2.php\">Sign up</a>
        </form>";
    } 
    else
    {
        echo "<div class=\"dropdown\">
            <button class=\"btn btn-secondary dropdown-toggle\" type=\"button\" id=\"dropdownMenuLink\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
        Posting options
            </button>
            <div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuLink\">
                <a class=\"dropdown-item\" href=\"search.php\">Search</a>
                <a class=\"dropdown-item\" href=\"post_sighting.html\">Post Sighting</a>
                <a class=\"dropdown-item\" href=\"post_discussion.html\">Post Discussion</a>
                <a class=\"dropdown-item\" href=\"user.php\">My profile</a>
                <a class=\"dropdown-item\" href=\"logout.php\">Logout</a>
            </div>
        </div>";
    }
?>
    </nav>
    <div class="location-info">
        <div class="monster-content">
    <?php

    include ("connection.php");

    $locID = $_GET["ID"];

    $sql = "SELECT *
        FROM location
        WHERE CSP = '".$locID."'";

    $sqlMon = "SELECT ID, mon_name, type, description
        FROM (monster LEFT OUTER JOIN traits ON monID = ID), lives_in, monster_names
        WHERE monster_names.moID = ID
        AND lives_in.monst_ID = ID
        AND lives_in.CoStPr = '".$locID."'";

    $sqlSight = "SELECT postnum, mon_name, time_date, poster_name
        FROM sighting, monster_names
        WHERE monster_names.moID = sighting.monster_id
        AND location_name = '".$locID."'";

    $result = $mysqli_conn->query($sql)->fetch_assoc();

    echo "<h1>".$result["CSP"]."</h1>";
    echo "<h2 style=\"margin-bottom: 2rem;\">".$result["country"]." - ".$result["environment"]."</h2>";

    $result = $mysqli_conn->query($sqlMon);

    echo "<h2>Monsters at this location</h2>";

    if ($result->num_rows > 0){
        echo "<ul class=\"list-group\" style=\"max-height: 16rem; overflow-y: scroll;\">";
    
        while ($row = $result->fetch_assoc())
        {
            echo "<li class=\"list-group-item\">
                <a href=\"monster.php?ID=".$row["ID"]."\">".$row["mon_name"]." 
                - ".$row["type"]." - ".$row["description"]."</a></li>";
        }

        echo "</ul>";
    }
    else
    {
        echo "<div class=\"alert alert-danger\" role=\"alert\">
              No monsters known at this location
              </div>";
    }

    $result = $mysqli_conn->query($sqlSight);

    echo "<h2>Sightings at this location</h2>";
    
    if ($result->num_rows > 0){
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
        echo "<div class=\"alert alert-danger\" role=\"alert\">
              No sightings from this location
              </div>";
    }

    $mysqli_conn->close();
?>
        </div>
    </div>
</html>
