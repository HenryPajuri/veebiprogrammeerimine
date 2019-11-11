<?php
  require("../../../Config_19.php");
  require("functions_main.php");
  require("functions_user.php");
  require("functions_pic.php");
  require("classes/PicUpload.class.php");
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

  //piirid galerii lehel näidatava piltide arvu jaoks
  $page = 1;
  $limit = 5;
  $totalPics = countPublicImages(2);
  if(!isset($_GET["page"]) or $_GET["page"] < 1){
      $page = 1;
  } elseif (round($_GET["page"] - 1) * $limit > $totalPics){
      $page = round($totalPics / $limit) - 1;
  } else {
    $page = $_GET["page"];
  }
  $publicThumbsHTML = readAllPublicPicsPage(2, $page, $limit);


  //$publicThumbsHTML = readAllPublicPics(2);

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
  <h2>Avalike piltide galerii</h2>
  <p>
  
  <?php
	if($page > 1){
		echo '<a href="?page=' .($page - 1) .'">Eelmine leht</a> | ' ."\n";
	} else {
		echo "<span>Eelmine leht</span> | \n";
	}
	if($page * $limit < $totalPics){
		echo '<a href="?page=' .($page + 1) .'">Järgmine leht</a>' ."\n";
	} else {
		echo "<span>Järgmine leht</span> | \n";
	}
  ?>
  
  </p>
  <?php
  echo $publicThumbsHTML;
  ?>
  <hr>
</body>
</html>