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
        <title>Webcom Admin - Subscriber</title>
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
                            Subscriber
                        </h2>
                    </div>
                    <br>
                    <div class="container-fluid">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    include_once('../php/db.inc.php');
                                    $conn = DB::getConnection();
                                    $limit = 15;
                                    if (isset($_GET["page"])) {
                                        $page  = $_GET["page"];
                                    } else {
                                        $page = 1;
                                    };
                                    $start_from = ($page - 1) * $limit;
                                    $sql = "SELECT * from subscribers ORDER BY id DESC LIMIT $start_from, $limit";
                                    if ($result = $conn->query($sql)) {
                                        if ($result->num_rows > 0) {
                                            $i = 0;
                                            while ($row = $result->fetch_assoc()) {
                                                $i++ ?>
                                            <tr>
                                                <th scope="row"><?= $i ?></th>
                                                <td><?= $row['name'] ?></td>
                                                <td><?= $row['email'] ?></td>
                                                <td><button class="btn btn-default p-0" onclick="deleteThing(<?= $row['id'] ?>, this)"><img src="images/icons/x.svg" alt=""></button></td>
                                            </tr>
                                <?php }
                                        } else {
                                            echo "<tr><td colspan=4>No data found. </td></tr>";
                                        }
                                    }
                                    ?>
                            </tbody>
                        </table>
                        <br>
                        <?php
                            $result = $conn->query("SELECT COUNT(id) AS count FROM subscribers");
                            $row = $result->fetch_assoc();
                            $total_records = $row['count'];
                            if ($total_records > $limit) {
                                $total_pages = ceil($total_records / $limit);
                                $pagLink = "<ul class='pagination'>";
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    $pagLink .= "<li class='page-item'><a class='page-link' href='queries.php?page=" . $i . "'>" . $i . "</a></li>";
                                }
                                echo $pagLink . "</ul>";
                            }
                            ?>
                    </div>
                </div>
            </div>
        </div>

        <?php include('include/jslib.inc.html') ?>

        <script>
            function deleteThing(id, elem) {
                if (confirm('Are you sure ?')) {
                    $.ajax({
                        url: 'php/delete.php?table_name=subscribers&&id=' + id,
                        type: 'GET',
                        error: function() {
                            alert('System Error. Try after sometime.');
                        },
                        success: function(response) {
                            response = JSON.parse(response);
                            if (response.status == 'success') {
                                alert('Deleted Successfully !!');
                                $(elem).parent().parent().remove();
                            } else {
                                alert('Something Went Wrong');
                            }
                        },
                    });
                }
            }
        </script>

    </body>

    </html>

<?php } else {
    header('location: ../adminpanel/');
}
?>