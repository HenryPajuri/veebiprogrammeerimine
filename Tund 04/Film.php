<?php
  require("../../../Config_19.php");
  require("function_film.php");
  //echo $serverHost;
  $username = "Henry Pajuri";
  $database = "if19_henry_pa_1";
  
  $filmInfoHTML = readAllFilms();

  require("Header.php");
  echo "<h1>" .$username . "Veeb 2019</h1>";
  ?>
  
  <hr>
  <h2>Eesti Filmid</h2>
  <p>Meie andmebaasis leiduvad järgmised filmid:</p>
  <hr>
  <?php
  echo $filmInfoHTML
  ?>
  
<body>
<html>
  