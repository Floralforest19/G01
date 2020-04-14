<?php
/**************************************** *
 * returns products from db who meets criteria
**************************************** */

if(isset($_POST['input'])){

  echo "<table id='products' class='table__box'>
  <thead class='table__head'>
    <th class='table__th'>Bild</th>
    <th class='table__th'>Produkt</th>
    <th class='table__th'>Pris</th>
  </thead>";

  // använder $filter som filter värde för att hämta från db
  $filter = htmlspecialchars($_POST['input']);

  echo "<h3>Visar resultat för: $filter</h3>";

  $sql = "SELECT * FROM product 
  WHERE description LIKE '%$filter%' OR name LIKE '%$filter%'
  ORDER BY name";
  $stmt = $db->prepare($sql);
  $stmt->execute();

  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
    $name = htmlspecialchars($row['name']);
    $price = htmlspecialchars($row['price']);
    echo "<tr class='table__row'>
            <td class='table__img'>BILD</td>
            <td class='table__data'>$name</td>
            <td class='table__data'>$price kr</td>
          </tr>"; 
  endwhile;

  echo "</table>";
}
else {
  echo "<h3>Ange en sökterm</h3>";
}

?>