<!-- Använder en temporär header för att få in CSS på sidan -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" type="text/css" href="styles/style.css" />
  <link
      href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap"
      rel="stylesheet"
  />
  <title>Webbshop</title>

<?php 

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

?>