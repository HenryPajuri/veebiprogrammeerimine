<?php
    function showFullDataByPerson(){
	  $personsInfoHTML = null;
	  $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	  $stmt = $conn->prepare("SELECT INIMESED.Naissoost_yliopilased, INIMESED.Meessoost_yliopilased, INIMESED.Meessoost_oppejoud, INIMESED.Naissoost_oppejoud FROM INIMESED");
	  echo $conn->error;
	  $stmt->bind_result($femalestudentFromDb, $malestudentFromDb, $femaleteacherFromDb, $maleteacherFromDb);
	  $stmt->execute();
	  while($stmt->fetch()){
         $personsInfoHTML .= "<br>Naissoost üliõpilasi on : " .$femalestudentFromDb;
         $personsInfoHTML .= "<br>Meesoost üliõpilasi on : " .$malestudentFromDb;
         $personsInfoHTML .= "<br>Naissoost õppejõude on : " .$femaleteacherFromDb;
         $personsInfoHTML .= "<br>Meessoost õppejõude on : " .$maleteacherFromDb;
	}
	  if($personsInfoHTML == null){
	     $personsInfoHTML = "<p>Andmebaasis pole ühtegi inimest!</p>";
	  } else {
            $personsInfoHTML = "<ul> \n" .$personsInfoHTML ."\n </ul> \n";
	  }
	  $stmt->close();
	  $conn->close();
	  return $personsInfoHTML;
  }

  function addPerson($femalestudent, $malestudent, $femaleteacher, $maleteacher){
    $notice = null;
    $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("INSERT INTO INIMESED (id, Naissoost_yliopilased, Meessoost_yliopilased, Meessoost_oppejoud, Naissoost_oppejoud) VALUES(?,?,?,?,?)");
    echo $conn->error;
    $stmt->bind_param("iiiii", $_SESSION["userID"], $femalestudent, $malestudent, $femaleteacher, $maleteacher);
    if($stmt->execute()){
       $notice = 1;
       $_SESSION["PersonAdded"] = $stmt->insert_id;
    } else {
        $notice = "Uute isikute lisamisel tekkis tehniline tõrge: " .$stmt->error;
      }
    
    $stmt->close();
    $conn->close();
    return $notice;
}
    function readAllPersonsForSelect(){
	  $personsHTML = null;
	  $maxPersonId = 0;
	  if(isset($_SESSION["PersonAdded"]) and !empty($_SESSION["PersonAdded"])){
		  $maxPersonId = $_SESSION["PersonAdded"];
	  }
	  $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	  $stmt = $conn->prepare("SELECT id, Naissoost_yliopilased, Meessoost_yliopilased, Meessoost_oppejoud, Naissoost_oppejoud FROM INIMESED ORDER BY id");
	  echo $conn->error;
	  $stmt->bind_result($idFromDb, $femalestudentFromDb, $malestudentFromDb, $femaleteacherFromDb, $maleteacherFromDb);
	  $stmt->execute();
	  while($stmt->fetch()){
	  	  $personsHTML .= '<option value="' .$idFromDb .'"';
		  if($idFromDb == $maxPersonId){
			  $personsHTML .= " selected";
		  }
		  $personsHTML .= ">" .$femalestudentFromDb . " " .$malestudentFromDb ." ".$femaleteacherFromDb ." ".$maleteacherFromDb ."</option> \n";
	  }
	  $stmt->close();
	  $conn->close();
	  return $personsHTML;
  }
  	function countPeople(){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT COUNT(Naissoost_yliopilased + Meessoost_yliopilased + Meessoost_oppejoud + Naissoost_oppejoud) FROM INIMESED");
		echo $conn->error;
		$stmt->bind_result($peopleCountFromDb);
		$stmt->execute();
		if($stmt->fetch()){
			$notice = $peopleCountFromDb;
		} else {
			$notice = 0;
		}
		
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
    function DeletePerson($femalestudent, $malestudent, $femaleteacher, $maleteacher){
        $notice = null;
        $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
        $stmt = $conn->prepare("DELETE FROM INIMESED (id, Naissoost_yliopilased, Meessoost_yliopilased, Meessoost_oppejoud, Naissoost_oppejoud) VALUES(?,?,?,?,?)");
        echo $conn->error;
        $stmt->bind_param("iiiii", $_SESSION["userID"], $femalestudent, $malestudent, $femaleteacher, $maleteacher);
        if($stmt->execute()){
           $notice = 1;
           $_SESSION["PersonDeleted"] = $stmt->insert_id;
        } else {
            $notice = "Väljuvate isikute lisamisel tekkis tehniline tõrge: " .$stmt->error;
          }
        
        $stmt->close();
        $conn->close();
        return $notice;
    }