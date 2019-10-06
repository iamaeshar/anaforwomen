<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['logged_in'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include('include/head.inc.html') ?>
        <title>Webcom Admin - Dashboard</title>
    </head>

    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-2 collapse d-md-flex min-vh-100 p-0 shadow" id="sidebar">
                    <?php include('layouts/navbar.html'); ?>
                </div>
                <div class="col p-0">
                    <div class="shadow-sm p-2">
                        <h2>
                            <button class="navbar-toggler d-md-none" type="button" data-target="#sidebar" data-toggle="collapse">
                                coll
                            </button>
                            Dashboard
                        </h2>
                    </div>
                    <br>
                    <?php
                        include_once('../php/db.inc.php');
                        $conn = DB::getConnection();
                        $sql = "SELECT  (
                            SELECT COUNT(*)
                            FROM   franchise
                            ) AS franchises,
                            (
                            SELECT COUNT(*)
                            FROM   messages
                            ) AS messages,
                            (
                            SELECT COUNT(*)
                            FROM   subscribers
                            ) AS subscribers
                            FROM    dual";
                        if ($result = $conn->query($sql)) {
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                            }
                        }
                        ?>
                    <div class="container-fluid">
                        <div id="dashboard-container">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4 card shadow text-center">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-muted">Messages</h6>
                                            <h5 class="card-title"><?= $row['messages'] ?></h5>
                                            <a href="messages" class="card-link">Explore</a>
                                        </div>
                                    </div>
                                    <div class="col-md-4 card shadow text-center">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-muted">Franchise Request</h6>
                                            <h5 class="card-title"><?= $row['franchises'] ?></h5>
                                            <a href="franchise-request" class="card-link">Explore</a>
                                        </div>
                                    </div>
                                    <div class="col-md-4 card shadow text-center">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-muted">Subscribers</h6>
                                            <h5 class="card-title"><?= $row['subscribers'] ?></h5>
                                            <a href="subscribers" class="card-link">Explore</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include('include/jslib.inc.html') ?>

    </body>

    </html>

<?php } else {
    header('location: ../adminpanel/');
}
?>