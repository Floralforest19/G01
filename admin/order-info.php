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
  $sql = "SELECT * FROM `orders` WHERE `order_id` LIKE '$order_id'";
  $stmt = $db->prepare($sql);
  $stmt->execute();

  $rowOrder = $stmt->fetch(PDO::FETCH_ASSOC);
    // order info
    $order_id = htmlspecialchars($rowOrder['order_id']);
    $customer_id = htmlspecialchars($rowOrder['customer_id']);
    $status = htmlspecialchars($rowOrder['status']);
    $amount = htmlspecialchars($rowOrder['amount']);
    $time = htmlspecialchars($rowOrder['time']);
    $order_info = htmlspecialchars($rowOrder['order_info']);

    // kund info
    $sqlCustomer = "SELECT * FROM customers WHERE customer_id = $customer_id";
    $stmtCustomer = $db->prepare($sqlCustomer);
    $stmtCustomer->execute();
    $rowCustomer = $stmtCustomer->fetch(PDO::FETCH_ASSOC);
  
    $fname = htmlspecialchars($rowCustomer['firstname']);
    $sname = htmlspecialchars($rowCustomer['surname']);
    $email = htmlspecialchars($rowCustomer['email']);
    $phone = htmlspecialchars($rowCustomer['phone']);
  
    $street = htmlspecialchars($rowCustomer['streetadress']);
    $zip = htmlspecialchars($rowCustomer['zip-code']);
    $city = htmlspecialchars($rowCustomer['city']);
    $other_city = htmlspecialchars($rowOrder['other_city']);

    // status på svenska
    if($status == 'active'){
      $statusText = 'Ny';
    } else if($status == 'in progress') {
      $statusText = 'Behandlas';
    } else if($status == 'done') {
      $statusText = 'Slutförd';
    } else {
      $statusText = 'Status okänd';
    }

  $tableOrders = "  
  <h2>Orderinformation - $order_id</h2>
  <div class='box__cat--form'>
  <div class='nav__admin'>
    <table class='table'>
      <thead>
        <th>Order-id</th>
        <th>Kund</th>
        <th>E-mail</th>
        <th>Telefon</th>
        <th>Kundadress</th>
        <th>
          Datum/Tid
        </th>
        <th>
          Summa
        </th>
        <th>Status</th>
      </thead>
      <tr>
        <td><p>$order_id</p></td>
        <td><p>$fname $sname</p></td>
        <td><p>$email</p></td>
        <td><p>$phone</p></td>
        <td><p>$street <br>$zip $city</p></td>
        <td><p>$time</p></td>  
        <td><p id='amountWithSale'></p></td>      
        <td>$statusText</td>
      </tr>
    </table>
    </div>";
    }
    echo $tableOrders;

    // leveransadress existerar ifall sant
    if( $other_city != null ){
      $tableShippingAddress = "  
    <table class='table'>
      <thead>
        <th>Mottagare</th>
        <th>Leveransadress</th>
      </thead>
      <tr>
        <td><p>$fname $sname</p></td>
        <td><p>$street <br>$zip <span id='otherCity'>$city</span></p></td>
      </tr>
    </table>
    ";

    echo $tableShippingAddress;
    
    } 
echo "<div class='nav__admin'>
<table id='dispItems' class='table'></table></div>
</div></section>";
  
  // echo "<p id='json'>$order_info</p>";
  echo "<input type='hidden' id='json' value='$order_info'/>";

 ?>

<script src="../js/order-info.js"></script>