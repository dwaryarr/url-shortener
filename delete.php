<?php
require_once 'connection.php';
$shorturl_id =  $_GET['id'];
$deleteShortUrl = mysqli_prepare($conn, "DELETE FROM shorturl WHERE shorturl_id = $shorturl_id");
$deleteShortUrl->execute();
if ($deleteShortUrl->affected_rows > 0) {
    header('Location: finish.php?status=delete_success');
    exit();
} else {
    header('Location: finish.php?status=delete_failed');
    exit();
}
