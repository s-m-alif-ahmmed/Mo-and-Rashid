<?php

namespace App\Http\Controllers\Web\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeProductWishlistController extends Controller
{
//    User
    public function addOrRemove(Request $request, $productID)
    {
        $auth = auth()->user();

        // Check if product exists
        $product = Product::find($productID);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        // Get color and size from the request
        $colorId = $request->input('color_id');
        $sizeId = $request->input('size_id');

        // Check the wishlist
        $wishlist = Wishlist::where('product_id', $productID)->where('user_id', $auth->id)->first();
        if (!$wishlist) {
            // Add to wishlist
            $wishlist = Wishlist::create([
                'product_id' => $productID,
                'user_id' => $auth->id,
                'product_color_id' => $colorId,
                'product_size_id' => $sizeId,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist',
                'wishlistItem' => [
                    'wishlistId' => $wishlist->id,
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->selling_price,
                    'color' => $wishlist->color,
                    'size' => $wishlist->size,
                    'image' => $product->images->first()->image // Assuming you have images related to the product
                ]
            ], 200);

        } else {
            // Remove from wishlist
            $wishlist->delete();
            return response()->json([
                'success' => false,
                'message' => 'Product removed from wishlist',
                'wishlistItem' => [
                    'wishlistId' => $wishlist->id,
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->selling_price,
                    'color' => $wishlist->color,
                    'size' => $wishlist->size,
                    'image' => $product->images->first()->image // Assuming you have images related to the product
                ]
            ], 200);
        }
    }

