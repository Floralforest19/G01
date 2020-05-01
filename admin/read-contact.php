<?php /**************************************** *
  * read info from db & show messages
**************************************** */
require_once 'header-admin.php';
require_once '../db.php';
?>

<section class='background'>

  <h2>Kundmeddleanden</h2>
<?php
    // visa kategorierna
    $sql = "SELECT * FROM contactform ORDER BY contactemail";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
      echo "<div class='box__cat--form'><table class='table__cat'><tr>";
      $id = htmlspecialchars($row['id']);
      $name = htmlspecialchars($row['contactname']);
      $message = htmlspecialchars($row['contactmessage']);
      $phone = htmlspecialchars($row['contactphone']);
      $email = htmlspecialchars($row['contactemail']);
      echo "<h3>$name</h3>";
      echo "<p>$email</p>";
      echo "<p>$phone</p>";
      echo "<p>$message</p>";
      echo "</div></tr></table></div>";
    endwhile;
  ?>

</section>
</body>
</html>
