<?php
//
// Program: authorQuoteJSONGenerator.php (2017-09-13) G.J. Watson
//
// Purpose: build static JSON file for Author Quotes
//
// Date       Version Note
// ========== ======= ====================================================
// 2017-09-13 v0.01   First cut of code
//

    set_include_path("<LIB GOES HERE>");
    require_once("dbquote.php");
    require_once("common.php");
    require_once("buildQuoteServicesJSON.php");

    $version  = "v0.01";
    $wrksp    = "<WRKSPACE DIR GOES HERE>";more
    $cdest    = "<DEST DIR GOES HERE>";
    $filename = "ramdomquote.json";
    $debug    = TRUE;

    try {
        debugMessage("Commencing ".basename(__FILE__)." ".$GLOBALS['version']."...");
        $server = new mysqli($GLOBALS['hostname'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database']);
        if ($server->connect_errno) {
            throw new Exception("Unable to retrieve information from the database");
        }
        debugMessage("Connected to host (".$server->host_info.")...");
        //
        // build the authors JSON file
        //
        $output = buildAllQuotesForAuthorJSON($server, 10);
        debugMessage("Writing JSON to file (".jsonFilename($wrksp, $filename).")...");
        if ($file = fopen(jsonFilename($wrksp, $filename), "w")) {
            fputs($file, $output);
            fclose($file);
            if (copy(jsonFilename($wrksp, $filename), $cdest.$filename)) {
                debugMessage("Copied JSON file to (".$cdest.$filename.")...");
            } else {
                printf("ERROR (9999): Failed to copy JSON file from source (".jsonFilename($wrksp, $filename).") to (".$cdest.$filename.")");
            }
        }
        $server->close();
    } catch (Exception $e) {
        debugMessage("ERROR: ".$e->getMessage());
    }
    exit();
?>
