<?php
// Initialize counts
$count_wishlist_items = 0;
$count_cart_items = 0;

// Only count items if user is logged in
if(isset($user_id) && $user_id != '') {
    // Count wishlist items
    $count_wishlist = $conn->prepare("SELECT COUNT(*) as count FROM `wishlist` WHERE user_id = ?");
    $count_wishlist->execute([$user_id]);
    $wishlist_result = $count_wishlist->fetch(PDO::FETCH_ASSOC);
    $count_wishlist_items = $wishlist_result['count'];

    // Count cart items
    $count_cart = $conn->prepare("SELECT COUNT(*) as count FROM `cart` WHERE user_id = ?");
    $count_cart->execute([$user_id]);
    $cart_result = $count_cart->fetch(PDO::FETCH_ASSOC);
    $count_cart_items = $cart_result['count'];
}
?> 