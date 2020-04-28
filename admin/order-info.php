<?php
/**************************************** *
 * let's user search for products
 * returns relevant products from db
**************************************** */
  require_once '../db.php';
  require_once 'header-admin.php';
?>

  <h1>Orderinfo</h1>

<?php

$sql = "SELECT * FROM `orders` WHERE `order_id` LIKE '1'";
$stmt = $db->prepare($sql);
$stmt->execute();


$tableOrders = "";
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
    echo "<pre>";
    print_r($row);
    echo "</pre>";
      // kolla igenom alla ordrar och spara order-id samt kundi-id
      $order_id = htmlspecialchars($row['order_id']);
      $customer_id = htmlspecialchars($row['customer_id']);
      $status = htmlspecialchars($row['status']);
      $amount = htmlspecialchars($row['amount']);
      $time = htmlspecialchars($row['time']);
      if($status == 'active'){
        $statusText = 'Ny';
      } else if($status == 'in progress') {
        $statusText = 'Behandlas';
      } else if($status == 'done') {
        $statusText = 'Slutförd';
      } else {
        $statusText = 'Status okänd';
      }

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

      $tableOrders.= "<table class='table'>
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
    ";
      // spara json info från db i variabel
      $order_json = htmlspecialchars($row['order_info']);
    endwhile;

    $tableOrders .= "</table>";
    echo $tableOrders;

    echo gettype($order_json)."<br><br>";
    $test =  json_encode($order_json);
    echo gettype($test)."<br><br>";
    echo $test."<br><br>";



// $sql = "INSERT INTO product (name, description, quantity, price, image_file_name, category_id) 
// VALUES ( :name, :description, :quantity, :price, :imageCollection,  :category_id)";
// $stmt = $db->prepare($sql);

 ?>
