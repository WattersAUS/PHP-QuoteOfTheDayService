<?php
//
// Program: randomQuote.php (2017-10-17) G.J. Watson
//
// Purpose: Retrieve a quote from the randomquote service
//
// Returns: Author Name / Quote
//
// Date       Version Note
// ========== ======= ====================================================
// 2017-10-17 v0.01   First cut of code
//

	function randomQuote() {
		ini_set("allow_url_fopen", 1);
		$name  = "...";
		$quote = "...";
		try {
			$url    = "<URL GOES HERE>";
			$decode = json_decode(file_get_contents($url));
			$name   = $decode->author->author_name;
			$quote  = $decode->author->quote->quote_text;
		} catch (Exception $e) {
			$name   = "ERROR!";
			$quote  = $e->getMessage();
		}
		return array('name' => $name, 'quote' => $quote);
	}
?>
