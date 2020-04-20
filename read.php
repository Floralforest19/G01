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

<?php
  if(isset($_GET['id'])){
    $id = htmlentities($_GET['id']);
    if($id != 'all'){
      $sql = "SELECT * FROM product 
              WHERE category_id = '$id'
              ORDER BY name";
    } else {
      $sql = "SELECT * FROM product 
              ORDER BY name";
    }
  } else {
    $sql = "SELECT * FROM product 
            ORDER BY name";
  };

  $stmt = $db->prepare($sql);
  $stmt->execute();

  // starta div för inlägg
  ?>

  <section class='background'>
    <h2>Våra produkter</h2>
    <div class='menu__categories'>
      <?php
        $sql2 = "SELECT * FROM category 
        ORDER BY name";
        $stmt2 = $db->prepare($sql2);
        $stmt2->execute();
        echo "<nav class='products__menu'>
        <a href='index.php?id=all' class='link__categories'>Alla produkter</a> ";
        while( $row2 = $stmt2->fetch(PDO::FETCH_ASSOC) ){
          $name2 = $row2['name'];
          $id2 = $row2['category_id'];
          echo "<a href='index.php?id=$id2' class='link__categories'>$name2 </a>";
        }
        echo "</nav>";
      ?>
    </div>
    <div class='product__wrapper'>

  <?php
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
</main>
