<?php
// controllers/SiswaController.php
class SiswaController {
    private $aspirasiModel;

    public function __construct($aspirasiModel) {
        if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'siswa') {
            header('Location: index.php?page=login-siswa');
            exit;
        }
        $this->aspirasiModel = $aspirasiModel;
    }

    public function dashboard() {
        $data = $this->aspirasiModel->getByNisn($_SESSION['user']['nisn']);
        require 'views/siswa/dashboard.php';
    }

    public function histori() {
        $data = $this->aspirasiModel->getByNisn($_SESSION['user']['nisn']);
        require 'views/siswa/histori.php';
    }

    public function detail($id) {
        $detail = $this->aspirasiModel->getById($id);
        require 'views/siswa/detail.php';
    }

    public function kirimAspirasi() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $kategori = htmlspecialchars($_POST['kategori']);
            $deskripsi = htmlspecialchars($_POST['deskripsi']);
            
            $foto = $_FILES['foto']['name'];
            $tmp = $_FILES['foto']['tmp_name'];
            $path = "assets/img/" . $foto;

            // FIX: Menggunakan fungsi bawaan PHP yang benar
            if (move_uploaded_file($tmp, $path)) {
                $this->aspirasiModel->create($_SESSION['user']['nisn'], $kategori, $deskripsi, $foto);
            }
            header('Location: index.php?page=siswa-dashboard');
            exit;
        }
    }
}
?>
