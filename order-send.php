<?php 
  /**************************************** *
    * read info from db & show, add categories
  **************************************** */

  require_once 'db.php'; 

// check if email exists
  if(isset($_POST['email'])){
  $checkEmail = htmlspecialchars($_POST['email']);

    // kolla ifall email existerar i db
    $sql2 = "SELECT * FROM `customers` WHERE email = '$checkEmail'";  
    $stmt2 = $db->prepare($sql2);
    $stmt2->execute();
          
    $result = false; 
    while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
      $result = true;
      $existing_customer_id = $row2['customer_id'];

      $sql = "INSERT INTO `orders` (`order_id`, `customer_id`, `status`, `amount`, `time`) 
      VALUES (NULL, '$existing_customer_id', 'active', '500', CURRENT_TIMESTAMP)";
      $stmt = $db->prepare($sql);
      $stmt->execute();

    }
    if(!$result){ // skapa ny kund och koppla order
      $firstname  = htmlspecialchars($_POST['firstname']); 
      $surname    = htmlspecialchars($_POST['surname']);
      $email      = htmlspecialchars($_POST['email']);
      $phone      = htmlspecialchars($_POST['phone']);
      $address    = htmlspecialchars($_POST['address']);
      $zip        = htmlspecialchars($_POST['zip']);
      $city       = htmlspecialchars($_POST['city']);

      $sql = "INSERT INTO `customers` (`customer_id`, `firstname`, `surname`, `streetadress`, `city`, `zip-code`, `phone`, `email`) 
      VALUES (NULL, '$firstname', '$surname', '$address', '$city', '$zip', '$phone', '$email')";
      $stmt = $db->prepare($sql);
      $stmt->execute();

      $sql3 =" SELECT customer_id FROM customers ORDER BY customer_id DESC LIMIT 1";
      $stmt3 = $db->prepare($sql3);
      $stmt3->execute();

      $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
      $new_customer_id = $row3['customer_id'];

      $sql4 ="INSERT INTO `orders` (`order_id`, `customer_id`, `status`, `amount`, `time`) 
      VALUES (NULL, $new_customer_id, 'active', '500', CURRENT_TIMESTAMP)";
      $stmt4 = $db->prepare($sql4);
      $stmt4->execute();
      // header('Location:order-confirmation.php');
    } 
    echo "working";
  }
?>
