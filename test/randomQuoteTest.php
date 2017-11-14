<?php
//
// Program: randomQuoteTest.php (2017-10-17) G.J. Watson
//
// Purpose: Retrieve a quote from the randomquote service
//
// Date       Version Note
// ========== ======= ====================================================
// 2017-10-17 v0.01   First cut of code
//

	set_include_path("<LIB GOES HERE>");
	require_once("randomQuote.php");

	$details = randomQuote();
	print("\nAuthor Name: ".$details[0]);
	print("\n      Quote: ".$details[1]);
	print("\n\n");
?>
