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
<script src="createvalidate.js"></script>
<ul>
  <li><a href="../index.php">Hem</a></li>
  <li><a href="../search.php">Sök</a></li>
  <li><a href="../contact.php">Kontakt</a></li>
</ul>

<section class='background'>

<h2>Kategorier</h2>

<div class="box__search--form">
  <form action="#" method="post" name="createCatForm"  onsubmit="return validateCatForm()">
    <input name="catname" type="text" required placeholder="Kategori...">
    <input type="submit" value="Lägg till kategori" class="contact-form-button">
  </form>
    <p id="feedbackCat" class="search__feedback"></p>
</div>

<?php require_once '../db.php';

  // skapa kategori
  if ( $_SERVER['REQUEST_METHOD'] === 'POST' ){
    $catname = htmlspecialchars($_POST['catname']);
    $sql = "INSERT INTO category (name) 
            VALUES ( :name)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':name' , $catname);
    $stmt->execute();
  } 

  // visa kategorierna
  $sql = "SELECT * FROM category 
          ORDER BY name";
  $stmt = $db->prepare($sql);
  $stmt->execute();

  echo "<article class='box__search'>
  <div class='box__text'>";
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
    $name = htmlspecialchars($row['name']);
    $id = htmlspecialchars($row['category_id']);

    echo "<h3>$name</h3>
    <a href='edit-cat.php?id=$id'>Redigera</a>";

    // man ska bara kunna radera en tom kategori
    $sqlCheckIfProdsExist = "SELECT product_id FROM product WHERE category_id = $id";
    $stmtCheckIfProdsExist = $db->prepare($sqlCheckIfProdsExist);
    $stmtCheckIfProdsExist->execute();
    $productrow = $stmtCheckIfProdsExist->fetch(PDO::FETCH_ASSOC);  
    // ifall raden är 0 så är kategorin tom på kategorier
    if( $productrow == 0 ){
      echo " <br><a onclick=\"return confirm('Är du säker att du vill radera kategorin?')\" href='delete-cat.php?id=$id'>Radera</a>"; 
    } else {
      echo "<p>Går ej att radera</p>";
    }
  endwhile;
  echo "</div></article></section>";

?>
</body>
</html>
