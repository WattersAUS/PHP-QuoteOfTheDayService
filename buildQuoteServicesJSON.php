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
// 2017-08-13 v1.01   Return table_ in field names for differentiation
//

    require_once("common.php");
    require_once("sqlquote.php");

    $version = "v1.01";

//
// base arrays author/quote
//

    function buildAuthorsJSONContents($item) {
        debugMessage("Process info for author (".$item["author_name"].")...");
        $authorInfo["author_id"]     = $item["author_id"];
        $authorInfo["author_name"]   = $item["author_name"];
        $authorInfo["author_period"] = $item["author_period"];
        return $authorInfo;
    }

    function buildQuoteJSONContents($item) {
        debugMessage("Process quote for author (".$item["author_name"].")...");
        $quoteInfo["quote_id"]   = $item["quote_id"];
        $quoteInfo["quote_text"] = $item["quote_text"];
        $quoteInfo["times_used"] = $item["times_used"];
        return $quoteInfo;
    }

//
// when a quote is used, update the times_used on the quote rec
//

    function incrementQuoteTimesUsed($db, $quote_id) {
        debugMessage("Increment the times_used on the quote id: ".$quote_id."...");
        if ($db->query(incrQuoteTimesUsedSQL($quote_id)) != TRUE) {
            throw new Exception("Unable increment the times_used for the selected quote");
        }
    }

//
// worker functions doing the main JSON building
//

    function getRandomQuoteJSON($db) {
        //
        // get number representing the 'least used' quotes
        //
        if (!$least = $db->query(getLeastTimesUsedSQL())) {
            throw new Exception("Unable to retrieve least used information");
        }
        debugMessage("Now retrieving the least used quotes...");
        if (!$used = $least->fetch_array(MYSQLI_ASSOC)) {
            throw new Exception("Unable to retrieve least used quote info");
        }
        //
        // get all the quotes used that number of times
        //
        debugMessage("Loading quotes used ".$used["usagecount"]." times for selection...");
        if (!$quotes = $db->query(getLeastUsedQuotesSQL($used["usagecount"]))) {
            throw new Exception("Unable to retrieve least used quotes");
        }
        //
        // iterate through 'quotes'
        //
        $loaded = [];
        while ($quote = $quotes->fetch_array(MYSQLI_ASSOC)) {
            debugMessage("Loading quote id: ".$quote["quote_id"]." from ".$quote["author_name"]."...");
            $loaded[] = $quote;
        }
        if (sizeof($loaded) == 0) {
            throw new Exception("No quotes retrieved!");
        }
        debugMessage("Loaded ".sizeof($loaded)." quotes used ".$used["usagecount"]." times...");
        $select = rand(0, sizeof($loaded) - 1);
        $item   = $loaded[$select];
        debugMessage("Selected Quote from array position ".$select.", id: ".$item["quote_id"]."...");
        $json          = buildAuthorsJSONContents($item);
        $json["quote"] = buildQuoteJSONContents($item);
        incrementQuoteTimesUsed($db, $item["quote_id"]);
        return $json;
    }

    function getAllQuotesJSON($db) {
        if (!$authors = $db->query(getActiveAuthorsSQL())) {
            throw new Exception("Unable to retrieve all quotes");
        }
        $json = [];
        while ($author = $authors->fetch_array(MYSQLI_ASSOC)) {
            $authorJson = buildAuthorsJSONContents($author);
            if (!$quotes = $db->query(getQuoteSQL().setAuthorIDInQuoteSQL($author["author_id"]))) {
                throw new Exception("Unable to retrieve quotes for author");
            }
            debugMessage("Adding quotes for author (".$row["author_name"].") to results...");
            $quoteJson = [];
            while ($quote = $quotes->fetch_array(MYSQLI_ASSOC)) {
                $quoteJson[] = buildQuoteJSONContents($quote);
            }
            $authorJson["quotes"] = $quoteJson;
            $json[] = $authorJson;
        }
        return $json;
    }

    //
    // services call the appropriate func here
    //

    //
    // all authors that have a least one active quote
    //
    function buildActiveAuthorsJSON($db) {
        try {
            //
            // all authors that have at least one quote in the db
            //
            if (!$authors = $db->query(getActiveAuthorsSQL())) {
                throw new Exception("Unable to retrieve author information");
            }
            while ($row = $authors->fetch_array(MYSQLI_ASSOC)) {
                debugMessage("Adding Author (".$row["author_name"].") to results...");
                $json[] = buildAuthorsJSONContents($row);
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

    //
    // a random quote picked from the least used quotes in the db
    //
    function buildRandomQuoteJSON($db) {
        try {
            debugMessage("Finding a random quote from the least used quotes...");
            $outputArray["version"]    = $GLOBALS['version'];
            $outputArray["generated"]  = getGeneratedDateTime();
            $outputArray["service"]    = "randomquote";
            $outputArray["author"]     = getRandomQuoteJSON($db);
            $outputArray["msg"]        = "SUCCESS";
            $outputArray["status"]     = 0;
        } catch (Exception $e) {
            $outputArray["msg"]        = "ERROR: ".$e->getMessage();
            $outputArray["status"]     = 999;
        }
        return json_encode($outputArray, JSON_NUMERIC_CHECK);
    }

    //
    // all quotes for active authors
    //
    function buildAllQuotesJSON($db) {
        try {
            debugMessage("Processing all quotes for all active authors...");
            $outputArray["version"]    = $GLOBALS['version'];
            $outputArray["generated"]  = getGeneratedDateTime();
            $outputArray["service"]    = "allquotes";
            $outputArray["authors"]    = getAllQuotesJSON($db);
            $outputArray["msg"]        = "SUCCESS";
            $outputArray["status"]     = 0;
        } catch (Exception $e) {
            $outputArray["msg"]        = "ERROR: ".$e->getMessage();
            $outputArray["status"]     = 999;
        }
        return json_encode($outputArray, JSON_NUMERIC_CHECK);
    }

?>
