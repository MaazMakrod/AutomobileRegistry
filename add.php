<?php
if(isset($_POST['canc'])){
  header("Location: view.php");
  return;
}

session_start();

if(!isset($_SESSION['who'])){
  die('Access Denied');
}

require_once "pdo.php";

if(isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['model'])){
  if(strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1){
    $_SESSION['failure'] = 'All fields are required';
    header("Location: add.php");
    return;
  }
  elseif(!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])){
    $_SESSION['failure'] = 'Mileage and year must be numeric';
    header("Location: add.php");
    return;
  }
  else{
    $sql = "INSERT INTO autos (make, model, year, mileage) VALUES (:make, :model, :year, :mileage)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':make' => $_POST['make'], ':model' => $_POST['model'], ':year' => $_POST['year'], ':mileage' => $_POST['mileage']));
    $_SESSION['success'] = 'Record Inserted';//change to record Inserted
    header("Location: view.php");
    return;
  }
}
else if(isset($_POST['add'])){
  $_SESSION['failure'] = 'All fields are required';
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
<h1>Tracking Automobiles for <?= $_SESSION['who']?></h1>

<p>
<?php
if (isset($_SESSION['failure'])) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['failure'])."</p>\n");
    unset($_SESSION['failure']);
}
?>
</p>

<form method="POST">
  <label for="make">Make: </label>
  <input type="text" name="make" id="make"><br/>
  <label for="model">Model: </label>
  <input type="text" name="model" id="model"><br/>
  <label for="yr">Year: </label>
  <input type="text" name="year" id="yr"><br/>
  <label for="mile">Mileage: </label>
  <input type="text" name="mileage" id="mile"><br/>
  <input type="submit" name="add" value="Add">
  <input type="submit" name="canc" value="Cancel">
</form>

</div>
</body>
