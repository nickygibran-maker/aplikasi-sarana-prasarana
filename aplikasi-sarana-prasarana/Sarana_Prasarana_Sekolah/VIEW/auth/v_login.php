<?php session_start(); $type=$_GET['type']??'siswa'; $error=$_SESSION['error']??''; $success=$_SESSION['success']??''; unset($_SESSION['error'],$_SESSION['success']); ?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login • Sarpras Sekolah</title><link rel="stylesheet" href="../../ASSETS/modern.css"></head>
<body class="login-page"><div class="login-card">
<img class="login-logo" src="../../ASSETS/GAMBAR/logoapk.jpeg" alt="Logo">
<h1>Sarpras Sekolah</h1><p class="muted">Sistem aspirasi sarana dan prasarana sekolah</p>
<?php if($error): ?><div class="alert error"><?=htmlspecialchars($error)?></div><?php endif;?><?php if($success): ?><div class="alert success"><?=htmlspecialchars($success)?></div><?php endif;?>
<div class="tabs"><a class="<?=$type==='siswa'?'active':''?>" href="?type=siswa">👨‍🎓 Login Siswa</a><a class="<?=$type==='admin'?'active':''?>" href="?type=admin">🛡️ Login Admin</a></div>
<?php if($type==='admin'): ?><form method="post" action="../../CONTROLLER/c_auth.php"><div class="form-group"><label>Username</label><input name="username" placeholder="Masukkan username" required></div><div class="form-group"><label>Password</label><input type="password" name="password" placeholder="Masukkan password" required></div><button class="btn btn-primary" name="login_admin">Masuk sebagai Admin</button></form>
<?php else: ?><form method="post" action="../../CONTROLLER/c_auth.php"><div class="form-group"><label>NIS</label><input name="nis" type="number" placeholder="Masukkan NIS" required></div><button class="btn btn-primary" name="login_siswa">Masuk sebagai Siswa</button></form><small>Gunakan NIS yang terdaftar pada data siswa.</small><?php endif;?>
</div></body></html>