    public function removeWishlistItem($id)
    {
        try {
            // Find the wishlist item
            $wishlistItem = Wishlist::findOrFail($id);

            if ($wishlistItem) {
                $wishlistItem->delete(); // Remove the item from the wishlist
                return response()->json([
                    'success' => true,
                    'message' => 'Item removed from wishlist successfully!',
                    'action' => 'remove' // Indicate that the action was a removal
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Item not found.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Could not remove item from wishlist.'], 500);
        }
    }

    public function moveToCart(Request $request, $wishlistItemId)
    {
        // Get the current authenticated user
        $auth = auth()->user();

        // Find the wishlist item
        $wishlistItem = Wishlist::findOrFail($wishlistItemId);
        $product = Product::findOrFail($wishlistItem->product_id);

        // Get color and size from the wishlist item
        $colorId = $wishlistItem->product_color_id ?? null;
        $sizeId = $wishlistItem->product_size_id ?? null;

        // Check if the product is already in the cart
        $cart = Cart::where('product_id', $wishlistItem->product_id)
            ->where('user_id', $auth->id)
            ->where('color_id', $colorId)
            ->where('size_id', $sizeId)
            ->first();

        if (!$cart) {
            // Create a new cart item if not already in the cart
            $cart = Cart::create([
                'product_id' => $wishlistItem->product_id,
                'user_id' => $auth->id,
                'color_id' => $colorId,
                'size_id' => $sizeId,
                'discount_price' => $wishlistItem->product->discount_price,
                'selling_price' => $wishlistItem->product->selling_price,
                'quantity' => 1, // Default quantity is 1
            ]);

            // Remove the wishlist item after moving it to the cart
            $wishlistItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product moved to cart successfully',
                'cartItem' => [
                    'cartId' => $cart->id,
                    'id' => $cart->product->id,
                    'name' => $cart->product->name,
                    'quantity' => $cart->quantity,
                    'price' => $cart->selling_price,
                    'color' => $cart->color ? $cart->color->color : null, // Handle nullable color
                    'size' => $cart->size ? $cart->size->size : null, // Handle nullable size
                    'image' => asset($cart->product->images->first()->image), // Ensure the correct image URL
                ],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product already added to cart!',
            ]);
        }
    }

    public function moveAllToCart(Request $request)
    {
        // Get the current authenticated user
        $auth = auth()->user();

        // Retrieve all wishlist items for the authenticated user
        $wishlists = Wishlist::where('user_id', $auth->id)
            ->with(['product', 'color', 'size'])
            ->get();

        // Initialize an array to store the response data
        $movedItems = [];
        $failedItems = [];

        foreach ($wishlists as $wishlistItem) {
            // Get the color and size from the wishlist item
            $colorId = $wishlistItem->product_color_id ?? null;
            $sizeId = $wishlistItem->product_size_id ?? null;

            // Check if the product is already in the cart
            $cart = Cart::where('product_id', $wishlistItem->product_id)
                ->where('user_id', $auth->id)
                ->where('color_id', $colorId)
                ->where('size_id', $sizeId)
                ->first();

            if (!$cart) {
                // Create a new cart item if not already in the cart
                $cart = Cart::create([
                    'product_id' => $wishlistItem->product_id,
                    'user_id' => $auth->id,
                    'color_id' => $colorId,
                    'size_id' => $sizeId,
                    'discount_price' => $wishlistItem->product->discount_price,
                    'selling_price' => $wishlistItem->product->selling_price,
                    'quantity' => 1, // Default quantity is 1
                ]);

                // Add the moved item to the response array
                $movedItems[] = [
                    'wishlistId' => $wishlistItem->id,
                    'cartId' => $cart->id,
                    'id' => $cart->product->id,
                    'name' => $cart->product->name,
                    'quantity' => $cart->quantity,
                    'price' => $cart->selling_price,
                    'color' => $cart->color ? $cart->color->color : null,
                    'size' => $cart->size ? $cart->size->size : null,
                    'image' => asset($cart->product->images->first()->image),
                ];

                // Remove the item from the wishlist after moving it to the cart
                $wishlistItem->delete();
            } else {
                // Add the failed item to the response if it's already in the cart
                $failedItems[] = $wishlistItem->product->name;
            }
        }

        // Fetch the updated wishlist for the user
        $updatedWishlist = Wishlist::where('user_id', $auth->id)
            ->with(['product', 'color', 'size'])
            ->get();

        // Check if any items were moved or failed
        if (count($movedItems) > 0) {
            $response = [
                'success' => true,
                'message' => 'Selected products moved to cart successfully.',
                'movedItems' => $movedItems,
                'failedItems' => $failedItems, // Products that were already in the cart
                'updatedWishlist' => $updatedWishlist // Include the updated wishlist data
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No items were moved. All items are already in your cart.',
                'movedItems' => $movedItems,
                'failedItems' => $failedItems,
                'updatedWishlist' => $updatedWishlist // Return the current (empty) wishlist
            ];
        }

        return response()->json($response);
    }

//    Session Guest
    public function addOrRemoveGuest(Request $request, $productID)
    {
        // Validate the incoming request
        $request->validate([
            'color_id' => 'nullable|exists:colors,id',
            'size_id' => 'nullable|exists:sizes,id',
        ]);

        // Unique session key to store the wishlist
        $wishlistSessionKey = 'wishlist_' . session()->getId();
        $wishlistItems = Session::get($wishlistSessionKey, []);

        // Get the product details
        $item = Product::with(['images'])->find($productID);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Product not found.']);
        }

        $existingItemKey = "{$productID}_{$request->color_id}_{$request->size_id}";

        if (isset($wishlistItems[$existingItemKey])) {
            // Remove the item from the wishlist
            unset($wishlistItems[$existingItemKey]);
            Session::put($wishlistSessionKey, $wishlistItems);
            return response()->json([
                'success' => true,
                'action' => 'remove',
                'message' => 'Item removed from wishlist successfully!',
                'wishlistItems' => $wishlistItems,
            ]);
        } else {
            // Add the item to the wishlist
            $wishlistItems[$existingItemKey] = [
                'wishlistId' => $existingItemKey,
                'product' => [
                    'id' => $item->id,
                    'name' => $item->name,
                ],
                'selling_price' => $item->selling_price,
                'discount_price' => $item->discount_price,
                'color' => $request->color_id ? \App\Models\Color::find($request->color_id) : null,
                'size' => $request->size_id ? \App\Models\Size::find($request->size_id) : null,
                'images' => $item->images->pluck('image')->toArray(),
            ];

            // Save updated wishlist
            Session::put($wishlistSessionKey, $wishlistItems);

            return response()->json([
                'success' => true,
                'action' => 'add',
                'message' => 'Item added to wishlist successfully!',
                'wishlistItem' => $wishlistItems[$existingItemKey],
            ]);
        }
    }

