<?php 
/**************************************** *
 * show a single order
**************************************** */
  // skriva ut på samma sätt som orderbekrftelse? Lägga till status bara
    require_once 'header.php';
    require_once 'db.php';

    $order_id = htmlspecialchars($_GET['order_id']);
    // hämta från beställningar istället
    $order = "SELECT * FROM orders WHERE order_id=$order_id";
    $stmt = $db->prepare($order);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $customer_id = htmlspecialchars($_GET['customer_id']);
    $customer = "SELECT * FROM customers WHERE customer_id=$customer_id"; 
    $stmt = $db->prepare($customer);
    $stmt->execute();
    $customerRow = $stmt->fetch(PDO::FETCH_ASSOC);

    $order_id = htmlspecialchars($row['order_id']);
    $customer_id = htmlspecialchars($row['customer_id']);
    $amount = htmlspecialchars($row['amount']);
    $time = htmlspecialchars($row['time']);

    $firstname = htmlspecialchars($customerRow['firstname']);
    $surname = htmlspecialchars($customerRow['surname']);
    $fullname = $firstname." ".$surname;

    $email = htmlspecialchars($customerRow['email']);
    $phone = htmlspecialchars($customerRow['phone']);

    $street = htmlspecialchars($customerRow['streetadress']);
    $zip = htmlspecialchars($customerRow['zip-code']);
    $city = htmlspecialchars($customerRow['city']);
    $address = $street."<br>".$zip." ".$city;

    $thisPost = "
<section class='background'>
<h2>Orderbekräftelse</h2>
<div class='box__cat--form'>
<div class='nav__admin'>
  <table class='table'>
    <thead>
      <th>Order-id</th>
      <th>Kund-id</th>
      <th>Namn</th>
      <th>E-mail</th>
      <th>Telefon</th>
      <th>Adress</th>
      <th>Tid/datum</th>
      <th>Summa</th>
      
    </thead>
    <tr>
      <td><h3>$order_id</h3></td>
      <td><p>$customer_id</p></td>
      <td><p>$firstname</p></td>
      <td><p>$email</p></td>
      <td><p>$phone</p></td>
      <td><p>$address</p></td>
      <td><p>$time</p></td>  
      <td><p>$amount Kr</p></td>      
      
    </tr>
  </table>
</div></div></section>";

    echo $thisPost;

?>