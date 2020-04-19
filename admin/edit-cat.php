<?php /**************************************** *
  * read info from db & show, add categories
**************************************** */
?>

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
  <title>Webshop - Skapa kategori</title>
</head>
<body>
<script src="createvalidate.js"></script>
<ul>
  <li><a href="../index.php">Hem</a></li>
  <li><a href="../search.php">Sök</a></li>
  <li><a href="../contact.php">Kontakt</a></li>
  <li><a href="read-cat.php">Kategorier</a></li>
</ul>

  <?php 
    require_once '../db.php'; 

    // get current name and set as placeholder in form
    if(isset($_GET['id'])){
      $id = htmlspecialchars($_GET['id']); 
      $sql = "SELECT name FROM category WHERE category_id = $id";
      $stmt = $db->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $name = htmlspecialchars($row['name']);
    }
  ?>

  <section class='background'>
    <h2>Redigera kategori</h2>
    <div class="box__cat--form">
      <form action="#" method="post" name="createCatForm" accept-charset="UTF-8" onsubmit="return validateCatForm()">
        <input name="catname" type="text" class="input__cat" required placeholder="<?php echo $name ?>">
      <?php 
        if(isset($_POST['catname'])){
          $id = htmlspecialchars($_GET['id']); 
          $catname = ucfirst(htmlspecialchars($_POST['catname'])); 
          // kolla om kategorin finns i databasen
          $sql = "SELECT `name` FROM `category` WHERE `name` LIKE '$catname'";
          $stmt = $db->prepare($sql);
          $stmt->execute();
          // $result sätts till true ifall kategorin existerar
          $result = false; 
          while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $result = true; 
            echo "<p class='search__feedback'>$catname är redan en kategori. Ange annat värde för att spara.</p>";
          } // skapa ny kategori ifall nytt värde
          if(!$result){
            $sql = "UPDATE category SET name = '$catname' WHERE category_id = '$id' ";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            header('Location:read-cat.php');
          }
        }
      ?>
        <input type="submit" value="Byt kategorinamn" class="cat-form-btn"> 
      </form>
      <p id="feedbackCat" class="search__feedback"></p>
      <a href="read-cat.php"><button class="btn__delete">Avbryt</button></a>
        
    </div>
  </section>
</body>
</html>