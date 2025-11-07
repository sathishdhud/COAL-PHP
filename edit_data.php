<?php
header('Content-Type: application/json');

// Get POST data
$index = $_POST['index'] ?? -1;
$product_name = $_POST['product_name'] ?? '';
$quantity = $_POST['quantity'] ?? 0;
$price = $_POST['price'] ?? 0;

// Validate data
if ($index < 0 || empty($product_name) || !is_numeric($quantity) || !is_numeric($price)) {
    echo json_encode(['success' => false, 'message' => 'Invalid data provided']);
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
    echo json_encode(['success' => false, 'message' => 'Product not found']);
    exit;
}

// Update product entry
$data[$index] = [
    'product_name' => $product_name,
    'quantity' => (int)$quantity,
    'price' => (float)$price,
    'datetime' => $data[$index]['datetime'], // Keep original datetime
    'total_value' => $total_value
];

// Save data back to file
if (file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT))) {
    echo json_encode(['success' => true, 'message' => 'Product updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update product']);
}
?>