<?php require_once '../db.php';

// skapa produkt
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ){
  $name         = htmlspecialchars($_POST['name']);
  $description  = htmlspecialchars($_POST['description']);
  $quantity     = htmlspecialchars($_POST['quantity']);
  $price        = htmlspecialchars($_POST['price']);
  $category_id  = htmlspecialchars($_POST['test']);

  // räkna antalet filer/bilder som ska laddas upp
  $totalfiles = count($_FILES['image_file_name']['name']);
  
  // Skapa variabel som ska lagra alla bilder
  $imageCollection = "";
  $imageCounter    = 0;  // Räknar bilderna som läggs upp. Max 5

  $imageUploadError = 0;  // Säger till ifall det blev fel på någon uppladdning och visar bild-krav på nästa sida

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
        // echo "<img src='$target_file' class='img-fluid' alt='$name'><br>";      // **
        $uploadOk = 1;
      } else {
        // echo "Det här är ingen bild.<br>";      // **
        $uploadOk = 0;
        $addImageCollection = 0;
        $imageUploadError = 1;
      }
      
      
      // Check if file already exists
      if (file_exists($target_file)) {
        // echo "Den här bilden finns redan.<br>";      // **
        $uploadOk = 0;
      }
      // Check file size
      if ($_FILES["image_file_name"]["size"][$i] > 2000000) {  // Begränsad till 2MB
        // echo "Tyvärr, filen är för stor.<br>";      // **
        $uploadOk = 0;
        $addImageCollection = 0;
        $imageUploadError = 1;
      }
      
      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
        
        // echo "Tyvärr, bara JPG, JPEG, PNG & GIF är tillåtna filformat.<br>";      // **
        $uploadOk = 0;
        $addImageCollection = 0;
        $imageUploadError = 1;
      }
      
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0 && $imageCounter < 5) {
        

        // echo "Filen gick inte att ladda upp.";      // **
        
      } else {    // if everything is ok, try to upload file
      
        if (move_uploaded_file($_FILES["image_file_name"]["tmp_name"][$i], $target_file)) {
          //echo " Bilden ". basename( $_FILES["image_file_name"]["name"][$i]). " har laddats upp.<br>";
        } else {
          //echo "Tyvärr, det blev något fel vid uppladdning av fil.<br>";
          $imageUploadError = 1;
      }
        //echo "</div></tr>";
      }

      // Om $addImageCollection är "1" så kommer bildens sökväg att läggat till under produktens image_file_name kolumn
      if ($addImageCollection == 1 && $imageCounter < 5) {
        //Sparar alla bilder och separerar bildernas sökväg, med två mellanslag, i en string
        $imageCollection .= htmlspecialchars(basename ($_FILES["image_file_name"]["name"][$i])) . " * ";
      }
      $imageCounter++;
      if ($imageCounter > 5) {
        $imageUploadError = 1;
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

  $sql4  ="SELECT product_id FROM product ORDER BY product_id DESC LIMIT 1";
  $stmt4 = $db->prepare($sql4);
  $stmt4->execute();

  $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
  $new_product_id = $row4['product_id'];

  if ($imageUploadError > 0) {
    header("Location:new-update-site.php?product_id=$new_product_id&uppladdning=error&new=true");
    exit;
  }else {
    header("Location:new-update-site.php?product_id=$new_product_id&new=true"); // Efter att produkten skapats hamnar man på startsidan för admin
    exit;
  }
} 

?>

