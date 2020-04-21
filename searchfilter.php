<?php
/**************************************** *
 * returns products from db who meets criteria
 * checks if their are any results from search
 * if none exists, shows feedback to user instead of products
**************************************** */

if(isset($_POST['input']) ){
  // filter from user input
  $filter = htmlspecialchars($_POST['input']);
  echo "<div class='box__search--form'><h3>Visar resultat för: $filter</h3></div>";
  // prepare and execute sql request
  $sql = "SELECT *  FROM `product` WHERE `name` LIKE '%$filter%' OR `keywords` LIKE '%$filter%' ORDER BY `name` ASC";  
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $result = false;  
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
    // if any results, print to user
    $result = true;
    $name = htmlspecialchars($row['name']);
    $price = htmlspecialchars($row['price']);
    $id = htmlspecialchars($row['product_id']);
    $description = htmlspecialchars($row['description']);
    $image = htmlspecialchars($row['image_file_name']);

    if(empty($image)){
      $image = 'toalettpapper.jpg';
    }
    echo "<article class='box__search'>
            <div class='box__pic--search'>
              <img src='./images/$image' alt='$name'/>
            </div>
            <div class='box__text--search'>
              <h3>$name</h3>
              <p>$price kr</p>
              <p>$description</p>
              <a href='showproduct.php?id=$id'>Läs mer</a><br>";
              // lägga till när vi introducerar varukorg
              // <button>Lägg i varukorg</button>
              //<a href='#' class='product__btn'>Köp</a>
              echo "
            </div>
          </article>"; 
    endwhile;
    // if no results where found, feedback to user
    if( $result == false ){
      echo '<div class="box__search--form"><p>Tyvärr, inga resultat hittades!</p></div>';
    }

} else {
  echo '<div class="box__search--form"><h3>Ange en sökterm</h3></div>';
}