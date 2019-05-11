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
    <div class="monster-info">
        <div class="monster-content">
    <?php

    include ("connection.php");

    $monID = $_GET["ID"];

    $sqlNames = "SELECT mon_name
                FROM monster, monster_names
                WHERE moID = ID
                AND ID = ".$monID;

    $sqlPic = "SELECT media
        FROM monster
        WHERE ID = ".$monID;

    $sqlExtra = "SELECT type, rarity
        FROM monster
        WHERE ID = ".$monID;

    $sqlTraits = "SELECT description, diet, danger_scale, min_size, max_size
        FROM traits
        WHERE monID = ".$monID;

    $sqlTips = "SELECT tip_text
        FROM tips
        WHERE Monster_ID = ".$monID;

    $sqlLoc = "SELECT CSP, country, environment
        FROM location, lives_in
        WHERE lives_in.CoStPr = CSP
        AND lives_in.monst_ID = ".$monID;

    $sqlStr = "SELECT strength
        FROM mon_traits_strengths
        WHERE mon_ID = ".$monID;

    $sqlWeak = "SELECT weakness
        FROM mon_traits_weaknesses
        WHERE Mons_ID = ".$monID;

    $sqlLore = "SELECT lore_stories.stories
        FROM lore_stories
        WHERE mo_ID = ".$monID;

    $sqlLname = "SELECT lore.name
        FROM lore
        WHERE MID = ".$monID;

    $picLink = $mysqli_conn->query($sqlPic)->fetch_assoc();

    if ($picLink["media"] == null || $picLink["media"] == "picture")
    {
        echo "<img src=\"https://images.pexels.com/photos/893483/pexels-photo-893483.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260\">";
    }
    else
    {
        echo "<img src=\"".$picLink["media"]."\">";
    }

    $monNames = $mysqli_conn->query($sqlNames);

    echo "<div class=\"right-panel\">";
    echo "<h2>Recorded Names</h2>";
    echo "<ul class=\"list-group\">";

    while ($row = $monNames->fetch_assoc())
    {
        echo "<li class=\"list-group-item\">".$row["mon_name"]."</li>";
    }
    echo "</ul>";

    $monExtra = $mysqli_conn->query($sqlExtra)->fetch_assoc();
    echo "<h2>Rarity: <span class=\"badge badge-secondary\">".$monExtra["rarity"]."</span></h2><h2>Type: <span class=\"badge badge-secondary\">".$monExtra["type"]."</span></h2>";
    echo"</div>";

    $monTraits = $mysqli_conn->query($sqlTraits);

    echo "<h2>Lists of known traits</h2><ul class=\"list-group\">";
    while ($row = $monTraits->fetch_assoc())
    {
        echo "<li class=\"list-group-item\">".$row["description"]."</li>";
        echo "<li class=\"list-group-item\">Diet includes: ".$row["diet"]."</li>";
        echo "<li class=\"list-group-item\">Danger Level: ".$row["danger_scale"]."</li>";
        echo "<li class=\"list-group-item\">Size Range: ".$row["min_size"]." - ".$row["max_size"]."</li>";
    }
    echo "</ul>";

    $monTips = $mysqli_conn->query($sqlTips);

    echo "<h2>Tips for an encounter</h2><ul class=\"list-group\">";
    while ($row = $monTips->fetch_assoc())
    {
        echo "<li class=\"list-group-item\">".$row["tip_text"]."</li>";
    }
    echo "</ul>";

    $monStr = $mysqli_conn->query($sqlStr);
    $monWeak = $mysqli_conn->query($sqlWeak);
    echo "<h2>Strengths</h2><ul class=\"list-group\">";
    while ($row = $monStr->fetch_assoc())
    {
        echo "<li class=\"list-group-item\">".$row["strength"]."</li>";
    }
    echo "</ul>";
    echo "<h2>Weaknesses</h2><ul class=\"list-group\">";
    while ($row = $monWeak->fetch_assoc())
    {
        echo "<li class=\"list-group-item\">".$row["weakness"]."</li>";
    }
    echo "</ul>";

    $monLoc = $mysqli_conn->query($sqlLoc);
    echo "<h2>Known to frequent these locations</h2>";    
    echo "<ul class=\"list-group\">";
    while ($row = $monLoc->fetch_assoc())
    {
        echo "<li class=\"list-group-item\"><a href = location.php?ID=".$row["CSP"].">".$row["CSP"]." - ".$row["country"]." - ".$row["environment"]."</a></li>";
    }
    echo "</ul>";

    $monLname = $mysqli_conn->query($sqlLname)->fetch_assoc(); 
    echo "<h2>".$monLname["name"]."</h2><ul class=\"list-group\">";
    $monLore = $mysqli_conn->query($sqlLore);
    while ($row = $monLore->fetch_assoc())
    {
        echo "<li class=\"list-group-item\">".$row["stories"]."</li>";
    }
    echo "</ul>";

    if ($_SESSION["alias"] != null)
    {
        echo "<a style=\"width: 100%;\" class=\"btn btn-primary btn-lg\" href=\"favorite.php?MID=".$monID."\">Make Favorite</a>";
    }

    $mysqli_conn->close();
    ?>
        </div>
    </div>
</html>
