<?php
require_once 'header.php';
?>

<section class="contact-form">
    <h2 class="contact-form-heading">Din beställning</h2>

    <!-- Här läggs en liten sammanfattning in om beställningen, tex totalsumman -->
    <table id='dispItems' class='display__order-items'></table>

    <h2 class="contact-form-heading">Dina uppgifter</h2>
    <form name="orders-form" action="order-send.php" method="POST" onsubmit="return validateAll()">
        <div class="order-form-container">
            <div class="contact-form-objects">

                <label for="firstname">Förnamn</label>
                <input type="text" name="firstname" id="firstname" placeholder="Ange ditt förnamn" />
                <div id="firstnameFeedback" style="color:#eb4b88"></div>

                <label for="surname">Efternamn</label>
                <input type="text" name="surname" id="surname" placeholder="Ange ditt efternamn" />
                <div id="surnameFeedback" style="color:#eb4b88"></div>

                <label for="email">Email</label>
                <input type="text" name="email" id="email" placeholder="Ange din email" />
                <div id="emailFeedback" style="color:#eb4b88"></div>

                <label for="phone">Mobil</label>
                <input type="text" name="phone" id="phone" placeholder="Ange ditt mobilnummer" />
                <div id="phoneFeedback" style="color:#eb4b88"></div>

                <label for="address">Adress</label>
                <input type="text" name="address" id="address" placeholder="Ange din adress" />
                <div id="addressFeedback" style="color:#eb4b88"></div>

                <label for="zip">Postnummer</label>
                <input type="text" name="zip" id="zip" placeholder="Ange ditt postnummer" />
                <div id="zipFeedback" style="color:#eb4b88"></div>

                <label for="city">Postort</label>


                <input type="text" name="city" id="city" placeholder="Ange din postadress" required
                   autocomplete="off" onkeyup="getProducts(this.value)" onclick="getProducts(this.value)" />
                <div id="cityFeedback" style="color:#eb4b88"></div>

                <label for="leverans">Annan leveransaddress?</label>
                <input type="checkbox" id="leverans" name="lev" value="on" onclick="otherAddress()">

                <div id="checked" style="display:none">

                    <label for="address2">Leveransadress</label>
                    <input type="text" name="address2" id="address2" placeholder="Ange leveransadress" />
                    <div id="address2Feedback" style="color:#eb4b88"></div>


                    <label for="zip2">Postnummer</label>
                    <input type="text" name="zip2" id="zip2" placeholder="Ange postnummer" />
                    <div id="zip2Feedback" style="color:#eb4b88"></div>

                    <label for="city2">Postort</label>
                    <input type="text" name="city2" id="city2" placeholder="Ange postort"

                       autocomplete="off" onkeyup="getProducts(this.value)" onclick="getProducts(this.value)" />
                        onkeyup="calcShippingFee(this.value, 0, 'shippingFee')"
                        onclick="calcShippingFee(this.value,'shippingFee')" />
                    <div id="city2Feedback" style="color:#eb4b88"></div>


                </div>
            </div>
            <!-- send order info with post -->
            <div class="contact-form-submit">
                <button class="contact-form-button send-order-btn" type="submit">Skicka
                    beställning</button>
            </div>
            <div id="orderItems"></div>
            <!-- skickar json info till db -->
            <input type="hidden" name="order_info" id="order_info" value='' />
    </form>
    <br>
</section>

<script src="validateinput.js"></script>
<script src="js/shippingfee.js"></script>
<script src="js/order-show-items.js"></script>
<script src="js/order-send-items.js"></script>
<script src="other-address.js"></script>
<script src="js/save-order-info.js"></script>

<script>
function validateAll() {
    let isAllValidated = true;
    let firstnameValidated = validateTextInput('orders-form', 'firstname', 'firstnameFeedback');
    if (firstnameValidated == false) {
        isAllValidated = false;
    }

    let surnameValidated = validateTextInput('orders-form', 'surname', 'surnameFeedback');
    if (surnameValidated == false) {
        isAllValidated = false;
    }

    let emailValidated = validateEmail('orders-form', 'email', 'emailFeedback')
    if (emailValidated == false) {
        isAllValidated = false;
    }

    let phoneValidated = validatePhonenumber('orders-form', 'phone', 'phoneFeedback');
    if (phoneValidated == false) {
        isAllValidated = false;
    }

    let addressValidated = validateTextInput('orders-form', 'address', 'addressFeedback');
    if (addressValidated == false) {
        isAllValidated = false;
    }

    let zipValidated = validateTextInput('orders-form', 'zip', 'zipFeedback');
    if (zipValidated == false) {
        isAllValidated = false;
    }

    let cityValidated = validateTextInput('orders-form', 'city', 'cityFeedback');
    if (cityValidated == false) {
        isAllValidated = false;
    }

    let checkBox = document.getElementById("leverans");
    // If the checkbox is checked
    if (checkBox.checked == true) {
        let address2Validated = validateTextInput('orders-form', 'address2', 'address2Feedback');
        if (address2Validated == false) {
            isAllValidated = false;
        }

        let zip2Validated = validateTextInput('orders-form', 'zip2', 'zip2Feedback');
        if (zip2Validated == false) {
            isAllValidated = false;
        }

        let city2Validated = validateTextInput('orders-form', 'city2', 'city2Feedback');
        if (city2Validated == false) {
            isAllValidated = false;
        }
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