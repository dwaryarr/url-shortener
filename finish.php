<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>URL Shortener - Redirecting...</title>
</head>

<body style="text-align: center;">
    <?php
    $status = $_GET['status'];
    if ($status == "exist") {
        echo '<h1 class="text-center text-danger">Short URL already exist</h1>';
    } else if ($status == "insert_success") {
        echo '<h1 class="text-center text-success">New Short URL Has been Inserted!</h1>';
    } else if ($status == 'delete_success') {
        echo '<h1 class="text-center text-success">Short URL Has been Deleted!</h1>';
    } else if ($status == 'delete_failed') {
        echo '<h1 class="text-center text-danger">Delete Failed! Something went wrong!</h1>';
    } else if ($status == 'empty_shorturl') {
        echo '<h1 class="text-center text-danger">Short URL cannot be empty!</h1>';
    } else if ($status == 'empty_longurl') {
        echo '<h1 class="text-center text-danger">Long URL cannot be empty!</h1>';
    } elseif ($status == 'empty_all') {
        echo '<h1 class="text-center text-danger">Short URL and Long URL cannot be empty!</h1>';
        // fetching
    } else if ($status == 'fetch_success') {
        echo '<h1 class="text-center text-success">Fetch Success!</h1>';
    } else if ($status == 'fetch_failed') {
        echo '<h1 class="text-center text-danger">Fetch Failed! Something went wrong!</h1>';
        // fetching
    } else {
        echo '<h1 class="text-center text-danger">Insert Failed! Something went wrong!</h1>';
    }
    ?>
    <div id="counter"></div>
    <h5>Click here if not automatically redirected. <a href="index.php">Back to Home</a></h5>
    <script type="text/javascript">
        var status = "<?php echo $status; ?>";
        var counter = document.getElementById("counter");
        var count = 5;
        setInterval(function() {
            count--;
            if (count >= 0) {
                counter.innerHTML = "You will be redirected in " + count + " seconds";
            }
        }, 1000);
        setTimeout(function() {
            window.location.href = "index.php";
        }, 5000);
    </script>
</body>

</html>