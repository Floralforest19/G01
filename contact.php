<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles\style.css">

    <title>Contact</title>
</head>

<body class="contact-bg-color">


    <section class="contact-form">
        <h1 class="contact-form-heading">Kontakta oss</h1>
        <form>
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
                <button class="button" type="submit">Skicka nu</button>
            </div>
        </form>
    </section>

</body>

</html>