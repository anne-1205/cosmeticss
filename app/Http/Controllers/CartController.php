<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // Update quantity if the product is already in the cart
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Add new product to the cart
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart_count' => $this->getCartCount()
        ]);
    }

    public function viewCart()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        // Calculate cart totals
        $subtotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        $shipping = 5.00; // Fixed shipping cost
        $total = $subtotal + $shipping;

        return view('cart', compact('cartItems', 'subtotal', 'shipping', 'total'));
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::with('product')->find($request->cart_id);

        if ($cartItem && $cartItem->user_id == auth()->id()) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            // Recalculate totals
            $subtotal = $cartItem->product->price * $cartItem->quantity;
            $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
            $grandTotal = $cartItems->sum(function($item) {
                return $item->product->price * $item->quantity;
            }) + 5.00; // Adding shipping

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully!',
                'item_subtotal' => number_format($subtotal, 2),
                'grand_total' => number_format($grandTotal, 2),
                'subtotal' => number_format($grandTotal - 5.00, 2),
                'cart_count' => $this->getCartCount()
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Cart item not found!'], 404);
    }

    public function removeItem(Request $request, $id)
    {
        $cartItem = Cart::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if ($cartItem) {
            $cartItem->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart_count' => $this->getCartCount()
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found'], 404);
    }

    protected function getCartCount()
    {
        return Cart::where('user_id', auth()->id())->sum('quantity');
    }
}