<?php
  require("../../../Config_19.php");
  require("functions_main.php");
  require("functions_user.php");
  require("function_film.php");
  //echo $serverHost;
  $username = "Henry Pajuri";
  $database = "if19_henry_pa_1";

  

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
  $truckWeightComing = null;
  $truckWeightLeaving = null;
  $truckNumber = null;
  ?>
  <label>Siseneva auto number:</label>
	  <input name="truckNumber" type="text" value="<?php echo $truckNumber; ?>"><span><?php echo $truckNumberError; ?></span><br>
  <label>Auto kaal sisenemisel:</label>
	  <input name="truckWeightComing" type="text" value="<?php echo $truckWeightComing; ?>"><span><?php echo $truckWeightComingError; ?></span><br>
  <label>Auto kaal lahkumisel:</label>
	  <input name="truckWeightLeaving" type="text" value="<?php echo $truckWeightLeaving; ?>"><span><?php echo $truckWeightLeavingError; ?></span><br>
    <?php

      function addTruckInfo($truckNumber, $truckWeightComing, $truckWeightLeaving){
	  $notice = null;
	  $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	  $stmt = $conn->prepare("SELECT truckid FROM truckweight WHERE Trucknumber=? and TruckWeightComing=? and TruckWeightLeaving=?");
	  echo $conn->error;
	  $stmt->bind_param("sdd", $truckNumber, $truckWeightComing, $truckWeightLeaving);
	  $stmt->bind_result($idFromDb);
      $stmt->execute();
      }
    ?>