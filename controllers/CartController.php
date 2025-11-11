<?php

class CartController {
    public function index() {
        $cartModel = new CartModel();
        $categoryModel = new CategoryModel();
        
        $cartItems = $cartModel->getCartItems();
        $cartTotal = $cartModel->getCartTotal();
        $cartCount = $cartModel->getCartCount();
        $categories = $categoryModel->getAllCategories();

        require_once PATH_VIEW . 'users/cart.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 1;
            
            if ($product_id) {
                $cartModel = new CartModel();
                $cartModel->addToCart($product_id, $quantity);
                
                // Redirect về trang trước đó hoặc giỏ hàng
                $redirect = $_POST['redirect'] ?? BASE_URL . '?action=cart';
                header('Location: ' . $redirect);
                exit;
            }
        }
        
        header('Location: ' . BASE_URL);
        exit;
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 0;
            
            if ($product_id) {
                $cartModel = new CartModel();
                $cartModel->updateQuantity($product_id, $quantity);
            }
        }
        
        header('Location: ' . BASE_URL . '?action=cart');
        exit;
    }

    public function remove() {
        $product_id = $_GET['id'] ?? null;
        
        if ($product_id) {
            $cartModel = new CartModel();
            $cartModel->removeFromCart($product_id);
        }
        
        header('Location: ' . BASE_URL . '?action=cart');
        exit;
    }

    public function clear() {
        $cartModel = new CartModel();
        $cartModel->clearCart();
        
        header('Location: ' . BASE_URL . '?action=cart');
        exit;
    }

    public function checkout() {
        $cartModel = new CartModel();
        $categoryModel = new CategoryModel();
        
        $cartItems = $cartModel->getCartItems();
        
        if (empty($cartItems)) {
            header('Location: ' . BASE_URL . '?action=cart');
            exit;
        }
        
        $cartTotal = $cartModel->getCartTotal();
        $cartCount = $cartModel->getCartCount();
        $categories = $categoryModel->getAllCategories();

        require_once PATH_VIEW . 'users/checkout.php';
    }

    public function processCheckout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartModel = new CartModel();
            $cartItems = $cartModel->getCartItems();
            
            if (empty($cartItems)) {
                header('Location: ' . BASE_URL . '?action=cart');
                exit;
            }
            
            // Lấy thông tin khách hàng
            $customer_name = $_POST['customer_name'] ?? '';
            $customer_email = $_POST['customer_email'] ?? '';
            $customer_phone = $_POST['customer_phone'] ?? '';
            $customer_address = $_POST['customer_address'] ?? '';
            $notes = $_POST['notes'] ?? '';
            
            // Validate
            if (empty($customer_name) || empty($customer_email) || empty($customer_phone) || empty($customer_address)) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin!';
                header('Location: ' . BASE_URL . '?action=checkout');
                exit;
            }
            
            // Tính tổng tiền
            $total_amount = $cartModel->getCartTotal();
            
            try {
                // Bắt đầu transaction
                $pdo = $cartModel->getPdo();
                $pdo->beginTransaction();
                
                // Tạo đơn hàng
                $sql = "INSERT INTO orders (customer_name, customer_email, customer_phone, customer_address, total_amount, notes, status) 
                        VALUES (:customer_name, :customer_email, :customer_phone, :customer_address, :total_amount, :notes, 'pending')";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'customer_name' => $customer_name,
                    'customer_email' => $customer_email,
                    'customer_phone' => $customer_phone,
                    'customer_address' => $customer_address,
                    'total_amount' => $total_amount,
                    'notes' => $notes
                ]);
                
                $order_id = $pdo->lastInsertId();
                
                // Thêm chi tiết đơn hàng
                foreach ($cartItems as $item) {
                    $price = $item->sale_price ?? $item->price;
                    $sql = "INSERT INTO order_items (order_id, product_id, product_name, product_price, quantity, subtotal) 
                            VALUES (:order_id, :product_id, :product_name, :product_price, :quantity, :subtotal)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        'order_id' => $order_id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->name,
                        'product_price' => $price,
                        'quantity' => $item->quantity,
                        'subtotal' => $item->subtotal
                    ]);
                    
                    // Cập nhật tồn kho
                    $sql = "UPDATE products SET stock = stock - :quantity WHERE id = :product_id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        'quantity' => $item->quantity,
                        'product_id' => $item->product_id
                    ]);
                }
                
                // Commit transaction
                $pdo->commit();
                
                // Xóa giỏ hàng
                $cartModel->clearCart();
                
                // Thông báo thành công
                $_SESSION['success'] = 'Đặt hàng thành công! Mã đơn hàng: #' . $order_id;
                header('Location: ' . BASE_URL . '?action=order-success&id=' . $order_id);
                exit;
                
            } catch (Exception $e) {
                // Rollback nếu có lỗi
                $pdo->rollBack();
                $_SESSION['error'] = 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại!';
                header('Location: ' . BASE_URL . '?action=checkout');
                exit;
            }
        }
        
        header('Location: ' . BASE_URL . '?action=checkout');
        exit;
    }

    public function orderSuccess() {
        $order_id = $_GET['id'] ?? null;
        $cartModel = new CartModel();
        $categoryModel = new CategoryModel();
        
        $categories = $categoryModel->getAllCategories();
        $cartCount = $cartModel->getCartCount();
        
        require_once PATH_VIEW . 'users/order_success.php';
    }
}
