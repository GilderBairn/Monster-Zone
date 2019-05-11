<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: user.php");
    exit;
}

// Include connection file
include ("connection.php");

// Define variables and initialize with empty values
$alias = $password = "";
$alias_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if alias is empty
    if(empty(trim($_POST["alias"]))){
        $alias_err = "Please enter alias.";
    } else{
        $alias = trim($_POST["alias"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($alias_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT alias, password FROM user WHERE alias = ?";

        if($stmt = mysqli_prepare($mysqli_conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_alias);

            // Set parameters
            $param_alias = $alias;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if alias exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $alias, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["alias"] = $param_alias;

                            // Redirect user to welcome page
                            header("location: user.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if alias doesn't exist
                    $alias_err = "No account found with that alias.";
                }
            } else{
                echo "Error: " . $sql . "<br>" . $mysqli_conn->error;
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Close connection
    mysqli_close($mysqli_conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Monster Zone - Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="search.php">Monster Zone</a>
        <a class="navbar-brand" >cataloging the unknown</a>
        <form class="form-inline">
            <a style="{color: #28a745;} :hover {color: #ffffff;};" class="btn btn-outline-success my-2 my-sm-0" href="signup2.php">Sign Up</a>
        </form>
    </nav>
    <div class="signup_pane"> <!--login_pane is broken :(-->
      <div class="login_contents">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2>Login</h2>
            <p>Please fill in your credentials to login.</p>
                <div class="input-group mb-3 <?php echo (!empty($alias_err)) ? 'has-error' : ''; ?>">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">@</span>
                    </div>
                    <!--ALIAS-->
                    <input type="text" placeholder="Alias" name="alias" class="form-control" value="<?php echo $alias; ?>">
                    <span class="help-block"><?php echo $alias_err; ?></span>
                </div>
                <div class="input-group mb-3 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <!--PASS-->
                    <input type="password" placeholder="Password" name="password" class="form-control">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <div class="input-group mb-3">
                    <input type="submit" class="btn btn-primary" value="Login">
                </div>
                <p>Don't have an account? <a href="signup2.php">Sign up now</a>.</p>
                </form>
          </div>
    </div>
</body>
</html>
