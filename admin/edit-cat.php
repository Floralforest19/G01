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

    // hget current name and set as placeholder in form
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

    <h2>Uppdatera kategori</h2>
    <div class="box__cat--form">
      <form action="#" method="post" name="createCatForm"  onsubmit="return validateCatForm()">
        <input name="catname" type="text" class="input__cat" required placeholder="<?php echo $name ?>">
        <input type="submit" value="Uppdatera kategori" class="cat-form-btn">
      </form>
        <p id="feedbackCat" class="search__feedback"></p>
    </div>

  <?php 
    if(isset($_POST['catname'])){
      $id = htmlspecialchars($_GET['id']); 
      $catname = ucfirst(htmlspecialchars($_POST['catname'])); 
      $sql = "UPDATE category SET name = '$catname' WHERE category_id = '$id' ";
      $stmt = $db->prepare($sql);
      $stmt->execute();
      header('Location:read-cat.php');
    }
  ?>

  </section>
</body>
</html>