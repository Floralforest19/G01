<?php
/**************************************** *
  * read info from db & display products 
**************************************** */
  // koppla till databas
  require_once '../db.php';
?>

  <h2>Produkter</h2>
   <button> <a href='create-product.php'>Skapa ny produkt</a> </button> 

<div class='products__display'>

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

$productsBox = "<div class='product__wrapper'>";

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  // test
  // print_r($row);
  $name = htmlspecialchars($row['name']);
  $id = htmlspecialchars($row['product_id']); 

   
  $productsBox .= "<article class='box'>
  <div class='box__pic'>
    <img src='../images/toalettpapper.jpg' alt='toalettpapper'/>
  </div>
  <div class='box__text'>
    <h3>$name</h3>
      <a href='#' class='product__btn'>Redigera</a>
      <a href='#' class='product__btn'>Ta bort</a>
    </div>
"; 


  $table .= "<tr>
              <td>   <img src='../images/toalettpapper.jpg' alt='toalettpapper'/></td>
              <td> $name </td>
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
else 
{
    echo $productsBox;  
}	 
?>

</div>
