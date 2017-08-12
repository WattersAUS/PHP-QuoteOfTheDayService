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
    $authors  = "SELECT au.id,au.name,au.match_text,au.period,au.added";
    $authors .= " FROM author au";
    return $authors;
}

function addQuotesExistForAuthorSQL() {
    return " WHERE EXISTS (SELECT * FROM quote q WHERE q.author_id = au.id)";
}

function getActiveAuthorsSQL() {
    return getAuthorSQL().addQuotesExistForAuthorSQL();
}

function getAuthorQuotesSQL($author_id) {
    $quotes  = "SELECT qu.id,qu.author_id,qu.quote_text,qu.match_text,qu.times_used,qu.added";
    $quotes .= " FROM quote qu";
    $quotes .= " WHERE qu.author_id = ".$author_id;
    return $quotes;
}

function getLeastTimesUsedSQL() {
    return "SELECT MIN(qu.times_used) as usagecount FROM quote qu";
}

function getLeastUsedQuotesSQL($times) {
    $quotes  = "SELECT qu.id as quote_id,qu.quote_text,qu.times_used,au.id,au.name,au.period,au.added";
    $quotes .= " FROM quote qu";
    $quotes .= " LEFT JOIN author au ON qu.author_id = au.id";
    $quotes .= " WHERE qu.times_used = ".$times;
    $quotes .= " LIMIT 50";
    return $quotes;
}

function incrQuoteTimesUsedSQL($quote_id) {
    return "UPDATE quote SET times_used = times_used + 1 WHERE id = ".$quote_id;
}
?>
