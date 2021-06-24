<?php
//if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
  //  die('Name parameter missing');
//}

session_start();

if(!isset($_SESSION['who'])){
  die('Not logged in');
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
<h1>Tracking Autos for <?= $_SESSION['who']?></h1>

<p>
<?php
if (isset($_SESSION['success'])) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
?>
</p>

<ul>
<?php
if(isset($_SESSION['added'])){
  echo('<h2>Automobiles</h2>');

  $pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc', 'fred', 'zap');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $pdo->query("SELECT make, year, mileage FROM autos");

  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    echo "<li>" . htmlentities($row['year']) . " " . htmlentities($row['make']) . " / " . htmlentities($row['mileage']) . "</li>";
  }

}
?>
</ul>

<p>
<a href = "add.php">Add New</a> | <a href = "logout.php">Logout</a>
</p>

</div>
</body>
