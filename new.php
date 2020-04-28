<?php
  /**************************************** *
   * read info from db & display 3 newest posts
  **************************************** */
  require_once 'db.php';
  require_once 'header.php'
?>

<div class='products__display'>
  <section class='background'>
    <h2>Nya produkter</h2>
    <!-- <h3>Ta gärna en titt på våra senaste varor</h3> -->
    <div class='product__wrapper--newitem'>

    <?php
      // hämta de tre senaste produkterna
      $sqlNew =" SELECT * FROM product ORDER BY creation_date DESC LIMIT 3";
      $stmtNew = $db->prepare($sqlNew);
      $stmtNew->execute();

      // loopar över arrayen som har resultatet från db
      while($rowNew = $stmtNew->fetch(PDO::FETCH_ASSOC)) :
        // spara data från db i varsin variabel
        $id = htmlspecialchars($rowNew['product_id']); 
        $name = htmlspecialchars($rowNew['name']);
        $category = strtoupper(htmlspecialchars($rowNew['category_id']));
        $quantity = htmlspecialchars($rowNew['quantity']);
        $price = htmlspecialchars($rowNew['price']);
        $image = htmlspecialchars($rowNew['image_file_name']);

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
        // skriv ut 
        if($quantity > 0){
          // rea varor
          if($quantity < 10){
            $priceText = "<a href='showproduct.php?id=$id'><p class='sale__old'>$price kr</p></a>
            <a href='showproduct.php?id=$id'><p class='sale__new'>".$price*0.9." kr</p></a>";
          } else {
            $priceText = "<a href='showproduct.php?id=$id'><p class=''>$price kr</p></a>";
          }
          echo "
          <article class='box'>
            <div class='box__pic'>
            <a href='showproduct.php?id=$id'><img src='./images/$image' alt='$name'/></a>
            </div>
            <div class='box__text'>
              <input type='hidden' class='product-id' value='$id'/>
              <input type='hidden' class='product-name' value='$name'/>         
              <input type='hidden' class='product-price' value='$price'/>
              <input type='hidden' class='product-image' value='$image'/>
              <a href='showproduct.php?id=$id'><h3>$name</h3></a>
              $priceText
              <a href='showproduct.php?id=$id'>Läs mer</a><br></a>
              <p><input type='number' class='product-quantity' min='1' max='$quantity' value='1'/></p>
              <button class='add-to-cart'>Lägg i varukorg</button>
              <p>$quantity i lager</p>
            </div>
          </article>";
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