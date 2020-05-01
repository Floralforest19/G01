<?php
require_once 'header.php';
?>

<section class="contact-form">
    <h2 class="contact-form-heading">Kontakta oss</h2>
    <form name="contact-form" action="contact-send.php" method="POST">
        <div class="contact-form-container">
            <div>
                <label for="name">Namn</label>
                <input type="text" name="name" id="name" placeholder="Ange ditt namn" required />

                <label for="email">Email</label>
                <input type="text" name="email" id="email" placeholder="Ange din email" required />

                <label for="email">Mobil</label>
                <input type="text" name="mobile" id="mobile" placeholder="Ange din mobil" required />
            </div>

            <div>
                <label for="message">Meddelandet</label>
                <textarea name="message" id="message" required cols="50" rows="14"></textarea>
            </div>
        </div>
        <div class="contact-form-submit">
            <button class="contact-form-button" type="submit">Skicka nu</button>
        </div>
    </form>
</section>
<?php
require_once 'footer.php';
?>
</body>

</html>