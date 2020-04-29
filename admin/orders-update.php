<?php
/**************************************** *
 * use order_id and select-value to update orderstatus in db
 * different header locations depending on order status done/active
**************************************** */
  require_once '../db.php';
  if(isset($_POST['statusSelectDone']) || isset($_POST['statusSelect'])){
    $order_id = htmlspecialchars($_GET['order_id']); 
    if(isset($_POST['statusSelect'])){
      $selectValue = htmlspecialchars($_POST['statusSelect']);
      $location ='orders.php';
    } else {
      $selectValue = htmlspecialchars($_POST['statusSelectDone']);
      $location ='orders-done.php';

    }
    $sql2 = "INSERT INTO `orders_archive` 
    SELECT * FROM orders
    WHERE order_id = '$order_id'";
    $stmt2 = $db->prepare($sql2);
    $stmt2->execute();

    $sql3 = "DELETE FROM `orders` 
    WHERE order_id = '$order_id'";
    $stmt3 = $db->prepare($sql3);
    $stmt3->execute();

  } 
  header("Location:$location");
?>