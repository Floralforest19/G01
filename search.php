<?php
/**************************************** *
 * let's user search for products
 * returns relevant products from db
**************************************** */
 require_once 'db.php';
 require_once 'header.php';
?>
  <div class="box__search--form">
    <h1>Sök</h1>
    <form name="searchForm" action="search.php" onsubmit="return validateForm('searchForm','input','feedback')" method="post" class="search__form">
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
 <script src="validateinput.js"></script>