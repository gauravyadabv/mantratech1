<?php
require_once '../config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

// Validation
$errors = [];
if (empty($name)) $errors[] = 'Name is required.';
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
if (empty($subject)) $errors[] = 'Subject is required.';
if (empty($message)) $errors[] = 'Message is required.';

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// Save to database
if ($conn) {
    $name    = mysqli_real_escape_string($conn, $name);
    $email   = mysqli_real_escape_string($conn, $email);
    $subject = mysqli_real_escape_string($conn, $subject);
    $message = mysqli_real_escape_string($conn, $message);

    $result = mysqli_query($conn, "INSERT INTO contact_messages (name, email, subject, message) VALUES ('$name','$email','$subject','$message')");

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Thank you! Your message has been received. We will get back to you within 24 hours.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to save your message. Please try again or contact us directly.'
        ]);
    }
} else {
    // No DB - still give success (optionally send email here)
    echo json_encode([
        'success' => true,
        'message' => 'Thank you for your message! We will get back to you soon.'
    ]);
}
