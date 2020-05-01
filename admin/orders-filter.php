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

  <div class="nav__admin">
    <form action="">
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