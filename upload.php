<?php
// imghost.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Adjust this for security in production
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// API Response function
function sendResponse($status, $message, $data = null) {
    $response = [
        'status' => $status,
        'message' => $message
    ];
    if ($data !== null) {
        $response['data'] = $data;
    }
    echo json_encode($response);
    exit;
}

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse('error', 'Only POST requests are allowed');
}

// Check if file was uploaded
if (!isset($_FILES['image'])) {
    sendResponse('error', 'No image file uploaded');
}

$image = $_FILES['image'];
$uploadDir = 'imghost/'; // Changed to imghost folder
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
$maxSize = 5 * 1024 * 1024; // 5MB

// Create imghost directory if it doesn't exist
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Validate file
if ($image['error'] !== UPLOAD_ERR_OK) {
    sendResponse('error', 'Error uploading file');
}

if (!in_array($image['type'], $allowedTypes)) {
    sendResponse('error', 'Invalid image type. Only JPG, PNG, and GIF are allowed');
}

if ($image['size'] > $maxSize) {
    sendResponse('error', 'File too large. Maximum size is 5MB');
}

// Generate unique filename
$extension = pathinfo($image['name'], PATHINFO_EXTENSION);
$filename = uniqid() . '.' . $extension;
$destination = $uploadDir . $filename;

try {
    // Move the uploaded file
    if (move_uploaded_file($image['tmp_name'], $destination)) {
        $fileInfo = [
            'url' => 'http://' . $_SERVER['HTTP_HOST'] . '/' . $destination,
            'filename' => $filename,
            'size' => $image['size'],
            'type' => $image['type']
        ];

        sendResponse('success', 'Image uploaded successfully', $fileInfo);
    } else {
        sendResponse('error', 'Failed to move uploaded file');
    }
} catch (Exception $e) {
    sendResponse('error', 'Server error: ' . $e->getMessage());
}
?>