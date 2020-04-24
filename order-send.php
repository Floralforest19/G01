<?php 
  /**************************************** *
    * read info from db & show, add categories
  **************************************** */

  require_once 'db.php'; 

// check if email exists
  if(isset($_POST['email'])){
  $checkEmail = htmlspecialchars($_POST['email']);

  $firstname  = htmlspecialchars($_POST['firstname']); 
  $surname    = htmlspecialchars($_POST['surname']);
  $email      = htmlspecialchars($_POST['email']);
  $phone      = htmlspecialchars($_POST['phone']);
  $address    = htmlspecialchars($_POST['address']);
  $zip        = htmlspecialchars($_POST['zip']);
  $city       = htmlspecialchars($_POST['city']);

  echo "<pre>";
  print_r($_POST);
  echo "<pre>";

    // kolla ifall email existerar i db
    $sql2 = "SELECT * FROM `customers` WHERE email = '$checkEmail'";  
    $stmt2 = $db->prepare($sql2);
    $stmt2->execute();
          
    $result = false; 
    while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
      $result = true; 
      echo "<pre>";
      print_r($row2);
      echo "<pre>";
      echo "<br><br>"."KUNDEN EXSISTERAR"."<br><br>";
      // lägg till order till rätt kund
      // ta kund id:t
      // hämta kund info lägg till order 
            
      // $stmt = $db->prepare($sql);
      // $stmt->execute();
      // $sql = "UPDATE customers SET firstname = 'Hej', surname = 'Svejs' WHERE firstname = 'Kalle' ";
      //       $stmt = $db->prepare($sql);
      //       $stmt->execute();

    }
    if(!$result){ // skapa ny kund och koppla order
      echo "existerar inte";
      $firstname  = htmlspecialchars($_POST['firstname']); 
      $surname    = htmlspecialchars($_POST['surname']);
      $email      = htmlspecialchars($_POST['email']);
      $phone      = htmlspecialchars($_POST['phone']);
      $address    = htmlspecialchars($_POST['address']);
      $zip        = htmlspecialchars($_POST['zip']);
      $city       = htmlspecialchars($_POST['city']);

      $sql = "INSERT INTO `customers` (`customer_id`, `firstname`, `surname`, `streetadress`, `city`, `zip-code`, `phone`, `email`) 
      VALUES (NULL, 'Anders', 'Pluttt', 'DSADsdasdadas', 'dasda', '34567', '2345674567', 'stina@asdasda.aw');";
      $stmt = $db->prepare($sql);
      $stmt->execute();

      // header('Location:order-confirmation.php');
    } else{

    }
  }
?>
