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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
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
                    <a href="#orders" onclick="showSection('orders')" class="flex items-center px-3 py-2 text-sm font-medium rounded-md hover:bg-gray-100 text-gray-700 hover:text-gray-900">
                        <i class="fas fa-shopping-cart mr-3 text-gray-500"></i>
                        Orders
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
                        <div class="space-x-3">
                            <button onclick="document.getElementById('file-input').click()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-file-import mr-2"></i>Import
                            </button>
                            <button onclick="downloadImportTemplate()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                <i class="fas fa-file-download mr-2"></i>Template
                            </button>
                            <button onclick="openProductModal()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                                <i class="fas fa-plus mr-2"></i>Add Product
                            </button>
                        </div>
                    </div>

                    <!-- Search and Filter -->
                    <div class="bg-white p-4 rounded-lg shadow border border-gray-200 mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                <input type="text" id="product-search" placeholder="Product name..." 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select id="category-filter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Price Range</label>
                                <div class="flex space-x-2">
                                    <input type="number" id="min-price" placeholder="Min" 
                                        class="w-1/2 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                    <input type="number" id="max-price" placeholder="Max" 
                                        class="w-1/2 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Stock Status</label>
                                <select id="stock-filter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                    <option value="">All</option>
                                    <option value="in_stock">In Stock (>0)</option>
                                    <option value="out_of_stock">Out of Stock (0)</option>
                                    <option value="low_stock">Low Stock (<10)</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3 flex justify-end">
                            <button onclick="resetFilters()" class="px-3 py-1 text-sm text-gray-600 hover:text-gray-800">
                                Reset Filters
                            </button>
                            <button onclick="applyFilters()" class="ml-2 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                                Apply
                            </button>
                        </div>
                    </div>

                    <!-- Products Table -->
                    <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortTable('name')">
                                            Product <i class="fas fa-sort ml-1"></i>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortTable('category')">
                                            Category <i class="fas fa-sort ml-1"></i>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortTable('price')">
                                            Price <i class="fas fa-sort ml-1"></i>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortTable('stock')">
                                            Stock <i class="fas fa-sort ml-1"></i>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="products-table-body">
                                    <!-- Products will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                            <div class="flex-1 flex justify-between sm:hidden">
                                <button onclick="previousPage()" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Previous
                                </button>
                                <button onclick="nextPage()" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Next
                                </button>
                            </div>
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700" id="pagination-info">
                                        Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">20</span> results
                                    </p>
                                </div>
                                <div>
                                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                        <button onclick="previousPage()" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Previous</span>
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <div id="page-numbers" class="flex">
                                            <!-- Page numbers will be inserted here -->
                                        </div>
                                        <button onclick="nextPage()" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Next</span>
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users Section -->
                <!-- Users Section -->
<div id="users-section" class="section-content hidden">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-semibold text-gray-800">Users Management</h3>
        <div class="space-x-3">
            <button onclick="exportUsers()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-file-export mr-2"></i>Export
            </button>
            <button onclick="openUserModal()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>Add User
            </button>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white p-4 rounded-lg shadow border border-gray-200 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" id="user-search" placeholder="Name or email..." 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select id="role-filter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    <option value="">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status-filter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
        <div class="mt-3 flex justify-end">
            <button onclick="resetUserFilters()" class="px-3 py-1 text-sm text-gray-600 hover:text-gray-800">
                Reset Filters
            </button>
            <button onclick="applyUserFilters()" class="ml-2 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                Apply
            </button>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortUserTable('name')">
                            Name <i class="fas fa-sort ml-1"></i>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortUserTable('email')">
                            Email <i class="fas fa-sort ml-1"></i>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortUserTable('role')">
                            Role <i class="fas fa-sort ml-1"></i>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortUserTable('status')">
                            Status <i class="fas fa-sort ml-1"></i>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Active</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="users-table-body" class="bg-white divide-y divide-gray-200">
                    <!-- Users will be dynamically loaded here -->
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                <button onclick="previousUserPage()" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Previous
                </button>
                <button onclick="nextUserPage()" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Next
                </button>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700" id="user-pagination-info">
                        Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">20</span> results
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <button onclick="previousUserPage()" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Previous</span>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div id="user-page-numbers" class="flex">
                            <!-- Page numbers will be inserted here -->
                        </div>
                        <button onclick="nextUserPage()" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Next</span>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </nav>
                </div>
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
                    <div class="mb-4" id="password-fields">
                        <label for="user-password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input 
                            type="password" 
                            id="user-password" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                            autocomplete="new-password"
                        >
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                    </div>
                    <div class="mb-4" id="password-confirm-field">
                        <label for="user-password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input 
                            type="password" 
                            id="user-password_confirmation" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500"
                            autocomplete="new-password"
                        >
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

