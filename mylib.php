<?php
function db_connect()
{
	global $db;
	$DB_NAME = "MML_efedo552";
	$DB_HOST = "localhost";
	$DB_USER = "efedo552";
	$DB_PASS = "kdg%5C4&";
	
	$db = new mysqli ($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
	$errmsg = $db->connect_error ;
	return $errmsg ;
}
?>