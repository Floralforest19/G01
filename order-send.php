<?php 
  /**************************************** *
    * read info from db & show, add categories
  **************************************** */

  require_once 'db.php';

// check if email exists
  if(isset($_POST['email'])){
    // json meed info från loacl storage
    $order_info = ($_POST['order_info']);

  // spara email i en variabel för att jämföra och kolla om det är en ny kund
  $checkEmail = htmlspecialchars($_POST['email']);
  
  // hämtar total summan på ordern som behövs för att spara ordern
  $order_sum    = htmlspecialchars($_POST['order_sum']);
  $shipping_fee = 0;

    // check if email exist in db
    $sql2  = "SELECT * FROM `customers` WHERE email = '$checkEmail'";
    $stmt2 = $db->prepare($sql2);
    $stmt2->execute();

    $result = false;
    // if customer exist, save order to customer with existing id
    while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
      $result = true;
      $existing_customer_id = $row2['customer_id'];
      
      // om anna leveransadress är ifylld skicka med denna i ordern
      if(strlen(htmlspecialchars($_POST['city2'])) > 0 ){
        $address2    = htmlspecialchars($_POST['address2']);
        $zip2        = htmlspecialchars($_POST['zip2']);
        $city2       = htmlspecialchars($_POST['city2']);
        // kolla om fraktavgift
        if(strtolower($city2) !== 'stockholm' && $order_sum < 500){
          $shipping_fee += 50;
        }
        $sql = "INSERT INTO `orders` (`order_id`, `customer_id`, `status`, `amount`, `shipping_fee`,  `time`, `other_address`, `other_zip`, `other_city`,`order_info`)
        VALUES (NULL, '$existing_customer_id', 'active', '$order_sum', '$shipping_fee',  CURRENT_TIMESTAMP, '$address2', '$zip2', '$city2','$order_info')";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }else{
        // kolla om fraktavgift
        $city       = htmlspecialchars($_POST['city']);
        if(strtolower($city) !== 'stockholm' && $order_sum < 500){
          $shipping_fee += 50;
        }
        $sql = "INSERT INTO `orders` (`order_id`, `customer_id`, `status`, `amount`, `shipping_fee`,  `time`,`order_info`)
        VALUES (NULL, '$existing_customer_id', 'active', '$order_sum', '$shipping_fee',  CURRENT_TIMESTAMP,'$order_info')";
        $stmt = $db->prepare($sql);
        $stmt->execute();
      }
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
      $sql3 = "SELECT customer_id FROM customers ORDER BY customer_id DESC LIMIT 1";
      $stmt3 = $db->prepare($sql3);
      $stmt3->execute();

      $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
      $new_customer_id = $row3['customer_id'];

      // om anna leveransadress är ifylld skicka med denna i ordern
      if(strlen(htmlspecialchars($_POST['city2'])) > 0){
        $address2    = htmlspecialchars($_POST['address2']);
        $zip2        = htmlspecialchars($_POST['zip2']);
        $city2       = htmlspecialchars($_POST['city2']);
        // kolla om fraktavgift
        if(strtolower($city2) !== 'stockholm' && $order_sum < 500){
          $shipping_fee += 50;
        }
      // save order to new customer together with new address
      $sql4  = "INSERT INTO `orders` (`order_id`, `customer_id`, `status`, `amount`, `shipping_fee`,  `time`, `other_address`, `other_zip`, `other_city`,`order_info`)
      VALUES (NULL, $new_customer_id, 'active', '$order_sum', '$shipping_fee',  CURRENT_TIMESTAMP, '$address2', '$zip2', '$city2', '$order_info')";
      $stmt4 = $db->prepare($sql4);
      $stmt4->execute();
    }else{
        // kolla om fraktavgift
        if(strtolower($city) !== 'stockholm' && $order_sum < 500){
          $shipping_fee += 50;
        }
      // save order to new customer OBS!! AMOUNT SHOULD BE CHANGED
      $sql4  = "INSERT INTO `orders` (`order_id`, `customer_id`, `status`, `amount`, `shipping_fee`,  `time`, `order_info`)
      VALUES (NULL, $new_customer_id, 'active', '$order_sum', '$shipping_fee',  CURRENT_TIMESTAMP, '$order_info')";
      $stmt4 = $db->prepare($sql4);
      $stmt4->execute();
    }
  }
    
      // send customer info to order confirmation page
      $sql4  = "SELECT order_id, customer_id FROM orders ORDER BY order_id DESC LIMIT 1";
      $stmt4 = $db->prepare($sql4);
      $stmt4->execute();

      $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
      $new_order_id = $row4['order_id'];
      $order_customer_id = $row4['customer_id'];

      // hämta info om de köpta produkterna och uppdaterar db med den nya mängden
      // $_POST['numbOfDiffProds'] innehåller antalet olika sorters produkter som köpts
      for ($i=0; $i < $_POST['numbOfDiffProds']; $i++) {
        // 0 = product_id, 1 = price, 2 = quantity
        $strBoughtProdInfo = $_POST["$i"];
        $arrIdPriceQuant   = explode(",",$strBoughtProdInfo);
        $booughtProdId     = $arrIdPriceQuant[0];
        $boughtQuantity    = $arrIdPriceQuant[2];

        // hämta produktens info från db
        $sql5  = "SELECT * FROM product WHERE product_id = $booughtProdId";
        $stmt5 = $db->prepare($sql5);
        $stmt5->execute();
        $row5  = $stmt5->fetch(PDO::FETCH_ASSOC);
        // spara den gamla mängden varor i lager
        $oldQuantity = $row5['quantity'];

        // räkna ut nya antalet varor i lager. Gamla antalet - köpta antalet = nya antalet
        $newQuantity = $oldQuantity - $boughtQuantity;

        // uppdatera databasen med nya antalet varor i lager
        $sql6  = "UPDATE product SET quantity = '$newQuantity' WHERE product_id = '$booughtProdId'";
        $stmt6 = $db->prepare($sql6);
        $stmt6->execute();
      }
      // skicka kund till bekräftelse
      header("Location:orders-single.php?order_id=".$new_order_id."&city=".$_POST['city']."&city2=".$_POST['city2']);
  }
?>