<?php
/**************************************** *
 * let's user search for products
 * returns relevant products from db
**************************************** */
 require_once 'db.php';
?>
<h1>Sök</h1>

<form name="searchForm" action="search.php" onsubmit="return validateForm()" method="post" class="search__form">
  <input type="text" name="input" placeholder="Sök..." class="search__input">
  <input type="submit" value="Sök" class="search__submit">
</form>

<p id="feedback" class="search__feedback"></p>

<?php 
  // gets filtered product from db
  require_once 'searchfilter.php'; 
 ?>
 <script src="searchvalidate.js"></script>