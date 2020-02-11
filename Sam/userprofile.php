<?php
  require("../../../Config_19.php");
  require("functions_main.php");
  require("functions_user.php");
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
  
  $notice = null;
  $myDescription = null;
  
  if(isset($_POST["submitProfile"])){
	$notice = storeUserProfile($_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"]);
	if(!empty($_POST["description"])){
	  $myDescription = $_POST["description"];
	}
	$_SESSION["bgColor"] = $_POST["bgcolor"];
	$_SESSION["txtColor"] = $_POST["txtcolor"];
  } else {
	$myProfileDesc = showMyDesc();
	if(!empty($myProfileDesc)){
	  $myDescription = $myProfileDesc;
    }
  }


  if(isset($_POST["submitPic"]) and !empty($_FILES["fileToUpload"]["name"])) {
    $fileToUpload = $_FILES['fileToUpload'];
    $fileName = $_FILES['fileToUpload']['name'];
    $fileTmpName = $_FILES['fileToUpload']['tmp_name'];
    $fileSize = $_FILES['fileToUpload']['size'];
    $fileError = $_FILES['fileToUpload']['error'];
    $fileType = $_FILES['fileToUpload']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileDestination = "../images/".basename($fileName);
                move_uploaded_file($fileTmpName, $fileDestination);
                header("Location: userprofile.php?uploadsucess");
            } else {
                echo "Liiga suur fail!";
            } 
        } else {
            echo "Üleslaadimisel tekkis viga!";
        }
    } else {
        echo "Sellist tüüpi faile ei ole võimalik üles laadida!";
    }
    
	  $notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO profileimg (userid, filename, created, status) VALUES (?, ?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("isdi", $_SESSION["userID"], $filename, $created, $status);
		if($stmt->execute()){
			$notice = " Pildi andmed salvestati andmebaasi!";
		} else {
			$notice = " Pildi andmete salvestamine ebaõnnestus tehnilistel põhjustel! " .$stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
  }
  
  require("Header.php");
?>


<body>
   <?php
    echo "<h1>" .$userName ." koolitöö leht</h1>";
  ?>
  <p>See leht on loodud koolis õppetöö raames
  ja ei sisalda tõsiseltvõetavat sisu!</p>
  <hr>
  <p><a href="?logout=1">Logi välja!</a> | Tagasi <a href="home.php">avalehele </a></p>
  
  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Minu kirjeldus</label><br>
	  <textarea rows="10" cols="80" name="description" placeholder="Lisa siia oma tutvustus ..."><?php echo $myDescription; ?></textarea>
	  <br>
	  <label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $_SESSION["bgColor"]; ?>"><br>
	  <label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $_SESSION["txtColor"]; ?>"><br>
	  <input name="submitProfile" type="submit" value="Salvesta profiil"><span><?php echo $notice; ?></span>
	</form>

    <hr>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label>Sisesta vana parool:</label><br>
    <input name="oldPassword" type="text" value="<?php echo $oldPassword; ?>"><br>
    
    <label>Uus salasõna:</label><br>
    <input name="newPassWord" type="text"><br>

    <label>Uus salasõna uuesti:</label><br>
    <input name="confirmPassword" type="text"><br>
    
    <input name="updatePassFrom" type="submit" value="Uuenda parool">
  </form>
  <hr>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
	  <label>Lisa endale profiili pilt:</label>
	  <input type="file" name="fileToUpload" id="fileToUpload">
	  <br>
    <input name="submitPic" id="submitPic" type="submit" value="Lae pilt üles"><span id="notice"><?php echo $notice; ?></span>
  </form>
<hr>
  
</body>
</html>







