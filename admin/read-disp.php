<?php
/**************************************** *
  * read info from db & display products 
**************************************** */
  // koppla till databas
  require_once '../db.php';
?>

<h2>Produkter</h2>
<a href='create-product.php'> <button class='product__btn'> Skapa ny produkt</button> </a> 

<div class='products__display'>

    <?php 


$table = '<table class="table">';
$table .= '<tr>
<th>Bild</th>
<th>Kategori</th>  
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


  $bilder = htmlspecialchars($row['image_file_name']);

  // Splittar upp alla bilder i en array
  $bilderArray = explode(" * ", $bilder);
  $förstaBild = $bilderArray[0];

  // Ifall produkten inte har en bild så blir det standardbilden som är toapapper just nu
  if ($förstaBild == "") {
    $förstaBild = "toalettpapper.jpg";
  }

  
  $sqlCat = "SELECT name FROM category WHERE category_id = $catId";
  $stmtCat = $db->prepare($sqlCat);
  $stmtCat->execute();
  $rowCat = $stmtCat->fetch(PDO::FETCH_ASSOC);
  $nameCat = htmlspecialchars($rowCat['name']);
  
  $productsBox .= "<article class='box'>
  <div class='box__pic'>
    <img src='../images/$förstaBild' alt='toalettpapper'/>
  </div>
  <div class='box__text'>
    <h3>$name</h3>
    <p>$nameCat</p>
      <a href='updateproduct.php?product_id=$id'> <button class='btn__edit'>Redigera </button></a>
      <a onclick=\"return confirm('Är du säker att du vill radera $name?')\" href='delete-prod.php?id=$id'><button class='btn__delete'>Ta bort </button></a>

    </div>
    </article>
"; 


  $table .= "<tr>
              <td>   <img class='table__pic' src='$förstaBild' alt='toalettpapper'/></td>
              <td> $nameCat </td>
              <td> $name </td>
              <td> <a href='updateproduct.php?product_id=$id'
                  class='btn btn-outline-info'>
                  <button class='btn__edit'> Redigera</button>
                </a></td>
              <td>
                <a onclick=\"return confirm('Är du säker att du vill radera $name?')\" href='delete-prod.php?id=$id'>
                  <button class='btn__delete'> Ta bort</button>
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