<?php
//
// Module: sqlquote.php (2017-08-11) G.J. Watson
//
// Purpose: common functions
//
// Date       Version Note
// ========== ======= ================================================
// 2017-08-11 v0.01   First cut of code
//

function getAuthorSQL() {
    $authors  = "SELECT au.id AS author_id, au.name AS author_name, au.match_text AS author_match_text, au.period AS author_period, au.added AS author_added_when";
    $authors .= " FROM author au";
    return $authors;
}

function getQuoteSQL() {
    $quotes  = "SELECT qu.id AS quote_id, qu.author_id, qu.quote_text, qu.match_text AS quote_match_text, qu.times_used, qu.added AS quote_added_when, au.name AS author_name, au.period AS author_period, au.added AS author_added_when";
    $quotes .= " FROM quote qu";
    $quotes .= " LEFT JOIN author au ON qu.author_id = au.id";
    return $quotes;
}

function setLimitForSQL($limit) {
    return " LIMIT ".$limit;
}

function setQuotesExistForAuthorSQL() {
    return " WHERE EXISTS (SELECT 1 FROM quote q WHERE q.author_id = au.id)";
}

function getActiveAuthorsSQL() {
    return getAuthorSQL().setQuotesExistForAuthorSQL();
}

function setAuthorIDInQuoteSQL($author_id) {
    return " WHERE qu.author_id = ".$author_id;
}

function getAuthorQuotesSQL($author_id) {
    return getQuoteSQL().setAuthorIDInQuoteSQL($author_id);
}

function getLeastTimesUsedSQL() {
    return "SELECT MIN(qu.times_used) as usagecount FROM quote qu";
}

function setLastUsedQuotesSQL($times) {
    return " WHERE qu.times_used = ".$times;
}

function getLeastUsedQuotesSQL($times) {
    return getQuoteSQL().setLastUsedQuotesSQL($times).setLimitForSQL(50);
}

function incrQuoteTimesUsedSQL($quote_id) {
    return "UPDATE quote SET times_used = times_used + 1 WHERE id = ".$quote_id;
}
?>
