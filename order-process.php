<?php 


require_once "header.php";
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'):

/**********************************************
 * 
 *      skapa en funktion som kollar efter id i local storage.
 *      select allt i product med rätt id.
 *      loopa tills alla idn är kollade.
 *      skriv ut namn och pris.
 *  
 **********************************************/

  $firstname  = htmlspecialchars($_POST['firstname']); 
  $surname  = htmlspecialchars($_POST['surname']);
  $email    = htmlspecialchars($_POST['email']);
  $phone    = htmlspecialchars($_POST['phone']);
  $address  = htmlspecialchars($_POST['address']);
  $zip      = htmlspecialchars($_POST['zip']);
  $city     = htmlspecialchars($_POST['city']);

    print_r($_POST);

    $sql = "INSERT INTO customers(firstname, surname)
            VALUES (:firstname, :surname)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':surname', $surname);
    $stmt->execute();
  

//$sql = "INSERT INTO table_name (username, email) VALUES ('$_POST[username]', '$_POST[email]')”; if (!mysql_query($user_info, $connect)) { die('Error: ' . mysql_error()); }

endif;

?>