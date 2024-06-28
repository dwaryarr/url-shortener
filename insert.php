<?php
require_once 'connection.php';
$slug = $_POST['shorturl'];
if (empty($slug) && empty($longurl)) {
    header('Location: finish.php?status=empty_all');
    exit();
} else if (empty($shorturl)) {
    header('Location: finish.php?status=empty_shorturl');
    exit();
} else if (empty($longurl)) {
    header('Location: finish.php?status=empty_longurl');
    exit();
}
$shorturl = $baseurl . $slug;
$longurl = $_POST['longurl'];
$created_at = date('Y-m-d H:i:s');
if (!preg_match('/^[a-zA-Z0-9]+$/', $longurl)) {
    $longurl = 'https://' . $longurl;
}
$checkShortUrl = mysqli_prepare($conn, "SELECT *  FROM shorturl WHERE BINARY slug = '$slug'");
$checkShortUrl->execute();
if ($checkShortUrl->get_result()->num_rows > 0) {
    header('Location: finish.php?status=exist');
    exit();
} else {
    $insertShortUrl = mysqli_prepare($conn, "INSERT INTO shorturl (slug, shorturl, longurl, created_at) VALUES (?, ?, ?, ?)");
    $insertShortUrl->bind_param('ssss', $slug, $shorturl, $longurl, $created_at);
    $insertShortUrl->execute();
    if ($insertShortUrl->affected_rows > 0) {
        header('Location: finish.php?status=insert_success');
        exit();
    } else {
        header('Location: finish.php?status=insert_failed');
        exit();
    }
}
