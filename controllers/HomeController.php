<?php

class HomeController {
    public function index() {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $cartModel = new CartModel();
        
        $featuredProducts = $productModel->getFeaturedProducts(8);
        $newProducts = $productModel->getNewProducts(8);
        $allProducts = $productModel->getAllProduct();
        $categories = $categoryModel->getAllCategories();
        $cartCount = $cartModel->getCartCount();

        require_once PATH_VIEW . 'users/home.php';
    }

    public function detail($id) {
        if (!$id) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $productModel = new ProductModel();
        $cartModel = new CartModel();
        
        $product = $productModel->getAllProductID($id);
        
        if (!$product) {
            header('Location: ' . BASE_URL);
            exit;
        }

        // Tăng lượt xem
        $productModel->increaseViews($id);
        
        // Lấy sản phẩm liên quan
        $relatedProducts = $productModel->getRelatedProducts($id, $product->category_id, 4);
        $cartCount = $cartModel->getCartCount();

        require_once PATH_VIEW . 'users/product_detail.php';
    }

    public function category($id) {
        if (!$id) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $cartModel = new CartModel();
        
        $category = $categoryModel->getCategoryById($id);
        
        if (!$category) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $products = $productModel->getProductsByCategory($id);
        $categories = $categoryModel->getAllCategories();
        $cartCount = $cartModel->getCartCount();

        require_once PATH_VIEW . 'users/category.php';
    }

    public function search() {
        $keyword = $_GET['keyword'] ?? '';
        
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $cartModel = new CartModel();
        
        $products = $keyword ? $productModel->searchProducts($keyword) : [];
        $categories = $categoryModel->getAllCategories();
        $cartCount = $cartModel->getCartCount();

        require_once PATH_VIEW . 'users/search.php';
    }
}
