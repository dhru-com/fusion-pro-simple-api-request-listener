<?php

/**
 * Fusion Pro Simple API Request Listener
 *
 * This script acts as a lightweight HTTP endpoint for handling
 * predefined actions triggered via GET parameter `action`.
 *
 * Supported Actions:
 * - account_info
 * - products
 * - place_order
 *
 * Data for `place_order` is expected in POST body (JSON).
 */

// Allow CORS for testing purposes (should be restricted in production)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Detect request method and capture input data
$method = $_SERVER['REQUEST_METHOD'];
$input = $method === 'GET' ? $_GET : json_decode(file_get_contents('php://input'), true);

// Fetch action from GET query parameter
$action = isset($_GET['action']) ? $_GET['action'] : 'undefined';

// Initialize response variables
$status = 'error';
$message = 'Unknown action';
$result = [];
$replay = '';
$order_id = '';

// Handle actions
switch ($action) {
    case 'account_info':
        // Return dummy account details
        $status = 'success';
        $result = [
            'email' => 'user@example.com',
            'balance' => 100,
            'currency' => 'USD'
        ];
        break;

    case 'products':
        // Return static product listing
        $status = 'success';
        $result = [
            'products' => [
                ['id' => 1, 'name' => 'Product A', 'price' => 10],
                ['id' => 2, 'name' => 'Product B', 'price' => 20]
            ]
        ];
        break;

    case 'place_order':
        // Expected fields in POST body: IMEI, product_id
        $IMEI = isset($input['IMEI']) ? $input['IMEI'] : null;
        $product_id = isset($input['product_id']) ? $input['product_id'] : null;

        // Validate required fields
        if ($IMEI && $product_id) {
            // Simulate successful order response
            $status = 'success';
            $message = 'Order placed';

            $order_id = uniqid();
            $replay = '1234567890';

//          Simulate reject order response
//          $status = 'error';
//          $message = 'Invalid IMEI, Code not found';

        }
        else {
            // Missing fields - return error
            $status = 'error';
            $message = 'Missing IMEI or product_id';
        }

        break;

    default:
        // No matching action
        $status = 'error';
        $message = 'Unknown action';
        break;
}

// Build and send JSON response
$response = [
    'status' => $status,
    'message' => $message,
    'order_id' => $order_id,
    'replay' => $replay,
];

echo json_encode($response, JSON_PRETTY_PRINT);
