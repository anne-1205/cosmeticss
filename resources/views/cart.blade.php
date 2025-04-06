<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - HM Cosmetics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #FFB6C1;
            --accent-color: #FFC0CB;
            --text-color: #4A4A4A;
            --background-color: #FFF5F6;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: 'Arial', sans-serif;
        }

        .hero-section {
            background-color: var(--primary-color);
            padding: 2rem 0;
            text-align: center;
            margin-bottom: 2rem;
        }

        .btn-shop {
            background-color: var(--accent-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-shop:hover {
            background-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .cart-item {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
            transition: transform 0.2s;
        }

        .cart-item:hover {
            transform: translateY(-5px);
        }

        .cart-item-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .card-title {
            color: var(--text-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .card-text {
            color: black; /* Changed to black */
            font-weight: 500;
            font-size: 1.1rem;
        }

        .input-group {
            border-radius: 25px;
            overflow: hidden;
        }

        .input-group .btn {
            background-color: var(--accent-color);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
        }

        .input-group .form-control {
            border: 1px solid var(--accent-color);
            background-color: white;
        }

        .order-summary {
            background-color: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .order-summary h5 {
            color: var(--text-color);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        #shipping, #subtotal, #total {
            color: black;
            font-weight: 600;
        }

        .btn-checkout {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 12px 25px;
            font-weight: 600;
            width: 100%;
            margin-top: 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-checkout:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .btn-remove {
            color: #FF6B6B;
            transition: all 0.2s;
        }

        .btn-remove:hover {
            color: #FF4444;
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <header class="hero-section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="text-white">HM Cosmetics</h1>
                <div>
                    <a href="{{ route('user.home') }}" class="btn btn-shop me-2">
                        <i class="fas fa-home me-2"></i>Home
                    </a>
                    <a href="#" class="btn btn-shop position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"></span>
                    </a>
                </div>
            </div>
        </div>
    </header>
    
    <!DOCTYPE html>
<html lang="en">
<head>
    <!-- Previous head content remains the same -->
</head>
<body>
    <!-- Previous header content remains the same -->
    
    <div class="container py-5">
        <h2 class="mb-4 text-center">Your Shopping Cart</h2>
        <div class="row">
            <div class="col-md-8">
                @forelse ($cartItems as $item)
                    <div class="card cart-item">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="cart-item-image" alt="{{ $item->product->name }}">
                                </div>
                                <div class="col-md-4">
                                    <h5 class="card-title">{{ $item->product->name }}</h5>
                                    <p class="card-text">₱{{ number_format($item->product->price, 2) }}</p>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <button class="btn" onclick="updateQuantity('{{ $item->id }}', -1)">-</button>
                                        <input type="text" class="form-control text-center" data-cart-id="{{ $item->id }}" value="{{ $item->quantity }}" readonly>
                                        <button class="btn" onclick="updateQuantity('{{ $item->id }}', 1)">+</button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <p class="text-end mb-0 item-subtotal card-text" data-cart-id="{{ $item->id }}">₱{{ number_format($item->product->price * $item->quantity, 2) }}</p>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-link btn-remove" onclick="removeItem('{{ $item->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart fa-3x mb-3 text-muted"></i>
                        <h3 class="text-muted">Your cart is empty</h3>
                        <a href="{{ route('user.home') }}" class="btn btn-shop mt-3">Continue Shopping</a>
                    </div>
                @endforelse
            </div>
            <div class="col-md-4">
                <div class="order-summary">
                    <h5 class="text-center">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal:</span>
                        <span id="subtotal">₱{{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping:</span>
                        <span id="shipping">₱5.00</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total:</strong>
                        <strong id="total">₱{{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity) + 5, 2) }}</strong>
                    </div>
                    @if($cartItems->isNotEmpty())
                        <a href="{{ route('checkout.index') }}" class="btn btn-checkout">
                            <i class="fas fa-lock me-2"></i>PROCEED TO CHECKOUT
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

   
</body>
</html>

    <script>
        function updateQuantity(cartId, change) {
            const quantityInput = document.querySelector(`input[data-cart-id="${cartId}"]`);
            let currentQuantity = parseInt(quantityInput.value);

            // Calculate the new quantity
            const newQuantity = Math.max(1, currentQuantity + change);

            // Update the quantity in the backend
            fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    cart_id: cartId,
                    quantity: newQuantity,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the quantity input field
                    quantityInput.value = newQuantity;

                    // Update the subtotal for the item
                    const subtotalElement = document.querySelector(`p[data-cart-id="${cartId}"]`);
                    subtotalElement.textContent = `$${data.subtotal.toFixed(2)}`;

                    // Update the overall subtotal and total
                    updateCartSummary();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function updateCartSummary() {
            const cartItems = document.querySelectorAll('.cart-item');
            let subtotal = 0;

            cartItems.forEach(item => {
                const itemSubtotal = parseFloat(item.querySelector('.item-subtotal').textContent.replace('$', ''));
                subtotal += itemSubtotal;
            });

            document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('total').textContent = `$${(subtotal + 5).toFixed(2)}`; // Add shipping cost
        }

        function removeItem(productId) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart = cart.filter(item => item.id !== productId);
            localStorage.setItem('cart', JSON.stringify(cart));
            displayCart();
        }

        function checkout() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart.length === 0) {
                alert('Your cart is empty. Please add items before checkout.');
                return;
            }
            alert('Proceeding to checkout...');
        }

        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartCount = cart.reduce((total, item) => total + item.quantity, 0);
            document.getElementById('cart-count').textContent = cartCount;
        }

        // Initialize cart count on page load
        document.addEventListener('DOMContentLoaded', () => {
            updateCartCount();
        });
    </script>
</body>
</html>