<script>
    // User-specific variables
    let currentUserPage = 1;
    const usersPerPage = 10;
    let totalUsers = 0;
    let userSortColumn = 'name';
    let userSortDirection = 'asc';
    let currentUserFilters = {};

    // Load users with pagination and filters
    function loadUsers(page = 1, filters = {}) {
        currentUserPage = page;
        currentUserFilters = filters;
        
        // Show loading state
        const tbody = document.getElementById('users-table-body');
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-4 text-center">
                    <div class="flex justify-center">
                        <i class="fas fa-spinner fa-spin text-purple-600 text-2xl"></i>
                    </div>
                </td>
            </tr>
        `;
        
        // Simulate API call (replace with actual fetch)
        setTimeout(() => {
            // Filter users based on current filters
            let filteredUsers = [...users];
            
            // Apply search filter
            if (filters.search) {
                const searchTerm = filters.search.toLowerCase();
                filteredUsers = filteredUsers.filter(u => 
                    u.name.toLowerCase().includes(searchTerm) || 
                    u.email.toLowerCase().includes(searchTerm)
                );
            }
            
            // Apply role filter
            if (filters.role) {
                filteredUsers = filteredUsers.filter(u => 
                    u.role === filters.role
                );
            }
            
            // Apply status filter
            if (filters.status) {
                filteredUsers = filteredUsers.filter(u => 
                    u.status === filters.status
                );
            }
            
            // Sort users
            filteredUsers.sort((a, b) => {
                let valA, valB;
                
                switch(userSortColumn) {
                    case 'name':
                        valA = a.name.toLowerCase();
                        valB = b.name.toLowerCase();
                        break;
                    case 'email':
                        valA = a.email.toLowerCase();
                        valB = b.email.toLowerCase();
                        break;
                    case 'role':
                        valA = a.role;
                        valB = b.role;
                        break;
                    case 'status':
                        valA = a.status;
                        valB = b.status;
                        break;
                    default:
                        valA = a.name.toLowerCase();
                        valB = b.name.toLowerCase();
                }
                
                if (valA < valB) return userSortDirection === 'asc' ? -1 : 1;
                if (valA > valB) return userSortDirection === 'asc' ? 1 : -1;
                return 0;
            });
            
            totalUsers = filteredUsers.length;
            
            // Calculate pagination
            const startIndex = (page - 1) * usersPerPage;
            const endIndex = Math.min(startIndex + usersPerPage, totalUsers);
            const paginatedUsers = filteredUsers.slice(startIndex, endIndex);
            
            // Update table
            tbody.innerHTML = '';
            
            if (paginatedUsers.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            No users found matching your criteria.
                        </td>
                    </tr>
                `;
            } else {
                paginatedUsers.forEach(user => {
                    const statusClass = user.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                    const lastActive = user.last_active ? formatDate(user.last_active) : 'Never';
                    
                    const tr = document.createElement('tr');
                    tr.className = 'hover:bg-gray-50';
                    tr.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="${user.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name) + '&background=7e22ce&color=fff'}" alt="${user.name}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">${user.name}</div>
                                    <div class="text-sm text-gray-500">ID: ${user.id}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.email}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">${user.role}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full ${statusClass} capitalize">${user.status || 'active'}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${lastActive}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="editUser(${user.id})" class="text-purple-600 hover:text-purple-900 mr-3">Edit</button>
                            <button onclick="deleteUser(${user.id})" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            }
            
            // Update pagination controls
            updateUserPaginationControls();
            
        }, 500); // Simulate network delay
    }

    // Update user pagination controls
    function updateUserPaginationControls() {
        const totalPages = Math.ceil(totalUsers / usersPerPage);
        const startItem = ((currentUserPage - 1) * usersPerPage) + 1;
        const endItem = Math.min(currentUserPage * usersPerPage, totalUsers);
        
        // Update pagination info
        document.getElementById('user-pagination-info').innerHTML = `
            Showing <span class="font-medium">${startItem}</span> to <span class="font-medium">${endItem}</span> of <span class="font-medium">${totalUsers}</span> results
        `;
        
        // Update page numbers
        const pageNumbersContainer = document.getElementById('user-page-numbers');
        pageNumbersContainer.innerHTML = '';
        
        // Always show first page
        addUserPageNumber(1, currentUserPage === 1);
        
        // Show ellipsis if needed
        if (currentUserPage > 3) {
            const ellipsis = document.createElement('span');
            ellipsis.className = 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700';
            ellipsis.textContent = '...';
            pageNumbersContainer.appendChild(ellipsis);
        }
        
        // Show current page and neighbors
        const startPage = Math.max(2, currentUserPage - 1);
        const endPage = Math.min(totalPages - 1, currentUserPage + 1);
        
        for (let i = startPage; i <= endPage; i++) {
            addUserPageNumber(i, i === currentUserPage);
        }
        
        // Show ellipsis if needed
        if (currentUserPage < totalPages - 2) {
            const ellipsis = document.createElement('span');
            ellipsis.className = 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700';
            ellipsis.textContent = '...';
            pageNumbersContainer.appendChild(ellipsis);
        }
        
        // Always show last page if there are multiple pages
        if (totalPages > 1) {
            addUserPageNumber(totalPages, currentUserPage === totalPages);
        }
    }
    
    function addUserPageNumber(pageNumber, isActive) {
        const pageNumbersContainer = document.getElementById('user-page-numbers');
        const pageButton = document.createElement('button');
        pageButton.className = `relative inline-flex items-center px-4 py-2 border text-sm font-medium ${
            isActive 
                ? 'z-10 bg-purple-50 border-purple-500 text-purple-600' 
                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
        }`;
        pageButton.textContent = pageNumber;
        pageButton.onclick = () => loadUsers(pageNumber, currentUserFilters);
        pageNumbersContainer.appendChild(pageButton);
    }

    // User pagination navigation
    function previousUserPage() {
        if (currentUserPage > 1) {
            loadUsers(currentUserPage - 1, currentUserFilters);
        }
    }
    
    function nextUserPage() {
        if (currentUserPage < Math.ceil(totalUsers / usersPerPage)) {
            loadUsers(currentUserPage + 1, currentUserFilters);
        }
    }

    // User table sorting
    function sortUserTable(column) {
        if (userSortColumn === column) {
            userSortDirection = userSortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            userSortColumn = column;
            userSortDirection = 'asc';
        }
        loadUsers(currentUserPage, currentUserFilters);
    }

    // Apply user filters
    function applyUserFilters() {
        const filters = {
            search: document.getElementById('user-search').value,
            role: document.getElementById('role-filter').value,
            status: document.getElementById('status-filter').value
        };
        loadUsers(1, filters);
    }
    
    // Reset user filters
    function resetUserFilters() {
        document.getElementById('user-search').value = '';
        document.getElementById('role-filter').value = '';
        document.getElementById('status-filter').value = '';
        loadUsers(1, {});
    }

    // Export users to CSV
    function exportUsers() {
        // Get filtered users
        let filteredUsers = [...users];
        
        if (currentUserFilters.search) {
            const searchTerm = currentUserFilters.search.toLowerCase();
            filteredUsers = filteredUsers.filter(u => 
                u.name.toLowerCase().includes(searchTerm) || 
                u.email.toLowerCase().includes(searchTerm)
            );
        }
        
        if (currentUserFilters.role) {
            filteredUsers = filteredUsers.filter(u => 
                u.role === currentUserFilters.role
            );
        }
        
        if (currentUserFilters.status) {
            filteredUsers = filteredUsers.filter(u => 
                u.status === currentUserFilters.status
            );
        }
        
        // Sort users
        filteredUsers.sort((a, b) => {
            let valA, valB;
            
            switch(userSortColumn) {
                case 'name':
                    valA = a.name.toLowerCase();
                    valB = b.name.toLowerCase();
                    break;
                case 'email':
                    valA = a.email.toLowerCase();
                    valB = b.email.toLowerCase();
                    break;
                case 'role':
                    valA = a.role;
                    valB = b.role;
                    break;
                case 'status':
                    valA = a.status;
                    valB = b.status;
                    break;
                default:
                    valA = a.name.toLowerCase();
                    valB = b.name.toLowerCase();
            }
            
            if (valA < valB) return userSortDirection === 'asc' ? -1 : 1;
            if (valA > valB) return userSortDirection === 'asc' ? 1 : -1;
            return 0;
        });
        
        // Prepare CSV content
        let csvContent = "data:text/csv;charset=utf-8,";
        
        // Add headers
        csvContent += "ID,Name,Email,Role,Status,Last Active\n";
        
        // Add user data
        filteredUsers.forEach(user => {
            const lastActive = user.last_active ? formatDate(user.last_active) : 'Never';
            csvContent += `${user.id},"${user.name}","${user.email}",${user.role},${user.status},${lastActive}\n`;
        });
        
        // Create download link
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "hm_users_export.csv");
        document.body.appendChild(link);
        
        // Trigger download
        link.click();
        
        // Clean up
        document.body.removeChild(link);
        
        showToast('Users exported successfully', 'success');
    }

    // Format date for display
    function formatDate(dateString) {
        const options = { 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        return new Date(dateString).toLocaleDateString('en-US', options);
    }

    // User CRUD operations
    function openUserModal(userId = null) {
        const modal = document.getElementById('user-modal');
        const title = document.getElementById('user-modal-title');
        const form = document.getElementById('user-form');
        
        // Clear previous errors
        document.querySelectorAll('.error-message').forEach(el => el.remove());
        document.getElementById('user-name').classList.remove('border-red-500');
        document.getElementById('user-email').classList.remove('border-red-500');
        document.getElementById('user-password').classList.remove('border-red-500');
        document.getElementById('user-password_confirmation').classList.remove('border-red-500');
        
        if (userId) {
            title.textContent = 'Edit User';
            const user = users.find(u => u.id === userId);
            if (user) {
                document.getElementById('user-id').value = user.id;
                document.getElementById('user-name').value = user.name;
                document.getElementById('user-email').value = user.email;
                document.getElementById('user-role').value = user.role;
                document.getElementById('user-status').value = user.status;
                
                // Hide password fields for existing users
                document.getElementById('password-fields').classList.add('hidden');
                document.getElementById('password-confirm-field').classList.add('hidden');
            }
        } else {
            title.textContent = 'Add New User';
            form.reset();
            document.getElementById('user-id').value = '';
            
            // Show password fields for new users
            document.getElementById('password-fields').classList.remove('hidden');
            document.getElementById('password-confirm-field').classList.remove('hidden');
        }
        
        modal.classList.remove('hidden');
    }

    function saveUser() {
        // Get form elements
        const id = document.getElementById('user-id').value;
        const nameInput = document.getElementById('user-name');
        const emailInput = document.getElementById('user-email');
        const passwordInput = document.getElementById('user-password');
        const passwordConfirmInput = document.getElementById('user-password_confirmation');
        const roleSelect = document.getElementById('user-role');
        const statusSelect = document.getElementById('user-status');

        // Get values
        const name = nameInput.value.trim();
        const email = emailInput.value.trim();
        const password = passwordInput.value;
        const password_confirmation = passwordConfirmInput.value;
        const role = roleSelect.value;
        const status = statusSelect.value;

        // Clear previous errors
        document.querySelectorAll('.error-message').forEach(el => el.remove());
        nameInput.classList.remove('border-red-500');
        emailInput.classList.remove('border-red-500');
        passwordInput.classList.remove('border-red-500');
        passwordConfirmInput.classList.remove('border-red-500');

        // Validation
        let isValid = true;

        if (!name) {
            showFieldError(nameInput, 'Name is required');
            isValid = false;
        }

        if (!email) {
            showFieldError(emailInput, 'Email is required');
            isValid = false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            showFieldError(emailInput, 'Please enter a valid email');
            isValid = false;
        }

        // Only validate password if it's a new user or password fields are visible
        if (!id || (password || password_confirmation)) {
            if (password.length < 8) {
                showFieldError(passwordInput, 'Password must be at least 8 characters');
                isValid = false;
            }

            if (password !== password_confirmation) {
                showFieldError(passwordConfirmInput, 'Passwords do not match');
                isValid = false;
            }
        }

        if (!isValid) {
            showToast('Please fix the errors in the form', 'error');
            return;
        }

        // Prepare data
        const userData = {
            name: name,
            email: email,
            role: role,
            status: status
        };

        // Only add password if it's being changed
        if (password) {
            userData.password = password;
            userData.password_confirmation = password_confirmation;
        }

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
                loadUsers(currentUserPage, currentUserFilters); // Refresh the users table
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

    // Initialize users when section is shown
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listener for user search input
        document.getElementById('user-search').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                applyUserFilters();
            }
        });
        
        // Load users when section is shown
        document.querySelector('a[href="#users"]').addEventListener('click', function() {
            loadUsers();
        });
    });
