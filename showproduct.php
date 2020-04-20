<?php 
    require_once 'header.php';
    require_once 'db.php';

    $id = htmlspecialchars($_GET['id']);
    $sql = "SELECT * FROM product WHERE product_id=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $id = htmlspecialchars($row['product_id']);
    $name = htmlspecialchars($row['name']);
    $description = htmlspecialchars($row['description']);
    $quantity = htmlspecialchars($row['quantity']);
    $price = htmlspecialchars($row['price']);


  $thisPost = "
      <section class='background'>
        <h2>$name</h2>
        <article class='single__product__wrapper'>
          <div class='single__product__pic'>
            <img src='./images/toalettpapper.jpg' alt='toalettpapper' />
          </div>
          <div class='single__product__text'>
            <p>$description</p>
            <h2>Pris: $price sek</h2>
            <h3>I lager: $quantity st</h3>
            <button>Lägg i varukorg</button>
          </div>
        </article>
      </section>";

echo $thisPost;

require_once 'footer.php';
?>