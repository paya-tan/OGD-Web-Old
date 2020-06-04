<?php
	date_default_timezone_set("America/Los_Angeles");
	$id = intval(date("m")) * intval(date("d"));
	$quotes = array();
	$quotes = explode(";", file_get_contents('quotes.txt'));
	$x = count($quotes);
	while ($id >= $x) {
		$id = $id - $x;
	}
	echo "<span id='quote'><b>Dr. Parrott's Quote of the Day:</b>&nbsp;&nbsp;".str_replace('\"', "", $quotes[$id])."</span>";
	unset($quotes);
	unset($id);
	unset($x);
?>