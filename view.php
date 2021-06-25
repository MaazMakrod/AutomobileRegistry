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
<h1>Welcoming to the Automobile's Database</h1>

<p>
<?php
if (isset($_SESSION['success'])) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>
</p>

<?php
  $count = 1;
  require_once "pdo.php";

  echo('<table border="1" width = "100%">'."\n");
  $stmt = $pdo->query("SELECT autos_id, make, model, year, mileage FROM autos");
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    if($count === 1){
        echo('<tr><th width = "20%">Make</th><th width = "20%">Model</th><th width = "20%">Year</th><th width = "20%">Mileage</th><th width = "20%">Action</th></tr>');
    }

    $count++;

    echo "<tr><td>";
    echo(htmlentities($row['make']));
    echo("</td><td>");
    echo(htmlentities($row['model']));
    echo("</td><td>");
    echo(htmlentities($row['year']));
    echo("</td><td>");
    echo(htmlentities($row['mileage']));
    echo("</td><td>");
    echo('<a href="edit.php?user_id='.$row['autos_id'].'">Edit</a> / ');
    echo('<a href="delete.php?user_id='.$row['autos_id'].'">Delete</a>');
    echo("</td></tr>\n");
  }
  echo('</table>');

  if($count === 1){
      echo('<p>No Rows Found</p>');
  }
?>

<p><a href = "add.php">Add New Entry</a></p>
<p><a href = "logout.php">Logout</a></p>

</div>
</body>
