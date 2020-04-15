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



  // <div class="product__wrapper">
  //   <article class="box">
  //     <div class="box__pic">
  //       <img src="./images/toalettpapper.jpg" alt="toalettpapper"/>
  //     </div>
  //     <div class="box__text">
  //       <h3>Toalettpapper</h3>
  //       <button>Lägg i varukorg</button>
  //     </div>
  //   </article>


  // starta div för inlägg
  echo "<section class='background'>
        <h2>Våra produkter</h2>
        <div class='product__wrapper'>";
  // loopar över arrayen som har resultatet från db
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
      // spara data från db i varsin variabel
      $id = htmlspecialchars($row['product_id']); // $row = array
      $name = htmlspecialchars($row['name']);
      $description = htmlspecialchars($row['description']);
      $category = strtoupper(htmlspecialchars($row['category_id']));
      $quantity = htmlspecialchars($row['quantity']);
      $price = htmlspecialchars($row['price']);
      if($quantity > 0){
        $quantityText = "Antal i lager - ".$quantity;
      } else {
        $quantityText = "Ej i lager";
      }

      echo "
          <article class='box'>
            <div class='box__pic'>
              <img src='./images/toalettpapper.jpg' alt='toalettpapper'/>
            </div>
            <div class='box__text'>
              <h3>$name</h3>
              <p>$price kr</p>
              <p>$description</p>
              <a href='showproduct.php?id=$id'>Läs mer</a><br>
              <button>Lägg i varukorg</button>";
              // läs mer bör gå till produktsidan
              // lägga till när vi introducerar varukorg
              //<a href='#' class='product__btn'>Köp</a>
              echo "<p class=''>$quantityText</p>
            </div>
          </article>"; 

  // avsluta while loop
  endwhile;
// stäng post div
  echo "</div></section>";
?>
</div>

