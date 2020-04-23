
  <?php require_once '../db.php';

// skapa produkt
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ){
  $name = htmlspecialchars($_POST['name']);
  $description  = htmlspecialchars($_POST['description']);
  $quantity  = ($_POST['quantity']);
  $price  = ($_POST['price']);
  $category_id  = htmlspecialchars($_POST['test']);
  // $image_file_name = htmlspecialchars(basename ($_FILES["image_file_name"]["name"]));



  // räkna antalet filer/bilder som ska laddas upp
  $totalfiles = count($_FILES['image_file_name']['name']);
  
  // Skapa variabel som ska lagra alla bilder
  $imageCollection = "";
  
  // Loopar över alla filer/bilder
  for($i=0;$i<$totalfiles;$i++){
    $target_dir = "../images/";

    //Sparar alla bilder och separerar bildernas sökväg, med två mellanslag, i en string
    $imageCollection .= htmlspecialchars(basename ($_FILES["image_file_name"]["name"][$i])) . " * "; 


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
    }
    

    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Den här bilden finns redan.<br>";
      $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["image_file_name"]["size"][$i] > 5000000) {
    echo "Tyvärr, filen är för stor.<br>";
    $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {

    echo "Tyvärr, bara JPG, JPEG, PNG & GIF är tillåtna filformat.<br>";
    $uploadOk = 0;
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

  }   // Slut på for-loop





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
} 

?>

