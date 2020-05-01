<?php

require_once 'header.php';
require_once 'db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST'):
    // Testa att skriva ut data som finns i POST-arrayen
    print_r($_POST);
    
    // Lägg till htmlspecialchars för att rensa HTML
    $contactname = htmlspecialchars($_POST['name']);
    $contactemail = htmlspecialchars($_POST['email']);
    $contactphone = htmlspecialchars($_POST['mobile']);
    $contactmessage = htmlspecialchars($_POST['message']);

    // Förbered en SQL-sats
    $sql = "INSERT INTO `contactform` (`id`, `contactname`, `contactemail`, `contactphone`, `contactmessage`) 
            VALUES (NULL, '$contactname', '$contactemail', '$contactphone', '$contactmessage')";

    $stmt = $db->prepare($sql);

    
    // Skicka SQL till databasen
    $stmt->execute();

endif;

header("Location:contact-thanks.php");

require_once 'footer.php';

?>