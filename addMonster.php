<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if no redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login2.php");
    exit;
}

// Include connection file
include ("connection.php");

// Define error variables and initialize with empty values
$name_err = $media_err = $type_err = $rarity_err = ""; //monster
$description_err = $diet_err = $dangerS_err = $minS_err = $maxS_err = $strength_err = $weak_err = "";//Traits
$state_err = $country_err = $environment_err = ""; //location
$story_err = "";//Lore

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
  // Variables with escape user inputs for security
    //Monster
    $name = mysqli_real_escape_string($mysqli_conn, $_POST["name"]);//MultiValue
    $media = mysqli_real_escape_string($mysqli_conn, $_POST["media"]);
    $type = mysqli_real_escape_string($mysqli_conn, $_POST["type"]);
    $rarity = mysqli_real_escape_string($mysqli_conn, $_POST["rarity"]);
    // Attempt insert query for Monster
    $sql = "INSERT INTO monster (ID, media, type, rarity) VALUES (NULL, '$media', '$type', '$rarity')";
    if(mysqli_query($mysqli_conn, $sql)){
        echo "Monster added successfully.";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
    //Select MONSTERID
    $result = mysql_query($mysqli_conn, "SELECT MAX(ID) FROM monster");
    $row = mysql_fetch_assoc($result); 
    $monID = $row['maximum'];
    $sql = "INSERT INTO monster_names (ID, mon_name) VALUES ($monID, $name)";
    if(mysqli_query($mysqli_conn, $sql)){
        echo "Name added successfully.";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }

    //Traits
    $description = mysqli_real_escape_string($mysqli_conn, $_POST["description"]);
    $diet = mysqli_real_escape_string($mysqli_conn, $_POST["diet"]);
    $dangerS = mysqli_real_escape_string($mysqli_conn, $_POST["dangerS"]);
    $minS = mysqli_real_escape_string($mysqli_conn, $_POST["minS"]);
    $maxS = mysqli_real_escape_string($mysqli_conn, $_POST["maxS"]);
    // Attempt insert query for Traits
    $sql = "INSERT INTO traits (monID, description, diet, danger_scale, min_size, max_size) VALUES ($monID, '$description', '$diet', '$dangerS', '$minS', '$maxS')";
    if(mysqli_query($mysqli_conn, $sql)){
        echo "Traits added successfully.";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
    //MultiValue
    $strength = mysqli_real_escape_string($mysqli_conn, $_POST["strength"]);
    $weak = mysqli_real_escape_string($mysqli_conn, $_POST["weak"]);

    //lore
    $lore = mysqli_real_escape_string($mysqli_conn, $name.=" story");
    $story = mysqli_real_escape_string($mysqli_conn, $_POST["environment"]);

    //location
    $state = mysqli_real_escape_string($mysqli_conn, $_POST["state"]);
    $country = mysqli_real_escape_string($mysqli_conn, $_POST["country"]);
    $environment = mysqli_real_escape_string($mysqli_conn, $_POST["environment"]);

    // Close connection
    mysqli_close($mysqli_conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Monster Zone - Add Monster</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="search.php">Monster Zone</a>
        <a class="navbar-brand" >cataloging the unknown</a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <a class="dropdown-item" href="http://student2.cs.appstate.edu/classes/3430/184/team6/search.php">Search</a>
          <a class="dropdown-item" href="http://student2.cs.appstate.edu/classes/3430/184/team6/post_sighting.html">Post Sighting</a>
          <a class="dropdown-item" href="http://student2.cs.appstate.edu/classes/3430/184/team6/post_discussion.html">Post Discussion</a>
              <a class="dropdown-item" href="http://student2.cs.appstate.edu/classes/3430/184/team6/user.php">Your Account</a>
        </div>
    </nav>
    <div class="Monster_search">
      <div style="height: 80%; overflow-y: scroll;">
      <div class="post-form">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <h2>Add Monster</h2>
          <p>Please fill this form to add a new monster</p>
          <!--Name-->
          <div class="input-group mb-3 <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
              <input type="text" placeholder="Monster Name" name="name" class="form-control" value="<?php echo $name; ?>">
              <span class="help-block">&nbsp;<?php echo $name_err; ?></span>
          </div>

          <!--Description-->
          <div class= "post_media <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
              <textarea class="form-control" placeholder="Your Description" name="description" style="margin-bottom: 7;"></textarea>
              <span class="help-block">&nbsp;<?php echo $name_err; ?></span>
          </div>

          <!--Media-->
          <div class="input-group mb-3 <?php echo (!empty(media_err)) ? 'has-error' : ''; ?>">
              <input type="url" placeholder="Your Media URL" name="media" class="form-control" value="<?php echo $media; ?>">
              <span class="help-block">&nbsp;<?php echo $name_err; ?></span>
          </div>

          <div class="input-group mb-3 <?php echo (!empty($diet_err)) ? 'has-error' : ''; ?>">
              <!--Type-->
              <input type="text" placeholder="Type" name="type" class="form-control" value="<?php echo $type; ?>">
              <span class="help-block">&nbsp;<?php echo $name_err; ?></span>
              <!--Diet-->
              <input type="text" placeholder="Diet" name="diet" class="form-control" value="<?php echo $diet; ?>">
              <span class="help-block">&nbsp;<?php echo $name_err; ?></span>
              <!--Weakness-->
              <input type="text" placeholder="Weakness" name="weak" class="form-control" value="<?php echo $weak; ?>">
              <span class="help-block">&nbsp;<?php echo $weak_err; ?></span>
              <!--Strength-->
              <input type="text" placeholder="Strength" name="strength" class="form-control" value="<?php echo $strength; ?>">
              <span class="help-block">&nbsp;<?php echo $strength_err; ?></span>
          </div>
          <div class="input-group mb-3 <?php echo (!empty($diet_err)) ? 'has-error' : ''; ?>">
            <!--Location-->
            <input type="text" placeholder="County/State/Province/" name="state" class="form-control" value="<?php echo $state; ?>">
            <span class="help-block">&nbsp;<?php echo $state_err; ?></span>
            <!--country-->
            <input type="text" placeholder="Country" name="state" class="form-control" value="<?php echo $state; ?>">
            <span class="help-block">&nbsp;<?php echo $state_err; ?></span>
            <!--Environment-->
            <input type="text" placeholder="Environment" name="state" class="form-control" value="<?php echo $state; ?>">
            <span class="help-block">&nbsp;<?php echo $state_err; ?></span>
          </div>
          <div class="input-group mb-3 <?php echo (!empty($dangerS_err)) ? 'has-error' : ''; ?>">
              <!--Rarity Scale-->
              <input type="number" placeholder="1-10 Rarity" min="1" max="10" name="rarity" class="form-control" value="<?php echo $rarity; ?>">
              <span class="help-block">&nbsp;<?php echo $rarity_err; ?></span>
              <!--Danger Scale-->
              <input type="number" placeholder="1-10 Danger Scale" min="1" max="10" name="dangerS" class="form-control" value="<?php echo $dangerS; ?>">
              <span class="help-block">&nbsp;<?php echo $dangerS_err; ?></span>
              <!--Size min-->
              <input type="number" placeholder="Min-size in feet" min="1" max="1000000" name="minS" class="form-control" value="<?php echo $minS; ?>">
              <span class="help-block">&nbsp;<?php echo $minS_err; ?></span>
              <!--Size max-->
              <input type="number" placeholder="Max-size in feet" min="1" max="1000000" name="maxS" class="form-control" value="<?php echo $maxS; ?>">
              <span class="help-block">&nbsp;<?php echo $maxS_err; ?></span>
          </div>
          <!--Lore Story-->
          <div class= "post_media <?php echo (!empty($story_err)) ? 'has-error' : ''; ?>">
              <textarea class="form-control" placeholder="Your Lore Story" name="story" style="margin-bottom: 7;"></textarea>
              <span class="help-block">&nbsp;<?php echo $story_err; ?></span>
          </div>

          <!--BUTTONS-->
          <input type="submit" value="Submit">
          <input type="reset" value="Reset">
      </form>
      </div>
    </div>
    </div>
</body>
</html>
