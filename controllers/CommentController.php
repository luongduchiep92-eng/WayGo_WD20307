<?php
require_once 'models/CommentModel.php';

class CommentController {
    private $model;
    public function __construct() {
        $this->model = new CommentModel();
    }

    // List comment
    public function listComments() {
        $filters = [
            'guest_name' => $_POST['guest_name'] ?? '',
            'supplier_name' => $_POST['supplier_name'] ?? '',
            'rating' => $_POST['rating'] ?? ''
        ];
        $comments = $this->model->getAllComments($filters);
        include 'views/comments/list.php';
    }

    // Show add comment form
    public function showAddForm() {
        include 'views/comments/add.php';
    }

    // Add comment
    public function addComment() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->addComment(
                $_POST['guest_name'],
                $_POST['supplier_name'],
                $_POST['content'],
                $_POST['rating']
            );
        }
        header("Location: index.php?action=comments_list");
        exit;
    }

    // Delete comment
    public function deleteComment() {
        $id = $_GET['id'] ?? null;
        if($id) $this->model->deleteComment($id);
        header("Location: index.php?action=comments_list");
        exit;
    }

    // Xem chi tiết comment
    public function detailComment() {
        $id = $_GET['id'] ?? null;
        $comment = $this->model->getCommentById($id);
        include 'views/comments/detail.php';
    }
}





