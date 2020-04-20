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
      $name = $row['name'];
      $description  = $row['description'];
      $quantity  = $row['quantity'];
      $image_file_name  = $row['image_file_name'];
      $price  = $row['price'];
      $category_id  = $row['category_id'];

    }else{
      echo 'Produkten finns inte';
      exit;
    }
  
  }


//2. Update product 
if($_SERVER['REQUEST_METHOD'] === 'POST'){

 $product_id = htmlentities($_POST['product_id']);
    $name = htmlentities($_POST['name']);
    $description  = htmlentities($_POST['description']);
    $quantity   = htmlentities($_POST['quantity']);
    $image_file_name = htmlentities($_POST['image_file_name']);
    $price = htmlentities($_POST['price']);
    $category_id = htmlentities($_POST['category_id']);

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

<h2>Updatera produkt</h2>

<div class="update-product-form">
    <form method="POST">
        Bild: <input name="image_file_name" type="text" required value="<?php echo $image_file_name; ?>">
        <?php
// visa kategorierna
require_once '../db.php';
  $sql = "SELECT * FROM category 
  ORDER BY name";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $selectCat = "<select name='category_id' id='category_id'>";
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
    $name = ucfirst(htmlspecialchars($row['name']));
    $id = htmlspecialchars($row['category_id']);
    $selectCat .= "<option value='$id'>$name</option>";
  endwhile;
  $selectCat.= "</select>";

  echo 'Kategori: ' . $selectCat;
?>
        Name: <input name="name" type="text" required value="<?php echo $name; ?>">
        Beskrivning: <textarea name="description" type="text" cols="30" rows="5"
            required><?php echo $description; ?></textarea>
        Antal: <input name="quantity" type="number" required value="<?php echo $quantity; ?>">
        Pris: <input name="price" type="number" required value="<?php echo $price; ?>">
        <input type="submit" value="Updatera produkt">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
    </form>
</div>