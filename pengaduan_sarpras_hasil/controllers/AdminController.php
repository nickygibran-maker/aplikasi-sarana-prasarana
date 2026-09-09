<?php
// controllers/AdminController.php
class AdminController {
    private $aspirasiModel;

    public function __construct($aspirasiModel) {
        if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?page=login-admin');
            exit;
        }
        $this->aspirasiModel = $aspirasiModel;
    }

    public function dashboard() {
        $allData = $this->aspirasiModel->getAll();
        require 'views/admin/dashboard.php';
    }

    public function aspirasi() {
        $allData = $this->aspirasiModel->getAll();
        require 'views/admin/aspirasi.php';
    }

    public function detail($id) {
        $detail = $this->aspirasiModel->getById($id);
        require 'views/admin/detail.php';
    }

    public function tanggapi() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_aspirasi'];
            $status = $_POST['status'];
            $tanggapan = htmlspecialchars($_POST['tanggapan']);
            
            $this->aspirasiModel->updateStatus($id, $status, $tanggapan);
            header('Location: index.php?page=admin-aspirasi');
        }
    }
}
?>
