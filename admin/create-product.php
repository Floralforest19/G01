
<h2>Skapa produkt</h2>

<div>
<form action="#" method="post" name="createProdForm">
    <div>  <input name="image_file_name" type="text" class="input__cat" required placeholder="Bild"></div> 
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
?>
</div> 

   <div> <input name="name" type="text" class="input__cat" required placeholder="Produktnamn"></div> 
   <div> <textarea name="description" type="text" cols="30" rows="5" class="input__cat" required placeholder="Beskrivning"> </textarea></div> 
   <div>  <input name="quantity" type="number" class="input__cat" required placeholder="Antal"></div> 
   <div>  <input name="price" type="number" class="input__cat" required placeholder="Pris"></div> 

    <input type="submit" value="Lägg till produkt">
</form>

</div>


  <?php require_once '../db.php';

    // skapa produkt
    if ( $_SERVER['REQUEST_METHOD'] === 'POST' ){
      $name = htmlspecialchars($_POST['name']);
      $description  = htmlspecialchars($_POST['description']);
      $quantity  = ($_POST['quantity']);
      $image_file_name  = htmlspecialchars($_POST['image_file_name']);
      $price  = ($_POST['price']);
      $category_id  = htmlspecialchars($_POST['test']);

      $sql = "INSERT INTO product (name, description, quantity, price,image_file_name, category_id) 
              VALUES ( :name, :description, :quantity,:price,:image_file_name,  :category_id)";
      $stmt = $db->prepare($sql);

      $stmt->bindParam(':name' , $name);
      $stmt->bindParam(':description'  , $description);
      $stmt->bindParam(':quantity' , $quantity );
      $stmt->bindParam(':image_file_name' , $image_file_name );
      $stmt->bindParam(':price' , $price );
      $stmt->bindParam(':category_id' , $category_id );

      $stmt->execute();
    } 

      echo "</div></tr>";
  ?>