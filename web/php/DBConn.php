<?php
//author = Kyle Burton
	$ErrorMsgs = array();
	$mysqli = new mysqli("localhost", "root", "", "WP_Blood");
	if ($mysqli->connect_errno)
	{
		echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	}
?>
