<!DOCTYPE html>
<html>
<head>
<title>Siin saab väljuvaid inimesi lisada</title>
<li><a href="people.php">Tagasi avalehele</a></li>
</head>

<body>
<h1>Väljuvad inimesed:</h1>
  <form method="delete" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" style="display:inline;">
	  <label>Lisa väljuvaid naissoost üliõpilasi:</label>
      <input name="femalestudents" type="number" value="<?php echo $femalestudent; ?>">
      <label>Lisa väljuvaid meessoost üliõpilasi:</label>
      <input name="malestudents" type="number" value="<?php echo $malestudent; ?>">
      <label>Lisa väljuvaid naissoost õppejõude:</label>
      <input name="femaleteachers" type="number" value="<?php echo $femaleteacher; ?>">
      <label>Lisa väljuvaid meesoost õppejõude:</label>
      <input name="maleteachers" type="number" value="<?php echo $maleteacher; ?>">
      <input name="submitPerson" type="submit" value="Salvesta muutus"><span><?php echo $personNotice; ?></span>
  </form>
  <hr>
</body>

</html>

<?php
if(isset($_POST['delete'])) {
$servername = "localhost";
$username = "if19";
$password = "ifikas2019";
$dbname = "if19_henry_pa_1";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// sql to delete a record
$sql = "DELETE FROM INIMESED WHERE id=3";

if (mysqli_query($conn, $sql)) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
}

mysqli_close($conn);
?>