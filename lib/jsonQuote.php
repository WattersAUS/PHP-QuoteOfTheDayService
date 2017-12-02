<?php
//
// Module: jsonQuote.php (2017-11-29) G.J. Watson
//
// Purpose: JSON builder helper functions
//
// Date       Version Note
// ========== ======= ====================================================
// 2017-11-29 v1.00   First cut of code
//

    function buildAuthorsJSON($item, $added) {
        $authorInfo["author_id"]     = $item["author_id"];
        $authorInfo["author_name"]   = $item["author_name"];
        $authorInfo["author_period"] = $item["author_period"];
        $authorInfo["added"]         = $added;
        return $authorInfo;
    }

    function buildQuoteJSON($item, $added) {
        $quoteInfo["quote_id"]   = $item["quote_id"];
        $quoteInfo["quote_text"] = $item["quote_text"];
        $quoteInfo["times_used"] = $item["times_used"];
        $quoteInfo["added"]      = $added;
        return $quoteInfo;
    }
?>
