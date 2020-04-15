<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="styles/style.css">
  <title>Kris&Ros</title>
</head>
<body>
  <h1>Kris & Ros</h1>
      <header id="header" class="header">
        <div id="header-top" class="header-top">

            <img class="header-logo-main" src="images\Skärmklipp.PNG" alt="temp logo">

            <input class="header-search" type="search" name="header-search" id="header-search" placeholder="Search...">

            <div class="header-button">
                <a class="header-button-a" href="">
                    <img class="header-logo-button" src="./images/phone.png" alt="Phone">
                    <p>Contact</p>
                </a>
                <a class="header-button-a" href="">
                    <img class="header-logo-button" src="./images/shoppingcart.png" alt="Shopping cart">
                    <p>Cart</p>
                </a>
            </div>

        </div>

        <nav class="header-nav">
            <a class="header-nav-active" href="">Home</a>
            <a href="/Applications/MAMP/htdocs/G01/products.html">Products</a>
            <a href="">About</a>
            <a href="">Contact</a>
            <a href="">Basket</a>
        </nav>
    </header>
    <script src="header.js"></script>


  <?php 
  require_once 'read.php'
  ; 
  ?>
</body>
</html>