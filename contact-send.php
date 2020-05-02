<?php
require_once 'db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST'):
    // Lägg till htmlspecialchars för att rensa HTML
    $contactname = htmlspecialchars($_POST['name']);
    $contactemail = htmlspecialchars($_POST['email']);
    $contactphone = htmlspecialchars($_POST['mobile']);
    $contactmessage = htmlspecialchars($_POST['message']);

    // Förbered en SQL-sats
    $sql = "INSERT INTO `contactform` (`id`, `contactname`, `contactemail`, `contactphone`, `contactmessage`,`contactdate`) 
            VALUES (NULL, '$contactname', '$contactemail', '$contactphone', '$contactmessage', CURRENT_TIMESTAMP )";
        $stmt = $db->prepare($sql);
        $stmt->execute();

endif;

header("Location:contact-thanks.php");


?>