<x-app-layout>
    <x-slot name="header">
        <div class="text-center py-8 bg-gradient-to-r from-pink-50 to-purple-50">
            <h2 class="font-serif text-3xl text-gray-900 leading-tight">
                {{ __('HM Cosmetics Dashboard') }}
            </h2>
            <p class="text-sm text-gray-600 mt-2">Luxury Beauty Management</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-white to-pink-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6 border border-pink-100 transform hover:scale-105 transition-transform duration-300">
                    <h3 class="text-lg font-serif text-gray-800">Total Products</h3>
                    <p class="text-4xl font-light text-pink-600 mt-2">{{ $productsCount ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 border border-purple-100 transform hover:scale-105 transition-transform duration-300">
                    <h3 class="text-lg font-serif text-gray-800">Total Users</h3>
                    <p class="text-4xl font-light text-purple-600 mt-2">{{ $usersCount ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 border border-blue-100 transform hover:scale-105 transition-transform duration-300">
                    <h3 class="text-lg font-serif text-gray-800">Orders</h3>
                    <p class="text-4xl font-light text-blue-600 mt-2">{{ $ordersCount ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 border border-green-100 transform hover:scale-105 transition-transform duration-300">
                    <h3 class="text-lg font-serif text-gray-800">Revenue</h3>
                    <p class="text-4xl font-light text-green-600 mt-2">${{ $revenue ?? 0 }}</p>
                </div>
            </div>

            <!-- Main Content Tabs -->
            <div class="bg-white overflow-hidden shadow-xl rounded-xl border border-gray-100">
                <div class="p-8">
                    <div class="mb-8 border-b border-gray-200">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="tabs">
                            <li class="mr-2">
                                <a href="#products" class="inline-block p-4 border-b-2 border-pink-400 rounded-t-lg active text-pink-600 font-serif tracking-wide">Products</a>
                            </li>
                            <li class="mr-2">
                                <a href="#users" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 font-serif tracking-wide">Users</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Products Tab -->
                    <div id="products-content" class="tab-content">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-2xl font-serif text-gray-800">Manage Products</h3>
                            <button class="bg-gradient-to-r from-pink-500 to-pink-600 text-white px-6 py-3 rounded-lg hover:from-pink-600 hover:to-pink-700 shadow-md transform hover:scale-105 transition-all duration-300">
                                Add New Product
                            </button>
                        </div>
                        
                        <!-- Products Table -->
                        <div class="overflow-x-auto bg-white rounded-xl shadow-inner border border-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($products ?? [] as $product)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-6 py-4 font-serif">{{ $product->name }}</td>
                                            <td class="px-6 py-4">{{ $product->category }}</td>
                                            <td class="px-6 py-4 text-pink-600 font-semibold">${{ $product->price }}</td>
                                            <td class="px-6 py-4">{{ $product->stock }}</td>
                                            <td class="px-6 py-4">
                                                <button class="text-blue-600 hover:text-blue-900 font-medium transition-colors duration-200">Edit</button>
                                                <button class="text-red-600 hover:text-red-900 ml-4 font-medium transition-colors duration-200">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 font-serif italic">
                                                No products found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Users Tab -->
                    <div id="users-content" class="tab-content hidden">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-2xl font-serif text-gray-800">Manage Users</h3>
                            <button class="bg-gradient-to-r from-purple-500 to-purple-600 text-white px-6 py-3 rounded-lg hover:from-purple-600 hover:to-purple-700 shadow-md transform hover:scale-105 transition-all duration-300">
                                Add New User
                            </button>
                        </div>
                        
                        <!-- Users Table -->
                        <div class="overflow-x-auto bg-white rounded-xl shadow-inner border border-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($users ?? [] as $user)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-6 py-4 font-serif">{{ $user->name }}</td>
                                            <td class="px-6 py-4">{{ $user->email }}</td>
                                            <td class="px-6 py-4">
                                                <span class="px-3 py-1 text-sm rounded-full bg-purple-50 text-purple-700">
                                                {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-3 py-1 text-sm rounded-full {{ $user->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                                    {{ ucfirst($user->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <button class="text-blue-600 hover:text-blue-900 font-medium transition-colors duration-200">Edit</button>
                                                <button class="text-red-600 hover:text-red-900 ml-4 font-medium transition-colors duration-200">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 font-serif italic">
                                                No users found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add custom fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        .font-serif {
            font-family: 'Playfair Display', serif;
        }
        
        /* Custom Scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f7f7f7;
            border-radius: 4px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #e2e2e2;
            border-radius: 4px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #d1d1d1;
        }

        /* Subtle animations */
        .tab-content {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Card hover effects */
        .rounded-lg {
            transition: all 0.3s ease;
        }

        .rounded-lg:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }
    </style>

    <script>
        const tabs = document.querySelectorAll('#tabs a');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = e.target.getAttribute('href').substring(1);
                
                tabs.forEach(t => {
                    t.classList.remove('border-pink-400', 'text-pink-600');
                    t.classList.add('border-transparent');
                });
                e.target.classList.add('border-pink-400', 'text-pink-600');
                
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });
                document.getElementById(`${targetId}-content`).classList.remove('hidden');
            });
        });

        // Add smooth scrolling for table
        document.querySelectorAll('.overflow-x-auto').forEach(table => {
            let isDown = false;
            let startX;
            let scrollLeft;

            table.addEventListener('mousedown', (e) => {
                isDown = true;
                table.classList.add('cursor-grabbing');
                startX = e.pageX - table.offsetLeft;
                scrollLeft = table.scrollLeft;
            });

            table.addEventListener('mouseleave', () => {
                isDown = false;
                table.classList.remove('cursor-grabbing');
            });

            table.addEventListener('mouseup', () => {
                isDown = false;
                table.classList.remove('cursor-grabbing');
            });

            table.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - table.offsetLeft;
                const walk = (x - startX) * 2;
                table.scrollLeft = scrollLeft - walk;
            });
        });
    </script>
</x-app-layout>
