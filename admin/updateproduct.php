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
      $totalfiles = count($image_array) - 2;


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
    $image_file_name = htmlspecialchars($_POST['image_file_name']);
    $price = htmlspecialchars($_POST['price']);
    $category_id = htmlspecialchars($_POST['category_id']);

echo $product_id;
    $update = "UPDATE product
            SET
            name = :name,
            description = :description,
            quantity = :quantity,
            image_file_name = :image_file_name,
            price = :price,
            category_id = :category_id
            WHERE product_id = :product_id";

    $stmt = $db->prepare($update);

    $stmt->bindParam(':name' , $name );
    $stmt->bindParam(':description'  , $description);
    $stmt->bindParam(':quantity'  , $quantity);
    $stmt->bindParam(':image_file_name', $image_file_name);
    $stmt->bindParam(':price'  , $price);
    $stmt->bindParam(':category_id'  , $category_id);
    $stmt->bindParam(':product_id'  , $product_id);

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
  <form method="POST" style="display: grid;">  <!-- har lagt till display-grid för enkelhetens skull -->

  <?php
      // Kontrollerar att bild finns på produkten     ***************************************************************************************
    if (strlen($image_array[0]) > 0) {
      echo "<div>";
      for ($i=0; $i <= $totalfiles; $i++) { 
        $image_printer = "<img src='../images/$image_array[$i]' alt='$name image $i' style='max-height: 150px;'/>";
        echo $image_printer;
      }
      echo "</div>";
    }
  ?>

        Bild: <input name="image_file_name" type="text" required value="<?php echo $image_file_name; ?>">
        <?php
// visa kategorierna
require_once '../db.php';
  $sql = "SELECT * FROM category
  WHERE category_id = $category_id
  ORDER BY name";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $selectCat = "<select name='category_id' id='category_id'>";
  // förväljer den kategori som produkten redan hade tilldelats
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
    $catname = ucfirst(htmlspecialchars($row['name']));
    $id = htmlspecialchars($row['category_id']);
    if($id == $category_id){
    $selectCat .= "<option value='$id' selected>$catname</option>";
    } else {
    $selectCat .= "<option value='$id'>$catname</option>";
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
