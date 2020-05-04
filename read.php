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
          $id    = htmlentities($_GET['id']);
          $sql2  = "SELECT * FROM category WHERE category_id = '$id'";
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
  // kolla vilka 3 varor som är senast skapade
  $sqlNew  = "SELECT product_id FROM product ORDER BY creation_date DESC LIMIT 3";
  $stmtNew = $db->prepare($sqlNew);
  $stmtNew->execute();
  // spara 3 senaste produkternas id:n i en array
  $newProdIds = array();
  $i = 0;
  while($rowNew = $stmtNew->fetch(PDO::FETCH_ASSOC)){
    $newProdIds[$i] = $rowNew['product_id'];
    $i++;
  }

  // loopar över arrayen som har resultatet från db
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
      // spara data från db i varsin variabel
      $id          = htmlspecialchars($row['product_id']); // $row = array
      $name        = htmlspecialchars($row['name']);
      $description = htmlspecialchars($row['description']);
      $category    = strtoupper(htmlspecialchars($row['category_id']));
      $quantity    = htmlspecialchars($row['quantity']);
      $price       = htmlspecialchars($row['price']);
      $image       = htmlspecialchars($row['image_file_name']);

      // Om det inte finns en bild läggs det upp en dummy
      if(empty($image)){
        $image = 'noimage.jpg';
      }
      // Delar upp bild-strängen till en array
      $imageArray = explode(" * ", $image);
      // Kollar om bild-array har mer än ett värde
      $imageCount = count($imageArray);
      // Om bild-array har mer än ett värde är det första bilden som blir primär, sorteras i bokstavsordning.
      if ($imageCount > 1) {
        $image = $imageArray[0];
      }
      
      // skriv ut 
      if($quantity > 0){
        // rea varor
        if($quantity < 10 && $id != $newProdIds[0] && $id != $newProdIds[1] && $id != $newProdIds[2]){
          $priceText = "<a href='showproduct.php?id=$id'><p class='sale__old'>$price kr</p></a>
          <a href='showproduct.php?id=$id'><p class='sale__new'>".number_format($price*0.9,2)." kr</p></a>";
        } else {
          $priceText = "<a href='showproduct.php?id=$id'><p class=''>$price kr</p></a>";
        }
        echo "
        <article class='box' style='position:relative;'>
          <div class='box__pic'>
          <a href='showproduct.php?id=$id'><img src='./images/$image' alt='$name'/></a>
          </div>
          <div class='box__text'>
            <input type='hidden' class='product-id' value='$id'/>
            <input type='hidden' class='product-name' value='$name'/>         
            <input type='hidden' class='product-price' value='$price'/>
            <input type='hidden' class='product-image' value='$image'/>
            <input type='hidden' class='product-sale' value='$quantity'/>";
            // nya varor
            if($id == $newProdIds[0] || $id == $newProdIds[1] || $id == $newProdIds[2]){
              echo "<a href='showproduct.php?id=$id'><img src='./images/new.png' style='max-width:80px; position: absolute;top: 0;left: 0; rotate:-21deg;'></a>";
            }
            // reavaror
            if($quantity < 10 && $id != $newProdIds[0] && $id != $newProdIds[1] && $id != $newProdIds[2]){ 
              echo "<a href='showproduct.php?id=$id'><img src='./images/sale.png' style='max-width:80px; position: absolute;top: 0;left: 0; rotate:-21deg;'></a>";
            }
            echo "
            <a href='showproduct.php?id=$id'><h3>$name</h3></a>
            $priceText
            <a href='showproduct.php?id=$id'>Läs mer</a><br></a>
            <p><input type='number' class='product-quantity' min='1' max='$quantity' value='1'/></p>
            <button class='add-to-cart'>Lägg i varukorg</button>
            <p>$quantity i lager</p>
          </div>
        </article>";
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