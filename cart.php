<?php
require_once 'header.php';
?>

<?php
  require_once 'db.php';

  $sql  = "SELECT * FROM product ORDER BY name";
  $stmt = $db->prepare($sql);
  $stmt->execute();

//skriv ut lagerstatus i hidden inputs för att använda vid validering
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
    // spara data från db i varsin variabel
    $id       = htmlspecialchars($row['product_id']);
    $quantity = htmlspecialchars($row['quantity']);
      
    echo "<input type='hidden' id='product-$id' value='$quantity'/>";

    // avsluta while loop
    endwhile;
?>



<section class='background'>
    <div class='menu__categories'>
        <table id="dispCart" class="table"></table>
    </div>
</section>

<div id="emptyCart"></div>

<script type="text/javascript" src="js/cart-localstorage.js"></script>
<script src="js/cart-show-all-items.js"></script>

<?php 
require_once 'footer.php';
?>

<script type="text/javascript">
//Vänta tills allt har laddats, då kör funktionen (som jquery document.ready())
/*window.onload = function() {
    setUpPlusQuantityClickEvent();
}*/
</script>

</body>

</html>