<?php

$action = $_GET['action'] ?? '/';

$role = $_GET['role'] ?? 'product-list';

if($role === 'admin'){
    if ($role === 'admin') {
    match ($action) {
        // 'product-list', 'list', '/' => (new ProductController())->list(),
        
    };
}

}else
    match ($action) {
        // '/' => (new HomeController)->index(),

    };

