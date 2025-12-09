<?php
require_once PATH_MODEL . 'CommentModel.php';

class CommentController {
    private $model;

    public function __construct() {
        $this->model = new CommentModel();
    }

    // Danh sách
    public function listComments() {
        $filters = [
            'guest_name' => $_POST['guest_name'] ?? '',
            'supplier_name' => $_POST['supplier_name'] ?? '',
            'rating' => $_POST['rating'] ?? ''
        ];
        $comments = $this->model->getAllComments($filters);

        include PATH_VIEW . 'admin/comments/list.php'; 
    }

    // Form thêm mới
    public function showAddForm() {
        include PATH_VIEW . 'admin/comments/add.php';
    }

    // Xử lý thêm
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

    // Xóa
    public function deleteComment() {
        $id = $_GET['id'] ?? null;
        if($id) $this->model->deleteComment($id);
        header("Location: index.php?action=comments_list");
        exit;
    }

    // Chi tiết
    public function detailComment() {
        $id = $_GET['id'] ?? null;
        $comment = $this->model->getCommentById($id);
        include PATH_VIEW . 'admin/comments/detail.php';
    }
}