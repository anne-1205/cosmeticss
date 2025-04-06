<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - HM Cosmetics</title>
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

        .order-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
            transition: transform 0.2s;
        }

        .order-card:hover {
            transform: translateY(-5px);
        }

        .order-item-image {
            width: 80px;
            height: 80px;
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
            color: black;
            font-weight: 500;
            font-size: 1.1rem;
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

        .status-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
        }

        .status-pending {
            background-color: #FFF3CD;
            color: #856404;
        }

        .status-processing {
            background-color: #CCE5FF;
            color: #004085;
        }

        .status-shipped {
            background-color: #D4EDDA;
            color: #155724;
        }

        .status-delivered {
            background-color: #D1ECF1;
            color: #0C5460;
        }

        .status-cancelled {
            background-color: #F8D7DA;
            color: #721C24;
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
                        <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ auth()->user()->cartItems->count() }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </header>
    
    <div class="container py-5">
        <h2 class="mb-4 text-center">Checkout</h2>
        <div class="row">
            <div class="col-md-8">
                @if(isset($order))
                    <div class="card order-card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="mb-0">Order #{{ $order->id }}</h4>
                                <span class="status-badge status-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <p class="text-muted">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                            
                            <hr>
                            
                            <h5 class="mb-3">Order Items</h5>
                            @foreach($order->items as $item)
                                <div class="card order-card mb-2">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-2">
                                                <img src="{{ asset('storage/' . $item->product->image) }}" class="order-item-image" alt="{{ $item->product->name }}">
                                            </div>
                                            <div class="col-md-4">
                                                <h5 class="card-title">{{ $item->product->name }}</h5>
                                                <p class="card-text">₱{{ number_format($item->price, 2) }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="mb-0">Quantity: {{ $item->quantity }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="text-end mb-0 card-text">₱{{ number_format($item->price * $item->quantity, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            <hr>
                            
                            <h5 class="mb-3">Shipping Information</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Shipping Address:</strong></p>
                                    <p>{{ $order->shipping_address }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Contact Number:</strong></p>
                                    <p>{{ $order->contact_number }}</p>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                
                                <div class="col-md-6">
                                    @if($order->notes)
                                        <p><strong>Notes:</strong></p>
                                        <p>{{ $order->notes }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <div class="card order-card mb-4">
                            <div class="card-body">
                                <h4 class="mb-4">Shipping Information</h4>
                                
                                <div class="mb-3">
                                    <label for="shipping_address" class="form-label">Shipping Address</label>
                                    <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3" required></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="billing_address" class="form-label">Billing Address (if different)</label>
                                    <textarea class="form-control" id="billing_address" name="billing_address" rows="3"></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="contact_number" class="form-label">Contact Number</label>
                                    <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Order Notes (optional)</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
            
            <div class="col-md-4">
                <div class="order-summary">
                    <h5 class="text-center">Order Summary</h5>
                    
                    @if(isset($order))
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal:</span>
                            <span id="subtotal">₱{{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Shipping:</span>
                            <span id="shipping">₱{{ number_format($order->shipping, 2) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total:</strong>
                            <strong id="total">₱{{ number_format($order->total, 2) }}</strong>
                        </div>
                        
                        @if($order->status == 'pending')
                            <div class="alert alert-warning">
                                <i class="fas fa-info-circle me-2"></i> Your order is being processed. We'll notify you once it's shipped.
                            </div>
                        @elseif($order->status == 'processing')
                            <div class="alert alert-info">
                                <i class="fas fa-truck me-2"></i> Your order is being prepared for shipment.
                            </div>
                        @elseif($order->status == 'shipped')
                            <div class="alert alert-primary">
                                <i class="fas fa-shipping-fast me-2"></i> Your order has been shipped!
                            </div>
                        @elseif($order->status == 'delivered')
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i> Your order has been delivered!
                            </div>
                        @endif
                    @else
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
                        
                        <button type="submit" form="checkoutForm" class="btn btn-checkout">
                            <i class="fas fa-lock me-2"></i>Place Order
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation before submission
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            const shippingAddress = document.getElementById('shipping_address').value.trim();
            const contactNumber = document.getElementById('contact_number').value.trim();
            
            if (!shippingAddress) {
                e.preventDefault();
                alert('Please enter your shipping address');
                document.getElementById('shipping_address').focus();
                return;
            }
            
            if (!contactNumber) {
                e.preventDefault();
                alert('Please enter your contact number');
                document.getElementById('contact_number').focus();
                return;
            }
            
            // You can add additional validation for contact number format if needed
            if (!/^[0-9+() -]+$/.test(contactNumber)) {
                e.preventDefault();
                alert('Please enter a valid contact number');
                document.getElementById('contact_number').focus();
                return;
            }
        });
    </script>
</body>
</html>