    public function removeWishlistItemGuest(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'wishlist_id' => 'required|string',
            ]);

            // Unique session key to store the wishlist
            $wishlistSessionKey = 'wishlist_' . session()->getId();
            $wishlistItems = Session::get($wishlistSessionKey, []);

            // Check if the item exists in the wishlist
            if (isset($wishlistItems[$request->wishlist_id])) {
                unset($wishlistItems[$request->wishlist_id]); // Remove the item
                Session::put($wishlistSessionKey, $wishlistItems);

                return response()->json(['success' => true, 'message' => 'Item removed from wishlist successfully!']);
            }

            return response()->json(['success' => false, 'message' => 'Item not found in wishlist.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Could not remove item from wishlist.'], 500);
        }
    }

    public function moveToCartGuest(Request $request)
    {
        // Retrieve the wishlistItemId from the AJAX request
        $wishlistItemId = $request->input('wishlistItemId'); // Ensure the correct parameter name

        // Unique session key to store the cart
        $cartSessionKey = 'cart_' . session()->getId();
        $cartItems = Session::get($cartSessionKey, []);

        // Unique session key to store the wishlist
        $wishlistSessionKey = 'wishlist_' . session()->getId();
        $wishlistItems = Session::get($wishlistSessionKey, []);

        // Check if the wishlist item exists in the session wishlist
        if (!isset($wishlistItems[$wishlistItemId])) {
            return response()->json(['success' => false, 'message' => 'Product not found in wishlist.']);
        }

        // Get the wishlist item details
        $wishlistItem = $wishlistItems[$wishlistItemId];
        $item = Product::with(['images'])->find($wishlistItem['product']['id']); // Ensure images are loaded

        // Check if the item exists in the database
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Product not found.']);
        }

        // Ensure color and size are checked for null before accessing their properties
        $colorId = $wishlistItem['color'] ? $wishlistItem['color']['id'] : null;
        $sizeId = $wishlistItem['size'] ? $wishlistItem['size']['id'] : null;

        // Create a unique key for the wishlist item
        $existingItemKey = "{$wishlistItem['product']['id']}_{$colorId}_{$sizeId}";

        // Check if the item already exists in the cart
        if (!isset($cartItems[$existingItemKey])) {
            // Move the wishlist item to the cart
            $cartItems[$existingItemKey] = [
                'cartId' => $existingItemKey,
                'product' => [
                    'id' => $item->id,
                    'name' => $item->name,
                ],
                'selling_price' => $item->selling_price,
                'discount_price' => $item->discount_price,
                'quantity' => 1,
                'color' => $wishlistItem['color'] ?? null,  // Safe check for null
                'size' => $wishlistItem['size'] ?? null,    // Safe check for null
                'images' => $item->images->pluck('image')->toArray(),
            ];

            // Remove the wishlist item from the session
            unset($wishlistItems[$wishlistItemId]);

            // Save the updated wishlist and cart to session
            Session::put($cartSessionKey, $cartItems);
            Session::put($wishlistSessionKey, $wishlistItems); // Ensure the wishlist is updated

            return response()->json([
                'success' => true,
                'message' => 'Product moved to cart successfully!',
                'cartItem' => $cartItems[$existingItemKey],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product already in cart!',
            ]);
        }
    }

//    public function moveAllToCartGuest(Request $request)
//    {
//        // Retrieve all wishlist item IDs from the request
//        $wishlistItemIds = $request->input('wishlistItemIds');
//
//        // Unique session key to store the cart
//        $cartSessionKey = 'cart_' . session()->getId();
//        $cartItems = Session::get($cartSessionKey, []);
//
//        // Unique session key to store the wishlist
//        $wishlistSessionKey = 'wishlist_' . session()->getId();
//        $wishlistItems = Session::get($wishlistSessionKey, []);
//
//        $movedItems = [];
//        $existingCartItemKeys = [];
//
//        // Prepare an array of existing cart item keys to check if an item is already in the cart
//        foreach ($cartItems as $cartItem) {
//            $existingCartItemKeys[] = $cartItem['cartId'];
//        }
//
//        foreach ($wishlistItemIds as $wishlistItemId) {
//            // Check if the wishlist item exists in the session wishlist
//            if (isset($wishlistItems[$wishlistItemId])) {
//                $wishlistItem = $wishlistItems[$wishlistItemId];
//
//                $item = Product::with(['images'])->find($wishlistItem['product']['id']); // Ensure images are loaded
//                if ($item) {
//                    // Ensure color and size are checked for null before accessing their properties
//                    $colorId = $wishlistItem['color'] ? $wishlistItem['color']['id'] : null;
//                    $sizeId = $wishlistItem['size'] ? $wishlistItem['size']['id'] : null;
//
//                    // Create a unique key for the wishlist item
//                    $existingItemKey = "{$wishlistItem['product']['id']}_{$colorId}_{$sizeId}";
//
//                    // Skip adding the item to the cart if it already exists
//                    if (!in_array($existingItemKey, $existingCartItemKeys)) {
//                        // Move the wishlist item to the cart
//                        $cartItems[$existingItemKey] = [
//                            'cartId' => $existingItemKey,
//                            'product' => [
//                                'id' => $item->id,
//                                'name' => $item->name,
//                            ],
//                            'selling_price' => $item->selling_price,
//                            'discount_price' => $item->discount_price,
//                            'quantity' => 1,
//                            'color' => $wishlistItem['color'] ?? null,  // Safe check for null
//                            'size' => $wishlistItem['size'] ?? null,    // Safe check for null
//                            'images' => $item->images->pluck('image')->toArray(),
//                        ];
//
//                        // Add the moved item to the movedItems array to send in the response
//                        $movedItems[] = $cartItems[$existingItemKey];
//                    }
//                }
//            }
//        }
//
//        // Save the updated cart to session (don't change wishlist if item is already in cart)
//        Session::put($cartSessionKey, $cartItems);
//
//        // Since we're not removing any items from the wishlist, no need to update it here
//
//        return response()->json([
//            'success' => true,
//            'message' => 'All products moved to cart successfully!',
//            'cartItems' => array_values($cartItems),  // Return the updated cart items
//        ]);
//    }

}
