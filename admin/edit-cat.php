<?php 
  /**************************************** *
    * read info from db & show, add categories
  **************************************** */
  require_once 'header-admin.php';
  require_once '../db.php'; 

  // get current name and set as placeholder in form
  if(isset($_GET['id'])){
    $id   = htmlspecialchars($_GET['id']); 
    $sql  = "SELECT name FROM category WHERE category_id = $id";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $row  = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = htmlspecialchars($row['name']);
  }
?>

<section class='background'>
  <h2>Redigera kategori</h2>
  <div class="box__cat--form box__cat--form--main">
    <form action="edit-cat-logic.php?id=<?php echo $id; ?>" method="post" name="createCatForm" accept-charset="UTF-8" onsubmit="return validateForm('createCatForm','catname','feedbackCat')">
      <input name="catname" type="text" class="input__cat" required placeholder="<?php echo $name ?>">
      <p id="feedbackCat" class="search__feedback"></p>
      <input type="submit" value="Byt kategorinamn" class="cat-form-btn"> 
    </form>
    <a href="read-cat.php"><button class="btn__delete">Avbryt</button></a>
        
  </div>
</section>
</body>
</html>