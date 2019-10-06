<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    extract($_POST);
    $sql = "INSERT INTO messages(name,email,message) VALUES('$name', '$email', '$message')";
    require 'db.inc.php';
    $conn = DB::getConnection();
    if ($conn->query($sql)) {
        $response['status'] = 'success';
        $response['message'] = 'Thank you for contacting us.';

        $to = "info@anaforwomen.com,anaforwomen@gmail.com";
        $from = "$name <$email>";
        $subject = "Message from Anaforwomen Website";
        $body = '<!DOCTYPE html>
        <html>
        
        <head>
            <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
        </head>
        
        <body style="font-family: Arial, Helvetica, sans-serif;margin:0px;background-color: #ffffff;">
            <table style="background-color: #eeeeee;padding: 8px 16px;width: 100%;box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 3px 1px -2px rgba(0,0,0,0.12), 0 1px 5px 0 rgba(0,0,0,0.2);">
                <tr>
                    <td><img src="https://www.anaforwomen.com/images/logo.png" height="50px" alt="Anaforwomen" /></td>
                    <td style="line-height: 50px;vertical-align: top; margin:0px; font-size: 32px; font-weight: 500;">Message from Anaforwomen Website</td>
                </tr>
            </table>
            <table style="padding: 8px 16px;width: 100%;font-weight: 500;" cellspacing="10">
                <tr>
                    <td style="color: #263a73;width: 30%">Name:</td>
                    <td style="width: 70%;">' . $name . '</td>
                </tr>
                <tr>
                    <td style="color: #263a73;width: 30%">Email:</td>
                    <td style="width: 70%;">' . $email . '</td>
                </tr>
                <tr>
                    <td style="color: #263a73;width: 30%">Message:</td>
                    <td style="width: 70%;">' . $message . '</td>
                </tr>
            </table>
        </body>
        </html>';

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headersO = $headers . 'From: ' . $from . "\r\n";
        mail($to, $subject, $body, $headersO);
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Something went wrong try after sometime';
    }
    echo json_encode($response);
} else {
    header('location: ../');
}
