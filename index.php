<?php
require_once('connection.php');
// jika pakai https aktifkan ini
// ini_set('display_errors', 0);
$getShortUrl = mysqli_prepare($conn, "SELECT * FROM shorturl");
$getShortUrl->execute();
$shorturl = $getShortUrl->get_result()->fetch_all(MYSQLI_ASSOC);
$slug = trim($_SERVER['REQUEST_URI'], '/');
$stmt = mysqli_prepare($conn, "SELECT * FROM shorturl WHERE BINARY slug ='$slug'");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $views = $row['views'] + 1;
    $updateViews = mysqli_prepare($conn, "UPDATE shorturl SET views = $views WHERE shorturl_id = " . $row['shorturl_id']);
    $updateViews->execute();
    $longurl = $row['longurl'];
    header("Location: " . $longurl);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <title>Input Movies - dMoviesAPI</title>
</head>

<body style="background-color: #A8A8A8;">
    <div class="container">
        <div class="row-fluid">
            <h1 class="text-center">URL Shortener</h1>
            <hr>
            <div class="row-fluid">
                <div class="card p-5">
                    <form class="row gx-3 gy-2 align-items-center" action="insert.php" method="POST">
                        <div class="col-md-5">
                            <label class="form-label" for="shorturl">Short URL</label>
                            <div class="input-group">
                                <div class="input-group-text"><?= $baseurl; ?></div>
                                <input type="text" class="form-control" id="shorturl" name="shorturl" placeholder="SHORT-URL...">
                                <button type="button" class="btn btn-outline-dark" onclick="copyToClipboard()">Copy</button>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label" for="longurl">Forward To (Long URL)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="longurl" name="longurl" placeholder="Long URL...">
                            </div>
                        </div>
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>

                    <hr>

                    <table class="table table-responsive table-bordered" id="tableShortUrl">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Short URL</th>
                                <th class="text-center">Forward To (Long URL)</th>
                                <th class="text-center">Views</th>
                                <th class="text-center">Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($shorturl as $s) :
                            ?>
                                <tr>
                                    <td><?= $s['shorturl_id'] ?></td>
                                    <td><a href="<?= $s['shorturl'] ?>" target="_blank" class="text-decoration-none"><?= $s['shorturl'] ?></a></td>
                                    <td><a href="<?= $s['longurl'] ?>" target="_blank" class="text-decoration-none"><?= $s['longurl'] ?></a></td>
                                    <td><?= $s['views'] ?></td>
                                    <td><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $s['shorturl_id'] ?>">Delete</button></td>
                                    <div class="modal fade" id="delete<?= $s['shorturl_id'] ?>" tabindex="-1" aria-labelledby="delete<?= $s['shorturl_id'] ?>Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="delete<?= $s['shorturl_id'] ?>Label">Delete Movie</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    Are you sure want to delete this movie?<br>
                                                    <b>" <?= $s['shorturl'] ?> "</b>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <a href="delete.php/?id=<?= $s['shorturl_id'] ?>" class="btn btn-danger">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script>
        new DataTable('#tableShortUrl', {
            order: [
                [0, 'desc']
            ]
        });

        function copyToClipboard() {
            var copyText = $('#shorturl').val();
            // alert(copyText.value);
            // copyText.select();
            // copyText.setSelectionRange(0, 99999);
            // navigator.clipboard.writeText(copyText.value);
            // alert("Copied the text: " + copyText.value);

            copyText.select();
            document.execCommand('copy');
            copyText.remove();
        }
    </script>
</body>

</html>