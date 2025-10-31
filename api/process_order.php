<?php
include '../includes/db.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $items = $_POST['items'] ?? '[]';

    $itemsArray = json_decode($items, true);
    $total = 0;
    foreach ($itemsArray as $item) {
        $total += floatval($item['price']) * intval($item['quantity']);
    }

    if ($name && $phone && $address && !empty($itemsArray)) {
        $stmt = $conn->prepare("INSERT INTO orders (user_name, phone, address, total, items) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssds", $name, $phone, $address, $total, $items);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save order.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing fields or empty cart.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$conn->close();
