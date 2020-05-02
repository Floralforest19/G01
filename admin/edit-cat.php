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
    <form action="#" method="post" name="createCatForm" accept-charset="UTF-8" onsubmit="return validateForm('createCatForm','catname','feedbackCat')">
      <input name="catname" type="text" class="input__cat" required placeholder="<?php echo $name ?>">
      <?php // kolla om kategori existerat --> ge feedback
        
        if(isset($_POST['catname'])){
          $id      = htmlspecialchars($_GET['id']); 
          $catname = ucfirst(htmlspecialchars($_POST['catname'])); 
          
          // kolla om kategorin finns i databasen
          $sql  = "SELECT `name` FROM `category` WHERE `name` LIKE '$catname'";
          $stmt = $db->prepare($sql);
          $stmt->execute();
          
          // $result sätts till true ifall kategorin existerar
          $result = false; 
          while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $result = true; 
            echo "<p class='search__feedback'>$catname är redan en kategori, ange annat värde.</p>";
          }
           // skapa ny kategori ifall nytt värde
          if(!$result){
            $sql  = "UPDATE category SET name = '$catname' WHERE category_id = '$id' ";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            header('Location:read-cat.php');
          }
        }
      ?>
      <p id="feedbackCat" class="search__feedback"></p>
      <input type="submit" value="Byt kategorinamn" class="cat-form-btn"> 
    </form>
    <a href="read-cat.php"><button class="btn__delete">Avbryt</button></a>
        
  </div>
</section>
</body>
</html>