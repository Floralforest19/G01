<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" type="text/css" href="../styles/style.css" />
  <link
      href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap"
      rel="stylesheet"
  />
  <title>Webbshop - Skapa kategori</title>
</head>
<body>
<ul>
  <li><a href="../index.php">Hem</a></li>
  <li><a href="../search.php">Sök</a></li>
  <li><a href="../contact.php">Kontakt</a></li>
</ul>

<section class='background'>
        <h2>Kategorier</h2>
<div class="box__search--form">
  <form action="#" method="post" name="createCatForm" class="search__form">
    <input name="catname" type="text" required placeholder="Kategori..."><br>
    <input type="submit" value="Lägg till kategori" class="contact-form-button">
  </form>
    <p id="feedbackCat" class="search__feedback"></p>
</div>
<?php 
require_once '../db.php';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ){
  $catname = htmlspecialchars($_POST['catname']);

  $sql = "INSERT INTO category (name) 
          VALUES ( :name)";

  $stmt = $db->prepare($sql);
  $stmt->bindParam(':name' , $catname);
  $stmt->execute();

} 

  $sql = "SELECT * FROM category 
          ORDER BY name";
  $stmt = $db->prepare($sql);
  $stmt->execute();

  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
    $name = htmlspecialchars($row['name']);
    echo "<article class='box__search'>
      <div class='box__text'>
        <h3>$name</h3>
      </div></article>"; 
  endwhile;
  echo "</section>";

?>


<script src="createvalidate"></script>
</body>
</html>
