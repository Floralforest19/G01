<?php 
  /**************************************** *
    * read info from db & show, add categories
  **************************************** */
  require_once 'header-admin.php';
  require_once '../db.php'; 

// check if email exists
  if(isset($_POST['email'])){
    $checkEmail = htmlspecialchars('email');

    // kolla ifall email existerar i db
    $sql = "SELECT * FROM `customers` WHERE `email` LIKE '$checkEmail'";  
    $stmt = $db->prepare($sql);
    $stmt->execute();
          
    $result = false; 
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $result = true; 
      print_r($row);
      // lägg till order till rätt kund
      // ta kund id:t
      // hämta kund info lägg till order 
    }
    if(!$result){ // skapa ny kund och koppla order
      $sql = "UPDATE category SET name = '$catname' WHERE category_id = '$id' ";
      $stmt = $db->prepare($sql);
      $stmt->execute();
      // header('Location:order-confirmation.php');
    } else{

    }
  }
?>
