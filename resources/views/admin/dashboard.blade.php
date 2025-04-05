<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-pink-100 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-pink-800">Total Products</h3>
                    <p class="text-3xl font-bold text-pink-600">{{ $productsCount ?? 0 }}</p>
                </div>
                <div class="bg-purple-100 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-purple-800">Total Users</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ $usersCount ?? 0 }}</p>
                </div>
                <div class="bg-blue-100 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-blue-800">Orders</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $ordersCount ?? 0 }}</p>
                </div>
                <div class="bg-green-100 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-green-800">Revenue</h3>
                    <p class="text-3xl font-bold text-green-600">${{ $revenue ?? 0 }}</p>
                </div>
            </div>

            <!-- Main Content Tabs -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4 border-b border-gray-200">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="tabs">
                            <li class="mr-2">
                                <a href="#products" class="inline-block p-4 border-b-2 border-pink-600 rounded-t-lg active text-pink-600">Products</a>
                            </li>
                            <li class="mr-2">
                                <a href="#users" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300">Users</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Products Tab -->
                    <div id="products-content" class="tab-content">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Manage Products</h3>
                            <button class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">
                                Add New Product
                            </button>
                        </div>
                        
                        <!-- Products Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($products ?? [] as $product)
                                        <tr>
                                            <td class="px-6 py-4">{{ $product->name }}</td>
                                            <td class="px-6 py-4">{{ $product->category }}</td>
                                            <td class="px-6 py-4">${{ $product->price }}</td>
                                            <td class="px-6 py-4">{{ $product->stock }}</td>
                                            <td class="px-6 py-4">
                                                <button class="text-blue-600 hover:text-blue-900">Edit</button>
                                                <button class="text-red-600 hover:text-red-900 ml-3">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
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
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Manage Users</h3>
                        </div>
                        
                        <!-- Users Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($users ?? [] as $user)
                                        <tr>
                                            <td class="px-6 py-4">{{ $user->name }}</td>
                                            <td class="px-6 py-4">{{ $user->email }}</td>
                                            <td class="px-6 py-4">{{ $user->role }}</td>
                                            <td class="px-6 py-4">
                                                <span class="px-2 py-1 text-xs rounded-full {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ ucfirst($user->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <button class="text-blue-600 hover:text-blue-900">Edit</button>
                                                <button class="text-red-600 hover:text-red-900 ml-3">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
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

    <script>
        const tabs = document.querySelectorAll('#tabs a');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = e.target.getAttribute('href').substring(1);
                
                tabs.forEach(t => {
                    t.classList.remove('border-pink-600', 'text-pink-600');
                    t.classList.add('border-transparent');
                });
                e.target.classList.add('border-pink-600', 'text-pink-600');
                
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });
                document.getElementById(`${targetId}-content`).classList.remove('hidden');
            });
        });
    </script>
</x-app-layout>
