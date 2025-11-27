<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Verifikasi UUID untuk Orders, OrderItems, dan CartItems ===\n\n";

// Cek Orders
echo "Orders:\n";
$orders = App\Models\Order::take(2)->get();
foreach ($orders as $order) {
    echo "  - ID: {$order->id} | User: {$order->user->name} | Total: Rp " . number_format($order->total_amount, 0, ',', '.') . " | Length: " . strlen($order->id) . "\n";
    
    // Tampilkan order items
    if ($order->items->count() > 0) {
        echo "    Order Items:\n";
        foreach ($order->items->take(2) as $item) {
            echo "      * Item ID: {$item->id} | Product: {$item->product_name} | Qty: {$item->quantity}\n";
        }
    }
}

echo "\nCart Items:\n";
$cartItems = App\Models\CartItem::take(3)->get();
foreach ($cartItems as $cart) {
    echo "  - ID: {$cart->id} | User: {$cart->user->name} | Product: {$cart->product->name} | Qty: {$cart->quantity} | Length: " . strlen($cart->id) . "\n";
}

echo "\n=== Verifikasi Relasi ===\n";
$order = App\Models\Order::first();
if ($order) {
    echo "Order ID: {$order->id}\n";
    echo "  - User: {$order->user->name}\n";
    echo "  - Items Count: {$order->items->count()}\n";
    if ($order->items->count() > 0) {
        $firstItem = $order->items->first();
        echo "  - First Item ID: {$firstItem->id}\n";
        echo "  - Product: " . ($firstItem->product ? $firstItem->product->name : 'N/A') . "\n";
    }
}

echo "\n=== UUID Verification Complete ===\n";
