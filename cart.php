<?php
require_once 'header.php';
?>

<div class="shoppingcart-container">
    <h2>Kassa</h2>
    <div class="shoppingcart-products-container">
        <div class="shoppingcart-product-container">
            <div class="shoppingcart-product-img">
                <img src="" alt="" />Produktens bild
            </div>

            <div class="shopppingcart-product-text">
                <h3>Produktens namn</h3>
            </div>

            <div class="shopppingcart-product-chosen-quantity">
                <h3>Produktens antal</h3>
            </div>

            <div class="shopping-cart-product-sum">
                <p>Produktens totalsum</p>
            </div>

            <div class="shoppingcart-remove-button">
                <button class="remove-button">X</button>
            </div>
        </div>
        <!--slut på shoppingcart-product-container-->

        <div class="shoppingcart-empty-cart">
            <button class="empty-cart-button">Töm hela varukorgen</button>
        </div>

        <div class="shoppingcart-totalprice-text">TOTALSUMMA</div>
    </div>
    <!--slut på shoppingcart-products-container-->

    <button class="buy-button">Gå vidare</button>
</div>

<!--slut på shoppingcart container-->

<?php
    require_once 'footer.php';
    ?>
</body>

</html>