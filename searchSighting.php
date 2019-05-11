<html>
<head>
    <title>Monster Zone - Search</title>
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
                <a class=\"dropdown-item\" href=\"post_sighting.html\">Post Sighting</a>
                <a class=\"dropdown-item\" href=\"post_discussion.html\">Post Discussion</a>
                <a class=\"dropdown-item\" href=\"user.php\">My profile</a>
                <a class=\"dropdown-item\" href=\"logout.php\">Logout</a>
            </div>
        </div>";
    }
?>
    </nav>
    <div class="Monster_search">
        <form action="searchSighting.php" method="get">
        <div class="input-group mb-3" style="margin-bottom: 0!important;">
            <div class="input-group-prepend">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sightings</button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="search.php">Monsters</a>
                    <a class="dropdown-item" href="searchSighting.php">Sightings</a>
                    <a class="dropdown-item" href="searchLocation.php">Locations</a>
                    <a class="dropdown-item" href="searchDiscussion.php">Discussions</a>
                </div>
            </div>
            <input type="text" name="term"class="form-control" placeholder="Bigfoot" aria-label="search_query" aria-describedby="button-addon2">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
            </div>
        </div>
        </form>
        <div class="search-scroll">
        <?php
        include ("connection.php");

        $term = $_GET["term"];

        $sql = "SELECT DISTINCT postnum, title, poster_name, location_name, time_date
            FROM sighting, (monster LEFT OUTER JOIN traits on monID = ID), location, monster_names
            WHERE sighting.location_name = location.CSP
            AND monster_names.moID = ID
            AND sighting.monster_ID = ID
            AND ((mon_name LIKE '%".$term."%' OR traits.description LIKE '%".$term."%' OR type LIKE '%".$term."%' OR diet LIKE '%".$term."%')
            OR (CSP LIKE '%".$term."%' OR country LIKE '%".$term."%' or environment LIKE '%".$term."%')
            OR (title LIKE '%".$term."%' OR poster_name LIKE '%".$term."%' OR time_date LIKE '%".$term."%'))";
        if ($term != "")
        {
            $result = $mysqli_conn->query($sql);
        
            if ($result->num_rows > 0)
            {
                echo "<ul class=\"list-group\">";
                while($row = $result->fetch_assoc())
                {
                    echo "<li class =\"list-group-item\"><a href=\"sighting.php?ID=".$row["postnum"]."\">".$row["title"]." - ".$row["poster_name"]." - ".$row["time_date"]." - ".$row["location_name"]."</a></li>";
                }
                echo "</ul>";
            }
            else
            {
                echo "<div class=\"alert alert-danger\" role=\"alert\" style=\"margin-top: 1rem; margin-bottom: 0;\">No Results.</div>";
            }
        }
        
        $mysqli_conn->close();
    ?>
    </div>
    </div>
</body>
</html>
