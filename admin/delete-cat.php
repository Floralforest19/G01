<?php 
/**************************************** *
 * delete category
**************************************** */
require_once '../db.php';

if(isset($_GET['id'])){
  // ta id från get
  $id = htmlspecialchars($_GET['id']); 

  $sql = "DELETE FROM category WHERE category_id = :id";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->execute();
}

  header('Location:read-cat.php');

?>