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
    $sql = "SELECT * FROM product WHERE product_id = :product_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':product_id' , $product_id );
    $stmt->execute();

    if($stmt->rowCount() > 0){
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $name = htmlspecialchars($row['name']);
      $description  = htmlspecialchars($row['description']);
      $quantity  = htmlspecialchars($row['quantity']);
      $image_file_name  = htmlspecialchars($row['image_file_name']);
      $price  = htmlspecialchars($row['price']);
      $category_id  = htmlspecialchars($row['category_id']);


      // Splittar upp alla bilder produkten har till en array: $image_array
      $image_array = explode(" * ", $image_file_name);
      
      // Variabel som räknar hur många bilder produkten har. Minus två för att inkludera position "noll" och det sista värdet som alltid är tomt.
      $totalfiles = count($image_array) - 1;

    }else{
      echo 'Produkten finns inte';
      exit;
    }

  }


//2. Update product
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $product_id = htmlspecialchars($_POST['product_id']);
    $name = htmlspecialchars($_POST['name']);
    $description  = htmlspecialchars($_POST['description']);
    $quantity   = htmlspecialchars($_POST['quantity']);

    $price = htmlspecialchars($_POST['price']);
    $category_id = htmlspecialchars($_POST['category_id']);
    
  // räkna antalet filer/bilder som ska laddas upp
  $totalfiles = count($_FILES['image_file_name']['name']);
  
  // Skapa variabel som ska lagra alla bilder
  $imageCollection = "";

  // Kontrollerar ifall en bild är uppladdad genom att räkna längden på första variabeln i bild-arrayn
  if (strlen(htmlspecialchars(basename($_FILES["image_file_name"]["name"][0]))) > 1) {
    // Loopar över alla filer/bilder
    for($i=0;$i<$totalfiles;$i++){
      $target_dir = "../images/";

      $addImageCollection = 1;  // Variabel som används för att se ifall bildens sökväg ska läggas till i produktens tabell.
      
      
      $target_file = $target_dir . basename($_FILES["image_file_name"]["name"][$i]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

      
      $check = getimagesize($_FILES["image_file_name"]["tmp_name"][$i]);
      if($check !== false) {
        echo "<img src='$target_file' class='img-fluid' alt='$name'><br>";
        $uploadOk = 1;
      } else {
        echo "Det här är ingen bild.<br>";
        $uploadOk = 0;
        $addImageCollection = 0;
        
      }
      
      
      // Check if file already exists
      if (file_exists($target_file)) {
        echo "Den här bilden finns redan.<br>";
        $uploadOk = 0;
      }
      // Check file size
      if ($_FILES["image_file_name"]["size"][$i] > 1000000) {  // Begränsad till 1MB
        echo "Tyvärr, filen är för stor.<br>";
        $uploadOk = 0;
      $addImageCollection = 0;
      }
      
      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
        
        echo "Tyvärr, bara JPG, JPEG, PNG & GIF är tillåtna filformat.<br>";
        $uploadOk = 0;
        $addImageCollection = 0;
      }
      
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
        
        echo "Filen gick inte att ladda upp.";
        // if everything is ok, try to upload file
      } else {
      
        if (move_uploaded_file($_FILES["image_file_name"]["tmp_name"][$i], $target_file)) {
          echo " Bilden ". basename( $_FILES["image_file_name"]["name"][$i]). " har laddats upp.<br>";
        } else {
          echo "Tyvärr, det blev något fel vid uppladdning av fil.<br>";
        }
        echo "</div></tr>";
      }

      // Om $addImageCollection är "1" så kommer bildens sökväg att läggat till under produktens image_file_name kolumn
      if ($addImageCollection == 1) {
        //Sparar alla bilder och separerar bildernas sökväg, med två mellanslag, i en string
        $imageCollection .= htmlspecialchars(basename ($_FILES["image_file_name"]["name"][$i])) . " * ";
      }
    }   // Slut på bildernas for-loop.
  }   // Slut på if-sats som kollar ifall bild variabeln är tom.

  if (strlen($image_array[0]) > 0) {
    
    if ($_POST['image_radio'] == "new") { // Om användaren har valt att spara över de gamla bilderna
      $update = "UPDATE product
      SET
      name = :name,
      description = :description,
      quantity = :quantity,
      image_file_name = :imageCollection,
      price = :price,
      category_id = :category_id
      WHERE product_id = :product_id";

      $stmt = $db->prepare($update);

      $stmt->bindParam(':name' , $name );
      $stmt->bindParam(':description'  , $description);
      $stmt->bindParam(':quantity'  , $quantity);
      $stmt->bindParam(':price'  , $price);
      $stmt->bindParam(':category_id'  , $category_id);
      $stmt->bindParam(':product_id'  , $product_id);


      $stmt->bindParam(':imageCollection' , $imageCollection);

    } else {  // Om användaren har valt att behålla de gamla bilderna
      $update = "UPDATE product
      SET
      name = :name,
      description = :description,
      quantity = :quantity,
      price = :price,
      category_id = :category_id
      WHERE product_id = :product_id";

      $stmt = $db->prepare($update);

      $stmt->bindParam(':name' , $name );
      $stmt->bindParam(':description'  , $description);
      $stmt->bindParam(':quantity'  , $quantity);
      $stmt->bindParam(':price'  , $price);
      $stmt->bindParam(':category_id'  , $category_id);
      $stmt->bindParam(':product_id'  , $product_id);

      }
  } else {
    $update = "UPDATE product
    SET
    name = :name,
    description = :description,
    quantity = :quantity,
    image_file_name = :imageCollection,
    price = :price,
    category_id = :category_id
    WHERE product_id = :product_id";

    $stmt = $db->prepare($update);

    $stmt->bindParam(':name' , $name );
    $stmt->bindParam(':description'  , $description);
    $stmt->bindParam(':quantity'  , $quantity);
    $stmt->bindParam(':price'  , $price);
    $stmt->bindParam(':category_id'  , $category_id);
    $stmt->bindParam(':product_id'  , $product_id);


    $stmt->bindParam(':imageCollection' , $imageCollection);
  }

    $stmt->execute();

    header('Location:index.php');
    exit;
  }else if (isset($_GET['product_id']) == false) {
    echo 'Produkten finns inte';
    exit;
  }


