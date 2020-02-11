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

  $toScript = "\t" .'<link rel="stylesheet" type="text/css" href="style/modal.css">'. "\n";
  $toScript .="\t" .'<script type="text/javascript" src="javascript/modal.js"defer></script>' . "\n";

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

  <div id="myModal" class="modal">
    <!--sulgemisnupp-->
    <span id="close" class="close">&times;</span>
    <!--pildikoht-->
    <img id="modalImg" class="modal-content" alt="pilt">
    <!--Pildi tekst-->
    <div id="caption" class = "caption"></div>

    <div id="rating" class="modalcaption">
      <label><input type="radio" id="rate1" name="rating" value="1">1</label>
      <label><input type="radio" id="rate2" name="rating" value="2">2</label>
      <label><input type="radio" id="rate3" name="rating" value="3">3</label>
      <label><input type="radio" id="rate4" name="rating" value="4">4</label>
      <label><input type="radio" id="rate5" name="rating" value="5">5</label>
      <input type="button" value="Salvesta hinnang" id="storeRating">
      <br>
	   	<span id="avgRating"></span>
    </div>
  </div>

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
  <div id="gallery">
  <?php
  echo $publicThumbsHTML;
  ?>
  </div>
  <hr>
</body>
</html>