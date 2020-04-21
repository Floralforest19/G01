<?php 
  // skriva ut på samma sätt som orderbekrftelse? Lägga till status bara
    require_once 'header-admin.php';
    require_once '../db.php';

    $id = htmlspecialchars($_GET['id']);
    // hämta från beställningar istället
    $sql = "SELECT * FROM product WHERE product_id=$id";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $name = htmlspecialchars($row['name']);
    $description = htmlspecialchars($row['description']);


  $thisPost = "<section class='background'><div class='box__cat--form'>
  <table class='table'>
  <thead>
  <th>Namn</th>
  <th>Beskrivning</th>
  <th>Status</th>
  <th></th>
</thead>
    <tr>
      <td><a href='showorder.php?id=$id'><h3>$name</h3></a></td>
      <td><p>$description</p></td>
      <td><p>Status</p></td>
      <td><a href='showorder.php?id=$id'><button class='btn__edit'>Arkivera</button></a></td>
      </tr>
    </table>
  </div></section>";

echo $thisPost;

?>