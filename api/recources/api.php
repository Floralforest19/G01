<?php
require_once './recources/db.php';

//Signin if http header basic auth exists
if ($_SERVER['HTTP_AUTHORIZATION']) {
    //try signing in.
    signIn();
}

function checkauth()
{
    if ($_SESSION['userid']) {
        return true;
    } else {
        throwApiMessage("unauthorized", 401);
    }
}

function buildQueryString($sql = "", $authkeys = array())
{
    $db = $GLOBALS['db'];
    //$authkeys. keys that need authentication to be accessed
    //array("column" => "value"). * == restrict all values

    //Build query string
    if ($_GET['queryParam']) {
        $sql = " WHERE ";
        //create array from query. Delimiter should be ^
        $query = explode("^", $_GET['queryParam']);
        $num = 0;
        foreach ($query as $part) {
            //Check if starts with OR. Else it's and
            if (substr($part, 0, 2) === "OR") {
                //Remove OR from string
                $part = substr($part, strlen("OR"));

                $sql .= " OR ";
            } else if ($num != 0) {
                $sql .= " AND ";
            }

            //Expload = [0] == key, [1] == value
            $part = explode("=", $part);

            //check that value exists for key
            if (!$part[1]) {
                throwApiMessage("Provde a value for column, " . $part[0], 401);
                //Check if user is authenticated to view the specific column
            } else if (array_key_exists($part[0], $authkeys) and ($authkeys[$part[0]] == $part[1] or $authkeys[$part[0]] == "*") and !$_SESSION['userid']) {
                throwApiMessage("You need to signin to view this column, " . $part[0], 401);
                //Else. Check that column is only letters
            } else if (!ctype_alpha($part[0])) {
                throwApiMessage("Invalided format of column, " . $part[0], 500);
            }

            $sql .= $part[0] . " = " . $db->quote($part[1]);

            $num++;
        }
    } else if (!empty($authkeys) and !$_SESSION['userid']) {
        $sql = " WHERE ";
        //Exclude row from result if authkeys exists.
        $i = 0; //Count itterations in foreach
        $len = count($authkeys); //to know if last itteration
        foreach ($authkeys as $key => $val) {
            //Last
            if ($val == "*") {
            } elseif ($i == $len - 1) {
                $sql .= $key . " != '" . $val . "'";
            } else {
                $sql .= $key . " != '" . $val . "' AND ";
            }
        }
    }

    if ($_GET['limit']) {
        //Check if limit is int
        if (!filter_var($_GET['limit'], FILTER_VALIDATE_INT)) {
            throwApiMessage("limit can only be an int", 400);
        }

        $sql .= " LIMIT " . $_GET['limit'];
    }

    if ($_GET['offset']) {
        //check if offset int
        if (!filter_var($_GET['offset'], FILTER_VALIDATE_INT)) {
            throwApiMessage("offset can only be an int", 400);
        }

        $sql .= " OFFSET " . $_GET['offset'];
    }


    if ($_GET['orderby']) {
        //Check asc desc
        $orderby = explode("=", $_GET['orderby']);

        //Check that column is only letters
        if (!ctype_alpha($orderby[0])) {
            throwApiMessage("Invalided format of column, " . $orderby[0], 500);
        }

        $sql .= " ORDER BY " . $orderby[0];

        if ($orderby[1]) {
            $orderby[1] = strtoupper($orderby[1]);
            if ($orderby[1] == "ASC" or $orderby[1] == "DESC") {
                $sql .= " " . strtoupper($orderby[1]);
            } else {
                throwApiMessage("Invalid operator at order by", 400);
            }
        }
    }

    return $sql;
}

function throwApiMessage($message, $statusCode = 500)
{
    $error = false;
    //If statuscode is above 399 is't treated as a error
    if ($statusCode > 399) {
        $error = true;
    }

    //Stringify error

    if ($error) {
        $error = "true";
    } else {
        $error = "false";
    }

    http_response_code($statusCode);
    echo '{"error": "' . $error . '", "message": "' . $message . '"}';
    exit();
}


function signIn()
{
    $db = $GLOBALS['db'];

    //Check if auth header exist
    if ($_SERVER['HTTP_AUTHORIZATION']) {
        //parse password
        //Remove Basic from string
        $auth = substr($_SERVER['HTTP_AUTHORIZATION'], strlen("Basic "));
        //base64 decode and explode at :
        base64_decode($auth);
        $auth = explode(":", base64_decode($auth));
        $data = array("username" => $auth[0], "password" => $auth[1]);
    } else {
        $data = json_decode(file_get_contents('php://input'), true);
    }

    if (!$data['username'] or !$data['password']) {
        throwApiMessage("Username and/or password can not be empty", 400);
    }

    $sql = "SELECT * FROM Users WHERE username=" . $db->quote($data['username']) . " AND password='" . sha1($data['password']) . "'";
    $stmt = $db->query($sql);

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) == 1) {
        //remove password from array before storing in session
        unset($result[0]['password']);
        $_SESSION['userid'] = $result[0]['userid'];
        $_SESSION['user'] = $result[0];

        if ($_SERVER['HTTP_AUTHORIZATION']) {
            return true;
        } else {
            throwApiMessage("OK", 200);
        }
    } else {
        throwApiMessage("Invalid username or password", 400);
    };
}

function printElementWithId($id, $table)
{
    $db = $GLOBALS['db'];
    $stmt = $db->query("SELECT * FROM $table WHERE " . $id);
    //$stmt->bindParam(':id' , $id);
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}
