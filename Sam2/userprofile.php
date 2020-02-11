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


  

  // Initialize message variable
  $msg = "";

  // If upload button is clicked ...
  if (isset($_POST['upload'])) {
  	// Get image name
  	$image = $_FILES['image']['name'];
  
  	// image file directory
  	$target = "uploads/".basename($image);

  	$sql = "INSERT INTO images (image, image_text) VALUES ('$image', '$image_text')";
  	// execute query
  	mysqli_query($database, $sql);

  	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}
  }
  $result = mysqli_query($database, "SELECT * FROM profileimg");

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
  <form method="POST" action="userprofile.php" enctype="multipart/form-data">
  	<input type="hidden" name="size" value="1000000">
  	<div>
  	  <input type="file" name="image">
   		<button type="submit" name="upload">POST</button>
  	</div>
  </form>
</div>
  
</body>
</html>







