<?php
require_once("create_user.php");
$userData = file_get_contents('php://input');
registerUser($userData);
?>