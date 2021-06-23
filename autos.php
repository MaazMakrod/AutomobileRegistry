<?php
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}

if ( isset($_POST['logout'] ) ) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc', 'fred', 'zap');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$failure = false;
$success = false;

if(isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])){
  if(!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])){
    $failure = 'Mileage and year must be numeric';
  }
  elseif(strlen($_POST['make']) < 1){
    $failure = 'Make is required';
  }
  else{
    $sql = "INSERT INTO autos (make, year, mileage) VALUES (:make, :year, :mileage)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':make' => $_POST['make'], ':year' => $_POST['year'], ':mileage' => $_POST['mileage']));
    $success = 'Record Inserted';
  }
}
else if(isset($_POST['add'])){
  $failure = 'Must Fill In all Fields';
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
<h1>Tracking Autos for <?= $_GET['name']?></h1>

<p>
<?php
if ( $failure !== false ) {
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}
if ( $success !== false ) {
    echo('<p style="color: green;">'.htmlentities($success)."</p>\n");
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
  <input type="submit" name="logout" value="Log Out">
</form>

<h2>Automobiles</h2>

<ul>
<?php
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  echo "<li>" . htmlentities($row['year']) . " " . htmlentities($row['make']) . " / " . htmlentities($row['mileage']) . "</li>";
}
?>
</ul>
</div>
</body>
