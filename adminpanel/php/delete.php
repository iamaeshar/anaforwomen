<?php
if (!isset($_SESSION)) {
    session_start();
}

$response['status'] = ['unknown'];

if (isset($_SESSION['logged_in'])) {
    $table_name = $_GET['table_name'];
    $id = $_GET['id'];

    include_once('../../php/db.inc.php');
    $conn = DB::getConnection();
    $sql = "DELETE from $table_name WHERE id=$id";
    if ($conn->query($sql)) {
        $response['status'] = ['success'];
        $response['message'] = ['Deleted successfully !!'];
    } else {
        $response['status'] = ['error'];
        $response['message'] = ['something went wrong.'];
    }
    echo json_encode($response);
} else {
    header('location: ../');
}
