<?php
// models/Auth.php
class Auth {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function loginSiswa($nisn, $password) {
        $stmt = $this->db->prepare("SELECT * FROM siswa WHERE nisn = :nisn");
        $stmt->execute(['nisn' => $nisn]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function loginAdmin($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM admin WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }
        return false;
    }
}
?>
