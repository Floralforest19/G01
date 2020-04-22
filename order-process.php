<?php 

require_once "header.php";
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'):

    
// Hämta och rensa data från POST-Arrayen
  $product_id    = htmlspecialchars($_POST['product_id']); 
  $customer_id = htmlspecialchars($_POST['customer_id']);


$sql = "SELECT * FROM customers WHERE customer_id=:id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $customer_id);
$stmt->execute();

// Om kunden saknas skapa ett felmeddelande
if ($stmt->rowCount() == 0) {
    $message = "<div>
                <p>Du finns inte med i vårt register. Vill du registrera dig?</p>
                <button>Ja</button>
                <button>Nej</button>
                </div>";
} 

else { // Ja kunden finns i databasen.
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = htmlspecialchars($row['firstname']);
    $email = htmlspecialchars($row['email']);

    $message = "<div>
                <h3>Tack $name!</h3>
                <p>Din beställning är nu genomförd och en orderbekräftelse har skickats till $email
                <br><br>
                Fakturan skickas separat</p>
                </div>";
    //Skicka beställningen till databasen
    /*$sql = "INSERT INTO orders(customer_id)
            VALUES (:customer_id)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->execute();
    }*/
}

echo $message;
    

endif;  