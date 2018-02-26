<?php
require_once "locals.php";
$link = new mysqli($ip, $user, $password,$database_name);
if ($link->connect_error) {
    die('Could not connect: '.$link->connect_error );
}
$link->query("SET NAMES utf8mb4");
?>
