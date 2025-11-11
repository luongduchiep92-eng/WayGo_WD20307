<?php
class CartModel extends BaseModel {
    protected $table = 'cart';

    private function getSessionId() {
        if (!isset($_SESSION['cart_session_id'])) {
            $_SESSION['cart_session_id'] = session_id();
        }
        return $_SESSION['cart_session_id'];
    }

    public function addToCart($product_id, $quantity = 1) {
        $session_id = $this->getSessionId();
        
        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        $existing = $this->getCartItem($product_id);
        
        if ($existing) {
            // Cập nhật số lượng
            $sql = "UPDATE {$this->table} 
                    SET quantity = quantity + :quantity 
                    WHERE session_id = :session_id AND product_id = :product_id";
        } else {
            // Thêm mới
            $sql = "INSERT INTO {$this->table} (session_id, product_id, quantity) 
                    VALUES (:session_id, :product_id, :quantity)";
        }
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'session_id' => $session_id,
            'product_id' => $product_id,
            'quantity' => $quantity
        ]);
    }

    public function getCartItems() {
        $session_id = $this->getSessionId();
        
        $sql = "SELECT c.*, p.name, p.price, p.sale_price, p.image, p.stock,
                (COALESCE(p.sale_price, p.price) * c.quantity) as subtotal
                FROM {$this->table} c
                INNER JOIN products p ON c.product_id = p.id
                WHERE c.session_id = :session_id AND p.status = 'active'
                ORDER BY c.created_at DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['session_id' => $session_id]);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        return $stmt->fetchAll();
    }

    public function getCartItem($product_id) {
        $session_id = $this->getSessionId();
        
        $sql = "SELECT * FROM {$this->table} 
                WHERE session_id = :session_id AND product_id = :product_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'session_id' => $session_id,
            'product_id' => $product_id
        ]);
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        return $stmt->fetch();
    }

    public function updateQuantity($product_id, $quantity) {
        $session_id = $this->getSessionId();
        
        if ($quantity <= 0) {
            return $this->removeFromCart($product_id);
        }
        
        $sql = "UPDATE {$this->table} 
                SET quantity = :quantity 
                WHERE session_id = :session_id AND product_id = :product_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'session_id' => $session_id,
            'product_id' => $product_id,
            'quantity' => $quantity
        ]);
    }

    public function removeFromCart($product_id) {
        $session_id = $this->getSessionId();
        
        $sql = "DELETE FROM {$this->table} 
                WHERE session_id = :session_id AND product_id = :product_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'session_id' => $session_id,
            'product_id' => $product_id
        ]);
    }

    public function clearCart() {
        $session_id = $this->getSessionId();
        
        $sql = "DELETE FROM {$this->table} WHERE session_id = :session_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['session_id' => $session_id]);
    }

    public function getCartCount() {
        $session_id = $this->getSessionId();
        
        $sql = "SELECT SUM(quantity) as total FROM {$this->table} 
                WHERE session_id = :session_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['session_id' => $session_id]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->total ?? 0;
    }

    public function getCartTotal() {
        $items = $this->getCartItems();
        $total = 0;
        foreach ($items as $item) {
            $total += $item->subtotal;
        }
        return $total;
    }
}
