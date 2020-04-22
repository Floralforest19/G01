<?php 
  require_once 'header-admin.php'; 
  require_once '../db.php';
?>


<section class='background'>
  <h2>Beställningar</h2>
  <div class="box__cat--form">
  <div class='nav__admin'>

<?php

  if( isset($_GET['id']) ){
    $id = htmlentities($_GET['id']);
    // hämta från beställningar istället
    $sql = "SELECT * FROM orders ORDER BY $id ASC";
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
      $status = htmlspecialchars($row['status']);
      $amount = htmlspecialchars($row['amount']);
      $time = htmlspecialchars($row['time']);
      if($status == 'active'){
        $statusText = 'Aktiv';
      } else if($status == 'in progress') {
        $statusText = 'Pågående';
      } else if($status == 'done') {
        $statusText = 'Avklarad';
      } else {
        $statusText = 'Oklar';
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

      $tableOrders.= "
      <tr>
        <td><a href='showorder.php?id=$order_id'><h3>$order_id</h3></a></td>
        <td><p>$customer_id</p></td>
        <td><p>$fname $sname</p></td>
        <td><p>$email</p></td>
        <td><p>$phone</p></td>
        <td><p>$street <br>$zip $city</p></td>
        <td><p>$time</p></td>  
        <td><p>$amount</p></td>      
        <td><br>$statusText</td>
      </tr>
    ";
    endwhile;
    $tableOrders .= "</table></div>";
    echo $tableOrders;
  ?>
  </div></div></section>
  
</section>
</body>
</html>