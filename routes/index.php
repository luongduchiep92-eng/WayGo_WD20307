<?php

$action = $_GET['action'] ?? '/';

$role = $_GET['role'] ?? 'product-list';

if($role === 'admin'){
    if ($role === 'admin') {
    match ($action) {
        'product-list', 'list', '/' => (new ProductController())->list(),
        'product-add', 'add' => (new ProductController())->add(),
        'product-edit', 'edit' => (new ProductController())->edit(),
        'product-delete', 'delete' => (new ProductController())->delete(),
        default => (new ProductController())->list(),
    };
}

}else
    match ($action) {
        '/' => (new HomeController)->index(),
        'product' => (new HomeController)->detail($_GET['id'] ?? null),
        'category' => (new HomeController)->category($_GET['id'] ?? null),
        'search' => (new HomeController)->search(),
        'cart' => (new CartController)->index(),
        'cart-add' => (new CartController)->add(),
        'cart-update' => (new CartController)->update(),
        'cart-remove' => (new CartController)->remove(),
        'cart-clear' => (new CartController)->clear(),
        'checkout' => (new CartController)->checkout(),
        'process-checkout' => (new CartController)->processCheckout(),
        'order-success' => (new CartController)->orderSuccess(),
        default => (new HomeController)->index(),
    };

