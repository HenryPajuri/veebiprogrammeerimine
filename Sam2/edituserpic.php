<?php
   require("../../../Config_19.php");
   require("functions_main.php");
   require("functions_user.php");
   require("functions_pic.php");
   $database = "if19_henry_pa_1";
    
  //kui pole sisseloginud
  if(!isset($_SESSION["userID"])){
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
  
  $notice = null;
  
  if(isset($_GET["photoid"])){
	  echo $_GET["photoid"];
	  $userPicHTML = readuserPic($_GET["photoid"]);
  } else {
	  $userPicThumbsHTML = "<p>Pildi lugemisel tekkis viga!</p> \n";
  }
  
  //$publicThumbsHTML = readAllPublicPics(2);
  //<link rel="stylesheet" type="text/css" href="style/modal.css">
  
  require("Header.php");
?>


<body>
  <?php
    echo "<h1>" .$userName ." koolitöö leht</h1>";
  ?>
  <p>See leht on loodud koolis õppetöö raames
  ja ei sisalda tõsiseltvõetavat sisu!</p>
  <hr>
  <p><a href="?logout=1">Logi välja!</a> | Tagasi <a href="home.php">avalehele</a></p>
  <hr>
  <h2>Minu pildi pildi info muutmine või pildi kustutamine</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	
	<input name="changeUserPicInfo" type="submit" value="Salvesta muutus!"><span><?php echo $notice; ?></span>
  </form>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	
	<input name="deleteUserPic" type="submit" value="Kustuta pilt!"><span><?php echo $notice; ?></span>
  </form>
  	  <?php
		echo $userPicHTML;
	  ?>
  
  <hr>
</body>
</html>




