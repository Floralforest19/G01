<?php
/**************************************** *
 * let's user search for products
 * returns relevant products from db
**************************************** */
  require_once '../db.php';
  require_once 'header-admin.php';
  ?>

<section class='background'>

<?php

if( isset($_GET['order_id'])){
  $order_id = htmlspecialchars($_GET['order_id']);
  $sql = "SELECT * FROM `orders_archive` WHERE `order_id` LIKE '$order_id'";
  $stmt = $db->prepare($sql);
  $stmt->execute();

  // hämta order info
  $rowOrder = $stmt->fetch(PDO::FETCH_ASSOC);
  // hämta kund info
  $customer_id = htmlspecialchars($rowOrder['customer_id']);
  $sqlCustomer = "SELECT * FROM customers WHERE customer_id = $customer_id";
  $stmtCustomer = $db->prepare($sqlCustomer);
  $stmtCustomer->execute();
  $rowCustomer = $stmtCustomer->fetch(PDO::FETCH_ASSOC);
  
  // spara info i variabler
  $amount = htmlspecialchars($rowOrder['amount']);
  $total_amount = htmlspecialchars($rowOrder['total_amount']);
  $shipping_fee = htmlspecialchars($rowOrder['shipping_fee']);
  $time = htmlspecialchars($rowOrder['time']);
  $order_info = htmlspecialchars($rowOrder['order_info']);
  $name = htmlspecialchars($rowCustomer['firstname'])." ".htmlspecialchars($rowCustomer['surname']);
  $city = htmlspecialchars($rowCustomer['city']);
  $street = htmlspecialchars($rowCustomer['streetadress']);
  $zip = htmlspecialchars($rowCustomer['zip-code']);
  $other_city = htmlspecialchars($rowOrder['other_city']);
  $other_zip = htmlspecialchars($rowOrder['other_zip']);
  $other_street = htmlspecialchars($rowOrder['other_address']);

  $tableOrders = "  
  <h2>Order $order_id</h2>
  <div class='box__cat--form'>
  <div class='nav__admin'>
    <table class='table'>
      <tr>
        <th>Order-id</th>
        <td>$order_id</td>
      </tr>
    <tr>
      <th>Status</th>
      <td>Slutförd</td>
    </tr>
      <tr>
        <th>Kund</th>
        <td>$name</td>
      </tr>
      <tr>
        <th>Faktureringsadress</th>
        <td>$street<br>$zip $city</td>
      </tr>";

    }
    echo $tableOrders;

    // leveransadress existerar ifall sant
    if( $other_city != null ){
      $tableShippingAddress = "  
          <tr>
            <th>Leveransadress</th>
            <td>$other_street<br>$other_zip $other_city</td>
          </tr>
        </table>
      </div>";
      echo $tableShippingAddress;
    } else {
      $tableShippingAddress = "  
          <tr>
            <th>Leveransadress</th>
            <td>Samma som ovan</td>
          </tr>
        </table>
      </div>";
      echo $tableShippingAddress;

    }
  
  // produkt info
  $tableProducts = "
  <div class='nav__admin'>
  <table id='dispItems' class='table'>
  <thead>
    <th class='table__show-items--name'>Produkt</th>
    <th>Antal</th>
    <th>Pris</th>
    <th>Summa</th>
  </thead>
  <tr>
    <td></td>
    <td></td>
    <td>Produktsumma: </td>
    <td>".number_format($amount,2)." kr</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td>Fraktavgift: </td>
    <td>$shipping_fee kr</td>
  </tr>
  <tr>
    <th></th>
    <th></th>
    <th>Total summa: </th>
    <th>".number_format($total_amount,2)." kr</th>
  </tr>
    </table>
  </div>";
  echo $tableProducts;
  echo "</section>";
  
  echo "<input type='hidden' id='json' value='$order_info'/>";
    
 ?>

<script src="../js/order-info.js"></script>