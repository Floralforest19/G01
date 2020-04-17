<?php /**************************************** *
  * read info from db & show, add categories
**************************************** */
require_once 'header-admin.php';
?>

<section class='background'>

  <h2>Kategorier</h2>

  <div class="box__cat--form box__cat--form--main">
    <form action="#" method="post" name="createCatForm"  onsubmit="return validateCatForm()">
      <input name="catname" type="text" class="input__cat" required placeholder="Lägg till kategori...">
      <input type="submit" value="Lägg till kategori" class="cat-form-btn">
    </form>
      <p id="feedbackCat" class="search__feedback"></p>
  </div>

  
    
  <?php require_once '../db.php';

    // skapa kategori
    if ( $_SERVER['REQUEST_METHOD'] === 'POST' ){
      $catname = htmlspecialchars(ucfirst($_POST['catname']));
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
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
      echo "<div class='box__cat--form'><table class='table__cat'><tr>";
      $name = htmlspecialchars($row['name']);
      $id = htmlspecialchars($row['category_id']);
      echo "<h3>$name</h3>
      <a href='edit-cat.php?id=$id'><button class='btn__edit'>Redigera</button></a>";
      // man ska bara kunna radera en tom kategori
      $sqlCheckIfProdsExist = "SELECT product_id FROM product WHERE category_id = $id";
      $stmtCheckIfProdsExist = $db->prepare($sqlCheckIfProdsExist);
      $stmtCheckIfProdsExist->execute();
      $productrow = $stmtCheckIfProdsExist->fetch(PDO::FETCH_ASSOC);  
      // ifall raden är 0 så är kategorin tom på kategorier
      if( $productrow == 0 ){
        echo "<a href='delete-cat.php?id=$id' onclick=\"return confirm('Är du säker att du vill radera kategorin?')\"><button  class='btn__delete'>Radera</button></a>"; 
      } else {
        echo "<p>Går ej att radera, innehåller produkter</p>";
      }
      echo "</div></tr></table></div>";
    endwhile;
  ?>
    
  
</section>
</body>
</html>