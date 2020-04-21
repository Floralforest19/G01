<?php 
  require_once 'header-admin.php'; 
  require_once '../db.php';
?>


<section class='background'>

  <h2>Beställningar</h2>
  <div class='box__cat--form'>
    <a href='orders.php?id=name'>Sortera på namn</a>
    <a href='orders.php?id=id'>Sortera på id</a>

<?php

  if(isset($_GET['id'])){
    $id = htmlentities($_GET['id']);
    // hämta från beställningar istället
    if($id == 'name'){
      $sql = "SELECT * FROM product
              ORDER BY name";
    } elseif($id == 'id'){
      $sql = "SELECT * FROM product
              ORDER BY category_id";
    }
  } else {
    $sql = "SELECT * FROM product
            ORDER BY name";
  }
  $stmt = $db->prepare($sql);
  $stmt->execute();

  $tableOrders = "
  <table class='table'>
    <tr>
      <th>Namn</th>
      <th>Beskrivning</th>
      <th>Status</th>
      <th></th>
    </tr>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
      $name = htmlspecialchars($row['name']);
      $id = htmlspecialchars($row['category_id']);
      $description = htmlspecialchars($row['description']);
      $tableOrders.= "<tr>
        <td><a href='showorder.php?id=$id'><h3>$name</h3></a></td>
        <td><p>$description</p></td>
        <td><p>Status</p></td>
        <td><a href='showorder.php?id=$id'><button class='btn__edit'>Arkivera</button></a></td>
      </tr>";
    endwhile;
    $tableOrders .= "</table></div>";
    echo $tableOrders;
  ?>
  </section>
  
</section>
</body>
</html>