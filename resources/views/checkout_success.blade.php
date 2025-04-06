<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Keep the same head section as before -->
</head>
<body>
    <!-- Keep the same header section as before -->
    
    <div class="container py-5">
        <div class="confirmation-card">
            <div class="confirmation-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2 class="mb-3">Thank You for Your Order!</h2>
            <p class="mb-4">Your order has been placed successfully.</p>
            
            <div class="order-details">
                <h5 class="mb-3">Order Details</h5>
                <p><strong>Order Number:</strong> #{{ $order->id }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                <p><strong>Total:</strong> ₱{{ number_format($order->total, 2) }}</p>
                <p><strong>Status:</strong> <span class="badge bg-warning text-dark">{{ ucfirst($order->status) }}</span></p>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('user.home') }}" class="btn btn-shop me-3">
                    <i class="fas fa-home me-2"></i>Back to Home
                </a>
                <a href="{{ route('checkout.show', $order->id) }}" class="btn btn-shop">
                    <i class="fas fa-eye me-2"></i>View Order
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>