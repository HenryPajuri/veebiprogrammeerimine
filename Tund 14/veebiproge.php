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
    