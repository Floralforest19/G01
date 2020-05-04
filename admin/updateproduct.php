<?php 

/**************************************** *
 1. Get product data.
 2. Update product data.
**************************************** */

require_once 'header-admin.php';
require_once '../db.php';

//1. Get product data.
if(isset($_GET['product_id'])){
    $product_id = htmlspecialchars($_GET['product_id']);
    $sql        = "SELECT * FROM product WHERE product_id = :product_id";
    $stmt       = $db->prepare($sql);
    $stmt->bindParam(':product_id' , $product_id );
    $stmt->execute();

    if($stmt->rowCount() > 0){
      $row              = $stmt->fetch(PDO::FETCH_ASSOC);
      $name             = htmlspecialchars($row['name']);
      $description      = htmlspecialchars($row['description']);
      $quantity         = htmlspecialchars($row['quantity']);
      $image_file_name  = htmlspecialchars($row['image_file_name']);
      $price            = htmlspecialchars($row['price']);
      $category_id      = htmlspecialchars($row['category_id']);

      // Splittar upp alla bilder produkten har till en array: $image_array
      $image_array = explode(" * ", $image_file_name);

      // Variabel som räknar hur många bilder produkten har. Minus ett för att inkludera position "noll" och det sista värdet som alltid är tomt.
      $totalfiles = count($image_array) - 1;

      // Kontrollerar hur många bilder som redan finns för att begränsa hur många bilder som kan laddas upp

    }else{
      // echo 'Produkten finns inte';                               // **
      exit;
    }

  }
  // logik för uppdatering
  require_once 'updateproduct-logic.php';

  // visa olika rubriker beroende på om man uppdaterar eller skapar
  if (isset($_GET['new'])) {
    echo "<h2>Produkt skapad</h2>";
  } else {
    echo "<h2>Uppdatera produkt</h2>";
  }
?>

<div class="update-product-form">
  <form method="POST" name="update-form" action="" enctype="multipart/form-data" style="padding-left: 10%;padding-right: 10%;" onsubmit="return validateAll()" class='wrap'>

  <?php
      // Kontrollerar att bild finns på produkten

    if (strlen($image_array[0]) > 0) {  // Kollar ifall index-0 innehåller något
      echo "<div>";
      echo 'Produktens nuvarande bild/er: ';
      for ($i=0; $i <= $totalfiles; $i++) {  // Loopar imageArray för att skriva ut alla bilder
        echo '<br>';
        if (strlen($image_array[$i]) > 0) {   // Kollar ifall indexet innehåller något
          $image_printer = "<div style='border: 1px solid #ddd;border-radius: 10px;padding: 7px;background-color: white;display: table;'>";
          $image_printer .= "<img src='../images/$image_array[$i]' alt='$name image $i' style='max-height: 150px;'/>";
          $image_printer .= "<div>
          Spara bild: <input type='radio' name='image_radio_$i' value='save' checked> Ja 
          <input type='radio' name='image_radio_$i' value='trash'> Nej 
          </div>";
          if ($i == 0) {  // Radiobutton som bestämmer vilken bild som ska vara primära bilden, första bilden är primär by default
            $image_printer .= "Primär bild: <input type='radio' name='image_primary' value='0' checked>
            </div>";
          } else {
            $image_printer .= "Primär bild: <input type='radio' name='image_primary' value='$i'>
            </div>";
          }

          echo $image_printer;
          
        }
      }
      echo "</div>";

    } else {
      echo "Produkten har ingen bild än. <br><br>";
    }
    if (isset($_GET['uppladdning']) == true) {  // Om produktens sparade och nya bilder är fler än 5 skickas man tillbaka till samma sida med varningstext
      echo "<h4 style='color: red;'>En produkt får max ha 5 bilder.<br>Godkända filformat är JPG, JPEG, PNG & GIF.<br>En bild får vara max 2MB stor.</h4>";
    }
    ?>
      <div>  
        <input type="file" name="image_file_name[]" id="image_file_name" type="text" class="input__cat" placeholder="Bild" multiple>
      </div>
      <br>
    <?php
// visa kategorierna
require_once '../db.php';
  $sql = "SELECT * FROM category
  ORDER BY name";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  
  $selectCat = "<select name='category_id' id='category_id' class='text'>";
  // förväljer den kategori som produkten redan hade tilldelats
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
    $catname = ucfirst(htmlspecialchars($row['name']));
    $category_select_id = htmlspecialchars($row['category_id']);
    if($category_id == $category_select_id){
    $selectCat .= "<option value='$category_select_id' selected>$catname</option>";
    } else {
    $selectCat .= "<option value='$category_select_id'>$catname</option>";
    }
  endwhile;
  $selectCat.= "</select><br>";

  echo 'Kategori: ' . $selectCat;
?><label for="name">Namn:</label>
<input class="input__cat" name="name" type="text" required value="<?php echo $name; ?>">
<div id="nameFeedback" style="color:#eb4b88"></div>

<label for="description"> Beskrivning:</label>
<textarea class="input__cat" name="description" type="text" cols="30" rows="5" required><?php echo $description; ?></textarea>
<div id="descriptionFeedback" style="color:#eb4b88"></div>

<label for="quantity"> Antal:</label>
<input class="input__cat" name="quantity" type="number" required value="<?php echo $quantity; ?>">
<div id="quantityFeedback" style="color:#eb4b88"></div>

<label for="price"> Pris:</label>
<input class="input__cat" name="price" type="number" required value="<?php echo $price; ?>">
<div id="priceFeedback" style="color:#eb4b88"></div>

        <div style="display: flex;justify-content: center;justify-content: space-evenly;">

        <?php
          if (isset($_GET['new']) == true) { // Om nyskapad produkt ändra Avbryt-knapp till Klar-knapp
          ?>
            <a class="btn__delete del" href="index.php" style="text-decoration: none;text-align: center;font-weight: 600;padding-top: 3px;background: #51e661;">Klar</a>
          <?php
          } else {
          ?>
            <a class="btn__delete del" href="index.php" style="text-decoration: none;text-align: center;font-weight: 600;padding-top: 3px;">Avbryt</a>
          <?php
          }
          ?>

          <input class="product__btn" type="submit" value="Uppdatera produkt">
        </div>
        <input class="input__cat" type="hidden" name="product_id" value="<?php echo $product_id; ?>">
    </form>
</div>


<!-- <script src="../validateinput.js"></script> -->
<script src="../js/validate-updateproduct.js"></script>

<script>
function validateAll() {
    let isAllValidated = true;

    let nameValidated = validateTextInput('update-form', 'name', 'nameFeedback');
    if (nameValidated == false) {
        isAllValidated = false;
    }

    let descriptionValidated = validateTextDescriptionInput('update-form', 'description', 'descriptionFeedback');
    if (descriptionValidated == false) {
        isAllValidated = false;
    }

    let quantityValidated = validateNumberInput('update-form', 'quantity', 'quantityFeedback');
    if (quantityValidated == false) {
        isAllValidated = false;
    }

    let priceValidated = validatePriceInput('update-form', 'price', 'priceFeedback');
    if (priceValidated == false) {
        isAllValidated = false;
    }


    if (isAllValidated == false) {
        return false;
    }
    return true;
}
</script>
