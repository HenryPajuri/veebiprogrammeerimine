<?php
	//võtame vastu saadetud info
  	$photoId = $_REQUEST["photoid"];
	require("../../../Config_19.php");
    require("functions_user.php");
	$database = "if19_henry_pa_1";
	
	$conn = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	//küsime uue keskmise hinde
	$stmt=$conn->prepare("SELECT AVG(rating)FROM vpphotoratings WHERE photoid=?");
	$stmt->bind_param("i", $photoId);
	$stmt->bind_result($score);
	$stmt->execute();
	$stmt->fetch();
	$stmt->close();
	$conn->close();
	//ümardan keskmise hinde kaks kohta pärast koma ja tagastan
	echo round($score, 2);