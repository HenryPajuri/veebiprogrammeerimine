<?php
  $username = "Henry Pajuri";
  $photoDir = "../photos/";
  $photoTypesAllowed = ["image/jpeg", "image/png"];
  $fulltimenow = date("d.m.Y H:i:s");
  $hournow = date("H");
  $partofday = "hägune aeg";
  if($hournow < 8){
    $partofday = "hommik";
  }
  if($hournow >= 9){
	$partofday = "Aeg tööd teha";
  }
   if($hournow >= 22){
	$partofday = "Uneaeg";
  }
  
  //info semestri kulgemise kohta
  $semesterStart = new DateTime("2019-9-2");
  $semesterEnd = new DateTime("2019-12-13");
  $semesterDuration = $semesterStart -> diff($semesterEnd);
  //echo $semesterStart; /objekti nii näidata ei saaa!!!
  //var_dump ($semesterStart);
  //echo $semesterStart -> timezone;
  $today = new DateTime("now");
  $fromsemesterStart = $semesterStart -> diff($today);
  //var_dump ($fromsemesterStart);
  //echo $fromsemesterStart -> days;
  //echo $fromsemesterStart -> format ("%r%a");
  //<p>Semester on täies hoos: <meter min="0" max="110" value="15" >17%</meter></p>
  $semesterInfoHTML = "<p>Info semestri kohta pole kättesadav.</p>";
  if ($fromsemesterStart -> format ("%r%a") > 0 and $fromsemesterStart -> format ("%r%a") <=$semesterDuration -> format ("%r%a")){
	  $semesterInfoHTML = "<p>Semester on täies hoos: ";
	  $semesterInfoHTML .= '<meter min="0" ';
	  $semesterInfoHTML .= 'max="' .$semesterDuration -> format ("%r%a") .'" ';
	  $semesterInfoHTML .= 'value="' .$fromsemesterStart -> format ("%r%a") .'">';
	  $semesterInfoHTML .= round($fromsemesterStart -> format ("%r%a") / $semesterDuration -> format ("%r%a") * 100, 1) ."%";
	  $semesterInfoHTML .= "</meter></p>";
  }
  //juhusliku foto kasutamine
  $photoList = []; //array ehk massiiv
  
  $allFiles = array_slice(scandir($photoDir), 2);
  //var_dump($allFiles);
  //kontrollin kas on pildid
  foreach ($allFiles as $file){
	  $fileInfo = getimagesize($photoDir .$file);
	  var_dump ($fileInfo);
	  if(in_array($fileInfo["mime"], $photoTypesAllowed) == true){
		  array_push($photoList, $file);
	  }
  }
  
  //"tlu_terra_600x400_1.jpg", "tlu_terra_600x400_2.jpg", "tlu_terra_600x400_3.jpg"
  //var_dump($photoList);
  //echo $photoList[2];
  $photoCount = count($photoList);
  $randomImgHTML = "";
  if ($photoCount > 0){
	$photoNum = mt_rand(0, $photoCount - 1);
	//echo $photoNum;
	//<img src="../photos/tlu_astra_600x400_1.jpg" alt="Pildil on Tallinna Ülikooli hoone."
	$randomImgHTML = '<img src="' .$photoDir .$photoList[$photoNum] .'" alt="Pildil on Tallinna Ülikooli hoone.">';
  } else {
	  $randomImgHTML = "<p>Pilte pole</p>";
  }
  require ("Header.php");
  echo $randomImgHTML;
  echo "<h1>" .$username . "Veeb 2019</h1>";
  ?>
   <p>See veebileht on valminud õppetöö käigus ning ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
  <img src="http://www.youandthemat.com/wp-content/uploads/nature-2-26-17.jpg" width ="860" Height = "600">
  <a href="http://greeny.cs.tlu.ee/~henrypaj/">
<?php
  echo $semesterInfoHTML;
  echo "See on parim PHP!</p>";
  echo "<p>Lehe avamise hetkel oli aeg: " .$fulltimenow .", " .$partofday . " .</p>";
?>
	
<ul>
<li>Git push</li>
<li>Git config</li>
<li>-ls</li>
<li>WinSCP</li>
<li>Lin2.Tlu.ee</li>
<li>pwd</li>
<li>cd</li>
<li>ls -la</li>
</body>
</html>