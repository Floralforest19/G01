<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles\style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Webshop v4.0</title>
</head>
<body>
<header id="header" class="header">


    <div id="header-top" class="header-top">
        <a href="index.php"><img id="header-logo-main" class="header-logo-main" src="images/logga.png" alt="temp logo"></a>
    </div>

    <div id="header-nav" class="header-nav">
        <div id="header-nav-1" class="bar1"></div>
        <div id="header-nav-2" class="bar2"></div>
        <div id="header-nav-3" class="bar3"></div>

        <div id="dropdownMenu" class="dropdown-content">
            <a href="index.php">Hem</a>
            <?php 
                    require_once 'db.php';
                    $sql2 = "SELECT * FROM category
                    ORDER BY name";
                    $stmt2 = $db->prepare($sql2);
                    $stmt2->execute();
                    $navLinks = "<a href='index.php?id=all'>Alla produkter</a> 
                    <a href='new.php'>Nyheter</a>
                    <a href='lastchance.php'>Sista chansen</a>";
                    while( $row2 = $stmt2->fetch(PDO::FETCH_ASSOC) ){
                      $name2 = $row2['name'];
                      $id2 = $row2['category_id'];
                      $navLinks .= "<a href='index.php?id=$id2'>$name2 </a>";
                    }
                    echo $navLinks;
            ?>
        </div>
    </div>

    <div class="search-feedback-wrapper">
    <form class="header-search" name="searchBarForm" action="search.php" onsubmit="return validateForm('searchBarForm','input','feedbackBar')" method="post">
        <input id="header-search" class="header-search-bar searchInput" type="search" name="input" placeholder="Sök...">
    </form>
      <p id="feedbackBar" class="search__feedback margin-no"></p>

    <a class="header-button-a header-button-contact" href="">
        <img class="header-logo-button" src="./images/phone.png" alt="Phone">
        <p>Contact</p>
    </a>
    </div>

    <a class="header-button-a header-button-cart" href="cart.php">
        <img class="header-logo-button" src="./images/shoppingcart.png" alt="Shopping cart">
        <span id="updateCart">(0)</span>
        <p>Cart</p>
    </a>

    <a id="goTop" class="goTop" href="#"><img class="goTop-img" src="./images/goTop.svg" alt="Go top arrow"></a>
</header>

<div class="category_menu">
    <?php 
            require_once 'db.php';
            $sql2 = "SELECT * FROM category
            ORDER BY name";
            $stmt2 = $db->prepare($sql2);
            $stmt2->execute();
            $navLinks = "<a href='index.php?id=all'>Alla produkter</a> 
            <a href='new.php'>Nyheter</a>
            <a href='lastchance.php'>Sista chansen</a>";
            while( $row2 = $stmt2->fetch(PDO::FETCH_ASSOC) ){
              $name2 = $row2['name'];
              $id2 = $row2['category_id'];
              $navLinks .= "<br> <a href='index.php?id=$id2'>$name2 </a>";
            }
            echo $navLinks;
    ?>
</div>

<main id="main">
<script src="header.js"></script>
<script src="validateinput.js"></script>
