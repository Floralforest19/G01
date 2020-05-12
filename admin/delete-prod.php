<?php 
/**************************************** *
 * delete product
**************************************** */
require_once '../db.php';

if(isset($_GET['id'])){
  $id = htmlspecialchars($_GET['id']); 

  $sql  = "DELETE FROM product WHERE product_id = :id";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->execute();
}

  header('Location:read-disp.php');

?>