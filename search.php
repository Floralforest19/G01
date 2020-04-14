<?php
/**************************************** *
 * let's user search for products
 * returns relevant products from db
**************************************** */
 require_once 'db.php';
?>

<h1>Sök</h1>

<form name="searchForm" action="#" onsubmit="return validateForm()" method="post">
  <input type="text" name="input">
  <input type="submit" value="Sök">
</form>

<p id="feedback"></p>

<table id="products">
  <thead>
    <td>Bild</td>
    <td>Produkt</td>
    <td>Pris</td>
  </thead>

<?php require_once 'searchfilter.php'; ?>

</table>

<script type="application/javascript" src="searchvalidate.js"></script>