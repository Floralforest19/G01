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

    <button class='btn__edit' id="statusAll">Alla</button>
    <button class='btn__edit'  id="statusNew">Nya</button>
    <button class='btn__edit' id="statusActive">Behandlas</button>


  <!-- <div class="nav__admin">
    <form id="statusForm">
      <input type="radio" id="new" name="status" value="new">
      <label for="new">Nya </label>
      <input type="radio" id="active" name="status" value="active">
      <label for="active">Behandlas </label>
      <input type="radio" id="both" name="status" value="both">
      <label for="both">Visa alla</label>
    </form>
  </div> -->

  <div class="nav__admin">
    <form>
      <input type="text" name="filterCity" id="filterInput" placeholder="Filtrera efter stad">
    </form>
  </div>

  <div class="nav__admin" id="table_div">
    <table id="tableOutput"></table>
  </div>

  </div>
</section>
  

<script src="../js/filter-orders2.js"></script>

</body>
</html>