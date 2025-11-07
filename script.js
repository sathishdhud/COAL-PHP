document.addEventListener('DOMContentLoaded', function() {
    // Load products on page load
    loadProducts();
    
    // Handle form submission
    document.getElementById('productForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const productName = document.getElementById('productName').value;
        const quantity = document.getElementById('quantity').value;
        const price = document.getElementById('price').value;
        
        // Send data via AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_data.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Reset form
                document.getElementById('productForm').reset();
                // Reload products
                loadProducts();
            }
        };
        xhr.send(`product_name=${encodeURIComponent(productName)}&quantity=${encodeURIComponent(quantity)}&price=${encodeURIComponent(price)}`);
    });
    
    // Handle save changes button in edit modal
    document.getElementById('saveChanges').addEventListener('click', function() {
        const index = document.getElementById('editIndex').value;
        const productName = document.getElementById('editProductName').value;
        const quantity = document.getElementById('editQuantity').value;
        const price = document.getElementById('editPrice').value;
        
        // Send updated data via AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'edit_data.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
                modal.hide();
                // Reload products
                loadProducts();
            }
        };
        xhr.send(`index=${encodeURIComponent(index)}&product_name=${encodeURIComponent(productName)}&quantity=${encodeURIComponent(quantity)}&price=${encodeURIComponent(price)}`);
    });
});

// Function to load products via AJAX
function loadProducts() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_data.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('productsTable').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

// Function to open edit modal with product data
function openEditModal(index, productName, quantity, price) {
    document.getElementById('editIndex').value = index;
    document.getElementById('editProductName').value = productName;
    document.getElementById('editQuantity').value = quantity;
    document.getElementById('editPrice').value = price;
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editModal'));
    modal.show();
}