<?php
// Include connection file
include ("connection.php");
session_start();
// Define variables and initialize with empty values
$alias = $email = $password = $confirm_password = $dob = "";
$alias_err = $email_err = $password_err = $confirm_password_err = $dob_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate email
    if(empty(trim($_POST["email"])) || empty(trim($_POST["alias"])) || empty(trim($_POST["dob"]))){
        if (empty(trim($_POST["email"]))){
            $email_err = "Please enter an email.";
        }
        if (empty(trim($_POST["alias"]))){
            $alias_err = "Please enter an alias.";
        }
        if (empty(trim($_POST["alias"]))){
            $dob_err = "Please enter a birthdate.";
        }
    } else{
        // Prepare a select statement
        $sql = "SELECT alias FROM user WHERE alias = ?";

        if($stmt = mysqli_prepare($mysqli_conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_alias);
            // Set parameters
            $param_alias = trim($_POST["alias"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $alias_err = "This alias is already taken.";
                } else{
                    $alias = trim($_POST["alias"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later. -Alias error";
            }
        }
        mysqli_stmt_close($stmt);// Close statement

        // Validate alias
        // Prepare a select statement
        $sql = "SELECT alias FROM user WHERE email = ?";

        if($stmt = mysqli_prepare($mysqli_conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later. -Email error";
            }
        }
        mysqli_stmt_close($stmt); // Close statement
        $dob = trim($_POST["dob"]);//DOB
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if(empty($email_err) && empty($alias_err) && empty($password_err) && empty($confirm_password_err) && empty($dob_err)){

        // Prepare an insert statements
        $sql = "INSERT INTO user (alias, email, password, dob) VALUES (?, ?, ?, ?)";

        if($stmt = mysqli_prepare($mysqli_conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_alias, $param_email, $param_password, $param_dob);

            // Set parameters
            $param_alias = $alias;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_dob = $dob;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                $_SESSION['alias'] = $param_alias;//Set login status (on) & to alias
                header("location: user.php");
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
    <title>Monster Zone - Sign up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="search.php">Monster Zone</a>
        <a class="navbar-brand" >cataloging the unknown</a>
        <form class="form-inline">
            <a style="{color: #28a745;} :hover {color: #ffffff;};" class="btn btn-outline-success my-2 my-sm-0" href="login2.php">Log in</a>
        </form>
    </nav>
    <div class="signup_pane">
      <div class="login_contents">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="input-group mb-3 <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">@</span>
                </div>
                <!--EMAIL-->
                <input type="text" placeholder="Email" name="email" class="form-control" value="<?php echo $email; ?>">
                <br>
                <span class="help-block">&nbsp;<?php echo $email_err; ?></span>
            </div>
            <div class="input-group mb-3 <?php echo (!empty($alias_err)) ? 'has-error' : ''; ?>">
                <!--ALIAS-->
                <input type="text" placeholder="Alias" style="text-align: center" name="alias" class="form-control" value="<?php echo $alias; ?>">
                <br>
                <span class="help-block">&nbsp;<?php echo $alias_err; ?></span>
            </div>
            <div class="input-group mb-3 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <!--PASS-->
                <input type="password" autocomplete = "off" placeholder="Password" style="text-align: center" name="password" class="form-control" value="<?php echo $password; ?>">
                <br>
                <span class="help-block">&nbsp;<?php echo $password_err; ?></span>
            </div>
            <div class="input-group mb-3 <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <input type="password" autocomplete = "off" placeholder="Confirm Password" style="text-align: center" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <br>
                <span class="help-block">&nbsp;<?php echo $confirm_password_err; ?></span>
            </div>
            <div class="input-group mb-3 <?php echo (!empty($dob_err)) ? 'has-error' : ''; ?>">
                <!--DOB-->
                <input type="date" placeholder="YYYY/MM/DD" style="text-align: center" name="dob" class="form-control" value="<?php echo $dob; ?>">
                <br>
                <span class="help-block">&nbsp;<?php echo $dob_err; ?></span>
            </div>
            <div class="input-group mb-3">
                <input type="submit" value="Submit" class="btn btn-primary btn-lg-success">
                <input type="reset"  value="Reset"  class="btn btn-default">
            </div>
            <p style="text-align: center;">WARNING! - This website supports password hashing and protects against SQL injections.
              However, the details stored on this website are not guaranteed to be secure. Input passwords and information at your own risk.</p>
            <p>Already have an account? <a href="login2.php">Login here</a>.</p>
        </form>
    </div>
    </div>
</body>
</html>
