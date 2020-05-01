<?php /**************************************** *
  * read info from db & show messages
**************************************** */
require_once 'header-admin.php';
require_once '../db.php';
?>

<section class='background'>

  <h2>Kundmeddleanden</h2>
  <div class='box__cat--form'>
    <p>
      Sortera på e-mail
      <a href='read-contact.php?id=contactemail&order_sort=ASC' id='sumSort'><i class="fas fa-angle-up"></i></a>
      <a href='read-contact.php?id=contactemail&order_sort=DESC' id='sumSort'><i class="fas fa-angle-down"></i></a>
      <br>
      Sortera på datum
      <a href='read-contact.php?id=contactname&order_sort=ASC' id='sumSort'><i class="fas fa-angle-up"></i></a>
      <a href='read-contact.php?id=contactname&order_sort=DESC' id='sumSort'><i class="fas fa-angle-down"></i></a>
    </p>
  </div>
<?php
    // visa meddelanden
    if( isset($_GET['id']) ){
      $id = htmlentities($_GET['id']);
      $orderSort = htmlentities($_GET['order_sort']);
      // hämta från beställningar istället
      $sql = "SELECT * FROM contactform ORDER BY $id $orderSort";
    } else {
      $sql = "SELECT * FROM contactform ORDER BY contactemail";;
    }
    
    $stmt = $db->prepare($sql);
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
      echo "<div class='box__cat--form'><table class='table__cat'><tr>";
      $id = htmlspecialchars($row['id']);
      $name = htmlspecialchars($row['contactname']);
      $message = htmlspecialchars($row['contactmessage']);
      $phone = htmlspecialchars($row['contactphone']);
      $email = htmlspecialchars($row['contactemail']);
      $date = htmlspecialchars($row['contactdate']);
      echo "<p>$date</p>";
      echo "<h3>$name</h3>";
      echo "<h4>$email</h4>";
      echo "<h4>$phone</h4>";
      echo "<p>$message</p>";
      echo "</div></tr></table></div>";
    endwhile;
  ?>
    
</section>
</body>
</html>