?>

<h2>Uppdatera produkt</h2>

<div class="update-product-form">
  <form method="POST" enctype="multipart/form-data" >  <!-- har lagt till display-grid för enkelhetens skull -->

  <?php
      // Kontrollerar att bild finns på produkten

    if (strlen($image_array[0]) > 0) {
      echo "<div>";
      echo 'Produktens nuvarande bild/er: ';
      for ($i=0; $i <= $totalfiles; $i++) { 
        echo '<br>';
        if (strlen($image_array[$i]) > 0) {

          $image_printer = "<img src='../images/$image_array[$i]' alt='$name image $i' style='max-height: 150px;'/>";
          echo $image_printer;
        }
      }
      echo "</div>";
  ?>
      <div>  
        <input type="file" name="image_file_name[]" id="image_file_name" type="text" class="input__cat" placeholder="Bild" multiple>
      </div> 

      <br>
      Vill du spara de gamla bilderna: 
      <div>
        <input type="radio" name="image_radio" id="image_old" <?php if (strlen($image_array[0]) > 0) { echo "checked"; }?> value="save" > Ja 
        
        
        <input type="radio" name="image_radio" id="image_new" <?php if (!strlen($image_array[0]) > 0) { echo "checked"; }?> value="new">Nej
      </div>

      <?php

    } else {
      echo "Produkten har ingen bild än. <br><br>";
    ?>
      <div>  <input type="file" name="image_file_name[]" id="image_file_name" type="text" class="input__cat" placeholder="Bild" multiple></div>
    <?php
    }

// visa kategorierna
require_once '../db.php';
  $sql = "SELECT * FROM category
  ORDER BY name";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  
  $selectCat = "<select name='category_id' id='category_id'>";
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
  $selectCat.= "</select>";

  echo 'Kategori: ' . $selectCat;
?>
        Namn: <input name="name" type="text" required value="<?php echo $name; ?>">
        Beskrivning: <textarea name="description" type="text" cols="30" rows="5"
            required><?php echo $description; ?></textarea>
        Antal: <input name="quantity" type="number" required value="<?php echo $quantity; ?>">
        Pris: <input name="price" type="number" required value="<?php echo $price; ?>">
        <input type="submit" value="Uppdatera produkt">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
    </form>
</div>
