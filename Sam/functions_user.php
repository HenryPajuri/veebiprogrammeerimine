<?php
  //käivitame sessiooni
  session_start();
  //var_dump($_SESSION);

  function signUp($name, $surname, $email, $gender, $birthDate, $password){
	  $notice = null;
	  $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	  $stmt = $conn->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES (?,?,?,?,?,?)");
	  echo $conn->error;
	  
	  //valmistame parooli salvestamiseks ette
      $options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
	  $pwdhash = password_hash($password,PASSWORD_BCRYPT, $options );
	  
	  $stmt->bind_param("sssiss", $name, $surname, $birthDate, $gender, $email, $pwdhash);
	  
	  if($stmt->execute()){
		  $notice = "Uue kasutaja salvestamine õnnestus!";
	  } else {
		  $notice = "Kasutaja salvestamisel tekkis tehniline viga: " .$stmt->error;
	  }
	  
	  $stmt->close();
	  $conn->close();
	  return $notice;
  }
  
    function signIn($email, $password){
	$notice = "";
	//echo "user:".$GLOBALS["serverHost"];
	//var_dump($GLOBALS);
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT password FROM vpusers WHERE email=?");
	echo $conn->error;
	$stmt->bind_param("s", $email);
	$stmt->bind_result($passwordFromDb);
	if($stmt->execute()){
		//kui päring õnnestus
	  if($stmt->fetch()){
		//kasutaja on olemas
		if(password_verify($password, $passwordFromDb)){
		  //kui salasõna klapib
		  $stmt->close();
		  $stmt = $conn->prepare("SELECT id, firstname, lastname FROM vpusers WHERE email=?");
		  echo $conn->error;
		  $stmt->bind_param("s", $email);
		  $stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb);
		  $stmt->execute();
		  $stmt->fetch();
		  $notice = "Sisse logis " .$firstnameFromDb ." " .$lastnameFromDb ."!";
		  //salvestame kasutaja nime sessioonimuutujatesse
		  $_SESSION["userID"] = $idFromDb;
		  $_SESSION["userFirstname"] = $firstnameFromDb;
		  $_SESSION["userLastname"] = $lastnameFromDb;
		  
		  //loeme kasutajaprofiili
		  $stmt->close();
		  $stmt = $conn->prepare("SELECT bgcolor, txtcolor FROM vpuserprofiles WHERE userid=?");
		  echo $conn->error;
		  $stmt->bind_param("i", $_SESSION["userID"]);
		  $stmt->bind_result($bgColorFromDb, $txtColorFromDb);
		  $stmt->execute();
		  if($stmt->fetch()){
			$_SESSION["bgColor"] = $bgColorFromDb;
	        $_SESSION["txtColor"] = $txtColorFromDb;
		  } else {
		    $_SESSION["bgColor"] = "#FFFFFF";
	        $_SESSION["txtColor"] = "#000000";
		  }
		  
		  $stmt->close();
	      $conn->close();
		  header("Location: home.php");
		  exit();
		  
		} else {
		  $notice = "Vale salasõna!";
		}
	  } else {
		$notice = "Sellist kasutajat (" .$email .") ei leitud!";  
	  }
	} else {
	  $notice = "Sisselogimisel tekkis tehniline viga!" .$stmt->error;
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
  }//sisselogimine lõppeb
  
  //kasutajaprofiili salvestamine
  function storeuserprofile($description, $bgColor, $txtColor){
	$notice = "";
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("SELECT id FROM vpuserprofiles WHERE userid=?");
	echo $conn->error;
	$stmt->bind_param("i", $_SESSION["userID"]);
	$stmt->bind_result($idFromDb);
	$stmt->execute();
	if($stmt->fetch()){
		//profiil juba olemas, uuendame
		$stmt->close();
		$stmt = $conn->prepare("UPDATE vpuserprofiles SET description = ?, bgcolor = ?, txtcolor = ? WHERE userid =?");
		echo $conn->error;
		$stmt->bind_param("sssi", $description, $bgColor, $txtColor, $_SESSION["userID"]);
		if($stmt->execute()){
			$notice = "Profiil edukalt uuendatud!";
			$_SESSION["bgColor"] = $bgColor;
	        $_SESSION["txtColor"] = $txtColor;
		} else {
		    $notice = "Profiili salvestamisel tekkis tõrge! " .$stmt->error;
		}
		//$notice = "Profiil olemas, ei salvestanud midagi!";
	} else {
		//profiili pole, salvestame
		$stmt->close();
		$stmt = $conn->prepare("INSERT INTO vpuserprofiles (userid, description, bgcolor, txtcolor) VALUES(?,?,?,?)");
		echo $conn->error;
		$stmt->bind_param("isss", $_SESSION["userID"], $description, $bgColor, $txtColor);
		if($stmt->execute()){
			$notice = "Profiil edukalt salvestatud!";
		} else {
			$notice = "Profiili salvestamisel tekkis tõrge! " .$stmt->error;
		}
	}
	$stmt->close();
	$conn->close();
	return $notice;
  }
  
  function showMyDesc(){
	$notice = null;
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT description FROM vpuserprofiles WHERE userid=?");
	echo $conn->error;
	$stmt->bind_param("i", $_SESSION["userID"]);
	$stmt->bind_result($descriptionFromDb);
	$stmt->execute();
    if($stmt->fetch()){
	  $notice = $descriptionFromDb;
	}
	$stmt->close();
	$conn->close();
	return $notice;
  }
  function oldPassCheck($oldpassWord){
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT password FROM vpusers WHERE id=?");
	echo $conn->error;
	$stmt->bind_param("i", $_SESSION["userID"]);
	$stmt->bind_result($oldpassWordFromDb);
	$stmt->execute();

	$teade = FALSE;
	if($stmt->execute()){
	
		if($stmt->fetch()){
	
			if(password_verify($oldpassWord, $oldpassWordFromDb)){
			
				$stmt->close();
				$teade = TRUE;	
		}
	}
}

	return $teade;
}

function updatePassword($newpassWord){

	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("UPDATE vpusers SET password=? WHERE id=?");
	
	$options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
	$newPwdHash = password_hash($newpassWord,PASSWORD_BCRYPT, $options );

	$stmt->bind_param("si", $newPwdHash , $_SESSION["userID"]);

	$stmt->execute();
	$stmt->close();
	$conn->close();

}

function readMyMovies(){
	$notice = null;
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	//$stmt = $conn->prepare("SELECT message, created FROM vpmsg3");
	$stmt = $conn->prepare("SELECT Film_ID, Pealkiri, Aasta, Kestus FROM FILM");
	echo $conn->error;
	$stmt->bind_result($filmIDFromDb, $pealkiriFromDb, $aastaFromDb, $kestusFromDb);
	$stmt->execute();
	while ($stmt->fetch()) {
		$notice .= "<p>" . $filmIDFromDb . ". " . $pealkiriFromDb ." (Valmimisaasta: ". $aastaFromDb .").</p>Kestus: ". $kestusFromDb ." minutit";
	}
	if (empty($notice)) {
		$notice = "<p>Otsitud filme ei leitud!</p> \n";
	}
	$stmt->close();
	$conn->close();
	return $notice;	
}
