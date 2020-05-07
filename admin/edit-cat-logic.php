<?php 
  require_once 'header-admin.php';
require_once '../db.php'; 

?>

<section class='background'>

  <h2>Kategorier</h2>

  <div class="box__cat--form box__cat--form--main">

<?php

// kolla om kategori existerat --> ge feedback
        
        if(isset($_POST['catname'])){
          $id      = htmlspecialchars($_GET['id']); 
          $catname = ucfirst(htmlspecialchars($_POST['catname'])); 
          
          // kolla om kategorin finns i databasen
          $sql  = "SELECT `name` FROM `category` WHERE `name` LIKE '$catname'";
          $stmt = $db->prepare($sql);
          $stmt->execute();
          
          // $result sätts till true ifall kategorin existerar
          $result = false; 
          while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $result = true; 
            echo "<p class='search__feedback'>$catname är redan en kategori, ange annat värde.</p>
            <a href='edit-cat.php?id=$id'><button class='btn__catBack btn__sortStatus--active  '><i class='fas fa-angle-left'></i> Ändra</button></a><br>
            <a href='read-cat.php'><button class='btn__catBack '><i class='fas fa-angle-left'></i> Till kategorier</button></a>
            ";
          }
           // skapa ny kategori ifall nytt värde
          if(!$result){
            $sql  = "UPDATE category SET name = '$catname' WHERE category_id = '$id' ";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            echo "<p class='search__feedback'>Kategorin ändrades till:</p> <h3>$catname</h3>
            <a href='read-cat.php'><button class='btn__catBack btn__sortStatus--active '><i class='fas fa-angle-left'></i> Till kategorier</button></a>

            ";


          }
        }
      ?>
</div></section>