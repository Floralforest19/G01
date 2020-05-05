<?php
  /**************************************** *
   *  display post with 10 or fewer in storage
  **************************************** */
  require_once 'db.php';
  require_once 'header.php'
?>

<div class='products__display'>
  <section class='background'>
    <h2>Sista chansen - 10% rabatt</h2>
    <div class='product__wrapper--newitem'>
    <?php

      // kolla vilka 3 varor som är senast skapade, de ska inte vara rea varor
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
      $new0 = $newProdIds[0];
      $new1 = $newProdIds[1];
      $new2 = $newProdIds[2];
        
      // hämta de produkter som är färre än 10 i lager
      $sqlLast  = "SELECT * FROM product WHERE quantity < 10 ORDER BY quantity";
      $stmtLast = $db->prepare($sqlLast);
      $stmtLast->execute();

      // loopar över arrayen som har resultatet från db
      while($rowLast = $stmtLast->fetch(PDO::FETCH_ASSOC)) :
        // spara data från db i varsin variabel
        $id       = htmlspecialchars($rowLast['product_id']); 

        // kolla om varan är ny
        $isItNew = false;
        // jämför produkt-idet med 
        for ($i=0; $i < 3; $i++) { 
          if($id == $newProdIds[$i]){
            $isItNew = true;
          }
        }
        // är varan inte ny, skriv ut den
        if($isItNew == false){
          $name     = htmlspecialchars($rowLast['name']);
          $category = strtoupper(htmlspecialchars($rowLast['category_id']));
          $quantity = htmlspecialchars($rowLast['quantity']);
          $price    = htmlspecialchars($rowLast['price']);
          // bildhantering
          $image = htmlspecialchars($rowLast['image_file_name']);
          if(empty($image)){
            $image = 'noimage.jpg';
          }
          $imageArray = explode(" * ", $image);
          $imageCount = count($imageArray);
          if ($imageCount > 1) {
            $image = $imageArray[0];
          }
          // skriv ut 
          if($quantity > 0){
            // rea varor
            if($quantity < 10){
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
                <input type='hidden' class='product-new0' value='$new0'/>
                <input type='hidden' class='product-new1' value='$new1'/>
                <input type='hidden' class='product-new2' value='$new2'/>
                <input type='hidden' class='product-image' value='$image'/>
                <input type='hidden' class='product-sale' value='$quantity'/>";
                if($quantity < 10){ 
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
        }
      endwhile;
    echo "</div></section>";
  ?>
</div>

<?php require_once 'footer.php'; ?>

<script type="text/javascript" src="js/shoppingcartvalidate.js"></script>
<script type="text/javascript" src="js/cart-localstorage.js"></script>
<script type="text/javascript" src="js/cart-add-product.js"></script>

<script type="text/javascript">
        //Vänta tills allt har laddats, då kör funktionen (som jquery document.ready())
        window.onload = function() {
            setAddProductToCartClickEvent();
        }
</script>