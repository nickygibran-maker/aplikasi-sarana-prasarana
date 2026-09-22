<?php
session_start();
if(isset($_SESSION['admin'])){ header('Location: VIEW/ADMIN/v_dasbord_admin.php'); exit; }
if(isset($_SESSION['siswa'])){ header('Location: VIEW/SISWA/dasbord_siswa.php'); exit; }
header('Location: VIEW/auth/v_login.php'); exit;
