<?php
  require("../../../Config_19.php");
  require("functions_main.php");
  require("functions_user.php");
  require("functions_news.php");
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


  $sql = "SELECT * FROM vpusers";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $id = $row['id'];
      $sqlImg = "SELECT * FROM profileimg WHERE userid='$id'";
      $resultImg = mysqli_query($conn, $sqlImg);
      while ($rowImg = mysqli_fetch_assoc($resultImg)) {
        echo "<div>";
          if ($rowImg['status'] == 0) {
              echo"<img src='uploads/profile".$id.".jpg'>";
          } else {
              echo"<img src='uploads/profiledefault.jpg'>";
          }
          echo $row['username'];
        echo "</div>";
      }
  } 
}
?>


<body>
  <?php
    echo "<h1>" .$userName ." koolitöö leht</h1>";
  ?>
  <p>See leht on loodud koolis õppetöö raames
  ja ei sisalda tõsiseltvõetavat sisu!</p>
  <hr>
  <p><a href="?logout=1">Logi välja!</a> | <a href="userprofile.php">Kasutajaprofiil</a></p>
  <ul>
    <li><a href="userprofile.php">Kasutajaprofiil</a></li>
	  <li><a href="messages.php">Sõnumid</a></li>
    <li><a href="photoupload.php">Piltide üleslaadimine</a></li>
    <li><a href="Add_Film.php">Lisa film</a></li>
    <li><a href="publicgallery.php">Avalike piltide galerii</a></li>
    <li><a href="userpics.php">Muuda enda pilte</a></li>
    <li><a href="addnews.php">Uudise lisamine</a></li>
    <li><a href="viljavedu.php">Viljavedu</a></li>

  </ul>
  
</body>
</html>






