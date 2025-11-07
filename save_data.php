<?php
header('Content-Type: application/json');

// Get POST data
$product_name = $_POST['product_name'] ?? '';
$quantity = $_POST['quantity'] ?? 0;
$price = $_POST['price'] ?? 0;

// Validate data
if (empty($product_name) || !is_numeric($quantity) || !is_numeric($price)) {
    echo json_encode(['success' => false, 'message' => 'Invalid data provided']);
    exit;
}

// Calculate total value
$total_value = $quantity * $price;

// Create product entry
$product = [
    'product_name' => $product_name,
    'quantity' => (int)$quantity,
    'price' => (float)$price,
    'datetime' => date('Y-m-d H:i:s'),
    'total_value' => $total_value
];

// Read existing data
$data = [];
if (file_exists('data.json')) {
    $json = file_get_contents('data.json');
    $data = json_decode($json, true) ?: [];
}

// Add new product
$data[] = $product;

// Save data back to file
if (file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT))) {
    echo json_encode(['success' => true, 'message' => 'Product added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save product']);
}
?>