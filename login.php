<?php

if ( isset($_POST['cancel'] ) ) {
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123
$check = '';

session_start();

if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION["failure"] = "Email and password are required";
    } elseif(strrpos($_POST['email'], '@') == FALSE){
      $_SESSION["failure"] = "Email must include at-sign (@)";
    } else {
        $check = hash('md5', $salt.$_POST['pass']);
        if ( $check == $stored_hash ) {
            $_SESSION['who'] = $_POST['email'];
            error_log("Login success ".$_SESSION['who']);
            header("Location: view.php");
            return;
        } else {
            $_SESSION["failure"] = "Incorrect password";
        }
    }
    error_log("Login fail ".$_SESSION['who']." $check");
    header("Location: login.php");
    return;
}

?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Maaz Makrod's Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php

if (isset($_SESSION["failure"])) {
    echo('<p style="color: red;">'.htmlentities($_SESSION["failure"])."</p>\n");
    unset($_SESSION["failure"]);
}
?>
<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="email" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the four character sound a cat
makes (all lower case) followed by 123. -->
</p>
</div>
</body>
