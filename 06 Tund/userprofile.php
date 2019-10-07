<?php
  require("../../../Config_19.php");
  require("functions_main.php");
  require("functions_user.php");
  $database = "f19_henry_pa_1";
  
  //kui pole sisseloginud
  if(!isset($_SESSION["userID"])){
	  //siis jõuga sisselogimise lehele
	  header("Location: page.php");
	  exit();
  }
  //väljalogimine
  if(isset($_GET["logout"])){
	  session_destroy();
	  header("Location: page.php");
	  exit();
  }
  
  $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
  
  require("Header.php");
?>


<body>
  <?php
    echo "<h1>" .$userName ." koolitöö leht</h1>";
  ?>
  <p>See leht on loodud koolis õppetöö raames
  ja ei sisalda tõsiseltvõetavat sisu!</p>
  <hr>
  <p><a href="?logout=1">Logi Välja!</a> <a href="userprofile.php">Kasutajaprofiil</a></p>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Minu kirjeldus</label><br>
	  <textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea>
	  <br>
	  <label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>"><br>
	  <label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $mytxtcolor; ?>"><br>
	  <input name="submitProfile" type="submit" value="Salvesta profiil">
	</form>
	<?php
	if(isset($_POST["submitUserData"])){
    if (isset($_POST["firstName"]) and !empty($_POST["firstName"])){
		$name = test_input($_POST["firstName"]);
	} else {
		
	}
    ?>
</body>
<head>
<style>
	body{background-color: #e8eaf9; 
	color: #000000} 
</style>
</head>
</html>








