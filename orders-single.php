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
    $customer_id = htmlspecialchars($row['customer_id']);

    $customer = "SELECT * FROM customers WHERE customer_id=$customer_id";
    $stmt = $db->prepare($customer);
    $stmt->execute();
    $customerRow = $stmt->fetch(PDO::FETCH_ASSOC);

    $order_id = htmlspecialchars($row['order_id']);
    $amount = htmlspecialchars($row['amount']);
    $time = htmlspecialchars($row['time']);

    $firstname = htmlspecialchars($customerRow['firstname']);
    $surname = htmlspecialchars($customerRow['surname']);
    $fullname = $firstname." ".$surname;
    $email = htmlspecialchars($customerRow['email']);
    $phone = htmlspecialchars($customerRow['phone']);

    // if other address is available show this in confirmation order
    if ($row['other_address'] != NULL) {

      $street = htmlspecialchars($row['other_address']);
      $zip = htmlspecialchars($row['other_zip']);
      $city = htmlspecialchars($row['other_city']);
      $address = $street."<br>".$zip." ".$city;

    } else { // if not show the customers own address
    
      $street = htmlspecialchars($customerRow['streetadress']);
      $zip = htmlspecialchars($customerRow['zip-code']);
      $city = htmlspecialchars($customerRow['city']);
      $address = $street."<br>".$zip." ".$city;

    }

    $thisPost = "
   
<h2>Tack för ditt köp!<br> Ett kvitto kommer att skickas till den mail du angivit</h2>   
<section class='background'>
<div class='box__cat--form'>
<table id='dispItems' class='display__order-items'>
<div class='nav__admin'>
  <table class='display__order-items'>
    <tr>
      <th>Order-id</th>
      <td><h3>$order_id</h3></td>
    </tr>
    <tr>  
      <th>Kund-id</th>
      <td><p>$customer_id</p></td>
    </tr>
    <tr>  
      <th>Namn</th>
      <td><p>$firstname</p></td>
    </tr> 
    <tr> 
      <th>E-mail</th>
      <td><p>$email</p></td>
    </tr> 
    <tr>  
      <th>Telefon</th>
      <td><p>$phone</p></td>
    </tr>
    <tr>
      <th>Adress</th>
      <td><p>$address</p></td>
   </tr>   
   <tr>   
      <th>Tid/datum</th>
      <td><p>$time</p></td>
   </tr>
   <tr>   
      <th>Summa</th>
      <td><p>$amount Kr</p></td>
    </tr>
  </table>
  
</div></div></section>";
    echo $thisPost;
    
 ?>   
 <script src="js/order-show-items.js"></script>
 <script>
    function clearLocal(){
        localStorage.clear()
    }
    clearLocal()
</script>
 <?php
require_once 'footer.php';
?>

