<?php
session_start();

//Get current url path
$request = $_SERVER['REQUEST_URI'];

//Remove get params from url
$request = explode("?", $request)[0];

#$request = str_replace("/mickans","",$request);

//Global variabel that stores variables from url
global $URL_VAR;
$URL_VAR = [];

//check if api
if (strpos($request, '/api') === 0) {
    $isApi = true;
    header('Content-Type: application/json');
}

//Parse url params
function parseUrl($url, $path)
{
    $path = explode("/", $path);
    $url = explode("/", $url);

    $i = 0;
    foreach ($url as $part) {
        $isvar = strpos($path[$i], ':');
        if ($part != $path[$i] && $isvar !== 0) {
            return false;
        }

        //Url variable exists. Save to global variable
        if ($isvar === 0) {
            $GLOBALS['URL_VAR'][str_replace(":", "", $path[$i])] = $part;
        }
        $i++;
    }

    return true;
};

function renderpage($pagepath, $protected = false)
{
    //If user is not signed in. Redirect to signin
    if ($protected and !$_SESSION['userid']) {
        header("Refresh:0; url=/signin");
    }

    $page = $pagepath;
    require_once("./web/templates/layout.php");
};

/*---------------------------------------------------------------------*/
/* Routing */


switch ($request) {
    case '/':
        renderpage('./web/pages/test.php');
        break;
    case parseUrl($request, '/api/test'):
        require_once './api/test.php';
        break;
    case parseUrl($request, '/api/test/:id'):
        require_once './api/test.php';
        break;
    case '/signout':
        //logout by killing session
        session_destroy();
        header("Refresh:0; url=/");
        break;
    default:
        http_response_code(404);
        echo '{"error": true, "message": "Resource does not exist"}';
        exit();
}


/*---------------------------------------------------------------------*/
/* API. We rely on that all of this functions exists in the corresponding endpoint */
if ($isApi) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            try {
                http_response_code(201);
                POST();
            } catch (exception $e) {
                error_log($e);
                throwApiMessage("A unkown error occured", 500);
            }
            break;
        case 'PUT':
            try {
                http_response_code(200);
                PUT();
            } catch (exception $e) {
                error_log($e);
                throwApiMessage("A unkown error occured", 500);
            }
            break;
        case 'DELETE';
            try {
                http_response_code(202);
                DELETE();
            } catch (exception $e) {
                error_log($e);
                throwApiMessage("A unkown error occured", 500);
            }
            break;
        case 'GET';
            try {
                http_response_code(200);
                GET();
            } catch (exception $e) {
                error_log($e);
                throwApiMessage("A unkown error occured", 500);
            }
            break;
    }
}

//Reset db connection
$db = null;
