<?php
// Read existing data
$data = [];
if (file_exists('data.json')) {
    $json = file_get_contents('data.json');
    $data = json_decode($json, true) ?: [];
}

// Sort data by datetime (newest first)
usort($data, function($a, $b) {
    return strtotime($b['datetime']) - strtotime($a['datetime']);
});

// Calculate grand total
$grand_total = 0;
foreach ($data as $product) {
    $grand_total += $product['total_value'];
}

// Display table
if (empty($data)) {
    echo '<p class="text-center text-muted">No products found. Add some products to get started!</p>';
} else {
    echo '<div class="table-responsive">';
    echo '<table class="table table-striped table-bordered">';
    echo '<thead class="table-light">';
    echo '<tr>';
    echo '<th>Product Name</th>';
    echo '<th>Quantity</th>';
    echo '<th>Price per Item</th>';
    echo '<th>Datetime Submitted</th>';
    echo '<th>Total Value</th>';
    echo '<th>Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    foreach ($data as $index => $product) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($product['product_name']) . '</td>';
        echo '<td>' . htmlspecialchars($product['quantity']) . '</td>';
        echo '<td>₹' . number_format($product['price'], 2) . '</td>';
        echo '<td>' . htmlspecialchars($product['datetime']) . '</td>';
        echo '<td>₹' . number_format($product['total_value'], 2) . '</td>';
        echo '<td><button class="btn btn-sm btn-warning" onclick="openEditModal(' . $index . ', \'' . htmlspecialchars($product['product_name']) . '\', ' . $product['quantity'] . ', ' . $product['price'] . ')">Edit</button></td>';
        echo '</tr>';
    }
    
    // Grand total row
    echo '<tr class="table-success fw-bold">';
    echo '<td>Sum Total</td>';
    echo '<td colspan="3"></td>';
    echo '<td>₹' . number_format($grand_total, 2) . '</td>';
    echo '<td></td>';
    echo '</tr>';
    
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}
?>