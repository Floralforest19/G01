
  <?php require_once '../db.php';

// skapa produkt
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ){
  $name = htmlspecialchars($_POST['name']);
  $description  = htmlspecialchars($_POST['description']);
  $quantity  = ($_POST['quantity']);
  $price  = ($_POST['price']);
  $category_id  = htmlspecialchars($_POST['test']);
  $image_file_name = htmlspecialchars(basename ($_FILES["image_file_name"]["name"]));

  $sql = "INSERT INTO product (name, description, quantity, price, image_file_name, category_id) 
          VALUES ( :name, :description, :quantity, :price, :image_file_name,  :category_id)";
  $stmt = $db->prepare($sql);

  $stmt->bindParam(':name' , $name);
  $stmt->bindParam(':description'  , $description);
  $stmt->bindParam(':quantity' , $quantity );
  $stmt->bindParam(':image_file_name' , $image_file_name );
  $stmt->bindParam(':price' , $price );
  $stmt->bindParam(':category_id' , $category_id );

  $stmt->execute();
} 

$target_dir = "../images/";
$target_file = $target_dir . basename($_FILES["image_file_name"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image

if(isset($_POST["submit"])) {
$check = getimagesize($_FILES["image_file_name"]["tmp_name"]);
if($check !== false) {
  echo "<img src='../images/$target_file' class='img-fluid' alt='$image'><br>";
  $uploadOk = 1;
} else {
  echo "Det här är ingen bild.<br>";
  $uploadOk = 0;
}
}

// Check if file already exists
if (file_exists($target_file)) {
echo "Den här bilden fanns redan.<br>";
$uploadOk = 0;
}
// Check file size
if ($_FILES["image_file_name"]["size"] > 500000) {
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
if (move_uploaded_file($_FILES["image_file_name"]["tmp_name"], $target_file)) {
  echo " Bilden ". basename( $_FILES["image_file_name"]["name"]). " har laddats upp.<br>";
} else {
  echo "Tyvärr, det blev något fel vid uppladdning av fil.<br>";
}
}
  echo "</div></tr>";
?>

