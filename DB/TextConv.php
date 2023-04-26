<?php
function ConvertText($tekst) //Opretter forbindelsen til MySQL databasen
 {
	// ' og & tegn
	$tekst = str_replace ("&", "&amp;", $tekst);
	$tekst = str_replace ("'", "&#039;", $tekst);
	//Danske tegn
	$tekst = str_replace ("æ", "&aelig;", $tekst);
	$tekst = str_replace ("ø", "&oslash;", $tekst);
	$tekst = str_replace ("å", "&aring;", $tekst);
	$tekst = str_replace ("Æ", "&AElig;", $tekst);
	$tekst = str_replace ("Ø", "&Oslash;", $tekst);
	$tekst = str_replace ("Å", "&Aring;", $tekst);
	//Tyske tegn
	$tekst = str_replace ("ä", "&auml;", $tekst);
	$tekst = str_replace ("ö", "&ouml;", $tekst);
	$tekst = str_replace ("ü", "&uuml;", $tekst);
	$tekst = str_replace ("Ä", "&Auml;", $tekst);
	$tekst = str_replace ("Ö", "&Ouml;", $tekst);
	$tekst = str_replace ("Ü", "&Uuml;", $tekst);
	return ($tekst);
 }
?>
