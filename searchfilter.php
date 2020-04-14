<?php
/**************************************** *
 * returns products from db who meets criteria
**************************************** */

  $filter = htmlspecialchars($_POST['input']);

  echo "<p>Visar resultat för: $filter</p>";

  $sql = "SELECT * FROM product 
  WHERE description LIKE '%$filter%' OR name LIKE '%$filter%'
  ORDER BY name";
  $stmt = $db->prepare($sql);
  $stmt->execute();

  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
    $name = htmlspecialchars($row['name']);
    $price = htmlspecialchars($row['price']);
    echo "<tr>
            <td>BILD</td>
            <td>$name</td>
            <td>$price kr</td>
          </tr>"; 
  endwhile;
?>