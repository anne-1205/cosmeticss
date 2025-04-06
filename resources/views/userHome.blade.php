<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HM Cosmetics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&family=Italiana&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #ff69b4;
            --secondary-color: #ffc0cb;
            --accent-color: #fff0f5;
            --heading-font: 'Playfair Display', serif;
            --subtitle-font: 'Cormorant Garamond', serif;
            --logo-font: 'Italiana', serif;
        }

        body {
            font-family: var(--subtitle-font);
            background-color: var(--accent-color);
        }

        .hero-section {
            background: url('{{ asset("images/cover.jpg") }}') center/cover no-repeat;
            height: 100vh; /* Full viewport height */
            width: 100%;
            display: flex;
            align-items: flex-start; /* Align content to the top */
            justify-content: flex-start; /* Align content to the left */
            padding: 50px; /* Add padding for spacing */
            position: relative;
        }

        .hero-content {
            color: #fff; /* White text for contrast */
            text-align: left;
            max-width: 400px;
        }

        .hero-title {
            font-family: var(--logo-font);
            font-size: 6rem;
            font-weight: 400;
            margin-bottom: 15px;
            color: #FF1493; /* Deeper pink color */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); /* Add subtle shadow for better visibility */
            letter-spacing: 3px;
            white-space: nowrap; /* Prevents text from wrapping to the next line */
        }

        .hero-subtitle {
            font-family: var(--subtitle-font);
            font-size: 2rem;
            font-weight: 400;
            font-style: italic;
            margin-bottom: 30px;
            color: #fff; /* White for contrast */
            letter-spacing: 1px;
        }

        .btn-shop {
            background-color: #ff69b4; /* Primary color */
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 25px;
            font-size: 1.2rem;
            font-weight: 500;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .btn-shop:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 105, 180, 0.3);
        }

        .featured-products {
            padding: 50px 0;
            background-color: white;
        }

        .product-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image {
            height: 250px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }

        .category-section {
            padding: 50px 0;
        }

        .category-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px; /* Add spacing below the image */
            transition: transform 0.3s ease;
        }

        .category-card {
            text-align: center;
            padding: 25px;
            background-color: var(--secondary-color); /* Changed to pink */
            border-radius: 10px;
            margin: 15px;
            transition: box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center content horizontally */
            justify-content: center; /* Center content vertically */
        }

        .category-card:hover {
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .category-card h4 {
            font-size: 1.5rem;
            margin: 15px 0 5px;
        }

        .category-card p {
            font-family: var(--subtitle-font);
            font-style: italic;
            font-size: 1.1rem;
        }

        /* Add these new styles */
        .header {
            background-color: var(--accent-color);
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-family: var(--logo-font);
            font-size: 2.8rem;
            color: #FF1493;
            margin: 0;
            letter-spacing: 2px;
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            align-items: center;
        }

        .btn-login {
            background-color: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 8px 24px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-login:hover {
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
        }

        .btn-register {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 26px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-register:hover {
            background-color: #ff4fa7;
            transform: translateY(-2px);
        }

        h2, h3, h4, h5 {
            font-family: var(--heading-font);
            letter-spacing: 1px;
        }

        .cart-icon {
            position: relative;
            margin-right: 20px;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            padding: 0.25em 0.6em;
            font-size: 0.75rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="m-0">HM Cosmetics</h1>
                </div>
                <div class="col-md-6">
    <div class="auth-buttons d-flex align-items-center">
    <a href="{{ route('cart.index') }}" class="btn btn-shop position-relative">
    <i class="fas fa-shopping-cart"></i>
    <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"></span>
</a>
        <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('images/default-avatar.png') }}" 
             alt="Profile Photo" 
             class="rounded-circle me-3" 
             style="width: 50px; height: 50px; object-fit: cover; border: 2px solid var(--primary-color);">
        <a href="{{ route('profile.edit') }}" class="btn btn-login">Manage Profile</a>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-register">Log Out</button>
        </form>
    </div>
</div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">HM Cosmetics</h1>
            <p class="hero-subtitle">Glow like never before!</p>
            <button class="btn btn-shop">Shop Now</button>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-products">
        <div class="container">
            <h2 class="text-center mb-5">Shop by Category</h2>
            @foreach ($categories as $category)
                <h3 class="text-center mt-4">{{ ucfirst($category->name) }}</h3>
                <div class="row">
                    @foreach ($products->where('category', $category->name) as $product)
                        <div class="col-md-3">
                            <div class="card product-card">
                                <img src="{{ asset('storage/' . $product->image) }}" class="product-image" alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">${{ number_format($product->price, 2) }}</p>
                                    <div class="d-flex align-items-center mb-3">
                                        <button class="btn btn-secondary me-2" onclick="updateQuantity('quantity-{{ $product->id }}', -1)">-</button>
                                        <input type="number" id="quantity-{{ $product->id }}" class="form-control text-center" value="1" min="1" style="width: 60px;">
                                        <button class="btn btn-secondary ms-2" onclick="updateQuantity('quantity-{{ $product->id }}', 1)">+</button>
                                    </div>
                                    <button class="btn btn-shop add-to-cart" 
                                            data-product-id="{{ $product->id }}"
                                            onclick="addToCart(this)">
                                        <i class="fas fa-cart-plus me-2"></i>Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </section>

    <!-- Categories -->
    <section class="category-section">
        <div class="container">
            <h2 class="text-center mb-5">Shop by Category</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="category-card">
                        <img src="{{ asset('images/lips.jpg') }}" class="category-image mb-3" alt="Lips">
                        <h4>Lips</h4>
                        <p>Lipsticks, Glosses & More</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="category-card">
                        <img src="{{ asset('images/face.jpg') }}" class="category-image mb-3" alt="Face">
                        <h4>Face</h4>
                        <p>Foundation, Blush & Concealer</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="category-card">
                        <img src="{{ asset('images/eyes.jpg') }}" class="category-image mb-3" alt="Eyes">
                        <h4>Eyes</h4>
                        <p>Mascara, Eyeliner & Shadow</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="category-card">
                        <img src="{{ asset('images/skincare.jpg') }}" class="category-image mb-3" alt="Skincare">
                        <h4>Skincare</h4>
                        <p>Moisturizer, Serum & More</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Special Offers -->
    <section class="special-offers py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="offer-card bg-white p-4 rounded">
                        <h3>New Arrivals</h3>
                        <p>Get 20% off on all new products</p>
                        <button class="btn btn-shop">Shop Now</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="offer-card bg-white p-4 rounded">
                        <h3>Limited Time Offer</h3>
                        <p>Buy 2 Get 1 Free on selected items</p>
                        <button class="btn btn-shop">Shop Now</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-kit-code.js" crossorigin="anonymous"></script>
    <script>
function addToCart(button) {
    const productId = button.getAttribute('data-product-id');
    const quantityInput = document.getElementById(`quantity-${productId}`);
    const quantity = parseInt(quantityInput?.value || 1);

    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity,
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            updateCartCount();
        } else {
            alert('Failed to add product to cart.');
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateCartCount() {
    fetch('/cart/count', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('cart-count').textContent = data.count;
    });
}

// Initialize cart count on page load
document.addEventListener('DOMContentLoaded', updateCartCount);
</script>
</body>
</html>

<?php
// filepath: c:\xampp2\htdocs\HMcosmetics\HMcosmetics\routes\web.php

Route::get('/user/home', function () {
    return view('userHome'); // Ensure userHome.blade.php exists in the views folder
})->name('user.home')->middleware('auth');