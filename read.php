<?php
/**************************************** *
 * read info from db & display posts
 * different sql-orders depending on which link pushed
 * filters according to categories
**************************************** */

  // koppla till databas
  require_once 'db.php';
?>

<div class='products__display'>

  <nav class='products__menu'>
    <a href='index.php?id=all'>Alla produkter</a>
    <a href='index.php?id=food'>Mat</a>
    <a href='index.php?id=hygien'>Hygien</a>
    <a href='index.php?id=roses'>Rosor</a>

   </nav>

<?php
  if(isset($_GET['id'])){
    $id = htmlentities($_GET['id']);
    if($id == 'food'){
      $sql = "SELECT * FROM product 
              WHERE category_id = '2'
              ORDER BY name";
    } elseif($id == 'hygien'){
      $sql = "SELECT * FROM product 
              WHERE category_id = '1'
              ORDER BY name";
    } elseif($id == 'all'){
      $sql = "SELECT * FROM product 
              ORDER BY name";
    } elseif($id == 'roses'){
      $sql = "SELECT * FROM product 
              WHERE category_id = '3'
              ORDER BY name";
    }
  } else {
    $sql = "SELECT * FROM product 
            ORDER BY name";
  }

  $stmt = $db->prepare($sql);
  $stmt->execute();

  // starta div för inlägg
  echo "<div class='products__container'>";
  // loopar över arrayen som har resultatet från db
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
      // spara data från db i varsin variabel
      $id = htmlspecialchars($row['product_id']); // $row = array
      $heading = htmlspecialchars($row['name']);
      // $description = htmlspecialchars($row['description']);
      $category = strtoupper(htmlspecialchars($row['category_id']));
      $quantity = htmlspecialchars($row['quantity']);
      $price = htmlspecialchars($row['price']);
      if($quantity > 0){
        $quantityText = "Antal i lager - ".$quantity;
      } else {
        $quantityText = "Ej i lager";
      }
      echo "<br>
          <div class='products__item'>
            <div class='products__item--img'>
            <br>
            <p>Plats för bild</p>
            <br>
            </div>
            <div class='products__item--text'>
              <h2>$heading</h2>
              <p>$price</p>
              <a href='#' class='product__btn'>Köp</a>
              <p class=''>$quantityText</p>
            </div>
          </div>
        <br>
        "; 
  // avsluta while loop
  endwhile;
// stäng post div
  echo "</div>";
?>

</div>

