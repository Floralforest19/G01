<?php
/**************************************** *
  * read info from db & display products 
**************************************** */
  // koppla till databas
  require_once '../db.php';
  require_once 'header-admin.php';
?>

  <h2>Produkter</h2>
   <button> <a href='create-product.php'>Skapa ny produkt</a> </button> 
 
<div class='products__display'>

<?php 


$table = '<table class="table">';
$table .= '<tr>
<th>Bild</th>
<th>Kategori</th>  
<th>Bild</th>  
<th>Namn</th>
<th>Redigera</th>
<th>Ta bort</th>
</tr>';

$productsBox = "<div class='product__wrapper'>";

// all info om produkter
$sql = "SELECT * FROM product";
$stmt = $db->prepare($sql);
$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  // test
  // print_r($row);
  $name = htmlspecialchars($row['name']);
  $id = htmlspecialchars($row['product_id']);    
  $catId = htmlspecialchars($row['category_id']);
  
  $sqlCat = "SELECT name FROM category WHERE category_id = $catId";
  $stmtCat = $db->prepare($sqlCat);
  $stmtCat->execute();
  $rowCat = $stmtCat->fetch(PDO::FETCH_ASSOC);
  $nameCat = htmlspecialchars($rowCat['name']);
  
  $productsBox .= "<article class='box'>
  <div class='box__pic'>
    <img src='../images/toalettpapper.jpg' alt='toalettpapper'/>
  </div>
  <div class='box__text'>
    <h3>$name</h3>
    <p>$nameCat</p>
      <a href='#' class='product__btn'>Redigera</a>
      <a href='#' class='product__btn'>Ta bort</a>
    </div>
    </article>
"; 


  $table .= "<tr>
              <td>   <img src='../images/toalettpapper.jpg' alt='toalettpapper'/></td>
              <td> $nameCat </td>
              <td> $name </td>
              <td> <a href='update.php?id=$id' 
                  class='btn btn-outline-info'>
                  Redigera
                </a></td>
              <td>
                <a onclick=\"return confirm('Är du säker att du vill radera $name?')\" href='delete.php?id=$id'  
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