</script> 

               <!-- Orders Section -->
<div id="orders-section" class="section-content hidden">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-semibold text-gray-800">Orders Management</h3>
        <div class="space-x-3">
            <button onclick="exportOrders()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-file-export mr-2"></i>Export
            </button>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white p-4 rounded-lg shadow border border-gray-200 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" id="order-search" placeholder="Order ID or user..." 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status-filter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                <div class="flex space-x-2">
                    <input type="date" id="start-date" placeholder="Start date" 
                        class="w-1/2 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    <input type="date" id="end-date" placeholder="End date" 
                        class="w-1/2 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Total Range</label>
                <div class="flex space-x-2">
                    <input type="number" id="min-total" placeholder="Min" 
                        class="w-1/2 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                    <input type="number" id="max-total" placeholder="Max" 
                        class="w-1/2 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                </div>
            </div>
        </div>
        <div class="mt-3 flex justify-end">
            <button onclick="resetOrderFilters()" class="px-3 py-1 text-sm text-gray-600 hover:text-gray-800">
                Reset Filters
            </button>
            <button onclick="applyOrderFilters()" class="ml-2 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                Apply
            </button>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortOrderTable('id')">
                            Order ID <i class="fas fa-sort ml-1"></i>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortOrderTable('user_id')">
                            Customer <i class="fas fa-sort ml-1"></i>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortOrderTable('total')">
                            Total <i class="fas fa-sort ml-1"></i>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortOrderTable('status')">
                            Status <i class="fas fa-sort ml-1"></i>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortOrderTable('created_at')">
                            Date <i class="fas fa-sort ml-1"></i>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="orders-table-body" class="bg-white divide-y divide-gray-200">
                    <!-- Orders will be dynamically loaded here -->
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                <button onclick="previousOrderPage()" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Previous
                </button>
                <button onclick="nextOrderPage()" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Next
                </button>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700" id="order-pagination-info">
                        Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">20</span> results
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <button onclick="previousOrderPage()" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Previous</span>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div id="order-page-numbers" class="flex">
                            <!-- Page numbers will be inserted here -->
                        </div>
                        <button onclick="nextOrderPage()" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Next</span>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div id="order-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Order #<span id="order-id"></span></h3>
                        <p class="text-sm text-gray-500">Placed on <span id="order-date"></span></p>
                    </div>
                    <div>
                        <span id="order-status-badge" class="px-3 py-1 rounded-full text-xs font-semibold"></span>
                    </div>
                </div>
                
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="col-span-2">
                        <h4 class="text-md font-medium text-gray-900 mb-3">Order Items</h4>
                        <div class="bg-gray-50 rounded-lg overflow-hidden border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="order-items-body" class="bg-white divide-y divide-gray-200">
                                    <!-- Order items will be loaded here -->
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-right text-sm font-medium text-gray-500">Subtotal</td>
                                        <td class="px-4 py-3 text-sm text-gray-900" id="order-subtotal"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-right text-sm font-medium text-gray-500">Shipping</td>
                                        <td class="px-4 py-3 text-sm text-gray-900" id="order-shipping"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-right text-sm font-medium text-gray-500">Total</td>
                                        <td class="px-4 py-3 text-sm font-semibold text-gray-900" id="order-total"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-md font-medium text-gray-900 mb-3">Customer Details</h4>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 mb-4">
                            <div class="flex items-center mb-3">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                    <i class="fas fa-user text-purple-600"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900" id="customer-name"></p>
                                    <p class="text-sm text-gray-500" id="customer-id"></p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <p class="text-xs text-gray-500">Contact</p>
                                    <p class="text-sm text-gray-900" id="customer-contact"></p>
                                </div>
                            </div>
                        </div>
                        
                        <h4 class="text-md font-medium text-gray-900 mb-3">Shipping Address</h4>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-sm text-gray-900" id="shipping-address"></p>
                            <p class="text-sm text-gray-500 mt-2" id="order-notes"></p>
                        </div>
                        
                        <div class="mt-4">
                            <label for="order-status" class="block text-sm font-medium text-gray-700 mb-1">Update Status</label>
                            <div class="flex">
                                <select id="order-status" class="flex-grow px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                                <button onclick="updateOrderStatus()" class="ml-2 px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeModal('order-modal')" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Orders-specific variables
    let currentOrderPage = 1;
    const ordersPerPage = 10;
    let totalOrders = 0;
    let orderSortColumn = 'created_at';
    let orderSortDirection = 'desc';
    let currentOrderFilters = {};
    
    // Sample orders data (replace with actual data from backend)
    const orders = [
        {
            id: 1,
            user_id: 60,
            subtotal: 60.00,
            shipping: 5.00,
            total: 65.00,
            status: 'pending',
            shipping_address: 'Taguig City',
            contact_number: '09273654434',
            notes: 'red na',
            created_at: '2025-04-06',
            updated_at: '2025-04-06',
            customer_name: 'John Doe',
            items: [
                { product_id: 1, product_name: 'Lipstick', price: 15.00, quantity: 2, subtotal: 30.00 },
                { product_id: 2, product_name: 'Mascara', price: 12.00, quantity: 1, subtotal: 12.00 }
            ]
        },
        {
            id: 2,
            user_id: 60,
            subtotal: 50.00,
            shipping: 5.00,
            total: 55.00,
            status: 'pending',
            shipping_address: 'Taguig City',
            contact_number: '09273654434',
            notes: 'red na',
            created_at: '2025-04-06',
            updated_at: '2025-04-06',
            customer_name: 'John Doe',
            items: [
                { product_id: 3, product_name: 'Foundation', price: 25.00, quantity: 2, subtotal: 50.00 }
            ]
        },
        {
            id: 6,
            user_id: 60,
            subtotal: 100.00,
            shipping: 5.00,
            total: 105.00,
            status: 'pending',
            shipping_address: 'Antipolo',
            contact_number: '09273654434',
            notes: 'Outside',
            created_at: '2025-04-06',
            updated_at: '2025-04-06',
            customer_name: 'John Doe',
            items: [
                { product_id: 4, product_name: 'Eyeshadow Palette', price: 50.00, quantity: 2, subtotal: 100.00 }
            ]
        },
        {
            id: 8,
            user_id: 60,
            subtotal: 100.00,
            shipping: 5.00,
            total: 105.00,
            status: 'pending',
            shipping_address: 'Taguig City',
            contact_number: '09478017960',
            notes: null,
            created_at: '2025-04-06',
            updated_at: '2025-04-06',
            customer_name: 'Jane Smith',
            items: [
                { product_id: 5, product_name: 'Blush', price: 20.00, quantity: 5, subtotal: 100.00 }
            ]
        }
    ];

    // Load orders with pagination and filters
    function loadOrders(page = 1, filters = {}) {
        currentOrderPage = page;
        currentOrderFilters = filters;
        
        // Show loading state
        const tbody = document.getElementById('orders-table-body');
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-4 text-center">
                    <div class="flex justify-center">
                        <i class="fas fa-spinner fa-spin text-purple-600 text-2xl"></i>
                    </div>
                </td>
            </tr>
        `;
        
        // Simulate API call (replace with actual fetch)
        setTimeout(() => {
            // Filter orders based on current filters
            let filteredOrders = [...orders];
            
            // Apply search filter
            if (filters.search) {
                const searchTerm = filters.search.toLowerCase();
                filteredOrders = filteredOrders.filter(o => 
                    o.id.toString().includes(searchTerm) || 
                    o.customer_name.toLowerCase().includes(searchTerm) ||
                    o.contact_number.includes(searchTerm)
                );
            }
            
            // Apply status filter
            if (filters.status) {
                filteredOrders = filteredOrders.filter(o => 
                    o.status === filters.status
                );
            }
            
            // Apply date range filter
            if (filters.startDate || filters.endDate) {
                const startDate = filters.startDate ? new Date(filters.startDate) : null;
                const endDate = filters.endDate ? new Date(filters.endDate) : null;
                
                filteredOrders = filteredOrders.filter(o => {
                    const orderDate = new Date(o.created_at);
                    return (!startDate || orderDate >= startDate) && 
                           (!endDate || orderDate <= endDate);
                });
            }
            
            // Apply total range filter
            if (filters.minTotal || filters.maxTotal) {
                const min = filters.minTotal ? parseFloat(filters.minTotal) : 0;
                const max = filters.maxTotal ? parseFloat(filters.maxTotal) : Number.MAX_VALUE;
                filteredOrders = filteredOrders.filter(o => 
                    o.total >= min && o.total <= max
                );
            }
            
            // Sort orders
            filteredOrders.sort((a, b) => {
                let valA, valB;
                
                switch(orderSortColumn) {
                    case 'id':
                        valA = a.id;
                        valB = b.id;
                        break;
                    case 'user_id':
                        valA = a.customer_name.toLowerCase();
                        valB = b.customer_name.toLowerCase();
                        break;
                    case 'total':
                        valA = parseFloat(a.total);
                        valB = parseFloat(b.total);
                        break;
                    case 'status':
                        valA = a.status;
                        valB = b.status;
                        break;
                    case 'created_at':
                        valA = new Date(a.created_at);
                        valB = new Date(b.created_at);
                        break;
                    default:
                        valA = new Date(a.created_at);
                        valB = new Date(b.created_at);
                }
                
                if (valA < valB) return orderSortDirection === 'asc' ? -1 : 1;
                if (valA > valB) return orderSortDirection === 'asc' ? 1 : -1;
                return 0;
            });
            
            totalOrders = filteredOrders.length;
            
            // Calculate pagination
            const startIndex = (page - 1) * ordersPerPage;
            const endIndex = Math.min(startIndex + ordersPerPage, totalOrders);
            const paginatedOrders = filteredOrders.slice(startIndex, endIndex);
            
            // Update table
            tbody.innerHTML = '';
            
            if (paginatedOrders.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            No orders found matching your criteria.
                        </td>
                    </tr>
                `;
            } else {
                paginatedOrders.forEach(order => {
                    const statusClass = {
                        'pending': 'bg-yellow-100 text-yellow-800',
                        'processing': 'bg-blue-100 text-blue-800',
                        'completed': 'bg-green-100 text-green-800',
                        'cancelled': 'bg-red-100 text-red-800'
                    }[order.status] || 'bg-gray-100 text-gray-800';
                    
                    const tr = document.createElement('tr');
                    tr.className = 'hover:bg-gray-50';
                    tr.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#${order.id}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${order.customer_name}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱${order.total.toFixed(2)}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full ${statusClass} capitalize">${order.status}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${formatDate(order.created_at)}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="viewOrderDetails(${order.id})" class="text-purple-600 hover:text-purple-900">View</button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            }
            
            // Update pagination controls
            updateOrderPaginationControls();
            
        }, 500); // Simulate network delay
    }

    // Update order pagination controls
    function updateOrderPaginationControls() {
        const totalPages = Math.ceil(totalOrders / ordersPerPage);
        const startItem = ((currentOrderPage - 1) * ordersPerPage) + 1;
        const endItem = Math.min(currentOrderPage * ordersPerPage, totalOrders);
        
        // Update pagination info
        document.getElementById('order-pagination-info').innerHTML = `
            Showing <span class="font-medium">${startItem}</span> to <span class="font-medium">${endItem}</span> of <span class="font-medium">${totalOrders}</span> results
        `;
        
        // Update page numbers
        const pageNumbersContainer = document.getElementById('order-page-numbers');
        pageNumbersContainer.innerHTML = '';
        
        // Always show first page
        addOrderPageNumber(1, currentOrderPage === 1);
        
        // Show ellipsis if needed
        if (currentOrderPage > 3) {
            const ellipsis = document.createElement('span');
            ellipsis.className = 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700';
            ellipsis.textContent = '...';
            pageNumbersContainer.appendChild(ellipsis);
        }
        
        // Show current page and neighbors
        const startPage = Math.max(2, currentOrderPage - 1);
        const endPage = Math.min(totalPages - 1, currentOrderPage + 1);
        
        for (let i = startPage; i <= endPage; i++) {
            addOrderPageNumber(i, i === currentOrderPage);
        }
        
        // Show ellipsis if needed
        if (currentOrderPage < totalPages - 2) {
            const ellipsis = document.createElement('span');
            ellipsis.className = 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700';
            ellipsis.textContent = '...';
            pageNumbersContainer.appendChild(ellipsis);
        }
        
        // Always show last page if there are multiple pages
        if (totalPages > 1) {
            addOrderPageNumber(totalPages, currentOrderPage === totalPages);
        }
    }
    
    function addOrderPageNumber(pageNumber, isActive) {
        const pageNumbersContainer = document.getElementById('order-page-numbers');
        const pageButton = document.createElement('button');
        pageButton.className = `relative inline-flex items-center px-4 py-2 border text-sm font-medium ${
            isActive 
                ? 'z-10 bg-purple-50 border-purple-500 text-purple-600' 
                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
        }`;
        pageButton.textContent = pageNumber;
        pageButton.onclick = () => loadOrders(pageNumber, currentOrderFilters);
        pageNumbersContainer.appendChild(pageButton);
    }

    // Order pagination navigation
    function previousOrderPage() {
        if (currentOrderPage > 1) {
            loadOrders(currentOrderPage - 1, currentOrderFilters);
        }
    }
    
    function nextOrderPage() {
        if (currentOrderPage < Math.ceil(totalOrders / ordersPerPage)) {
            loadOrders(currentOrderPage + 1, currentOrderFilters);
        }
    }

    // Order table sorting
    function sortOrderTable(column) {
        if (orderSortColumn === column) {
            orderSortDirection = orderSortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            orderSortColumn = column;
            orderSortDirection = 'desc'; // Default to descending for dates
        }
        loadOrders(currentOrderPage, currentOrderFilters);
    }

    // Apply order filters
    function applyOrderFilters() {
        const filters = {
            search: document.getElementById('order-search').value,
            status: document.getElementById('status-filter').value,
            startDate: document.getElementById('start-date').value,
            endDate: document.getElementById('end-date').value,
            minTotal: document.getElementById('min-total').value,
            maxTotal: document.getElementById('max-total').value
        };
        loadOrders(1, filters);
    }
    
    // Reset order filters
    function resetOrderFilters() {
        document.getElementById('order-search').value = '';
        document.getElementById('status-filter').value = '';
        document.getElementById('start-date').value = '';
        document.getElementById('end-date').value = '';
        document.getElementById('min-total').value = '';
        document.getElementById('max-total').value = '';
        loadOrders(1, {});
    }

    // View order details
    function viewOrderDetails(orderId) {
        const order = orders.find(o => o.id === orderId);
        if (!order) {
            showToast('Order not found!', 'error');
            return;
        }
        
        // Set order details
        document.getElementById('order-id').textContent = order.id;
        document.getElementById('order-date').textContent = formatDate(order.created_at, true);
        
        // Set status badge
        const statusBadge = document.getElementById('order-status-badge');
        statusBadge.textContent = order.status.charAt(0).toUpperCase() + order.status.slice(1);
        statusBadge.className = `px-3 py-1 rounded-full text-xs font-semibold ${
            order.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
            order.status === 'processing' ? 'bg-blue-100 text-blue-800' :
            order.status === 'completed' ? 'bg-green-100 text-green-800' :
            'bg-red-100 text-red-800'
        }`;
        
        // Set order items
        const itemsBody = document.getElementById('order-items-body');
        itemsBody.innerHTML = '';
        
        order.items.forEach(item => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="px-4 py-3 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">${item.product_name}</div>
                            <div class="text-sm text-gray-500">ID: ${item.product_id}</div>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">₱${item.price.toFixed(2)}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${item.quantity}</td>
                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">₱${item.subtotal.toFixed(2)}</td>
            `;
            itemsBody.appendChild(tr);
        });
        
        // Set order totals
        document.getElementById('order-subtotal').textContent = `₱${order.subtotal.toFixed(2)}`;
        document.getElementById('order-shipping').textContent = `₱${order.shipping.toFixed(2)}`;
        document.getElementById('order-total').textContent = `₱${order.total.toFixed(2)}`;
        
        // Set customer details
        document.getElementById('customer-name').textContent = order.customer_name;
        document.getElementById('customer-id').textContent = `ID: ${order.user_id}`;
        document.getElementById('customer-contact').textContent = order.contact_number;
        document.getElementById('shipping-address').textContent = order.shipping_address;
        document.getElementById('order-notes').textContent = order.notes ? `Notes: ${order.notes}` : '';
        
        // Set current status in dropdown
        document.getElementById('order-status').value = order.status;
        
        // Show modal
        document.getElementById('order-modal').classList.remove('hidden');
    }

    // Update order status
    function updateOrderStatus() {
        const orderId = document.getElementById('order-id').textContent;
        const newStatus = document.getElementById('order-status').value;
        
        // Show loading state
        const updateBtn = document.querySelector('#order-modal button[onclick="updateOrderStatus()"]');
        const originalText = updateBtn.innerHTML;
        updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
        updateBtn.disabled = true;
        
        // Simulate API call (replace with actual fetch)
        setTimeout(() => {
            // Find and update the order
            const orderIndex = orders.findIndex(o => o.id == orderId);
            if (orderIndex !== -1) {
                orders[orderIndex].status = newStatus;
                orders[orderIndex].updated_at = new Date().toISOString();
                
                // Update status badge
                const statusBadge = document.getElementById('order-status-badge');
                statusBadge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                statusBadge.className = `px-3 py-1 rounded-full text-xs font-semibold ${
                    newStatus === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                    newStatus === 'processing' ? 'bg-blue-100 text-blue-800' :
                    newStatus === 'completed' ? 'bg-green-100 text-green-800' :
                    'bg-red-100 text-red-800'
                }`;
                
                showToast('Order status updated successfully', 'success');
                
                // Refresh orders table
                loadOrders(currentOrderPage, currentOrderFilters);
            } else {
                showToast('Order not found!', 'error');
            }
            
            // Restore button state
            updateBtn.innerHTML = originalText;
            updateBtn.disabled = false;
        }, 1000);
    }

    // Export orders to CSV
    function exportOrders() {
        // Get filtered orders
        let filteredOrders = [...orders];
        
        if (currentOrderFilters.search) {
            const searchTerm = currentOrderFilters.search.toLowerCase();
            filteredOrders = filteredOrders.filter(o => 
                o.id.toString().includes(searchTerm) || 
                o.customer_name.toLowerCase().includes(searchTerm) ||
                o.contact_number.includes(searchTerm)
            );
        }
        
        if (currentOrderFilters.status) {
            filteredOrders = filteredOrders.filter(o => 
                o.status === currentOrderFilters.status
            );
        }
        
        if (currentOrderFilters.startDate || currentOrderFilters.endDate) {
            const startDate = currentOrderFilters.startDate ? new Date(currentOrderFilters.startDate) : null;
            const endDate = currentOrderFilters.endDate ? new Date(currentOrderFilters.endDate) : null;
            
            filteredOrders = filteredOrders.filter(o => {
                const orderDate = new Date(o.created_at);
                return (!startDate || orderDate >= startDate) && 
                       (!endDate || orderDate <= endDate);
            });
        }
        
        if (currentOrderFilters.minTotal || currentOrderFilters.maxTotal) {
            const min = currentOrderFilters.minTotal ? parseFloat(currentOrderFilters.minTotal) : 0;
            const max = currentOrderFilters.maxTotal ? parseFloat(currentOrderFilters.maxTotal) : Number.MAX_VALUE;
            filteredOrders = filteredOrders.filter(o => 
                o.total >= min && o.total <= max
            );
        }
        
        // Sort orders
        filteredOrders.sort((a, b) => {
            let valA, valB;
            
            switch(orderSortColumn) {
                case 'id':
                    valA = a.id;
                    valB = b.id;
                    break;
                case 'user_id':
                    valA = a.customer_name.toLowerCase();
                    valB = b.customer_name.toLowerCase();
                    break;
                case 'total':
                    valA = parseFloat(a.total);
                    valB = parseFloat(b.total);
                    break;
                case 'status':
                    valA = a.status;
                    valB = b.status;
                    break;
                case 'created_at':
                    valA = new Date(a.created_at);
                    valB = new Date(b.created_at);
                    break;
                default:
                    valA = new Date(a.created_at);
                    valB = new Date(b.created_at);
            }
            
            if (valA < valB) return orderSortDirection === 'asc' ? -1 : 1;
            if (valA > valB) return orderSortDirection === 'asc' ? 1 : -1;
            return 0;
        });
        
        // Prepare CSV content
        let csvContent = "data:text/csv;charset=utf-8,";
        
        // Add headers
        csvContent += "Order ID,Customer,Subtotal,Shipping,Total,Status,Date,Shipping Address,Contact Number,Notes\n";
        
        // Add order data
        filteredOrders.forEach(order => {
            csvContent += `${order.id},"${order.customer_name}",${order.subtotal.toFixed(2)},${order.shipping.toFixed(2)},${order.total.toFixed(2)},${order.status},"${formatDate(order.created_at)}","${order.shipping_address}","${order.contact_number}","${order.notes || ''}"\n`;
        });
        
        // Create download link
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "hm_orders_export.csv");
        document.body.appendChild(link);
        
        // Trigger download
        link.click();
        
        // Clean up
        document.body.removeChild(link);
        
        showToast('Orders exported successfully', 'success');
    }

    // Initialize orders when section is shown
    document.getElementById('orders-section').addEventListener('show', function() {
        loadOrders();
    });
</script>

    <!-- Import File Input -->
    <input type="file" id="file-input" class="hidden" accept=".xlsx, .xls, .csv">

    <!-- Product Modal -->
    <div id="product-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4" id="product-modal-title">Add New Product</h3>
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
                            <input type="number" step="0.01" min="0" id="product-price" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div class="mb-4">
                            <label for="product-stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                            <input type="number" min="0" id="product-stock" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div class="mb-4">
                            <label for="product-image" class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>
                            <input type="file" id="product-image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                            <p class="text-xs text-gray-500 mt-1">Accepted formats: JPG, PNG, GIF (Max 2MB)</p>
                            <div id="image-preview" class="mt-2 hidden">
                                <img id="preview-image" src="" alt="Preview" class="h-20 object-contain">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="product-description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea id="product-description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500"></textarea>
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

    <!-- Import Progress Modal -->
    <div id="import-progress-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Importing Products</h3>
                    <div class="mb-4">
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Progress</span>
                            <span id="import-progress-text">0/0</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div id="import-progress-bar" class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
                        </div>
                    </div>
                    <div id="import-results" class="hidden">
                        <div class="border-t border-gray-200 pt-3">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Import Results</h4>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div class="bg-green-50 p-2 rounded">
                                    <span class="font-medium text-green-800">Success:</span>
                                    <span id="import-success-count" class="ml-1">0</span>
                                </div>
                                <div class="bg-red-50 p-2 rounded">
                                    <span class="font-medium text-red-800">Failed:</span>
                                    <span id="import-failed-count" class="ml-1">0</span>
                                </div>
                            </div>
                            <div id="import-errors" class="mt-2 text-sm text-red-600 max-h-32 overflow-y-auto hidden">
                                <!-- Errors will be listed here -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closeModal('import-progress-modal')" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Done
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirm-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <!-- Confirmation modal content remains the same -->
    </div>

    <script>
        // Data from backend (fallback to empty arrays if not provided)
        const products = @json($products ?? []);
        const users = @json($users ?? []);
        const categories = @json($categories ?? []);

        // Current action and ID for confirmation
        let currentAction = null;
        let currentId = null;

        // Pagination variables
        let currentPage = 1;
        let itemsPerPage = 10;
        let totalItems = 0;
        let sortColumn = 'name';
        let sortDirection = 'asc';
        let currentFilters = {};

        // Initialize the dashboard
        document.addEventListener('DOMContentLoaded', function() {
            loadProducts();
            loadUsers();
            loadOrders();
            showSection('products');
            
            // Set up file input listener
            document.getElementById('file-input').addEventListener('change', handleFileUpload);
            
            // Set up image preview
            document.getElementById('product-image').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        document.getElementById('preview-image').src = event.target.result;
                        document.getElementById('image-preview').classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });
            
            // Set up search input listener
            document.getElementById('product-search').addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    applyFilters();
                }
            });
        });

        // Show section based on ID
        function showSection(sectionId) {
            document.querySelectorAll('.section-content').forEach(section => {
                section.classList.add('hidden');
            });
            document.getElementById(sectionId + '-section').classList.remove('hidden');
            document.getElementById('section-title').textContent = 
                sectionId === 'products' ? 'Products Management' : 
                sectionId === 'users' ? 'Users Management' : 
                'Orders Management';
        }

        // Load products into table with pagination
        function loadProducts(page = 1, filters = {}) {
            currentPage = page;
            currentFilters = filters;
            
            // Show loading state
            const tbody = document.getElementById('products-table-body');
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center">
                        <div class="flex justify-center">
                            <i class="fas fa-spinner fa-spin text-purple-600 text-2xl"></i>
                        </div>
                    </td>
                </tr>
            `;
            
            // Simulate API call with timeout (replace with actual fetch)
            setTimeout(() => {
                // Filter products based on current filters
                let filteredProducts = [...products];
                
                // Apply search filter
                if (filters.search) {
                    const searchTerm = filters.search.toLowerCase();
                    filteredProducts = filteredProducts.filter(p => 
                        p.name.toLowerCase().includes(searchTerm)
                    );
                }
                
                // Apply category filter
                if (filters.category) {
                    filteredProducts = filteredProducts.filter(p => 
                        p.category_id == filters.category
                    );
                }
                
                // Apply price range filter
                if (filters.minPrice || filters.maxPrice) {
                    const min = filters.minPrice ? parseFloat(filters.minPrice) : 0;
                    const max = filters.maxPrice ? parseFloat(filters.maxPrice) : Number.MAX_VALUE;
                    filteredProducts = filteredProducts.filter(p => 
                        p.price >= min && p.price <= max
                    );
                }
                
                // Apply stock filter
                if (filters.stockStatus) {
                    switch(filters.stockStatus) {
                        case 'in_stock':
                            filteredProducts = filteredProducts.filter(p => p.stock > 0);
                            break;
                        case 'out_of_stock':
                            filteredProducts = filteredProducts.filter(p => p.stock == 0);
                            break;
                        case 'low_stock':
                            filteredProducts = filteredProducts.filter(p => p.stock > 0 && p.stock < 10);
                            break;
                    }
                }
                
                // Sort products
                filteredProducts.sort((a, b) => {
                    let valA, valB;
                    
                    switch(sortColumn) {
                        case 'name':
                            valA = a.name.toLowerCase();
                            valB = b.name.toLowerCase();
                            break;
                        case 'category':
                            valA = getCategoryName(a.category_id).toLowerCase();
                            valB = getCategoryName(b.category_id).toLowerCase();
                            break;
                        case 'price':
                            valA = parseFloat(a.price);
                            valB = parseFloat(b.price);
                            break;
                        case 'stock':
                            valA = parseInt(a.stock);
                            valB = parseInt(b.stock);
                            break;
                        default:
                            valA = a.name.toLowerCase();
                            valB = b.name.toLowerCase();
                    }
                    
                    if (valA < valB) return sortDirection === 'asc' ? -1 : 1;
                    if (valA > valB) return sortDirection === 'asc' ? 1 : -1;
                    return 0;
                });
                
                totalItems = filteredProducts.length;
                
                // Calculate pagination
                const startIndex = (page - 1) * itemsPerPage;
                const endIndex = Math.min(startIndex + itemsPerPage, totalItems);
                const paginatedProducts = filteredProducts.slice(startIndex, endIndex);
                
                // Update table
                tbody.innerHTML = '';
                
                if (paginatedProducts.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                No products found matching your criteria.
                            </td>
                        </tr>
                    `;
                } else {
                    paginatedProducts.forEach(product => {
                        const tr = document.createElement('tr');
                        tr.className = 'hover:bg-gray-50';
                        tr.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    ${product.image ? `
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" src="/storage/${product.image}" alt="${product.name}">
                                        </div>
                                    ` : ''}
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">${product.name}</div>
                                        ${product.description ? `<div class="text-sm text-gray-500 truncate max-w-xs">${product.description}</div>` : ''}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${getCategoryName(product.category_id)}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$${parseFloat(product.price).toFixed(2)}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="${product.stock > 0 ? (product.stock < 10 ? 'text-yellow-600' : 'text-green-600') : 'text-red-600'}">
                                    ${product.stock}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="editProduct(${product.id})" class="text-purple-600 hover:text-purple-900 mr-3">Edit</button>
                                <button onclick="deleteProduct(${product.id})" class="text-red-600 hover:text-red-900">Delete</button>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
                
                // Update pagination controls
                updatePaginationControls();
                
            }, 500); // Simulate network delay
        }

        // Helper function to get category name by ID
        function getCategoryName(categoryId) {
            const category = categories.find(c => c.id == categoryId);
            return category ? category.name : 'Uncategorized';
        }

        // Update pagination controls
        function updatePaginationControls() {
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            const startItem = ((currentPage - 1) * itemsPerPage) + 1;
            const endItem = Math.min(currentPage * itemsPerPage, totalItems);
            
            // Update pagination info
            document.getElementById('pagination-info').innerHTML = `
                Showing <span class="font-medium">${startItem}</span> to <span class="font-medium">${endItem}</span> of <span class="font-medium">${totalItems}</span> results
            `;
            
            // Update page numbers
            const pageNumbersContainer = document.getElementById('page-numbers');
            pageNumbersContainer.innerHTML = '';
            
            // Always show first page
            addPageNumber(1, currentPage === 1);
            
            // Show ellipsis if needed
            if (currentPage > 3) {
                const ellipsis = document.createElement('span');
                ellipsis.className = 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700';
                ellipsis.textContent = '...';
                pageNumbersContainer.appendChild(ellipsis);
            }
            
            // Show current page and neighbors
            const startPage = Math.max(2, currentPage - 1);
            const endPage = Math.min(totalPages - 1, currentPage + 1);
            
            for (let i = startPage; i <= endPage; i++) {
                addPageNumber(i, i === currentPage);
            }
            
            // Show ellipsis if needed
            if (currentPage < totalPages - 2) {
                const ellipsis = document.createElement('span');
                ellipsis.className = 'relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700';
                ellipsis.textContent = '...';
                pageNumbersContainer.appendChild(ellipsis);
            }
            
            // Always show last page if there are multiple pages
            if (totalPages > 1) {
                addPageNumber(totalPages, currentPage === totalPages);
            }
        }
        
        function addPageNumber(pageNumber, isActive) {
            const pageNumbersContainer = document.getElementById('page-numbers');
            const pageButton = document.createElement('button');
            pageButton.className = `relative inline-flex items-center px-4 py-2 border text-sm font-medium ${
                isActive 
                    ? 'z-10 bg-purple-50 border-purple-500 text-purple-600' 
                    : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
            }`;
            pageButton.textContent = pageNumber;
            pageButton.onclick = () => loadProducts(pageNumber, currentFilters);
            pageNumbersContainer.appendChild(pageButton);
        }

        // Pagination navigation
        function previousPage() {
            if (currentPage > 1) {
                loadProducts(currentPage - 1, currentFilters);
            }
        }
        
        function nextPage() {
            if (currentPage < Math.ceil(totalItems / itemsPerPage)) {
                loadProducts(currentPage + 1, currentFilters);
            }
        }

        // Table sorting
        function sortTable(column) {
            if (sortColumn === column) {
                sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                sortColumn = column;
                sortDirection = 'asc';
            }
            loadProducts(currentPage, currentFilters);
        }

        // Apply filters
        function applyFilters() {
            const filters = {
                search: document.getElementById('product-search').value,
                category: document.getElementById('category-filter').value,
                minPrice: document.getElementById('min-price').value,
                maxPrice: document.getElementById('max-price').value,
                stockStatus: document.getElementById('stock-filter').value
            };
            loadProducts(1, filters);
        }
        
        // Reset filters
        function resetFilters() {
            document.getElementById('product-search').value = '';
            document.getElementById('category-filter').value = '';
            document.getElementById('min-price').value = '';
            document.getElementById('max-price').value = '';
            document.getElementById('stock-filter').value = '';
            loadProducts(1, {});
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
            document.getElementById('product-image').classList.remove('border-red-500');
            document.getElementById('product-description').classList.remove('border-red-500');
            document.getElementById('image-preview').classList.add('hidden');
            
            if (productId) {
                title.textContent = 'Edit Product';
                const product = products.find(p => p.id === productId);
                if (product) {
                    document.getElementById('product-id').value = product.id;
                    document.getElementById('product-name').value = product.name;
                    document.getElementById('product-category').value = product.category_id;
                    document.getElementById('product-price').value = product.price;
                    document.getElementById('product-stock').value = product.stock;
                    document.getElementById('product-description').value = product.description || '';
                    
                    if (product.image) {
                        document.getElementById('preview-image').src = `/storage/${product.image}`;
                        document.getElementById('image-preview').classList.remove('hidden');
                    }
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
            const descriptionInput = document.getElementById('product-description');

            // Get trimmed values
            const name = nameInput.value.trim();
            const category_id = categorySelect.value;
            const price = parseFloat(priceInput.value);
            const stock = parseInt(stockInput.value);
            const image = imageInput.files[0];
            const description = descriptionInput.value.trim();

            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(el => el.remove());
            nameInput.classList.remove('border-red-500');
            categorySelect.classList.remove('border-red-500');
            priceInput.classList.remove('border-red-500');
            stockInput.classList.remove('border-red-500');
            imageInput.classList.remove('border-red-500');
            descriptionInput.classList.remove('border-red-500');

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

            if (image) {
                const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                const maxSize = 2 * 1024 * 1024; // 2MB
                
                if (!validTypes.includes(image.type)) {
                    showFieldError(imageInput, 'Only JPG, PNG, and GIF images are allowed');
                    isValid = false;
                }
                
                if (image.size > maxSize) {
                    showFieldError(imageInput, 'Image size must be less than 2MB');
                    isValid = false;
                }
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
            formData.append('description', description);
            if (image) {
                formData.append('image', image);
            }

            // Determine endpoint and method
            const url = id ? `/admin/products/${id}` : '/admin/products';
            const method = id ? 'PUT' : 'POST';
            if (id) {
                formData.append('_method', 'PUT');
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
                    loadProducts(currentPage, currentFilters); // Refresh the products table
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

        // Import functionality
        function downloadImportTemplate() {
            // Create sample data for template
            const templateData = [
                {
                    'Product': 'Sample Product 1',
                    'Category': 'Makeup',
                    'Price': '19.99',
                    'Stock': '100',
                    'Description': 'Sample description'
                },
                {
                    'Product': 'Sample Product 2',
                    'Category': 'Skincare',
                    'Price': '29.99',
                    'Stock': '50',
                    'Description': 'Another sample description'
                }
            ];
            
            // Create worksheet
            const ws = XLSX.utils.json_to_sheet(templateData);
            
            // Create workbook
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Products");
            
            // Generate file and download
            XLSX.writeFile(wb, "HM_Products_Import_Template.xlsx");
            
            showToast('Template downloaded successfully', 'success');
        }

        function handleFileUpload(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Show progress modal
            const progressModal = document.getElementById('import-progress-modal');
            document.getElementById('import-results').classList.add('hidden');
            document.getElementById('import-errors').classList.add('hidden');
            document.getElementById('import-progress-bar').style.width = '0%';
            document.getElementById('import-progress-text').textContent = '0/0';
            progressModal.classList.remove('hidden');

            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, { type: 'array' });
                    const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                    const jsonData = XLSX.utils.sheet_to_json(firstSheet);

                    // Validate and format the data
                    const productsToImport = jsonData.map(item => ({
                        name: item.Product || item.product || item['Product Name'],
                        category: item.Category || item.category,
                        price: item.Price || item.price,
                        stock: item.Stock || item.stock || item.Quantity,
                        description: item.Description || item.description || ''
                    })).filter(p => p.name && p.category && p.price && p.stock);

                    if (productsToImport.length === 0) {
                        showToast('No valid products found in the file', 'error');
                        closeModal('import-progress-modal');
                        return;
                    }

                    // Start import process
                    importProducts(productsToImport);
                } catch (error) {
                    console.error('File processing error:', error);
                    showToast('Error processing the file. Please check the format.', 'error');
                    closeModal('import-progress-modal');
                }
            };
            reader.onerror = function() {
                showToast('Error reading the file', 'error');
                closeModal('import-progress-modal');
            };
            reader.readAsArrayBuffer(file);
        }

        function importProducts(products) {
            const totalProducts = products.length;
            let processed = 0;
            let successCount = 0;
            let failedCount = 0;
            const errors = [];
            
            // Update progress bar
            function updateProgress() {
                const progress = Math.round((processed / totalProducts) * 100);
                document.getElementById('import-progress-bar').style.width = `${progress}%`;
                document.getElementById('import-progress-text').textContent = `${processed}/${totalProducts}`;
                
                if (processed === totalProducts) {
                    document.getElementById('import-results').classList.remove('hidden');
                    document.getElementById('import-success-count').textContent = successCount;
                    document.getElementById('import-failed-count').textContent = failedCount;
                    
                    if (failedCount > 0) {
                        document.getElementById('import-errors').classList.remove('hidden');
                        const errorsContainer = document.getElementById('import-errors');
                        errorsContainer.innerHTML = '';
                        
                        errors.forEach(error => {
                            const errorItem = document.createElement('div');
                            errorItem.className = 'mb-1';
                            errorItem.innerHTML = `<span class="font-medium">Row ${error.row}:</span> ${error.message}`;
                            errorsContainer.appendChild(errorItem);
                        });
                    }
                }
            }
            
            // Process products in batches to avoid overwhelming the server
            const batchSize = 5;
            let currentIndex = 0;
            
            function processNextBatch() {
                const batch = products.slice(currentIndex, currentIndex + batchSize);
                if (batch.length === 0) return;
                
                const promises = batch.map((product, index) => {
                    const rowNumber = currentIndex + index + 1; // 1-based row numbering
                    
                    return fetch('/admin/products/import', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ products: [product] })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            successCount++;
                        } else {
                            failedCount++;
                            errors.push({
                                row: rowNumber,
                                message: data.message || 'Unknown error'
                            });
                        }
                    })
                    .catch(error => {
                        failedCount++;
                        errors.push({
                            row: rowNumber,
                            message: error.message || 'Network error'
                        });
                    })
                    .finally(() => {
                        processed++;
                        updateProgress();
                    });
                });
                
                Promise.all(promises).then(() => {
                    currentIndex += batchSize;
                    if (currentIndex < products.length) {
                        setTimeout(processNextBatch, 500); // Small delay between batches
                    }
                });
            }
            
            // Start processing
            processNextBatch();
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
            } text-white flex items-center`;
            
            const icon = document.createElement('i');
            icon.className = type === 'success' ? 'fas fa-check-circle mr-2' : 'fas fa-exclamation-circle mr-2';
            toast.appendChild(icon);
            
            const text = document.createElement('span');
            text.textContent = message;
            toast.appendChild(text);
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.add('opacity-0', 'transition-opacity', 'duration-300');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Other sections (Users, Orders) remain the same as in the original code
        // ...
    </script>
</body>
</html>