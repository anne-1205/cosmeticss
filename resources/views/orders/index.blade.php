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
            background-color: #ffe6f2; /* Soft pink background */
            color: #4a004e; /* Deep purple text for elegance */
        }
        .orders-container {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 6px 15px rgba(255, 105, 180, 0.3); /* Pink-themed shadow */
            max-width: 1000px;
            margin: 30px auto;
        }
        h2 {
            font-family: 'Georgia', serif;
            color: #d63384; /* Vibrant pink for headers */
            font-weight: bold;
        }
        .order-card {
            background-color: #ffe6f2; /* Lighter pink for card backgrounds */
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .badge {
            font-size: 0.85em;
            padding: 5px 10px;
            border-radius: 20px;
        }
        .btn-view {
            background-color: #ff69b4; /* Hot pink button */
            color: #fff;
            font-weight: bold;
            border-radius: 30px;
            padding: 10px 20px;
            transition: all 0.3s ease-in-out;
        }
        .btn-view:hover {
            background-color: #d63384; /* Slightly darker pink for hover effect */
            color: #fff;
        }
        .fa-box-open, .fa-shopping-bag, .fa-receipt {
            color: #d63384; /* Icon color matching the theme */
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="orders-container">
            <h2 class="text-center mb-4">Your Luxury Cosmetics Orders</h2>
            @if($orders && count($orders) > 0)
                @foreach($orders as $order)
                <div class="order-card">
                    <div class="row order-header">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Order #{{ $order->id }}</strong></p>
                            <p class="text-muted mb-0">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="mb-1"><strong>Total: ₱{{ number_format($order->total, 2) }}</strong></p>
                            <p class="mb-0">
                                Status: 
                                <span class="badge 
                                    @if($order->status == 'pending') bg-warning text-dark
                                    @elseif($order->status == 'processing') bg-info text-dark
                                    @elseif($order->status == 'completed') bg-success text-white
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            @foreach($order->items as $item)
                            <div class="d-flex mb-3">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                         alt="{{ $item->product_name }}" 
                                         class="img-thumbnail me-3" 
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                    <img src="https://via.placeholder.com/80" 
                                         alt="No image available" 
                                         class="img-thumbnail me-3" 
                                         style="width: 80px; height: 80px;">
                                @endif
                                <div>
                                    <h6 class="mb-1">{{ $item->product_name }}</h6>
                                    <p class="text-muted mb-1">Quantity: {{ $item->quantity }}</p>
                                    <p class="mb-0">₱{{ number_format($item->price * $item->quantity, 2) }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-view">
                                <i class="fas fa-receipt me-2"></i>View Details
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-4x mb-4"></i>
                    <h4>No orders found</h4>
                    <p class="text-muted">You haven't placed any orders yet.</p>
                    <a href="{{ route('home') }}" class="btn btn-view">
                        <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>