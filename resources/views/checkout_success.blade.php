<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #ffe4e6;
        }
        .confirmation-card {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            margin: 50px auto;
        }
        .confirmation-icon i {
            font-size: 4rem;
            color: #ff69b4;
            margin-bottom: 15px;
        }
        h2 {
            color: #ff69b4;
        }
        .order-details p strong {
            color: #ff69b4;
        }
        .btn-shop {
            background-color: #ff69b4;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 16px;
            text-decoration: none;
        }
        .btn-orders {
            background-color: #6a5acd;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 16px;
            text-decoration: none;
        }
        .btn-shop:hover {
            background-color: #ff1493;
            color: #fff;
        }
        .btn-orders:hover {
            background-color: #483d8b;
            color: #fff;
        }
        .badge {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <header>
        <!-- Add a luxurious logo or brand banner here -->
    </header>
    <div class="container py-5">
        <div class="confirmation-card">
            <div class="confirmation-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2 class="mb-3">Thank You for Your Order!</h2>
            <p class="mb-4">Your order has been placed successfully.</p>
            @isset($order)
                <div class="order-details">
                    <h5 class="mb-3">Order Details</h5>
                    <p><strong>Order Number:</strong> #{{ $order->id }}</p>
                    <p><strong>Date:</strong> {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                    <p><strong>Total:</strong> ₱{{ number_format($order->total, 2) }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge 
                            @if($order->status == 'pending') bg-warning text-dark
                            @elseif($order->status == 'to ship') bg-info text-dark
                            @elseif($order->status == 'delivered') bg-success text-white
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                </div>
                <div class="mt-4">
                    <a href="{{ route('user.home') }}" class="btn btn-shop me-3">
                        <i class="fas fa-home me-2"></i>Back to Home
                    </a>
                    <a href="{{ route('orders.index') }}" class="btn btn-orders me-3">
                        <i class="fas fa-list me-2"></i>View Orders
                    </a>
                    <a href="{{ route('checkout.show', $order->id) }}" class="btn btn-shop">
                        <i class="fas fa-eye me-2"></i>View Order
                    </a>
                </div>
            @else
                <div class="alert alert-warning">
                    Order information not available.
                </div>
                <div class="mt-4">
                    <a href="{{ route('user.home') }}" class="btn btn-shop me-3">
                        <i class="fas fa-home me-2"></i>Back to Home
                    </a>
                    <a href="{{ route('orders.index') }}" class="btn btn-orders">
                        <i class="fas fa-list me-2"></i>View Orders
                    </a>
                </div>
            @endisset
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>