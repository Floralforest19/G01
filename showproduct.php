<?php 
    require_once 'header.php';
    require_once 'db.php';

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

    $id   = htmlspecialchars($_GET['id']);
    $sql  = "SELECT * FROM product WHERE product_id=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row  = $stmt->fetch(PDO::FETCH_ASSOC);

    $id          = htmlspecialchars($row['product_id']);
    $name        = htmlspecialchars($row['name']);
    $description = htmlspecialchars($row['description']);
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
    $imageCount = count($imageArray)-1;
    $skrivImage = "";

    // Om bild-array har mer än ett värde är det första bilden som blir primär, sorteras i bokstavsordning.
    if ($imageCount > 1) {
      $image = $imageArray[0];
      
      $skrivImage = "";
      for ($i=0; $i < $imageCount; $i++) { 
        $skrivImage .= "<img src='./images/$imageArray[$i]'/>";
      }
    }
    // rea varor
    if($quantity < 10){
      $priceText = "<p class='sale__old'>$price kr</p>
      <p class='sale__new'>".number_format($price*0.9,2)." kr</p>";
    } else {
      $priceText = "<h4>$price kr</h4>";
    }    
    // Skriver ut produkten. OBS Endast 1 bild visas nu
  $thisPost = "
      <section class='background'>
      <h2>$name</h2>
      
      <article class='single__product__wrapper'>
      <div class='container'>
        
      <div class='single__product__pic main-img'>
          <img src='./images/$image' alt='$name' id='current' />
        </div>
        
        <div class='imgs'>
          $skrivImage
        </div>

        </div>

          <div class='single__product__text'>
            <input type='hidden' class='product-id' value='$id'/>
            <input type='hidden' class='product-name' value='$name'/>         
            <input type='hidden' class='product-price' value='$price'/>
            <input type='hidden' class='product-image' value='$image'/>
            <input type='hidden' class='product-sale' value='$quantity'/>
            ";
            // nya varor
            if($id == $newProdIds[0] || $id == $newProdIds[1] || $id == $newProdIds[2]){
              $thisPost .=  "<a href='showproduct.php?id=$id'><h2>Nyhet!</h2></a>";
            } 
            $thisPost .= "<h3>$name</h3>
            <p>$description</p>
            <p>Pris:</p>
            $priceText
            <p><input type='number' class='product-quantity' min='1' max='$quantity' value='1'/></p>
            <button class='add-to-cart'>Lägg i varukorg</button>
            <p>I lager: $quantity st</p>
          </div>
          
        </article>
      </section>";

echo $thisPost;

require_once 'footer.php';
?>

<script type="text/javascript" src="js/shoppingcartvalidate.js"></script>
<script type="text/javascript" src="js/cart-localstorage.js"></script>
<script type="text/javascript" src="js/cart-add-product.js"></script>
<script type="text/javascript" src="js/product-gallery.js"></script>

<script type="text/javascript">
//Vänta tills allt har laddats, då kör funktionen (som jquery document.ready())
window.onload = function() {
    setAddProductToCartClickEvent();
}
</script>