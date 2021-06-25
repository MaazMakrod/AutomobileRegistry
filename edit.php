<?php
require_once "pdo.php";
require_once "bootstrap.php";
session_start();

if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['autos_id']) ) {

    // Data validation
    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1) {
        $_SESSION['error'] = 'Missing data';
        header("Location: edit.php?user_id=".$_POST['autos_id']);
        return;
    }

    if(!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])){
      $_SESSION['error'] = 'Mileage and year must be numeric';
      header("Location: edit.php?user_id=".$_POST['autos_id']);
      return;
    }

    $sql = "UPDATE autos SET make = :make, model = :model, year = :year, mileage = :mileage WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage'],
        ':autos_id' => $_POST['autos_id']));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: view.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['user_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: view.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['user_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: view.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
?>

<h1>Edit Automobile</h1>
<form method="post">
<p>Make:
<input type="text" name="make" value="<?= htmlentities($row['make']) ?>"></p>
<p>Model:
<input type="text" name="model" value="<?= htmlentities($row['model']) ?>"></p>
<p>Year:
<input type="text" name="year" value="<?= htmlentities($row['year']) ?>"></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= htmlentities($row['mileage']) ?>"></p>
<input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
<p><input type="submit" value="Update"/>
<a href="view.php">Cancel</a></p>
</form>
