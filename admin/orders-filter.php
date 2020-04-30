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
  <div class="nav__admin">
    <form action="">
      <input type="text" id="filterInput" placholder="Filtrera efter stad">
    </form>
  </div>

  <div class="nav__admin">
    <ul id="products"></ul>
  </div>

  <div class='nav__admin'>

  <table class='table'>
  <thead>
    <th>Order-id</th>
    <!-- <th>Kund</th> -->
    <!-- <th>E-mail</th> -->
    <th>Leveransadress</th>
    <!-- <th>
      Datum/Tid
    </th>
    <th>
      Summa
    </th>
    <th>
      Status
    </th> -->
  </thead>

<?php

  $sql = "SELECT * FROM orders 
          WHERE status = 'active' OR status = 'in progress'
          ORDER BY order_id";
  $stmt = $db->prepare($sql);
  $stmt->execute();

  $tableOrders = "";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
      // kolla igenom alla ordrar och spara order-id samt kundi-id
      $order_id = htmlspecialchars($row['order_id']);
      $customer_id = htmlspecialchars($row['customer_id']);
      $status = htmlspecialchars($row['status']);
      $amount = htmlspecialchars($row['amount']);
      $shipping_fee = htmlspecialchars($row['shipping_fee']);
      $total_amount = floatval($amount) + floatval($shipping_fee);
      $time = htmlspecialchars($row['time']);

      $sqlCustomer = "SELECT * FROM customers WHERE customer_id = $customer_id";
      $stmtCustomer = $db->prepare($sqlCustomer);
      $stmtCustomer->execute();
      $rowCustomer = $stmtCustomer->fetch(PDO::FETCH_ASSOC);
  
      $email = htmlspecialchars($rowCustomer['email']);
      $fullname = htmlspecialchars($rowCustomer['firstname'])." ".htmlspecialchars($rowCustomer['surname']);

      $customer_city = htmlspecialchars($rowCustomer['city']);
      $customer_zip = htmlspecialchars($rowCustomer['zip-code']);
      $customer_address = htmlspecialchars($rowCustomer['streetadress']);

      $other_city = htmlspecialchars($row['other_city']);
      $other_zip = htmlspecialchars($row['other_zip']);
      $other_address = htmlspecialchars($row['other_address']);
      // beroende på om det finns nån annan leveransadress
      if( strlen(htmlspecialchars($row['other_city'])) > 0 ){
        $shippingAddress = "$other_address<br><span class='shipping_address'>$other_city</span> $other_zip";
      } else {
        $shippingAddress = "$customer_address<br><span class='shipping_address'>$customer_city</span> $customer_zip";
      }

      $selectStatus = 
      "<form method='post' action='orders-update.php?order_id=$order_id'>
        <select name='statusSelect' class='statusSelect'>";
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
      <tr>";
      $tableOrders.= "<td><a href='order-info.php?order_id=$order_id'><p>$order_id</p></a></td>";
        // <td><a href='order-info.php?order_id=$order_id'><p>$fullname</p></a></td>
        //<td><a href='order-info.php?order_id=$order_id'><p>$email</p></a></td>
        $tableOrders.= "<td>$shippingAddress</td>";
        // <td><p>$time</p></td>  
        // <td><p>".number_format($total_amount,2)." kr</p></td>      
        // <td>$selectStatus</td>
        $tableOrders.= "</tr>
    ";
    endwhile;
    $tableOrders .= "</table></div>";
    echo $tableOrders;
  ?>
  </div></div></section>
  
</section>
<script src="../js/filter-orders.js"></script>

</body>
</html>