<?php
require_once 'header.php';
?>

<a href="cart.php"><i class="fa fa-shopping-cart"></i> <span id="updateCart"> (0)</span></a>

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