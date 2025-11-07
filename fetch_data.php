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
    echo '<div class="alert alert-info text-center">';
    echo '<h5><i class="fas fa-info-circle"></i> No products found</h5>';
    echo '<p>Add some products to your inventory to get started!</p>';
    echo '</div>';
} else {
    echo '<div class="table-responsive">';
    echo '<table class="table table-striped table-hover">';
    echo '<thead>';
    echo '<tr class="table-secondary">';
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
        echo '<td><strong>' . htmlspecialchars($product['product_name']) . '</strong></td>';
        echo '<td>' . htmlspecialchars($product['quantity']) . '</td>';
        echo '<td><span class="text-success">₹' . number_format($product['price'], 2) . '</span></td>';
        echo '<td>' . htmlspecialchars($product['datetime']) . '</td>';
        echo '<td><strong class="text-primary">₹' . number_format($product['total_value'], 2) . '</strong></td>';
        echo '<td>';
        echo '<button class="btn btn-sm btn-warning" onclick="openEditModal(' . $index . ', \'' . htmlspecialchars($product['product_name']) . '\', ' . $product['quantity'] . ', ' . $product['price'] . ')">';
        echo '<i class="fas fa-edit"></i> Edit';
        echo '</button>';
        echo '</td>';
        echo '</tr>';
    }
    
    // Grand total row
    echo '<tr class="table-warning">';
    echo '<td colspan="4" class="text-end"><strong>Grand Total:</strong></td>';
    echo '<td><strong class="text-success">₹' . number_format($grand_total, 2) . '</strong></td>';
    echo '<td></td>';
    echo '</tr>';
    
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    
    echo '<div class="mt-3">';
    echo '<p class="text-muted"><i class="fas fa-info-circle"></i> Showing ' . count($data) . ' products in inventory</p>';
    echo '</div>';
}
?>