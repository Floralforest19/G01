<?php 
/**************************************** *
 * show a single order
**************************************** */
  // skriva ut på samma sätt som orderbekrftelse? Lägga till status bara
    require_once 'header.php';
    require_once 'db.php';

    $id = htmlspecialchars($_GET['id']);
    // hämta från beställningar istället
    $order = "SELECT * FROM orders WHERE order_id=1";
    $stmt = $db->prepare($order);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $customer = "SELECT * FROM customers WHERE customer_id=1"; 
    $stmt = $db->prepare($customer);
    $stmt->execute();
    $customerRow = $stmt->fetch(PDO::FETCH_ASSOC);

     $customer = "SELECT * FROM customers WHERE firstname=firstname"; 
    $stmt = $db->prepare($customer);
    $stmt->execute();
    $nameRow = $stmt->fetch(PDO::FETCH_ASSOC);

     $customer = "SELECT * FROM customers WHERE email=email"; 
    $stmt = $db->prepare($customer);
    $stmt->execute();
    $emailRow = $stmt->fetch(PDO::FETCH_ASSOC);

      $customer = "SELECT * FROM customers WHERE phone=phone"; 
    $stmt = $db->prepare($customer);
    $stmt->execute();
    $phoneRow = $stmt->fetch(PDO::FETCH_ASSOC);

     $customer = "SELECT * FROM customers WHERE streetadress=streetadress"; 
    $stmt = $db->prepare($customer);
    $stmt->execute();
    $streetadressRow = $stmt->fetch(PDO::FETCH_ASSOC);

    $order_id = htmlspecialchars($row['order_id']);
    $customer_id = htmlspecialchars($row['customer_id']);
    $amount = htmlspecialchars($row['amount']);
    $time = htmlspecialchars($row['time']);

    $firstname = htmlspecialchars($nameRow['firstname']);
    $surname = htmlspecialchars($surnameRow['surname']);
    $fullname = $fname." ".$sname;

    $email = htmlspecialchars($emailRow['email']);
    $phone = htmlspecialchars($phoneRow['phone']);

    $street = htmlspecialchars($streetadressRow['streetadress']);
    $zip = htmlspecialchars($row['zip-code']);
    $city = htmlspecialchars($row['city']);
    $address = $street."<br>".$zip." ".$city;

    $thisPost = "
<section class='background'>
<h2>Orderbekräftelse</h2>
<div class='box__cat--form'>
<div class='nav__admin'>
  <table class='table'>
    <thead>
      <th><a href='orders.php?id=order_id'>Order-id</a></th>
      <th><a href='orders.php?id=customer_id'>Kund-id</a></th>
      <th>Namn</th>
      <th>E-mail</th>
      <th>Telefon</th>
      <th>Adress</th>
      <th><a href='orders.php?id=time'>Tid/datum</a></th>
      <th>Summa</th>
      <th>Status</th>
    </thead>
    <tr>
      <td><a href='orders-single.php?id=$order_id'><h3>$order_id</h3></a></td>
      <td><p>$customer_id</p></td>
      <td><p>$firstname</p></td>
      <td><p>$email</p></td>
      <td><p>$phone</p></td>
      <td><p>$address</p></td>
      <td><p>$time</p></td>  
      <td><p>$amount Kr</p></td>      
      <td><a href='orders-single.php?id=$order_id'><button class='btn__edit'>Arkivera</button></a></td>
    </tr>
  </table>
</div></div></section>";

    echo $thisPost;

?>