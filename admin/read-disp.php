<?php
/**************************************** *
  * read info from db & display products 
**************************************** */
  // koppla till databas
  require_once '../db.php';
?>

<div class='products__display'>
  <h2>Produkter</h2>
   <button> <a href='create-product.php'>Skapa ny produkt</a> </button> 
<div> 

<?php 

$sql = "SELECT * FROM product";
$stmt = $db->prepare($sql);
$stmt->execute();


$table = '<table class="table">';
$table .= '<tr>
<th>Bild</th>  
<th>Namn</th>
<th>Redigera</th>
<th>Ta bort</th>
</tr>';

$productsBox = '<div class="products__container">';

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  // test
  // print_r($row);
  $heading = htmlspecialchars($row['name']);
  $id = htmlspecialchars($row['product_id']); 

   
  $productsBox .= "<br>
  <div class='products__item'>
    <div class='products__item--img'>
    <br>
    <p>Plats för bild8</p>
    <br>
    </div>
    <div class='products__item--text'>
      <h2>$heading</h2>
      <a href='#' class='product__btn'>Redigera</a>
      <a href='#' class='product__btn'>Ta bort</a>
    </div>
  </div>
<br>
"; 


  $table .= "<tr>
              <td> Plats för bild3 </td>
              <td> $heading </td>
              <td> <a href='update.php?id=$id' 
                  class='btn btn-outline-info'>
                  Redigera
                </a></td>
              <td>
                <a href='delete.php?id=$id' 
                  class='btn btn-outline-danger'>
                  Ta bort
                </a>
              </td>
            </tr>";
}
$table .= '</table>';

$productsBox .= '</div>';


// echo $productsBox;  

// echo $table;

?>

<form action="#" method="post">
Visa som lista
    <input type="checkbox" name="formProductList" value="Yes" />
Visa som bildprodukter

    <input type="checkbox" name="formProductBox" value="No" />

    <input type="submit" name="formSubmit" value="Submit" />
</form>

<?php

if(isset($_POST['formProductList']) && 
   $_POST['formProductList'] == 'Yes') 
{
    echo $table;
}
else if (isset($_POST['formProductBox']) && 
$_POST['formProductBox'] == 'No') 
{
    echo $productsBox;  
}	 
?>

