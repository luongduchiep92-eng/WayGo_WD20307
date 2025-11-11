<?php
    class ProductController{
        public function List(){
            $productModel = new ProductModel();
            $products = $productModel -> getAllProduct();
            include(PATH_VIEW . 'admin/products/list.php');
        }
        public function add(){
            $categoryModel = new CategoryModel();
            $categories = $categoryModel->getAllCategories();
            if(isset($_POST['submit'])){
                $name = $_POST['name'] ?? '';
                $price = $_POST['price'] ?? '';
                $description = $_POST['description'] ?? '';
                $category_id = $_POST['category_id'] ?? '';
                $file = $_FILES['image'] ?? null;
                if($file['name'] != ''){
                    $folder = 'products';
                    $image = upload_file($folder, $file);
                }
                $productModel = new ProductModel();
                $data = [
                    'name' => $name,
                    'image' => $image ?? '',
                    'price' => $price,
                    'description' => $description,
                    'category_id' => $category_id
                ];
                $productModel->addProduct($data);
                header('Location: ' . BASE_URL . 'index.php?role=admin&action=product-list');
                exit();
            }
            include(PATH_VIEW . 'admin/products/add.php');
        }
        public function edit(){
            $id = $_GET['id'] ?? 0;
            $productModel = new ProductModel();
            $productCurrent = $productModel->getAllProductId($id);
            $categoryModel = new CategoryModel();
            $categories = $categoryModel->getAllCategories();
            if(isset($_POST['submit'])){
                $name = $_POST['name'] ?? '';
                $price = $_POST['price'] ?? '';
                $description = $_POST['description'] ?? '';
                $category_id = $_POST['category_id'] ?? '';
                $file = $_FILES['image'] ?? null;
                if($file['name'] != ''){
                    $folder = 'products';
                    $image = upload_file($folder, $file);
                }
                $productModel = new ProductModel();
                $data = [
                    'name' => $name,
                    'image' => $image ?? $productCurrent->image,
                    'price' => $price,
                    'description' => $description,
                    'category_id' => $category_id
                ];
                $productModel->updateProduct($id,$data);
                header('Location: ' . BASE_URL . 'index.php?role=admin&action=product-list');
                exit();
            }
            // debug($id);
            include(PATH_VIEW . 'admin/products/edit.php');
        }
        public function delete(){
            $id = $_GET['id'] ?? 0;
            $productModel = new ProductModel();
            $productModel->deleteProduct($id);
            header('Location: ' . BASE_URL . 'index.php?role=admin&action=product-list');
            exit();
        }
    }
