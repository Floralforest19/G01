<?php 
  // skriva ut på samma sätt som orderbekrftelse? Lägga till status bara
    require_once 'header-admin.php';
    require_once '../db.php';

    $id = htmlspecialchars($_GET['id']);
    // hämta från beställningar istället
    $sql = "SELECT * FROM orders WHERE $id";
    $sql = "SELECT * FROM orders, customers 
            WHERE orders.order_id = $id";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $order_id = htmlspecialchars($row['order_id']);
    $customer_id = htmlspecialchars($row['customer_id']);
    $amount = htmlspecialchars($row['amount']);
    $time = htmlspecialchars($row['time']);

    $fname = htmlspecialchars($row['firstname']);
    $sname = htmlspecialchars($row['surname']);
    $fullname = $fname." ".$sname;

    $email = htmlspecialchars($row['email']);
    $phone = htmlspecialchars($row['phone']);

    $street = htmlspecialchars($row['streetadress']);
    $zip = htmlspecialchars($row['zip-code']);
    $city = htmlspecialchars($row['city']);
    $address = $street."<br>".$zip." ".$city;

    $thisPost = "
<section class='background'>
<h2>Order: $order_id</h2>
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
      <td><a href='showorder.php?id=$order_id'><h3>$order_id</h3></a></td>
      <td><p>$customer_id</p></td>
      <td><p>$fullname</p></td>
      <td><p>$email</p></td>
      <td><p>$phone</p></td>
      <td><p>$address</p></td>
      <td><p>$time</p></td>  
      <td><p>$amount</p></td>      
      <td><a href='showorder.php?id=$order_id'><button class='btn__edit'>Arkivera</button></a></td>
    </tr>
  </table>
</div></div></section>";

    echo $thisPost;

?>