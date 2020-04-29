
  <?php require_once '../db.php';

// skapa produkt
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ){
  $name = htmlspecialchars($_POST['name']);
  $description  = htmlspecialchars($_POST['description']);
  $quantity  = ($_POST['quantity']);
  $price  = ($_POST['price']);
  $category_id  = htmlspecialchars($_POST['test']);



  // räkna antalet filer/bilder som ska laddas upp
  $totalfiles = count($_FILES['image_file_name']['name']);
  
  // Skapa variabel som ska lagra alla bilder
  $imageCollection = "";
  $imageCounter = 0;  // Räknar bilderna som läggs upp. Max 5

  // Kontrollerar ifall en bild är uppladdad genom att räkna längden på första variabeln i bild-arrayn
  if (strlen(htmlspecialchars(basename ($_FILES["image_file_name"]["name"][0]))) > 1) {
    // Loopar över alla filer/bilder
    for($i=0;$i<$totalfiles;$i++){


      $target_dir = "../images/";

      $addImageCollection = 1;  // Variabel som används för att se ifall bildens sökväg ska läggas till i produktens tabell.
      
      
      $target_file = $target_dir . basename($_FILES["image_file_name"]["name"][$i]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

      
      $check = getimagesize($_FILES["image_file_name"]["tmp_name"][$i]);
      if($check !== false) {
        echo "<img src='$target_file' class='img-fluid' alt='$name'><br>";
        $uploadOk = 1;
      } else {
        echo "Det här är ingen bild.<br>";
        $uploadOk = 0;
        $addImageCollection = 0;
        
      }
      
      
      // Check if file already exists
      if (file_exists($target_file)) {
        echo "Den här bilden finns redan.<br>";
        $uploadOk = 0;
      }
      // Check file size
      if ($_FILES["image_file_name"]["size"][$i] > 1000000) {  // Begränsad till 1MB
        echo "Tyvärr, filen är för stor.<br>";
        $uploadOk = 0;
      $addImageCollection = 0;
      }
      
      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
        
        echo "Tyvärr, bara JPG, JPEG, PNG & GIF är tillåtna filformat.<br>";
        $uploadOk = 0;
        $addImageCollection = 0;
      }
      
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
        
        echo "Filen gick inte att ladda upp.";
        // if everything is ok, try to upload file
      } else {
      
        if (move_uploaded_file($_FILES["image_file_name"]["tmp_name"][$i], $target_file)) {
          echo " Bilden ". basename( $_FILES["image_file_name"]["name"][$i]). " har laddats upp.<br>";
        } else {
          echo "Tyvärr, det blev något fel vid uppladdning av fil.<br>";
        }
        echo "</div></tr>";
      }

      // Om $addImageCollection är "1" så kommer bildens sökväg att läggat till under produktens image_file_name kolumn
      if ($addImageCollection == 1) {
        //Sparar alla bilder och separerar bildernas sökväg, med två mellanslag, i en string
        $imageCollection .= htmlspecialchars(basename ($_FILES["image_file_name"]["name"][$i])) . " * ";
      }
      $imageCounter++;
      if ($imageCounter >= 5) {
        header("Location:create-product.php?uppladdning=fel");
        exit;
      }
    }   // Slut på bildernas for-loop.
  }   // Slut på if-sats som kollar ifall bild variabeln är tom.

  
  
  
  
  $sql = "INSERT INTO product (name, description, quantity, price, image_file_name, category_id) 
          VALUES ( :name, :description, :quantity, :price, :imageCollection,  :category_id)";
  $stmt = $db->prepare($sql);
  
  

  $stmt->bindParam(':name' , $name);
  $stmt->bindParam(':description'  , $description);
  $stmt->bindParam(':quantity' , $quantity );
  $stmt->bindParam(':imageCollection' , $imageCollection);
  $stmt->bindParam(':price' , $price );
  $stmt->bindParam(':category_id' , $category_id );

  $stmt->execute();

  header("Location:index.php"); // Efter att produkten skapats hamnar man på startsidan för admin
  exit;
} 

?>

