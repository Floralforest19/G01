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
  <h2>Aktiva beställningar</h2>
  <div class="box__cat--form">

    <button class='btn__sortStatus btn__sortStatus--active' id="statusAll">Alla</button>
    <button class='btn__sortStatus'  id="statusNew">Nya</button>
    <button class='btn__sortStatus' id="statusActive">Behandlas</button>

  <div class="nav__admin">
    <form>
      <input type="text" name="filterCity" id="filterInput" placeholder="Filtrera efter stad">
    </form>
  </div>

  <!-- tabell med ordrar -->
  <div class="nav__admin" id="table_div"></div>

  </div>
</section>


<script src="../js/filter-orders.js"></script>

</body>
</html>
