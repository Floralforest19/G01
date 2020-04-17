<?php

/**************************************
*Create new product
 *************************************/
require_once '../db.php';
?>

<!-- <?php
 // Hantera data som skickas via formuläret
if($_SERVER['REQUEST_METHOD'] === 'POST') :

  // Test
  // print_r($_POST);

  // Skapa en SQL-sats
  $sql = "INSERT INTO product (name, description, quantity, image_file_name)
          VALUES ( :name , :description, :quantity , :image_file_name) ";

  $stmt = $db->prepare($sql);

  // Binda parametrar
  $name = htmlspecialchars($_POST['name']);
  $description  = htmlspecialchars($_POST['description']);
  $quantity  = htmlspecialchars($_POST['quantity']);
  $image_file_name  = htmlspecialchars($_POST['image']);
//   $price  = ($_POST['price']);
//   $category_id  = htmlspecialchars($_POST['category_id']);

  $stmt->bindParam(':name' , $name );
  $stmt->bindParam(':description'  , $description);
  $stmt->bindParam(':quantity' , $quantity );
  $stmt->bindParam(':image_file_name' , $image_file_name );
//   $stmt->bindParam(':price' , $price );
//   $stmt->bindParam(':category_id' , $category_id );

  // Skicka SQL-satsen till databas-servern
  $stmt->execute();


endif;

?> -->

<?php
// visa kategorierna
  $sql = "SELECT * FROM category 
  ORDER BY name";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  echo "<select id='categori'>";
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
    $name = htmlspecialchars($row['name']);
    $id = htmlspecialchars($row['category_id']);
    $name = ucfirst($name);
    echo "<option value='$name'>$name</option>";
  endwhile;
  echo "</select>";
?>

<h2>Skapa ny produkt</h2>
    
<form action="#" method="POST">


<div class="col-md-12 form-group">
        <input  type="file" 
                name="image" 
                id="fileToUpload" 
                class="form-control">
    </div>
<!--     
    <div class="col-md-12 form-group">
        <input  type="file" 
                name="image" 
                id="fileToUpload" 
                class="form-control">
    </div>
    
    <div class="col-md-12 form-group">
        <input  type="file" 
                name="image" 
                id="fileToUpload" 
                class="form-control">
    </div>
    
    <div class="col-md-12 form-group">
        <input  type="file" 
                name="image" 
                id="fileToUpload" 
                class="form-control">
    </div>

    <div class="col-md-12 form-group">
        <input  type="file" 
                name="image" 
                id="fileToUpload" 
                class="form-control">
    </div> -->

    <label for="category">Välj kategori</label>

<select name="category_id">
  <option value="hygien">Hygien</option>
  <option value="mat">Mat</option>
  <option value="rosor">Rosor</option>
</select>


    <div class="col-md-12 form-group">
        <input name="name" type="text" required
        class="form-control" placeholder="Produktnamn">
    </div>   
      
    <div class="col-md-12 form-group">
        <textarea name="description" cols="30" rows="5" required
        class="form-control" placeholder="Beskrivning"></textarea>
    </div>

    <div class="col-md-12 form-group">
    <label for="quantity">Antal:</label>
    <input type="number" id="quantity" name="quantity" min="1" required>
    </div>   
        
    <!-- <div class="col-md-12 form-group">
    <label for="price">Pris:</label>
    <input type="number" id="price" name="price" min="1" required>
    </div>   -->
    
    <div class="col-md-12 form-group">
        <input  type="submit" 
                value="Lägg till"
                class="btn btn-success form-control">
    </div>
</form>