<?php
//Inkluderar filen i filen
require_once 'api/api.php';

$GLOBALS['primary_table'] = "Post";

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
        $stmt = $db->query("SELECT * FROM " . $GLOBALS['primary_table'] . " WHERE postid = {$id}");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC)[0]);
    } else {
        //build query. eco result
        $stmt = $db->query("SELECT * FROM " . $GLOBALS['primary_table'] . buildQueryString("", array("published" => "0")));
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
};
function POST()
{
    checkauth();

    //array som 'är nåbar genom alla funktioner
    $db = $GLOBALS['db'];
    //konverterar meddelandet i JSON från bodyn, till en php array
    $data = json_decode(file_get_contents('php://input'), true);

    //Förbered med sql kommandot med information till kontakt under namn och kontakt 
    $stmt = $db->prepare("INSERT INTO " . $GLOBALS['primary_table'] . " (userid, subject, text, published)
                        VALUES (:userid, :subject, :text, :published)");

    //Värdena läggs in i db via funktionen bindPram                    
    $stmt->bindParam(':userid', $_SESSION['userid']);
    $stmt->bindParam(':subject', $data['subject']);
    $stmt->bindParam(':text', $data['text']);
    $stmt->bindParam(':published', $data['published']);

    $stmt->execute();

    GET($db->lastInsertId());
}
function PUT()
{
    checkauth();
    $db = $GLOBALS['db'];
    if ($GLOBALS['URL_VAR']['id']) {
        $sql = "UPDATE " . $GLOBALS['primary_table'] . " 
             SET subject = :subject, text = :text, published = :published
             WHERE postid = :id";

        $data = json_decode(file_get_contents('php://input'), true);

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':subject', $data['subject']);
        $stmt->bindParam(':text', $data['text']);
        $stmt->bindParam(':id', $GLOBALS['URL_VAR']['id']);
        $stmt->bindParam(':published', $data['published']);
        $stmt->execute();

        printElementWithId("postid=" . $GLOBALS['URL_VAR']['id'], $GLOBALS['primary_table']);
    } else {
        throwApiMessage("Id required", 400);
    }
}
function DELETE()
{
    checkauth();
    $db = $GLOBALS['db'];
    if ($GLOBALS['URL_VAR']['id']) {
        $sql = "DELETE FROM " . $GLOBALS['primary_table'] . " WHERE postid = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $GLOBALS['URL_VAR']['id']);
        $stmt->execute();
        throwApiMessage("Record deleted", 202);
    } else {
        http_response_code(500);
        throwApiMessage("Id required", 400);
    }
};
