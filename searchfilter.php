<?php
/**************************************** *
 * returns products from db who meets criteria
 * checks if their are any results from search
 * if none exists, shows feedback to user instead of products
**************************************** */

// check if user has made an search
if(isset($_POST['input']) ){

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
  
  // filter from user input
  $filter = htmlspecialchars($_POST['input']);
  echo "<div class='box__search--form'><h3>Visar resultat för: $filter</h3></div>
  <div class='product__wrapper'>";
  // prepare and execute sql request
  $sql  = "SELECT *  FROM `product` WHERE `name` LIKE '%$filter%' ORDER BY `name` ASC";  
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $result = false;  
  $productsFound = 0;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
    // if any results, print to user
    $result = true;
    // product exist in database
    $productsFound++;
    $name        = htmlspecialchars($row['name']);
    $price       = htmlspecialchars($row['price']);
    $id          = htmlspecialchars($row['product_id']);
    $description = htmlspecialchars($row['description']);
    $quantity    = htmlspecialchars($row['quantity']);
    $image       = htmlspecialchars($row['image_file_name']);
    // if no image show other image
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
    if($quantity > 0){
      if($quantity < 10){
        $priceText = "<a href='showproduct.php?id=$id'><p class='sale__old'>$price kr</p></a>
        <a href='showproduct.php?id=$id'><p class='sale__new'>".number_format($price*0.9,2)." kr</p></a>";
      } else {
        $priceText = "<a href='showproduct.php?id=$id'><p class=''>$price kr</p></a>";
      }
    // product exist and in db and is in storage, show result
    echo "<article class='box' style='position:relative;'>
            <div class='box__pic'>
              <a href='showproduct.php?id=$id'><img src='./images/$image' alt='$name'/></a>
            </div>
            <div class='box__text'>
            ";
            // nya varor
            if($id == $newProdIds[0] || $id == $newProdIds[1] || $id == $newProdIds[2]){
              echo "<a href='showproduct.php?id=$id'><img src='./images/new.png' style='max-width:80px; position: absolute;top: 0;left: 0; rotate:-21deg;'></a>";
            } 
            // reavaror
            if($quantity < 10){ 
              echo "<a href='showproduct.php?id=$id'><img src='./images/sale.png' style='max-width:80px; position: absolute;top: 0;left: 0; rotate:-21deg;'></a>";
            }
              echo "<a href='showproduct.php?id=$id'><h3>$name</h3></a>
              $priceText
              <a href='showproduct.php?id=$id'>Läs mer</a>
              <p>$quantity i lager</p><br>
            </div>
          </article>";
    } else {
      // product exist in db but is out of storage, do NOT show result
      $productsFound--;
    }
    endwhile;
    // if no results where found, or results where out of storage, show feedback to user
    if( $result == false || $productsFound == 0 ){
      echo '<div class="box__search--form"><p>Tyvärr, inga resultat hittades!</p></div>';
    }
} else {
  // if no search yet, prompt user to search
  echo '<div class="box__search--form"><h3>Ange en sökterm</h3></div>';
}
echo "</div>";