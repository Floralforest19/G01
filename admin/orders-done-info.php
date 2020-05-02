<?php
require_once '../db.php';
  header("Content-Type: application/json; charset=UTF-8");  // ange att innehållet är json
/**************************************** *
 * read info from db & display orders
 * different sql-orders depending on which link pushed
**************************************** */

  $sql = "SELECT * FROM orders_archive";
  $stmt = $db->prepare($sql);
  $stmt->execute();

  // loopar över arrayen som har resultatet från db
  while (  $orderArray = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    $order_id    = htmlspecialchars($orderArray['order_id']);
    $customer_id = htmlspecialchars($orderArray['customer_id']);

    $sqlCustomerAddress = " SELECT * FROM customers
                            WHERE customer_id = '$customer_id'";
    $stmtCustomer = $db->prepare($sqlCustomerAddress);
    $stmtCustomer->execute();
    $rowCustomerInfo = $stmtCustomer->fetch(PDO::FETCH_ASSOC);

    $name  = htmlspecialchars($rowCustomerInfo['firstname'])." ".htmlspecialchars($rowCustomerInfo['surname']);
    $email = htmlspecialchars($rowCustomerInfo['email']);

    $homeStreet   = htmlspecialchars($rowCustomerInfo['streetadress']);
    $homeZip      = htmlspecialchars($rowCustomerInfo['zip-code']);
    $homeCity     = htmlspecialchars($rowCustomerInfo['city']);
    $otherStreet  = htmlspecialchars($orderArray['other_address']);
    $otherZip     = htmlspecialchars($orderArray['other_zip']);
    $otherCity    = htmlspecialchars($orderArray['other_city']);
    $status       = htmlspecialchars($orderArray['status']);
    $time         = htmlspecialchars($orderArray['time']);
    $shippingFee  = htmlspecialchars($orderArray['shipping_fee']);
    $amount       = htmlspecialchars($orderArray['amount']);
    $total_amount = $amount + $shippingFee;
    $sum = number_format($total_amount,2);

    if( $status == 'active'){
      $status = "Ny";
    } else {
      $status = "Behandlas";
    }

    if( strlen($otherCity) == 0 ){
      $shippingStreet = $homeStreet;
      $shippingZip = $homeZip;
      $shippingCity = $homeCity;
    } else {
      $shippingStreet = $otherStreet;
      $shippingZip = $otherZip;
      $shippingCity = $otherCity;
    }

    $order = array(
                    "order_id" => $order_id,
                    "name" => $name,
                    "email" => $email,
                    "shippingStreet" => $shippingStreet,
                    "shippingZip" => $shippingZip,
                    "shippingCity" => $shippingCity,
                    "time" => $time,
                    "totalSum" => $sum,
                    "status" => 'Slutförd'
                  );
    $orders[] = $order;
  }

  // Konvertera PHP-arrayen till JSON
  $json = json_encode($orders, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

  echo $json;  // Skicka JSON till klienten

?>
