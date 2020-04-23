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

    <section class='background'>
        <h2>Produkter</h2>
        <div class='menu__categories'>
            <?php
        $catHeading = "<h3>Alla produkter</h3>";
        if(isset($_GET['id'])){
          $id = htmlentities($_GET['id']);
          $sql2 = "SELECT * FROM category WHERE category_id = '$id'";
          $stmt2 = $db->prepare($sql2);
          $stmt2->execute();
          while( $row2 = $stmt2->fetch(PDO::FETCH_ASSOC) ){
            $name2 = $row2['name'];
            $catHeading = "<h3>$name2</h3>";
          }
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

        echo $catHeading;
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
      $image = htmlspecialchars($row['image_file_name']);

      // Om det inte finns en bild läggs det upp en dummy
      if(empty($image)){
        $image = 'toalettpapper.jpg';
      }

      // Delar upp bild-strängen till en array
      $imageArray = explode(" * ", $image);

      // Kollar om bild-array har mer än ett värde
      $imageCount = count($imageArray);

      // Om bild-array har mer än ett värde är det första bilden som blir primär, sorteras i bokstavsordning.
      if ($imageCount > 1) {
        $image = $imageArray[0];
      }

      if($quantity > 0){
        $quantityText = "Antal i lager - ".$quantity;
        echo "
        <article class='box'>
          <div class='box__pic'>
            <img src='./images/$image' alt='$name'/>
          </div>
          <div class='box__text'>
          <input type='hidden' class='product-id' value='$id'/>
          <input type='hidden' class='product-name' value='$name'/>         
          <input type='hidden' class='product-price' value='$price'/>
          <input type='hidden' class='product-image' value='$image'/>
            <h3>$name</h3>
            <p>$price kr</p>
            <p>$description</p>
            <a href='showproduct.php?id=$id'>Läs mer</a><br>
            <p>Antal: <input type='number' class='product-quantity' min='1' max='$quantity' value='1'/></p>
            <button class='add-to-cart'>Lägg i varukorg</button>";
            // läs mer bör gå till produktsidan
            // lägga till när vi introducerar varukorg
            //<a href='#' class='product__btn'>Köp</a>
            echo "<p class=''>$quantityText</p>
          </div>
        </article>";
      } else {
        $quantityText = "Ej i lager";
      }

  // avsluta while loop
  endwhile;
// stäng post div
  echo "</div></section>";
?>
        </div>

        <script type="text/javascript">
        //Vänta tills allt har laddats, då kör funktionen (som jquery document.ready())
        window.onload = function() {
            setAddProductToCartClickEvent();
        }
        </script>