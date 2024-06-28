<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'url-shortener';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Database connection error: ' . $conn->connect_error);
}

$baseurl = (($_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . '/';
