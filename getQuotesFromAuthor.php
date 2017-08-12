<?php
//
// Program: getQuotesFromAuthor.php (2017-08-11) G.J. Watson
//
// Purpose: Return JSON containing all quotes from an author
//
// Date       Version Note
// ========== ======= ====================================================
// 2017-08-11 v0.01   First cut of code
//

    set_include_path("<LIB GOES HERE>");

    require_once("dbquote.php");
    require_once("constants.php");
    require_once("common.php");
    require_once("checkAccess.php");
    require_once("buildQuoteServicesJSON.php");
    require_once("logRequest.php");

    function processAuthorsServiceRequest($token, $author) {
        $debug = TRUE;
        try {
            debugMessage("Commencing ".basename(__FILE__)." ".$GLOBALS['version']."...");
            $server = new mysqli($GLOBALS['hostname'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database']);
            if ($server->connect_errno) {
                throw new Exception("Unable to retrieve information from the database");
            }
            debugMessage("Connected to host (".$server->host_info.")...");
            $id = checkAccess($server, $token);
            if ($id < 0) {
                $json = json_encode(array("status" => $id, "msg" => serviceErrorMessage($id)), JSON_NUMERIC_CHECK);
            } else {




                //
                // if we've been supplied a value for the author, validate it!
                //
                if (!isset($author) || !is_numeric($author)) {
                    debugMessage("Author ID either not supplied, or not numeric...");
                    $drawLimit = 50;
                }



                $json = buildActiveAuthorsJSON($server);
                logRequest($server, $_SERVER['REMOTE_ADDR'], $id);




            }
            $server->close();
        } catch (Exception $e) {
            $json = json_encode(array("status" => 10000, "msg" => "DBERROR: ".$e->getMessage()), JSON_NUMERIC_CHECK);
        }
        return $json;
    }

    if($_SERVER['REQUEST_METHOD'] <> "GET") {
        $json = json_encode(array("status" => REAQMETHODERROR, "msg" => serviceErrorMessage(REAQMETHODERROR)), JSON_NUMERIC_CHECK);
    } else {
        if (! $_GET["token"] || empty($_GET["token"])) {
            $json = json_encode(array("status" => ACCESSTOKENMISSING, "msg" => serviceErrorMessage(ACCESSTOKENMISSING)), JSON_NUMERIC_CHECK);
        } else {
            $json = processAuthorsServiceRequest($_GET["token"], $_GET["author"]);
        }
    }

    header('Content-type: application/json;charset=utf-8');
    echo $json;
?>
