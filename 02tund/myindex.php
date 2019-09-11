<?php
  $username = "Henryyyyy Pajuri";
  $fulltimenow = date("d.m.Y H:i:s");
?>
<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>
  <?php
  echo $username;
  ?>
  Henry Pajuri progeb</title>
</head>
<body>
  <?php
  echo "<h1>" .$username . "Veeb 2019</h1>";
  ?>
   <p>See veebileht on valminud õppetöö käigus ning ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
  <img src="http://www.youandthemat.com/wp-content/uploads/nature-2-26-17.jpg" width ="860" Height = "600">
  <a href="http://greeny.cs.tlu.ee/~henrypaj/">
<?php
  echo "See on minu esimene PHP!</p>";
  echo "<p>Lehe avamise hetkel oli " .$fulltimenow .".</p>";
?>


</body>
</html>