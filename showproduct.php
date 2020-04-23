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
    $image = htmlspecialchars($row['image_file_name']);

    // Om det inte finns en bild läggs det upp en dummy
    if(empty($image)){
      $image = 'toalettpapper.jpg';
    }

    // Delar upp bild-strängen till en array
    $imageArray = explode(" * ", $image);

    // Kollar om bild-array har mer än ett värde
    $imageCount = count($imageArray);

    // Om bild-array har mer än ett värde är det första bilden som blir primär, sorteras i bokstavsordning.
    if ($imageCount > 1) {
      $image = $imageArray[0];
    }

    // Skriver ut produkten. OBS Endast 1 bild visas nu
  $thisPost = "
      <section class='background'>
        <h2>$name</h2>
        <article class='single__product__wrapper'>
          <div class='single__product__pic'>
            <img src='./images/$image' alt='$name' />
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