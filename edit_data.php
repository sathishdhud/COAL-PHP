<?php
header('Content-Type: application/json');

// Get POST data
$index = $_POST['index'] ?? -1;
$product_name = $_POST['product_name'] ?? '';
$quantity = $_POST['quantity'] ?? 0;
$price = $_POST['price'] ?? 0;

// Validate data
if ($index < 0 || empty($product_name) || !is_numeric($quantity) || !is_numeric($price)) {
    echo json_encode(['success' => false, 'message' => 'Invalid data provided. Please check all fields.']);
    exit;
}

// Additional validation
if ($quantity < 0 || $price < 0) {
    echo json_encode(['success' => false, 'message' => 'Quantity and price must be positive numbers.']);
    exit;
}

// Calculate total value
$total_value = $quantity * $price;

// Read existing data
$data = [];
if (file_exists('data.json')) {
    $json = file_get_contents('data.json');
    $data = json_decode($json, true) ?: [];
}

// Check if index exists
if (!isset($data[$index])) {
    echo json_encode(['success' => false, 'message' => 'Product not found. It may have been deleted.']);
    exit;
}

// Store original datetime
$original_datetime = $data[$index]['datetime'];

// Update product entry
$data[$index] = [
    'product_name' => trim($product_name),
    'quantity' => (int)$quantity,
    'price' => (float)$price,
    'datetime' => $original_datetime, // Keep original datetime
    'total_value' => $total_value
];

// Save data back to file
if (file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT))) {
    echo json_encode(['success' => true, 'message' => 'Product updated successfully in inventory.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update product. Please check file permissions.']);
}
?>