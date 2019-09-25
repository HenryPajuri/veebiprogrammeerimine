<?php
function readAllFilms (){
    //var_dump($GLOBALS);
  
  //loome andmebaasi ühenduse
    $conn =new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    //valmistame ette SQl päringu näiteks muutjua nimega $query.. või
    $stmt = $conn->prepare("SELECT pealkiri, aasta FROM film");
    echo $conn->error;
  //seome saadava tulemuse muutujaga
    $stmt->bind_result($filmTitle, $filmYear);
  //täidame käsu, ehk sooritame päringu
    $stmt->execute();
    echo $stmt->error;
    $filmInfoHTML = null;
  //võtan tulemuse (pinu ehk stack)
    while ($stmt->fetch()){
  //echo $filmTitle;
    $filmInfoHTML .= "<h3>" .$filmTitle ."</h3>";
    $filmInfoHTML .= "<p>" .$filmYear ."</p>";
    }
  //sulgeme ühendused
    $stmt->close();
    $conn->close();
    return $filmInfoHTML;
}

function storeFilmInfo($filmTitle, $filmYear, $filmDuration, $filmGenre, $filmDirector, $filmStudio){

  $conn =new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
  $stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES(?,?,?,?,?,?)");
  echo $conn->error;
  //seon saadetava info muutujatega
  //andmetüübid: s - string, i - integer, d - decimal
  $stmt->bind_param("siisss", $filmTitle, $filmYear, $filmDuration, $filmGenre, $filmDirector, $filmStudio);
  $stmt->execute();

  $stmt->close();
  $conn->close();
}
?>