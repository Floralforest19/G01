<?php
/**************************************** *
 * returns products from db who meets criteria
**************************************** */

if(isset($_POST['input']) ){
  // filter from user input
  $filter = htmlspecialchars($_POST['input']);
  echo "<h3>Visar resultat för: $filter</h3>";
  
  // prepare and execute sql request
  $sql = "SELECT * FROM product 
  WHERE description LIKE '%$filter%' OR name LIKE '%$filter%'
  ORDER BY name";
  $stmt = $db->prepare($sql);
  $stmt->execute();

  // print all relevant rows
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
  $name = htmlspecialchars($row['name']);
  $price = htmlspecialchars($row['price']);
  $id = htmlspecialchars($row['product_id']);
  echo "
    <article class='box__search'>
      <div class='box__pic'>
        <img src='./images/toalettpapper.jpg' alt='toalettpapper'/>
      </div>
      <div class='box__text--'>
        <h3>$name</h3>
        <p>$price kr</p>
        <a href='showproduct.php?id=$id'>Läs mer</a><br>";
        // läs mer bör gå till produktsidan
        // lägga till när vi introducerar varukorg
        // <button>Lägg i varukorg</button>
        //<a href='#' class='product__btn'>Köp</a>
        echo "
      </div>
    </article>"; 
  endwhile;

  echo "</table>";
}
else {
  echo "<h3>Ange en sökterm</h3>";
}