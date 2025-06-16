<?php
/**
 * Fusion Pro Simple API Request Listener
 *
 * **/
$API_KEY = $_GET['api_key'];
$IMEI = $_GET['IMEI']; // all fields are available.



$response = [
    'status' => 'success', //error
    'message' => 'Successfully processed!',
    'order_id' => uniqid(),
    'replay' => '1234567890',
];

echo json_encode($response, JSON_PRETTY_PRINT);
