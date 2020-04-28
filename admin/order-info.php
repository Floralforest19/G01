<?php
/**************************************** *
 * let's user search for products
 * returns relevant products from db
**************************************** */
  require_once '../db.php';
  require_once 'header-admin.php';
  ?>

<section class='background'>
    <h2>Orderinformation</h2>
    <div class='box__cat--form'>
    <div class='nav__admin'>

<?php

if( isset($_GET['order_id'])){
  $order_id = htmlspecialchars($_GET['order_id']);
  $sql = "SELECT * FROM `orders` WHERE `order_id` LIKE '$order_id'";
  $stmt = $db->prepare($sql);
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // order info
    $order_id = htmlspecialchars($row['order_id']);
    $customer_id = htmlspecialchars($row['customer_id']);
    $status = htmlspecialchars($row['status']);
    $amount = htmlspecialchars($row['amount']);
    $time = htmlspecialchars($row['time']);
    $order_info = htmlspecialchars($row['order_info']);

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
    <table class='table'>
      <thead>
        <th>Order-id</th>
        <th>Kund</th>
        <th>E-mail</th>
        <th>Telefon</th>
        <th>Adress</th>
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
        <td><p>$amount kr</p></td>      
        <td>$statusText</td>
      </tr>
    </table>

    </div></div></section>";

    echo $tableOrders;

  }
  echo gettype($order_info)."<br><br>";
  echo "<pre>";
  print_r($order_info);
  echo "</pre><br><br>";
  $test = json_encode($order_info);
  echo gettype($test)."<br><br>";

  $manage = json_decode($test, true);
  echo $manage."<br><br>";
  echo gettype($manage)."<br><br>";

  


 ?>