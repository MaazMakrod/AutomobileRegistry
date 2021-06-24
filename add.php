<?php
if(isset($_POST['canc'])){
  header("Location: view.php");
  return;
}

session_start();

if(!isset($_SESSION['who'])){
  die('Not logged in');
}

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc', 'fred', 'zap');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])){
  if(!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])){
    $_SESSION['failure'] = 'Mileage and year must be numeric';
    header("Location: add.php");
    return;
  }
  elseif(strlen($_POST['make']) < 1){
    $_SESSION['failure'] = 'Make is required';
    header("Location: add.php");
    return;
  }
  else{
    $sql = "INSERT INTO autos (make, year, mileage) VALUES (:make, :year, :mileage)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':make' => $_POST['make'], ':year' => $_POST['year'], ':mileage' => $_POST['mileage']));
    $_SESSION['success'] = 'Record Inserted';
    $_SESSION['added'] = true;
    header("Location: view.php");
    return;
  }
}
else if(isset($_POST['add'])){
  $_SESSION['failure'] = 'Must Fill In all Fields';
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
if (isset($_SESSION['failure'])) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['failure'])."</p>\n");
    unset($_SESSION['failure']);
}
?>
</p>

<form method="POST">
  <label for="make">Make: </label>
  <input type="text" name="make" id="make"><br/>
  <label for="yr">Year: </label>
  <input type="text" name="year" id="yr"><br/>
  <label for="mile">Mileage: </label>
  <input type="text" name="mileage" id="mile"><br/>
  <input type="submit" name="add" value="Add">
  <input type="submit" name="canc" value="Cancel">
</form>

</div>
</body>
