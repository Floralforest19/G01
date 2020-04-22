<?php
require_once 'header.php';
?>

    <section class="contact-form">
    <h2 class="contact-form-heading">Din beställning</h2>
    <!-- Här läggs en liten sammanfattning in om beställningen, tex totalsumman -->


        <h2 class="contact-form-heading">Dina uppgifter</h2>
        <form action="order-process.php" method="POST">
            <div class="contact-form-container">
                <div>
                
                    <!-- id för att testa nå databasen, detta ska inte vara med sen -->
                    <label for="customer_id">id</label>
                    <input type="text" name="customer_id" placeholder="Ange ditt id" required />

                    <label for="fname">Förnamn</label>
                    <input type="text" name="firstname" placeholder="Ange ditt förnamn" required />

                    <label for="lname">Efternamn</label>
                    <input type="text" name="lname" id="lname" placeholder="Ange ditt efternamn" required />

                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" placeholder="Ange din email" required />

                    <label for="mobile">Mobil</label>
                    <input type="text" name="mobile" id="mobile" placeholder="Ange ditt mobilnummer" required />

                    <label for="address">Adress</label>
                    <input type="text" name="address" id="address" placeholder="Ange din adress" required />

                    <label for="zip">Postnummer</label>
                    <input type="text" name="zip" id="zip" placeholder="Ange ditt postnummer" required />

                    <label for="city">Postort</label>
                    <input type="text" name="city" id="city" placeholder="Ange din postadress" required />
                    
                </div>
            <div class="contact-form-submit">
                <button class="contact-form-button" type="submit">Skicka beställning</button>
            </div>
        </form>
    </section>

<?php

require_once 'footer.php';
?>

