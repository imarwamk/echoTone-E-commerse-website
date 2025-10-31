<?php
include '../includes/db.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    $search = isset($_GET['q']) ? $_GET['q'] : '';

    if ($search == '') {
        echo json_encode([]);
        exit;
    }

    $search = "%".$search."%";

    $stmt = $conn->prepare("SELECT * FROM products WHERE albumName LIKE ? OR artistName LIKE ?");
    $stmt->bind_param("ss", $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    echo json_encode($products);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode($e->getMessage());
}

$conn->close();
