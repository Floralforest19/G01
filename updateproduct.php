<?php 

/**************************************** *
 1. Get a product
 2. Update a product
**************************************** */

header("Content-Type: application/json; charset=UTF-8");

require_once 'db.php';

//Get product info
if(isset($_GET['product_id'])){
    $product_id = htmlspecialchars($_GET['product_id']);
    $sql = "SELECT * FROM product WHERE product_id = :product_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':product_id' , $product_id );
    $stmt->execute();
  
    if($stmt->rowCount() > 0){
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $name = $row['name'];
      $description  = $row['description'];
      $quantity  = $row['quantity'];
      $image_file_name  = $row['image_file_name'];
      $price  = $row['price'];
      $category_id  = $row['category_id'];

      //https://www.w3schools.com/js/js_json_php.asp
      $productResponse = new \stdClass(); //https://stackoverflow.com/questions/8900701/creating-default-object-from-empty-value-in-php
      $productResponse->product_id=$product_id;
      $productResponse->name=$name;
      $productResponse->description=$description;
      $productResponse->quantity=$quantity;
      $productResponse->image_file_name=$image_file_name;
      $productResponse->price=$price;
      $productResponse->category_id=$category_id;

      $json = json_encode($productResponse,
      JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

      http_response_code(200);
      
      echo $json;
      
    }else{
        http_response_code(404);
      exit;
    }
  
  }



//Update product 
if($_SERVER['REQUEST_METHOD'] === 'POST'){

  //if we want to post as json
    $data = json_decode(file_get_contents('php://input'), true);
    $product_id = htmlentities($data['product_id']);
    $name = htmlentities($data['name']);
    $description  = htmlentities($data['description']);
    $quantity   = htmlentities($data['quantity']);
    $image_file_name = htmlentities($data['image_file_name']);
    $price = htmlentities($data['price']);
    $category_id = htmlentities($data['category_id']);
  
    //if we want to post as form data
    /* $product_id = htmlentities($_POST['product_id']);
    $name = htmlentities($_POST['name']);
    $description  = htmlentities($_POST['description']);
    $quantity   = htmlentities($_POST['quantity']);
    $image_file_name = htmlentities($_POST['image_file_name']);
    $price = htmlentities($_POST['price']);
    $category_id = htmlentities($_POST['category_id']);
*/

    $update = "UPDATE product
            SET 
            name = :name, 
            description = :description, 
            quantity = :quantity, 
            image_file_name = :image_file_name,
            price = :price,
            category_id = :category_id
            WHERE product_id = :product_id";
  
    $stmt = $db->prepare($update);
  
    $stmt->bindParam(':name' , $name );
    $stmt->bindParam(':description'  , $description);
    $stmt->bindParam(':quantity'  , $quantity);
    $stmt->bindParam(':image_file_name', $image_file_name);
    $stmt->bindParam(':price'  , $price);
    $stmt->bindParam(':category_id'  , $category_id);
    $stmt->bindParam(':product_id'  , $product_id);
  
    $stmt->execute();
    exit;
  }


?>