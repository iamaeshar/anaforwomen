<?php
    if($_SERVER['REQUEST_METHOD'] === "POST" and isset($_POST['email']) and isset($_POST['password'])){
        extract($_POST);
        include_once('../../php/db.inc.php');
        $conn = DB::getConnection();
        $sql = "SELECT name,email FROM admin WHERE email='$email' AND password='$password'";
        if($result = $conn->query($sql)) {
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                session_start();
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['logged_in'] = true;
                $response['status'] = 'success';
                $response['message'] = 'Logged in Successfully';
            }else {
                $_SESSION['logged_in'] = false;
                $response['status'] = 'error';
                $response['message'] = 'Incorrect email or password.';
            }
        }else {
            $_SESSION['logged_in'] = false; 
            $response['status'] = 'error';
            $response['message'] = 'Something went wrong try after sometime.';
        }
        echo json_encode($response);
    }else {
        header('location: ../');
    }
