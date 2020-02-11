<?php
	function addPicData($fileName, $altText, $privacy){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO vpphotos (userid, filename, alttext, privacy) VALUES (?, ?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("issi", $_SESSION["userID"], $fileName, $altText, $privacy);
		if($stmt->execute()){
			$notice = " Pildi andmed salvestati andmebaasi!";
		} else {
			$notice = " Pildi andmete salvestamine ebaõnnestus tehnilistel põhjustel! " .$stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function readuserPic($photoid){
		$picHTML = "<p>Korras!</p>";
		return $picHTML;
	}
	
	function readAllPublicPics($privacy){
		$picHTML = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy<=? AND deleted IS NULL");
		echo $conn->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($fileNameFromDb, $altTextFromDb);
		$stmt->execute();
		while($stmt->fetch()){
			//<img src="thumbs_kataloog/pilt" alt=""> \n
			$picHTML .= '<img src="' .$GLOBALS["pic_upload_dir_thumb"] .$fileNameFromDb .'" alt="' .$altTextFromDb .'">' ."\n";
		}
		if($picHTML == null){
			$picHTML = "<p>Kahjuks avalikke pilte pole!</p>";
		}
		$stmt->close();
		$conn->close();
		return $picHTML;
	}
	
	function readAllPublicPicsPage($privacy, $page, $limit){
		$picHTML = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//$stmt = $conn->prepare("SELECT id, filename, alttext FROM vpphotos WHERE privacy<=? AND deleted IS NULL ORDER BY id DESC LIMIT ?,?");
		$stmt = $conn->prepare("SELECT vpphotos.id, vpusers.firstname, vpusers.lastname, vpphotos.filename, vpphotos.alttext, AVG(vpphotoratings.rating) as AvgValue FROM vpphotos JOIN vpusers ON vpphotos.userid = vpusers.id LEFT JOIN vpphotoratings ON vpphotoratings.photoid = vpphotos.id WHERE vpphotos.privacy <= ? AND deleted IS NULL GROUP BY vpphotos.id DESC LIMIT ?, ?");
		echo $conn->error;
		$skip = ($page - 1) * $limit;
		$stmt->bind_param("iii", $privacy, $skip, $limit);
		$stmt->bind_result($idFromDb, $firstNameFromDb, $lastNameFromDb, $fileNameFromDb, $altTextFromDb, $avgFromDb);
		$stmt->execute();
		while($stmt->fetch()){
			//<img src="thumbs_kataloog/pilt" alt=""> \n
			//<img src="thumbs_kataloog/pilt" alt="" data-fn="failinimi"> \n
			$picHTML .= '<div class="thumbGallery">' ."\n";
			$picHTML .= '<img class="thumbs" src="' .$GLOBALS["pic_upload_dir_thumb"] .$fileNameFromDb .'" alt="';
			if(empty($altTextFromDb)){
				$picHTML .= "Illustreeriv foto";
			} else {
				$picHTML .= $altTextFromDb;
			}
			$picHTML .= '" data-fn="' .$fileNameFromDb .'"';
			$picHTML .= ' data-id="' .$idFromDb .'"';
			$picHTML .= '>' ."\n";
			$picHTML .= "<p>" .$firstNameFromDb ." " .$lastNameFromDb ."</p> \n";
			$picHTML .= '<p id="score' .$idFromDb .'">';
			if($avgFromDb == 0){
				$picHTML .="Pole hinnatud";
			} else {
				$picHTML .= "Hinne: " .round($avgFromDb, 2);
			}
			$picHTML .= "</p> \n";
			$picHTML .= "</div>";
		}
		if($picHTML == null){
			$picHTML = "<p>Kahjuks avalikke pilte pole!</p>";
		}
		$stmt->close();
		$conn->close();
		return $picHTML;
	}
	
	function readuserPicsPage($page, $limit){
		$picHTML = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT id, filename, alttext FROM vpphotos WHERE userid=? AND deleted IS NULL ORDER BY id DESC LIMIT ?,?");
		echo $conn->error;
		$skip = ($page - 1) * $limit;
		$stmt->bind_param("iii", $_SESSION["userID"], $skip, $limit);
		$stmt->bind_result($idFromDb, $fileNameFromDb, $altTextFromDb);
		$stmt->execute();
		while($stmt->fetch()){
			//<img src="thumbs_kataloog/pilt" alt=""> \n
			//<img src="thumbs_kataloog/pilt" alt="" data-fn="failinimi"> \n
			$picHTML .= '<div class="thumbGallery">' ."\n";
			$picHTML .= '<img class="thumbs" src="' .$GLOBALS["pic_upload_dir_thumb"] .$fileNameFromDb .'" alt="';
			if(empty($altTextFromDb)){
				$picHTML .= "Illustreeriv foto";
			} else {
				$picHTML .= $altTextFromDb;
			}
			$picHTML .= '" data-fn="' .$fileNameFromDb .'"';
			$picHTML .= ' data-id="' .$idFromDb .'"';
			$picHTML .= '>' ."\n";
			$picHTML .= '<a href="edituserpic.php?photoid=' .$idFromDb .'">Muuda/Kustuta</a>' ."\n";
			$picHTML .= "</div>";
		}
		if($picHTML == null){
			$picHTML = "<p>Kahjuks Sinu üleslaetud pilte ei leitud!</p>";
		}
		
		$stmt->close();
		$conn->close();
		return $picHTML;
	}
	
	function countPublicImages($privacy){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT COUNT(id) FROM vpphotos WHERE privacy <= ? AND deleted IS NULL");
		echo $conn->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($imageCountFromDb);
		$stmt->execute();
		if($stmt->fetch()){
			$notice = $imageCountFromDb;
		} else {
			$notice = 0;
		}
		
		$stmt->close();
		$conn->close();
		return $notice;
	}
	