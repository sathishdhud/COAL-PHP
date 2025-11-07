document.addEventListener('DOMContentLoaded', function() {
    // Load products on page load
    loadProducts();
    
    // Handle form submission
    document.getElementById('productForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const productName = document.getElementById('productName').value;
        const quantity = document.getElementById('quantity').value;
        const price = document.getElementById('price').value;
        
        // Show loading indicator
        const submitBtn = document.querySelector('#productForm button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
        submitBtn.disabled = true;
        
        // Send data via AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_data.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Reset form
                    document.getElementById('productForm').reset();
                    // Reload products
                    loadProducts();
                    // Show success message
                    showNotification('Product added successfully!', 'success');
                } else {
                    showNotification('Error adding product. Please try again.', 'error');
                }
                // Restore button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
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
        
        // Show loading indicator
        const saveBtn = document.getElementById('saveChanges');
        const originalText = saveBtn.innerHTML;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        saveBtn.disabled = true;
        
        // Send updated data via AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'edit_data.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
                        modal.hide();
                        // Reload products
                        loadProducts();
                        // Show success message
                        showNotification('Product updated successfully!', 'success');
                    } else {
                        showNotification('Error updating product: ' + response.message, 'error');
                    }
                } else {
                    showNotification('Error updating product. Please try again.', 'error');
                }
                // Restore button
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
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

// Function to show notifications
function showNotification(message, type) {
    // Remove any existing notifications
    const existingNotification = document.getElementById('custom-notification');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    // Create notification element
    const notification = document.createElement('div');
    notification.id = 'custom-notification';
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
    notification.style = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
            <div>${message}</div>
            <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
        </div>
    `;
    
    // Add to body
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 3000);
}