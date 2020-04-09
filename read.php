<?php
/**************************************** *
 * read info from db & display posts
 * different sql-orders depending on which link pushed
 * filters according to categories
**************************************** */

  // koppla till databas
  require_once 'db.php';

  if(isset($_GET['id'])){
    $id = htmlentities($_GET['id']);
    if($id == 'mat'){
      $sql = "SELECT * FROM products 
              WHERE category = 'mat'
              ORDER BY name";
    } elseif($id == 'hygien'){
      $sql = "SELECT * FROM products 
              WHERE category = 'hygien'
              ORDER BY name";
    } elseif($id == 'alla'){
      $sql = "SELECT * FROM products 
              ORDER BY name";
    } elseif($id == 'blommor'){
      $sql = "SELECT * FROM products 
              WHERE category = 'blommor'
              ORDER BY name";
    }
  } else {
    $sql = "SELECT * FROM products 
            ORDER BY name";
  }

  $stmt = $db->prepare($sql);
  $stmt->execute();

  // starta div för inlägg
  echo "<div class='container'>";
  // loopar över arrayen som har resultatet från db
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
      // spara data från db i varsin variabel
      $id = htmlspecialchars($row['productID']); // $row = array
      $heading = htmlspecialchars($row['name']);
      $description = htmlspecialchars($row['description']);
      $category = strtoupper(htmlspecialchars($row['category']));
      $storage = htmlspecialchars($row['storage']);
      if($storage > 0){
        $storageText = "Antal i lager - ".$storage;
      } else {
        $storageText = "Ej i lager";
      }
      echo "<br>
        <div class='products__container'>
          <div class='products__item'>
            <p class=''>$category</p>
            <h2>$heading</h2>
            <p>$description</p>
            <p class=''>$storageText</p>
          </div>
        </div>
        <br>
        "; 
  // avsluta while loop
  endwhile;
// stäng post div
  echo "</div>";