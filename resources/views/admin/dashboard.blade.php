<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HM Cosmetics Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="font-sans bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="w-64 bg-white border-r border-gray-200">
            <div class="p-4 border-b border-gray-200">
                <h1 class="text-xl font-semibold text-gray-800">HM Cosmetics</h1>
                <p class="text-xs text-gray-500">Admin Dashboard</p>
            </div>
            <nav class="p-4">
                <div class="space-y-1">
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-md bg-gray-100 text-gray-900">
                        <i class="fas fa-tachometer-alt mr-3 text-gray-500"></i>
                        Dashboard
                    </a>
                    <a href="#products" onclick="showSection('products')" class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-100 text-gray-700 hover:text-gray-900">
                        <i class="fas fa-boxes mr-3 text-gray-500"></i>
                        Products
                    </a>
                    <a href="#users" onclick="showSection('users')" class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-100 text-gray-700 hover:text-gray-900">
                        <i class="fas fa-users mr-3 text-gray-500"></i>
                        Users
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200">
                <div class="flex justify-between items-center px-6 py-4">
                    <h2 class="text-lg font-semibold text-gray-800" id="section-title">Dashboard</h2>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Search..." class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent w-64">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <div class="flex items-center space-x-2">
                            <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name=Admin+User&background=7e22ce&color=fff" alt="Admin">
                            <span class="text-sm font-medium">Admin</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="p-6">
                <!-- Products Section -->
                <div id="products-section" class="section-content">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Products Management</h3>
                        <button onclick="openProductModal()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Add Product
                        </button>
                    </div>

                    <!-- Products Table -->
                    <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="products-table-body">
                                <!-- Products will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Users Section -->
                <div id="users-section" class="section-content hidden">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Users Management</h3>
                        <button onclick="openUserModal()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Add User
                        </button>
                    </div>

                    <!-- Users Table -->
                    <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="users-table-body" class="bg-white divide-y divide-gray-200">
                                <!-- Users will be dynamically loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Product Modal -->
    <div id="product-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4" id="product-modal-title">Edit Product</h3>
                    <form id="product-form">
                        <input type="hidden" id="product-id">
                        <div class="mb-4">
                            <label for="product-name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                            <input type="text" id="product-name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div class="mb-4">
                            <label for="product-category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select id="product-category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="product-price" class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
                            <input type="number" id="product-price" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div class="mb-4">
                            <label for="product-stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                            <input type="number" id="product-stock" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div class="mb-4">
                            <label for="product-image" class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>
                            <input type="file" id="product-image" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        </div>
                    </form>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="saveProduct()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Save
                    </button>
                    <button type="button" onclick="closeModal('product-modal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- User Modal -->
    <div id="user-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4" id="user-modal-title">Add New User</h3>
                    <form id="user-form">
                        <input type="hidden" id="user-id">
                        <div class="mb-4">
                            <label for="user-name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" id="user-name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div class="mb-4">
                            <label for="user-email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="user-email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div class="mb-4">
                            <label for="user-role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                            <select id="user-role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="user-status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="user-status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="saveUser()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Save
                    </button>
                    <button type="button" onclick="closeModal('user-modal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirm-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="confirm-title">Delete Item</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" id="confirm-message">Are you sure you want to delete this item? This action cannot be undone.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="confirmAction()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Confirm
                    </button>
                    <button type="button" onclick="closeModal('confirm-modal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data from backend (fallback to empty arrays if not provided)
        const products = @json($products ?? []);
        const users = @json($users ?? []);
        const categories = @json($categories ?? []);

        // Current action and ID for confirmation
        let currentAction = null;
        let currentId = null;

        // Initialize the dashboard
        document.addEventListener('DOMContentLoaded', function() {
            loadProducts();
            loadUsers();
            showSection('products');
        });

        // Show section based on ID
        function showSection(sectionId) {
            document.querySelectorAll('.section-content').forEach(section => {
                section.classList.add('hidden');
            });
            document.getElementById(sectionId + '-section').classList.remove('hidden');
            document.getElementById('section-title').textContent = sectionId === 'products' ? 'Products Management' : 'Users Management';
        }

        // Load products into table
        function loadProducts() {
            const tbody = document.getElementById('products-table-body');
            tbody.innerHTML = '';

            if (products.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            No products found. <button onclick="openProductModal()" class="text-purple-600 hover:text-purple-800 font-medium">Add a product</button>
                        </td>
                    </tr>
                `;
                return;
            }

            products.forEach(product => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-gray-50';
                tr.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${product.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${getCategoryName(product.category_id)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$${parseFloat(product.price).toFixed(2)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${product.stock}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="editProduct(${product.id})" class="text-purple-600 hover:text-purple-900 mr-3">Edit</button>
                        <button onclick="deleteProduct(${product.id})" class="text-red-600 hover:text-red-900">Delete</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Helper function to get category name by ID
        function getCategoryName(categoryId) {
            const category = categories.find(c => c.id == categoryId);
            return category ? category.name : 'Uncategorized';
        }

        // Load users into table
        function loadUsers() {
            const tbody = document.getElementById('users-table-body');
            tbody.innerHTML = '';

            if (users.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            No users found. <button onclick="openUserModal()" class="text-purple-600 hover:text-purple-800 font-medium">Add a user</button>
                        </td>
                    </tr>
                `;
                return;
            }

            users.forEach(user => {
                const statusClass = user.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-gray-50';
                tr.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${user.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.email}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">${user.role}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full ${statusClass} capitalize">${user.status || 'active'}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="editUser(${user.id})" class="text-purple-600 hover:text-purple-900 mr-3">Edit</button>
                        <button onclick="deleteUser(${user.id})" class="text-red-600 hover:text-red-900">Delete</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Product CRUD operations
        function openProductModal(productId = null) {
            const modal = document.getElementById('product-modal');
            const title = document.getElementById('product-modal-title');
            const form = document.getElementById('product-form');
            
            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(el => el.remove());
            document.getElementById('product-name').classList.remove('border-red-500');
            document.getElementById('product-category').classList.remove('border-red-500');
            document.getElementById('product-price').classList.remove('border-red-500');
            document.getElementById('product-stock').classList.remove('border-red-500');
            
            if (productId) {
                title.textContent = 'Edit Product';
                const product = products.find(p => p.id === productId);
                if (product) {
                    document.getElementById('product-id').value = product.id;
                    document.getElementById('product-name').value = product.name;
                    document.getElementById('product-category').value = product.category_id;
                    document.getElementById('product-price').value = product.price;
                    document.getElementById('product-stock').value = product.stock;
                }
            } else {
                title.textContent = 'Add New Product';
                form.reset();
                document.getElementById('product-id').value = '';
            }
            
            modal.classList.remove('hidden');
        }

        function saveProduct() {
            // Get form elements
            const id = document.getElementById('product-id').value;
            const nameInput = document.getElementById('product-name');
            const categorySelect = document.getElementById('product-category');
            const priceInput = document.getElementById('product-price');
            const stockInput = document.getElementById('product-stock');
            const imageInput = document.getElementById('product-image');

            // Get trimmed values
            const name = nameInput.value.trim();
            const category_id = categorySelect.value;
            const price = parseFloat(priceInput.value);
            const stock = parseInt(stockInput.value);
            const image = imageInput.files[0];

            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(el => el.remove());
            nameInput.classList.remove('border-red-500');
            categorySelect.classList.remove('border-red-500');
            priceInput.classList.remove('border-red-500');
            stockInput.classList.remove('border-red-500');

            // Validation
            let isValid = true;

            if (!name) {
                showFieldError(nameInput, 'Product name is required');
                isValid = false;
            }

            if (!category_id) {
                showFieldError(categorySelect, 'Category is required');
                isValid = false;
            }

            if (isNaN(price) || price <= 0) {
                showFieldError(priceInput, 'Please enter a valid price');
                isValid = false;
            }

            if (isNaN(stock) || stock < 0) {
                showFieldError(stockInput, 'Please enter a valid stock quantity');
                isValid = false;
            }

            if (!isValid) {
                showToast('Please fix the errors in the form', 'error');
                return;
            }

            // Prepare form data
            const formData = new FormData();
            formData.append('name', name);
            formData.append('category_id', category_id);
            formData.append('price', price);
            formData.append('stock', stock);
            if (image) {
                formData.append('image', image);
            }

            // Determine endpoint and method
            const url = id ? `/admin/products/${id}` : '/admin/products';
            const method = id ? 'PUT' : 'POST'; // Use PUT for updates, POST for new products
            if (id) {
                formData.append('_method', 'PUT'); // Add _method field for PUT requests
            }

            // Show saving state
            const saveBtn = document.querySelector('#product-modal button[onclick="saveProduct()"]');
            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
            saveBtn.disabled = true;

            // Make API request
            fetch(url, {
                method: 'POST', // Always use POST for FormData
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'Server error');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showToast('Product saved successfully', 'success');
                    closeModal('product-modal');
                    loadProducts(); // Refresh the products table
                } else {
                    throw new Error(data.message || 'Failed to save product');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast(error.message || 'An error occurred while saving the product', 'error');
            })
            .finally(() => {
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
            });
        }

        function editProduct(productId) {
            const product = products.find(p => p.id === productId);
            if (product) {
                openProductModal(productId);
            } else {
                showToast('Product not found!', 'error');
            }
        }

        function deleteProduct(id) {
            currentAction = 'deleteProduct';
            currentId = id;
            document.getElementById('confirm-title').textContent = 'Delete Product';
            document.getElementById('confirm-message').textContent = 'Are you sure you want to delete this product? This action cannot be undone.';
            document.getElementById('confirm-modal').classList.remove('hidden');
        }

        // User CRUD operations
        function openUserModal(userId = null) {
            const modal = document.getElementById('user-modal');
            const title = document.getElementById('user-modal-title');
            const form = document.getElementById('user-form');
            
            if (userId) {
                title.textContent = 'Edit User';
                const user = users.find(u => u.id === userId);
                if (user) {
                    document.getElementById('user-id').value = user.id;
                    document.getElementById('user-name').value = user.name;
                    document.getElementById('user-email').value = user.email;
                    document.getElementById('user-role').value = user.role;
                    document.getElementById('user-status').value = user.status;
                }
            } else {
                title.textContent = 'Add New User';
                form.reset();
                document.getElementById('user-id').value = '';
            }
            
            modal.classList.remove('hidden');
        }

        function saveUser() {
            // Get form elements
            const id = document.getElementById('user-id').value;
            const name = document.getElementById('user-name').value.trim();
            const email = document.getElementById('user-email').value.trim();
            const role = document.getElementById('user-role').value;
            const status = document.getElementById('user-status').value;

            // Prepare data
            const userData = {
                name: name,
                email: email,
                role: role,
                status: status
            };

            // Determine endpoint
            const url = id ? `/admin/users/${id}` : '/admin/users';
            const method = id ? 'PUT' : 'POST';

            // Show saving state
            const saveBtn = document.querySelector('#user-modal button[onclick="saveUser()"]');
            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
            saveBtn.disabled = true;

            // Make API request
            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(userData)
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'Server error');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showToast('User saved successfully', 'success');
                    closeModal('user-modal');
                    loadUsers(); // Refresh the users table
                } else {
                    throw new Error(data.message || 'Failed to save user');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast(error.message || 'Failed to save user', 'error');
            })
            .finally(() => {
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
            });
        }

        function editUser(id) {
            openUserModal(id);
        }

        function deleteUser(id) {
            currentAction = 'deleteUser';
            currentId = id;
            document.getElementById('confirm-title').textContent = 'Delete User';
            document.getElementById('confirm-message').textContent = 'Are you sure you want to delete this user? This action cannot be undone.';
            document.getElementById('confirm-modal').classList.remove('hidden');
        }

        // Confirmation and modal handling
        function confirmAction() {
            if (currentAction === 'deleteProduct') {
                fetch(`/admin/products/${currentId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message, 'success');
                        loadProducts();
                    } else {
                        showToast(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An error occurred while deleting the product', 'error');
                });
            } else if (currentAction === 'deleteUser') {
                fetch(`/admin/users/${currentId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message, 'success');
                        loadUsers();
                    } else {
                        showToast(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An error occurred while deleting the user', 'error');
                });
            }
            closeModal('confirm-modal');
        }

        // Helper function to display field errors
        function showFieldError(inputElement, message) {
            inputElement.classList.add('border-red-500');
            const errorElement = document.createElement('p');
            errorElement.className = 'error-message text-red-500 text-xs mt-1';
            errorElement.textContent = message;
            inputElement.parentNode.appendChild(errorElement);
        }

        // Helper function to show toast notifications
        function showToast(message, type = 'success') {
            // Remove existing toasts if any
            document.querySelectorAll('.toast-notification').forEach(el => el.remove());
            
            const toast = document.createElement('div');
            toast.className = `toast-notification fixed top-4 right-4 px-4 py-2 rounded shadow-lg z-50 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.add('opacity-0', 'transition-opacity', 'duration-300');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
</body>
</html>