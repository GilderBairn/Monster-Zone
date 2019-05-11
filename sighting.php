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
    <div class="monster-info" style="height:75%;">
        <div style="height: 100%; overflow-y: scroll;">
    <?php

    include ("connection.php");

    $sightID = $_GET["ID"];

    $sql = "SELECT *
        FROM sighting
        WHERE postnum = ".$sightID;

    $result = $mysqli_conn->query($sql)->fetch_assoc();

    $sqlNames = "SELECT mon_name
        FROM monster_names
        WHERE moID = ".$result["monster_id"];

    $sqlCountry = "SELECT country
        FROM location
        WHERE CSP = '".$result["location_name"]."'";

    $nameList = $mysqli_conn->query($sqlNames);
    $country = $mysqli_conn->query($sqlCountry)->fetch_assoc()["country"];

    echo "<h2>".$result["title"]."</h2>";
    echo "<p>Seen on ".$result["time_date"]." by user: ".$result["poster_name"]." 
        near ".$result["location_name"].", ".$country."</p>";

    $row = $nameList->fetch_assoc();
    echo "<p>".$row["mon_name"];

    while ($row = $nameList->fetch_assoc())
    {
        echo " - ".$row["mon_name"];
    }
    echo "</p>";

    echo "<p class=\"lead\">".$result["description"]."</p>";

    if ($result["sighting_media"] == null || $result["sighting_media"] == "picture")
    {
        echo "<img style=\"width: 100%; height: auto;\" src=\"https://images.pexels.com/photos/893483/pexels-photo-893483.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260\">";
    }
    else
    {
        echo "<img style=\"width: 100%; height: auto;\" src=\"".$result["sighting_media"]."\">";
    }

    $mysqli_conn->close();
?>
        </div>
    </div>
</html>
