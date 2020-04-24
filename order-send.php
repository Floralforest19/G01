<?php 
  /**************************************** *
    * read info from db & show, add categories
  **************************************** */

  require_once 'db.php'; 

// check if email exists
  if(isset($_POST['email'])){
    $checkEmail = htmlspecialchars('email');

  $firstname  = htmlspecialchars($_POST['firstname']); 
  $surname    = htmlspecialchars($_POST['surname']);
  $email      = htmlspecialchars($_POST['email']);
  $phone      = htmlspecialchars($_POST['phone']);
  $address    = htmlspecialchars($_POST['address']);
  $zip        = htmlspecialchars($_POST['zip']);
  $city       = htmlspecialchars($_POST['city']);

    // kolla ifall email existerar i db
    $sql = "SELECT * FROM `customers` WHERE 'email' = '$checkEmail'";  
    $stmt = $db->prepare($sql);
    $stmt->execute();
          
    $result = false; 
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $result = true; 
      print_r($row);
      // lägg till order till rätt kund
      // ta kund id:t
      // hämta kund info lägg till order 
            
      // $sql = "UPDATE category SET name = '$catname' WHERE category_id = '$id' ";
      // $stmt = $db->prepare($sql);
      // $stmt->execute();
    }
    if(!$result){ // skapa ny kund och koppla order
      $firstname  = htmlspecialchars($_POST['firstname']); 
      $surname    = htmlspecialchars($_POST['surname']);
      $email      = htmlspecialchars($_POST['email']);
      $phone      = htmlspecialchars($_POST['phone']);
      $address    = htmlspecialchars($_POST['address']);
      $zip        = htmlspecialchars($_POST['zip']);
      $city       = htmlspecialchars($_POST['city']);

      $sql = "INSERT INTO `customers`(`firstname`, `surname`, `streetadress`, `city`, `zip-code`, `phone`, `email`)
              VALUES ($firstname, $surname, $address, $city, $zip, $phone, $email) ";
      $stmt = $db->prepare($sql);
      $stmt->execute();

      // header('Location:order-confirmation.php');
    } else{

    }
  }
?>
