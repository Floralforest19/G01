<?php require_once 'header-admin.php'; ?>
<h2>Skapa produkt</h2>

<div>
<form action="upload-pro.php" method="post" enctype="multipart/form-data" name="createProdForm">
    <div>  <input type="file" name="image_file_name[]" id="image_file_name" type="text" class="input__cat" required placeholder="Bild" multiple></div> 
   
    <div> <?php
// visa kategorierna
require_once '../db.php';
  $sql = "SELECT * FROM category 
  ORDER BY name";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $selectCat = "<select name='test' id='category_id'>";
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
    $name = ucfirst(htmlspecialchars($row['name']));
    $id = htmlspecialchars($row['category_id']);
    $selectCat .= "<option value='$id'>$name</option>";
  endwhile;
  $selectCat.= "</select>";

  echo $selectCat;
?>
</div> 

   <div> <input name="name" type="text" class="input__cat" required placeholder="Produktnamn"></div> 
   <div> <textarea name="description" type="text" cols="30" rows="5" class="input__cat" required placeholder="Beskrivning"> </textarea></div> 
   <div>  <input name="quantity" type="number" class="input__cat" required placeholder="Antal"></div> 
   <div>  <input name="price" type="number" class="input__cat" required placeholder="Pris"></div> 

    <input type="submit" value="Lägg till produkt">
</form>

</div>