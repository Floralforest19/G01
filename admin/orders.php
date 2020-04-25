<?php 
/**************************************** *
 * read info from db & display active/in progress orders
 * edit status with select
**************************************** */
  require_once 'header-admin.php'; 
  require_once '../db.php';
?>

<section class='background'>
  <h2>Aktiva beställningar</h2>
  <div class="box__cat--form">
  <div class='nav__admin'>

  <table class='table'>
  <thead>
    <th>Order-id</th>
    <th>Kund</th>
    <th>E-mail</th>
    <th>Telefon</th>
    <th>Adress</th>
    <th>
      Datum/Tid<br>
      <a href='orders.php?id=time&order_sort=ASC' id='sumSort'><i class="fas fa-angle-up"></i></a>
      <a href='orders.php?id=time&order_sort=DESC' id='sumSort'><i class="fas fa-angle-down"></i></a>
    </th>
    <th>
      Summa<br>
      <a href='orders.php?id=amount&order_sort=ASC' id='sumSort'><i class="fas fa-angle-up"></i></a>
      <a href='orders.php?id=amount&order_sort=DESC' id='sumSort'><i class="fas fa-angle-down"></i></a>
    </th>
    <th>
      Status<br>
      <a href='orders.php?id=status&order_sort=ASC' id='sumSort'><i class="fas fa-angle-up"></i></a>
      <a href='orders.php?id=status&order_sort=DESC' id='sumSort'><i class="fas fa-angle-down"></i></a>
    </th>
  </thead>

<?php

  if( isset($_GET['id']) ){
    $id = htmlentities($_GET['id']);
    $orderSort = htmlentities($_GET['order_sort']);
    // hämta från beställningar istället
    $sql = "SELECT * FROM orders 
            WHERE status = 'active' OR status = 'in progress'
            ORDER BY $id $orderSort";
  } else {
    $sql = "SELECT * FROM orders 
            WHERE status = 'active' OR status = 'in progress'
            ORDER BY order_id";
  }
  $stmt = $db->prepare($sql);
  $stmt->execute();

  $tableOrders = "";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
      // kolla igenom alla ordrar och spara order-id samt kundi-id
      $order_id = htmlspecialchars($row['order_id']);
      $customer_id = htmlspecialchars($row['customer_id']);
      $status = htmlspecialchars($row['status']);
      $amount = htmlspecialchars($row['amount']);
      $time = htmlspecialchars($row['time']);

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

      $selectStatus = 
      "<form method='post' action='orders-update.php?order_id=$order_id'         
        onsubmit=\"return alert('Status för order $order_id uppdaterades')\">
        <select name='statusSelect' id='statusSelect'>";
      if( $status == 'active'){
        $selectStatus .= "
        <option value='active' selected>Ny</option>
        <option value='in progress'>Behandlas</option>
        <option value='done'>Slutförd</option>";
      } else if( $status == 'in progress'){
        $selectStatus .= "
        <option value='active'>Ny</option>
        <option value='in progress' selected>Behandlas</option>
        <option value='done'>Slutförd</option>";
      } else if( $status == 'done'){
        $selectStatus .= "
        <option value='active'>Ny</option>
        <option value='in progress'>Behandlas</option>
        <option value='done' selected>Slutförd</option>";
      }
      $selectStatus .= "</select><input type='submit' value='Sätt status'></form>";

      $tableOrders.= "
      <tr>
        <td><p>$order_id</p></td>
        <td><p>$customer_id - $fname $sname</p></td>
        <td><p>$email</p></td>
        <td><p>$phone</p></td>
        <td><p>$street <br>$zip $city</p></td>
        <td><p>$time</p></td>  
        <td><p>$amount kr</p></td>      
        <td>$selectStatus</td>
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