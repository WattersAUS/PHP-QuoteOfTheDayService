<?php
//
// Module: buildQuoteServicesJSON.php (2017-08-11) G.J. Watson
//
// Purpose: Return JSON strings for Quote Services
//
// Date       Version Note
// ========== ======= ====================================================
// 2017-08-11 v0.01   First cut of code
// 2017-08-12 v1.00   First release with Random Quote function
//

    require_once("common.php");
    require_once("sqlquote.php");

    $version = "v1.00";

    function buildAuthorsJSONContents($item) {
        $msg = "Process author info for (".$item["name"].")...";
        debugMessage($msg);
        $authorInfo["id"]        = $item["id"];
        $authorInfo["name"]      = $item["name"];
        $authorInfo["period"]    = $item["period"];
        $authorInfo["added"]     = $item["added"];
        return $authorInfo;
    }

    function buildActiveAuthorsJSON($db) {
        try {
            //
            // all authors that have at least onw quote in the db
            //
            if (!$authors = $db->query(getActiveAuthorsSQL())) {
                throw new Exception("Unable to retrieve author information");
            }
            //
            // iterate through 'authors'
            //
            debugMessage("Commencing to process active authors...");
            while ($row = $authors->fetch_array(MYSQLI_ASSOC)) {
                $json[] = buildAuthorsJSONContents($row);
                debugMessage("Author (".$row["name"].") processed...");
            }
            //
            // format as JSON and save out to a file
            //
            $outputArray["version"]    = $GLOBALS['version'];
            $outputArray["generated"]  = getGeneratedDateTime();
            $outputArray["service"]    = "activeauthors";
            $outputArray["authors"]    = $json;
            $outputArray["msg"]        = "SUCCESS";
            $outputArray["status"]     = 0;
        } catch (Exception $e) {
            $outputArray["msg"]        = "ERROR: ".$e->getMessage();
            $outputArray["status"]     = 999;
        }
        return json_encode($outputArray, JSON_NUMERIC_CHECK);
    }

    function buildQuoteJSONContents($item) {
        $msg = "Process quote for author (".$item["name"].")...";
        debugMessage($msg);
        $quoteInfo["quote_text"] = $item["quote_text"];
        $quoteInfo["times_used"] = $item["times_used"];
        return $quoteInfo;
    }

//    function buildAuthorRandomQuoteJSON($author_id) {
//        $msg = "Process author quote for (".$row["name"].")...";
//        debugMessage($msg);
//        $quoteInfo["id"]        = 0;
//        $quoteInfo["name"]      = "Service not yet available...";
//        $quoteInfo["period"]    = "";
//        $quoteInfo["added"]     = "N/A";
//        return $quoteInfo;
//    }

    function getRandomQuoteJSON($db, $least) {
        //
        // get all the quotes used the least number of times
        //
        debugMessage("Loading quotes used ".$least["usagecount"]." times for selection...");
        if (!$quote = $db->query(getLeastUsedQuotesSQL($least["usagecount"]))) {
            throw new Exception("Unable to retrieve least used quotes");
        }
        //
        // iterate through 'quotes'
        //
        $loaded = [];
        while ($row = $quote->fetch_array(MYSQLI_ASSOC)) {
            debugMessage("Loading quote id: ".$row["id"]." from ".$row["name"]."...");
            $loaded[] = $row;
        }
        if (sizeof($loaded) == 0) {
            throw new Exception("No quotes retrieved!");
        }
        debugMessage("Loaded ".sizeof($loaded)." quotes used ".$least["usagecount"]." times...");
        $select = rand(0, sizeof($loaded) - 1);
        $item   = $loaded[$select];
        debugMessage("Selected Quote from array position ".$select.", id: ".$item["quote_id"]."...");
        $json          = buildAuthorsJSONContents($item);
        $json["quote"] = buildQuoteJSONContents($item);
        //
        // finally incr the quote used times on the selected
        //
        if ($db->query(incrQuoteTimesUsedSQL($item["quote_id"])) != TRUE) {
            throw new Exception("Unable increment the times_used for the selected quote");
        }
        return $json;
    }

    function buildRandomQuoteJSON($db) {
        try {
            //
            // get the least number of times a quote has been used
            //
            if (!$leastUsed = $db->query(getLeastTimesUsedSQL())) {
                throw new Exception("Unable to retrieve least used information");
            }
            debugMessage("Commencing to process active authors...");
            if ($row = $leastUsed->fetch_array(MYSQLI_ASSOC)) {
                $json[] = getRandomQuoteJSON($db, $row);
            }
            //
            // build the array that the JSON will be generated from
            //
            $outputArray["version"]    = $GLOBALS['version'];
            $outputArray["generated"]  = getGeneratedDateTime();
            $outputArray["service"]    = "randomquote";
            $outputArray["authors"]    = $json;
            $outputArray["msg"]        = "SUCCESS";
            $outputArray["status"]     = 0;
        } catch (Exception $e) {
            $outputArray["msg"]        = "ERROR: ".$e->getMessage();
            $outputArray["status"]     = 999;
        }
        return json_encode($outputArray, JSON_NUMERIC_CHECK);
    }
?>
