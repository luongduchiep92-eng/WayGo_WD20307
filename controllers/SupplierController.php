<?php
require_once PATH_MODEL . "supplierModel.php";

class SupplierController
{
    public function listSupplier()
    {
        $model = new Supplier();
        $suppliers = $model->getAll();
        include "views/suppliers/listsupplier.php";
    }

    public function addSupplier()
    {
        include "views/suppliers/addsupplier.php";
    }

    public function storeSupplier()
    {
        $model = new Supplier();

        $data = [
            "name" => $_POST["name"],
            "phone" => $_POST["phone"],
            "email" => $_POST["email"],
            "address" => $_POST["address"]
        ];

        $model->insert($data);
        header("Location: index.php?action=listsupplier");
        exit;
    }

    public function editSupplier()
    {
        $model = new Supplier();
        $supplier = $model->find($_GET['id']);

        include "views/suppliers/editsupplier.php";
    }

    public function updateSupplier()
    {
        $model = new Supplier();

        $data = [
            "name" => $_POST["name"],
            "phone" => $_POST["phone"],
            "email" => $_POST["email"],
            "address" => $_POST["address"]
        ];

        $model->updateSupplier($_GET['id'], $data);
        header("Location: index.php?action=listsupplier");
        exit;
    }

    public function deleteSupplier() // sửa lỗi eleteSupplier
    {
        $model = new Supplier();
        $model->deleteSupplier($_GET['id']);
        header("Location: index.php?action=listsupplier");
        exit;
    }
    // xem chi tiết nhà  cung cấp
    public function detailSupplier()
    {
        $model = new Supplier();
        $supplier = $model->find($_GET['id']); // Lấy thông tin theo id
        include "views/suppliers/detailsupplier.php"; // File hiển thị chi tiết
    }
}
