<?php 
  /**************************************** *
    * read info from db & show, add categories
  **************************************** */

  require_once 'db.php';

// check if email exists
  if(isset($_POST['email'])){
  $checkEmail = htmlspecialchars($_POST['email']);
  $order_sum = htmlspecialchars($_POST['order_sum']);

    // check if email exist in db
    $sql2 = "SELECT * FROM `customers` WHERE email = '$checkEmail'";
    $stmt2 = $db->prepare($sql2);
    $stmt2->execute();

    $result = false;

    // if customer exist, save order to customer with existing id
    while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
      $result = true;
      $existing_customer_id = $row2['customer_id'];
      // OBS!! AMOUNT SHOULD BE CHANGED
      $sql = "INSERT INTO `orders` (`order_id`, `customer_id`, `status`, `amount`, `time`)
      VALUES (NULL, '$existing_customer_id', 'active', '$order_sum', CURRENT_TIMESTAMP)";
      $stmt = $db->prepare($sql);
      $stmt->execute();

    }
    if(!$result){ // custmomer doesn't exist, save new customer info
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

      // get the new customers customer_id
      $sql3 =" SELECT customer_id FROM customers ORDER BY customer_id DESC LIMIT 1";
      $stmt3 = $db->prepare($sql3);
      $stmt3->execute();

      $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
      $new_customer_id = $row3['customer_id'];

      // save order to new customer OBS!! AMOUNT SHOULD BE CHANGED
      $sql4 ="INSERT INTO `orders` (`order_id`, `customer_id`, `status`, `amount`, `time`)
      VALUES (NULL, $new_customer_id, 'active', '$order_sum', CURRENT_TIMESTAMP)";
      $stmt4 = $db->prepare($sql4);
      $stmt4->execute();
    }
      // send customer info to order confirmation page
      $sql4 =" SELECT order_id, customer_id FROM orders ORDER BY order_id DESC LIMIT 1";
      $stmt4 = $db->prepare($sql4);
      $stmt4->execute();

      $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
      $new_order_id = $row4['order_id'];
      $order_customer_id = $row4['customer_id'];
      ("Location:orders-single.php?order_id=$new_order_id&customer_id=$order_customer_id");
  }
?>
