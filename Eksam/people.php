<?php
  require("../../../Config_19.php");
  require("functions_main.php");
  require("functions_user.php");
  require("functions_people.php");
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
  $femalestudent = null;
  $malestudent = null;
  $femaleteacher = null;
  $maleteacher = null;
  $personNotice = null;
  

 if(isset($_POST["submitPerson"])){
	  if(isset($_POST["femalestudents"]) and !empty(test_input($_POST["femalestudents"]))){
        $femalestudent = test_input($_POST["femalestudents"]);
      }
      if(isset($_POST["malestudents"]) and !empty(test_input($_POST["malestudents"]))){
        $malestudent = test_input($_POST["malestudents"]);
      }
      if(isset($_POST["femaleteachers"]) and !empty(test_input($_POST["femaleteachers"]))){
        $femaleteacher = test_input($_POST["femaleteachers"]);
      }
      if(isset($_POST["maleteachers"]) and !empty(test_input($_POST["maleteachers"]))){
        $maleteacher = test_input($_POST["maleteachers"]);
      }
 
      $personNotice = addPerson($femalestudent, $malestudent, $femaleteacher, $maleteacher);
      if($personNotice == 1){
         $femalestudent = null;
         $malestudent = null;
         $femaleteacher = null;
         $maleteacher = null;
         $personNotice = "Uute isikute lisamine õnnestus!";
        }
    }

  
  $result = showFullDataByPerson();

    
  require("Header.php");

  ?>
   <?php
    echo "<h1>" .$userName ." Eksami ülesanne</h1>";
    
    
  ?>
  <p>See leht on loodud koolis õppetöö raames
  ja ei sisalda tõsiseltvõetavat sisu!</p>
  <hr>
  <p><a href="?logout=1">Logi välja!</a> | Tagasi <a href="home.php">avalehele</a></p>
  <h2>Hoones viibivad inimesed: <?php echo $result ?> </h2>
  <hr>
  <h3>Saabuvate inimeste lisamine:</h3>
  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" style="display:inline;">
	  <label>Lisa naissoost üliõpilasi:</label>
      <input name="femalestudents" type="number" value="<?php echo $femalestudent; ?>">
      <label>Lisa meessoost üliõpilasi:</label>
      <input name="malestudents" type="number" value="<?php echo $malestudent; ?>">
      <label>Lisa naissoost õppejõude:</label>
      <input name="femaleteachers" type="number" value="<?php echo $femaleteacher; ?>">
      <label>Lisa meesoost õppejõude:</label>
      <input name="maleteachers" type="number" value="<?php echo $maleteacher; ?>">
      <input name="submitPerson" type="submit" value="Lisa"><span><?php echo $personNotice; ?></span>
  </form>
  <hr>
  <h3>Väljuvad inimesed:</h3>
  <li><a href="update_people.php">Lisa väljuvaid inimesi</a></li>
  