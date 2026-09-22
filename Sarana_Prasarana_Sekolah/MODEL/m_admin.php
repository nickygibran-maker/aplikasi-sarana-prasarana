<?php
require_once __DIR__.'/m_koneksi.php';
class Admin {
    private mysqli $db;
    public function __construct(){ $this->db=(new Koneksi())->koneksi; }
    public function login(string $username,string $password): ?array {
        $s=$this->db->prepare('SELECT id_admin,username,password FROM admin WHERE username=? LIMIT 1');
        $s->bind_param('s',$username); $s->execute(); $a=$s->get_result()->fetch_assoc();
        if($a && ($password===$a['password'] || password_verify($password,$a['password']))) return $a;
        return null;
    }
    public function getAll(): array { $r=$this->db->query('SELECT id_admin,username FROM admin ORDER BY id_admin'); return $r? $r->fetch_all(MYSQLI_ASSOC):[]; }
}
