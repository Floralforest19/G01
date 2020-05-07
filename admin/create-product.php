<?php require_once 'header-admin.php'; ?>
<h2>Skapa produkt</h2>

<div class="wrap">
<form action="upload-pro.php" method="post" enctype="multipart/form-data" name="createProdForm" onsubmit="return validateAll()" class="wrap">
    <?php
      if (isset($_GET['uppladdning']) == true) {
        echo "<h4 style='color: red;'>En produkt får max ha 5 bilder.</h4>";
      }
    ?>
    <div>  <input type="file" name="image_file_name[]" id="image_file_name" type="text" class="input__cat" placeholder="Bild" multiple accept=".png, .jpg, .jpeg, .gif"></div> 
   
    <div> <?php
// visa kategorierna
require_once '../db.php';
  $sql = "SELECT * FROM category 
  ORDER BY name";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $selectCat = "<select name='test' id='category_id' class='text'>";
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
    $name       = ucfirst(htmlspecialchars($row['name']));
    $id         = htmlspecialchars($row['category_id']);
    $selectCat .= "<option value='$id'>$name</option>";
  endwhile;
  $selectCat.= "</select>";

  echo $selectCat;
?>
</div> 
      <!-- Dessa inputs är required -->
   <div> <label for="name">Namn:</label> 
   <input name="name" type="text" class="input__cat" required placeholder="Produktnamn"></div> 
   <div id="nameFeedback" style="color:#eb4b88"></div>

   <div> <label for="description"> Beskrivning:</label>
    <textarea name="description" type="text" cols="30" rows="5" class="input__cat" required placeholder="Beskrivning"> </textarea></div> 
   <div id="descriptionFeedback" style="color:#eb4b88"></div>
   
   <div> <label for="quantity"> Antal:</label> 
   <input name="quantity" type="number" class="input__cat" required placeholder="Antal"></div> 
   <div id="quantityFeedback" style="color:#eb4b88"></div>
   
   <div> <label for="price"> Pris:</label>
    <input name="price" type="number" step="0.01" min="0" max="10000" class="input__cat" required placeholder="Pris"></div> 
   <div id="priceFeedback" style="color:#eb4b88"></div>
   
    <div style="display: flex;justify-content: center;justify-content: space-evenly;">
      <a class="btn__delete del" href="index.php" style="text-decoration: none;text-align: center;font-weight: 600;padding-top: 3px;">Avbryt</a>
      <input class="product__btn" type="submit" value="Lägg till produkt">
    </div>
</form>
</div>

<script src="../js/validate-updateproduct.js"></script>

<script>
function validateAll() {
    let isAllValidated = true;
    let nameValidated = catNameInput('createProdForm', 'name', 'nameFeedback');
    if (nameValidated == false) {
        isAllValidated = false;
    }

    let descriptionValidated = validateTextDescriptionInput('createProdForm', 'description', 'descriptionFeedback');
    if (descriptionValidated == false) {
        isAllValidated = false;
    }

    let quantityValidated = validateNumberInput('createProdForm', 'quantity', 'quantityFeedback');
    if (quantityValidated == false) {
        isAllValidated = false;
    }

    let priceValidated = validatePriceInput('createProdForm', 'price', 'priceFeedback');
    if (priceValidated == false) {
        isAllValidated = false;
    }


    if (isAllValidated == false) {
        return false;
    }
    return true;
}
</script>
