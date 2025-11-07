<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazon Product Inventory</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <!-- Amazon-like Header -->
    <header class="amazon-header">
        <div class="container-fluid">
            <div class="row align-items-center py-2">
                <div class="col-2">
                    <div class="logo">
                        <span class="amazon-logo">amazon</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="search-bar">
                        <input type="text" class="form-control search-input" placeholder="Search products...">
                        <button class="btn search-btn"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div class="col-4 text-end">
                    <div class="user-actions">
                        <span class="hello-user">Hello, Sign in</span>
                        <span class="returns-orders">Returns & Orders</span>
                        <span class="cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-count">0</span>
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="row nav-row">
                <div class="col-12">
                    <div class="nav-bar">
                        <span class="nav-item"><i class="fas fa-bars"></i> All</span>
                        <span class="nav-item">Today's Deals</span>
                        <span class="nav-item">Customer Service</span>
                        <span class="nav-item">Registry</span>
                        <span class="nav-item">Gift Cards</span>
                        <span class="nav-item">Sell</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-4">📦 Product Inventory Management</h1>
            </div>
        </div>
        
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-md-3">
                <div class="sidebar-card">
                    <h5>Inventory Management</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#"><i class="fas fa-box"></i> Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-plus-circle"></i> Add New Product</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-chart-bar"></i> Reports</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-cog"></i> Settings</a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9">
                <!-- Product Form -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h4><i class="fas fa-plus-circle"></i> Add New Product</h4>
                    </div>
                    <div class="card-body">
                        <form id="productForm">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="productName" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="productName" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="quantity" class="form-label">Quantity in Stock</label>
                                    <input type="number" class="form-control" id="quantity" min="0" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="price" class="form-label">Price per Item (₹)</label>
                                    <input type="number" class="form-control" id="price" min="0" step="0.01" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning"><i class="fas fa-plus"></i> Add Product</button>
                        </form>
                    </div>
                </div>
                
                <!-- Products Table -->
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h4><i class="fas fa-boxes"></i> Product Inventory</h4>
                    </div>
                    <div class="card-body">
                        <div id="productsTable">
                            <!-- Table will be loaded here via AJAX -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="editModalLabel"><i class="fas fa-edit"></i> Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editIndex">
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="editProductName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editQuantity" class="form-label">Quantity in Stock</label>
                            <input type="number" class="form-control" id="editQuantity" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPrice" class="form-label">Price per Item (₹)</label>
                            <input type="number" class="form-control" id="editPrice" min="0" step="0.01" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning" id="saveChanges"><i class="fas fa-save"></i> Save Changes</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="amazon-footer mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="back-to-top">
                        <a href="#" class="text-white">Back to top</a>
                    </div>
                </div>
            </div>
            <div class="row footer-links">
                <div class="col-md-3 col-6">
                    <h6>Get to Know Us</h6>
                    <ul>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">About Amazon</a></li>
                        <li><a href="#">Investor Relations</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-6">
                    <h6>Make Money with Us</h6>
                    <ul>
                        <li><a href="#">Sell products on Amazon</a></li>
                        <li><a href="#">Sell on Amazon Business</a></li>
                        <li><a href="#">Become an Affiliate</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-6">
                    <h6>Amazon Payment Products</h6>
                    <ul>
                        <li><a href="#">Amazon Business Card</a></li>
                        <li><a href="#">Shop with Points</a></li>
                        <li><a href="#">Reload Your Balance</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-6">
                    <h6>Let Us Help You</h6>
                    <ul>
                        <li><a href="#">Amazon and COVID-19</a></li>
                        <li><a href="#">Your Account</a></li>
                        <li><a href="#">Shipping Rates & Policies</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <div class="copyright">
                        <p>&copy; 1996-2025, Amazon.com, Inc. or its affiliates</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="script.js"></script>
</body>
</html>