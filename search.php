<?php
/**************************************** *
 * let's user search for products
 * returns relevant products from db
**************************************** */
 require_once 'db.php';
?>
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
</head>
<body>
<ul>
  <li><a href="index.php">Hem</a></li>
  <li><a href="search.php">Sök</a></li>
  <li><a href="contact.php">Kontakt</a></li>
</ul>

<main>
  
  <div class="box__search--form">
    <h1>Sök</h1>
    <form name="searchForm" action="search.php" onsubmit="return validateForm()" method="post" class="search__form">
      <input type="text" name="input" placeholder="Sök..." class="search__input">
      <input type="submit" value="Sök" class="search__submit contact-form-button">
    </form>
    <p id="feedback" class="search__feedback"></p>
  </div>

<section class='background'>
  <?php require_once 'searchfilter.php';
  require_once 'footer.php'; ?>
</section>

 </main>
</body>
</html>
 <script src="searchvalidate.js"></script>