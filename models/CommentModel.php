<?php
class CommentModel {
    public function __construct() {
        if(!isset($_SESSION)) session_start();
        if(!isset($_SESSION['comments'])) {
            $_SESSION['comments'] = [];
        }
    }

    // Lấy comment, lọc theo guest_name, supplier_name hoặc rating
    public function getAllComments($filters = []) {
        $comments = $_SESSION['comments'];
        if(!empty($filters)) {
            $comments = array_filter($comments, function($c) use ($filters) {
                $ok = true;
                if(!empty($filters['guest_name'])) {
                    $ok = $ok && stripos($c['guest_name'], $filters['guest_name']) !== false;
                }
                if(!empty($filters['supplier_name'])) {
                    $ok = $ok && stripos($c['supplier_name'], $filters['supplier_name']) !== false;
                }
                if(!empty($filters['rating'])) {
                    $ok = $ok && $c['rating'] == $filters['rating'];
                }
                return $ok;
            });
        }
        return $comments;
    }

    public function addComment($guest_name, $supplier_name, $content, $rating) {
        $comments = $_SESSION['comments'];
        $comments[] = [
            'id' => count($comments) + 1,
            'guest_name' => $guest_name,
            'supplier_name' => $supplier_name,
            'content' => $content,
            'rating' => $rating,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $_SESSION['comments'] = $comments;
    }

    public function deleteComment($id) {
        $_SESSION['comments'] = array_filter($_SESSION['comments'], fn($c) => $c['id'] != $id);
    }

    public function getCommentById($id) {
        foreach($_SESSION['comments'] as $c){
            if($c['id'] == $id) return $c;
        }
        return null;
    }
}
