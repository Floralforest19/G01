<?php
require_once '../db.php';
  // header("Content-Type: application/json; charset=UTF-8");  // ange att innehållet är json


/**************************************** *
 * read info from db & display posts
 * different sql-orders depending on which link pushed
 * filters according to categories
**************************************** */

 $sql = "SELECT order_info FROM orders LIMIT 1";



  // genomför sql-förfrågan
  $stmt = $db->prepare($sql);
  $stmt->execute();
  
  
   $productArray = $stmt->fetch(PDO::FETCH_ASSOC);

    $id = ($productArray['order_info']); 
    echo "<p id='test'>".$id."</p>";

    $id = new stdClass(); 
?>

<?php 
$myObj = new stdClass(); 
$myObj->name = "Geeks"; 
$myObj->college="NIT"; 
$myObj->gender = "Male"; 
$myObj->age = 30; 

$myJSON = json_encode($myObj); 

echo $myJSON; 
?> 

<!DOCTYPE html> 
<html> 
<body> 
<h1 style = "color:#090; text-align:center;">GeeksforGeeks</h1> 
<p style="font-size:25px">JSON get data from a PHP file on the server.</p> 

<h4>Author Name:</h4> 
<p id="name"></p> 
<h4>College:</h4> 
<p id="college"></p> 
<h4>Gender:</h4> 
<p id="gender"></p> 
<h4>Age:</h4> 
<p id="age"></p> 

<script> 
  var xmlhttp = new XMLHttpRequest(); 

  xmlhttp.onreadystatechange = function() { 
    if (this.readyState == 4 && this.status == 200) { 
      myObj = JSON.parse(this.responseText); 
      document.getElementById("name").innerHTML = myObj.name; 
      document.getElementById("college").innerHTML = myObj.college; 
      document.getElementById("gender").innerHTML = myObj.gender; 
      document.getElementById("age").innerHTML = myObj.age; 
    } 
  }; 
  xmlhttp.open("GET", "geeks.php", true); 
  xmlhttp.send(); 
</script> 

</body> 
</html> 


