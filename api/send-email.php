<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/lib/Mailer.php';

// ----------------------
// API key validation
// ----------------------
$security = require __DIR__ . '/config/security.php';

$headers = getallheaders();

$API_KEY =
    $headers['X-API-KEY']
    ?? $_SERVER['HTTP_X_API_KEY']
    ?? $_GET['api_key']
    ?? $_POST['api_key']
    ?? null;

// ----------------------
// Only POST allowed
// ----------------------
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// ----------------------
// Get POST data
// ----------------------
$to = $_POST['to'] ?? null;
$subject = $_POST['subject'] ?? 'No Subject';
$body = $_POST['body'] ?? '';
$from = $_POST['from'] ?? null;

// ----------------------
// Attachments
// ----------------------
$attachments = [];
if (!empty($_FILES['attachments'])) {
    $tmp_names = $_FILES['attachments']['tmp_name'];
    $names = $_FILES['attachments']['name'];

    if (!is_array($tmp_names)) {
        $tmp_names = [$tmp_names];
        $names = [$names];
    }

    foreach ($tmp_names as $key => $tmp_name) {
        $attachments[] = [
            'tmp_name' => $tmp_name,
            'name' => $names[$key]
        ];
    }
}

// ----------------------
// Send email
// ----------------------
$mailer = new Mailer();
$result = $mailer->send($to, $subject, $body, $from, $attachments);

if ($result['status'] === 'ok') {
    echo json_encode($result);
} else {
    http_response_code(500);
    echo json_encode($result);
}
