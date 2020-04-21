<?php 
  require_once 'header-admin.php'; 
  require_once '../db.php';
?>


<section class='background'>

  <h2>Beställningar</h2>
  <div class='box__cat--form'>

<?php

  if( isset($_GET['id']) ){
    $id = htmlentities($_GET['id']);
    // hämta från beställningar istället
    $sql = "SELECT * FROM orders ORDER BY $id";
  } else {
    $sql = "SELECT * FROM orders ORDER BY order_id";
  }
  $stmt = $db->prepare($sql);
  $stmt->execute();

  $tableOrders = "
  <table class='table'>
  <thead>
    <th><a href='orders.php?id=order_id'>Order-id</a></th>
    <th><a href='orders.php?id=customer_id'>Kund-id</a></th>
    <th>Namn</th>
    <th>E-mail</th>
    <th>Telefon</th>
    <th>Adress</th>
    <th><a href='orders.php?id=time'>Tid/datum</a></th>
    <th><a href='orders.php?id=amount'>Summa</a></th>
    <th>Status</th>
  </thead>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
      // kolla igenom alla ordrar och spara order-id samt kundi-id
      $order_id = htmlspecialchars($row['order_id']);
      $customer_id = htmlspecialchars($row['customer_id']);
      $amount = htmlspecialchars($row['amount']);
      $time = htmlspecialchars($row['time']);

      $sqlCustomer = "SELECT * FROM customers WHERE customer_id = $customer_id";
      $stmtCustomer = $db->prepare($sqlCustomer);
      $stmtCustomer->execute();
      $rowCustomer = $stmtCustomer->fetch(PDO::FETCH_ASSOC);
  
      $fname = htmlspecialchars($rowCustomer['firstname']);
      $sname = htmlspecialchars($rowCustomer['surname']);
      $fullname = $fname." ".$sname;
  
      $email = htmlspecialchars($rowCustomer['email']);
      $phone = htmlspecialchars($rowCustomer['phone']);
  
      $street = htmlspecialchars($rowCustomer['streetadress']);
      $zip = htmlspecialchars($rowCustomer['zip-code']);
      $city = htmlspecialchars($rowCustomer['city']);
      $address = $street."<br>".$zip." ".$city;
      $tableOrders.= "
      <tr>
        <td><a href='showorder.php?id=$order_id'><h3>$order_id</h3></a></td>
        <td><p>$customer_id</p></td>
        <td><p>$fullname</p></td>
        <td><p>$email</p></td>
        <td><p>$phone</p></td>
        <td><p>$address</p></td>
        <td><p>$time</p></td>  
        <td><p>$amount</p></td>      
        <td><br><a href='showorder.php?id=$order_id'><button class='btn__edit'>Ändra</button></a></td>
      </tr>
    ";
    endwhile;
    $tableOrders .= "</table></div>";
    echo $tableOrders;
  ?>
  </section>
  
</section>
</body>
</html>