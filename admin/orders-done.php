<table id="tableOutput" class="table"></table>
<?php
/**************************************** *
 * read info from db & display active/in progress orders
 * edit status with select
**************************************** */
  require_once 'header-admin.php';
  require_once '../db.php';
?>

<section class='background'>
  <h2>Avslutade beställningar</h2>
  <div class="box__cat--form">

  <div class="nav__admin">
    <form>
      <input type="text" name="filterCity" id="filterInput" class="input__filter" placeholder="Filtrera efter stad...">
      <p class="sortFeedback"></p>
    </form>
  </div>

  <!-- tabell med ordrar -->
  <div class="nav__admin" id="table_div"></div>

  </div>
</section>

<script src="../js/filter-orders-done.js"></script>

</body>
</html>
