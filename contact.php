<?php
require_once 'header.php';
?>

<section class="contact-form">
    <h2 class="contact-form-heading">Kontakta oss</h2>
    <form name="contact-form" action="contact-send.php" method="POST" onsubmit="return validateAll()">
        <div class="contact-form-container">
            <div>
                <label for="name">Namn</label>
                <input type="text" name="name" id="name" placeholder="Ange ditt namn" />
                <div id="contactNameFeedback" style="color:#eb4b88"></div>

                <label for="email">Email</label>
                <input type="text" name="email" id="email" placeholder="Ange din email" />
                <div id="contactEmailFeedback" style="color:#eb4b88"></div>

                <label for="mobile">Mobil</label>
                <input type="text" name="mobile" id="mobile" placeholder="Ange din mobil" />
                <div id="contactMobileFeedback" style="color:#eb4b88"></div>
            </div>

            <div>
                <label for="message">Meddelandet</label>
                <textarea name="message" id="message" cols="50" rows="14"></textarea>
                <div id="contactMessageFeedback" style="color:#eb4b88"></div>
            </div>
        </div>
        <div class="contact-form-submit">
            <button class="contact-form-button" type="submit">Skicka nu</button>
        </div>
    </form>
</section>


<script src="validateinput.js"></script>

<script>
function validateAll() {
    let isAllValidated = true;
    let contactNameValidated = validateTextInput('contact-form', 'name', 'contactNameFeedback');
    if (contactNameValidated == false) {
        isAllValidated = false;
    }

    let contactEmailValidated = validateEmail('contact-form', 'email', 'contactEmailFeedback');
    if (contactEmailValidated == false) {
        isAllValidated = false;
    }

    let contactMobileValidated = validatePhonenumber('contact-form', 'mobile', 'contactMobileFeedback')
    if (contactMobileValidated == false) {
        isAllValidated = false;
    }

    let contactMessageValidated = validateTextarea('contact-form', 'message', 'contactMessageFeedback');
    if (contactMessageValidated == false) {
        isAllValidated = false;
    }


    if (isAllValidated == false) {
        return false;
    }
    return true;
}
</script>
<?php
require_once 'footer.php';
?>
</body>

</html>