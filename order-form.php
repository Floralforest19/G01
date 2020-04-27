<?php
require_once 'header.php';
?>


    <section class="contact-form">
    <h2 class="contact-form-heading">Din beställning</h2>

    <!-- Här läggs en liten sammanfattning in om beställningen, tex totalsumman -->
    <table id='dispItems' class='display__order-items'></table>

        <h2 class="contact-form-heading">Dina uppgifter</h2>
        <form action="order-send.php" method="POST">
            <div class="contact-form-container">
                <div>
                
                    <label for="firstname">Förnamn</label>
                    <input type="text" name="firstname" id="firstname" placeholder="Ange ditt förnamn" required />

                    <label for="surname">Efternamn</label>
                    <input type="text" name="surname" id="surname" placeholder="Ange ditt efternamn" required />

                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" placeholder="Ange din email" required />

                    <label for="phone">Mobil</label>
                    <input type="text" name="phone" id="phone" placeholder="Ange ditt mobilnummer" required />

                    <label for="address">Adress</label>
                    <input type="text" name="address" id="address" placeholder="Ange din adress" required />

                    <label for="zip">Postnummer</label>
                    <input type="text" name="zip" id="zip" placeholder="Ange ditt postnummer" required />

                    <label for="city">Postort</label>
                    <input type="text" name="city" id="city" placeholder="Ange din postadress" required />
                    
                </div>
                <!-- send order info with post -->
            <div class="contact-form-submit">
                <button class="contact-form-button" type="submit">Skicka beställning</button>
            </div>
                <div id="orderItems"></div>
        </form>
        <br>
    </section>

    <script src="js/order-show-items.js"></script>
    <script src="js/order-send-items.js"></script>

<?php

require_once 'footer.php';
?>

