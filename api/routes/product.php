<?php
//Inkluderar filen i filen
require_once './recources/api.php';

$GLOBALS['primary_table'] = "product";

function GET($id = false, $internal = false)
{
    if (!$internal) {
        //checkauth();
    }

    $db = $GLOBALS['db'];
    if ($GLOBALS['URL_VAR']['id']) {
        $id = $GLOBALS['URL_VAR']['id'];
    }

    if ($id) {
        $stmt = $db->query("SELECT * FROM " . $GLOBALS['primary_table'] . " WHERE product_id = {$id}");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC)[0]);
    } else {
        //build query. eco result
        $stmt = $db->query("SELECT * FROM " . $GLOBALS['primary_table'] . buildQueryString("", array()));
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
};
function POST()
{
    //checkauth();

    //array som 'är nåbar genom alla funktioner
    $db = $GLOBALS['db'];
    //konverterar meddelandet i JSON från bodyn, till en php array
    $data = json_decode(file_get_contents('php://input'), true);

    //Förbered med sql kommandot med information till kontakt under namn och kontakt 
    $stmt = $db->prepare("INSERT INTO " . $GLOBALS['primary_table'] . " (category_id, description, image_file_name, name, price, quantity)
                        VALUES (:category_id, :description, :image_file_name, :name, :price, :quantity)");

    //Värdena läggs in i db via funktionen bindPram                    
    $stmt->bindParam(':category_id', $data['category_id']);
    $stmt->bindParam(':description', $data['description']);
    $stmt->bindParam(':image_file_name', $data['image_file_name']);
     $stmt->bindParam(':name', $data['name']);
      $stmt->bindParam(':price', $data['price']);
       $stmt->bindParam(':quantity', $data['quantity']);

    $stmt->execute();

    GET($db->lastInsertId());
}
function PUT()
{
    //checkauth();
    $db = $GLOBALS['db'];
    if ($GLOBALS['URL_VAR']['id']) {
        $sql = "UPDATE " . $GLOBALS['primary_table'] . " 
             SET category_id = :category_id, description = :description, image_file_name = :image_file_name, name =:name, price=:price, quantity=:quantity
             WHERE product_id = :id";

        $data = json_decode(file_get_contents('php://input'), true);

        $stmt = $db->prepare($sql);
    $stmt->bindParam(':category_id', $data['category_id']);
    $stmt->bindParam(':description', $data['description']);
    $stmt->bindParam(':image_file_name', $data['image:file_name']);
     $stmt->bindParam(':name', $data['name']);
      $stmt->bindParam(':price', $data['price']);
       $stmt->bindParam(':quantity', $data['quantity']);
        $stmt->execute();

        printElementWithId("product_id=" . $GLOBALS['URL_VAR']['id'], $GLOBALS['primary_table']);
    } else {
        throwApiMessage("Id required", 400);
    }
}
function DELETE()
{
    //checkauth();
    $db = $GLOBALS['db'];
    if ($GLOBALS['URL_VAR']['id']) {
        $sql = "DELETE FROM " . $GLOBALS['primary_table'] . " WHERE product_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $GLOBALS['URL_VAR']['id']);
        $stmt->execute();
        throwApiMessage("Record deleted", 202);
    } else {
        http_response_code(500);
        throwApiMessage("Id required", 400);
    }
};
