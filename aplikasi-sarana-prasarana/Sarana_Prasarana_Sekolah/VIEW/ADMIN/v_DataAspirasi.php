<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: ../auth/v_login.php?type=admin');
    exit;
}

require_once '../../MODEL/m_aspirasi.php';

$m = new Aspirasi();
$data = $m->getAll();

$msg = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';

unset($_SESSION['success'], $_SESSION['error']);
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>Data Aspirasi</title>

    <link rel="stylesheet" href="../../ASSETS/modern.css">
</head>

<body>

<nav class="navbar">

    <a class="nav-brand" href="v_dasbord_admin.php">
        <span class="brand-icon">🏫</span>
        <span>Admin Panel</span>
    </a>

    <ul class="nav-menu">

        <li>
            <a href="v_dasbord_admin.php">
                ⌂ Dashboard
            </a>
        </li>

        <li>
            <a href="v_DaftarSiswa.php">
                👨‍🎓 Data Siswa
            </a>
        </li>

        <li>
            <a class="active" href="v_DataAspirasi.php">
                📋 Data Aspirasi
            </a>
        </li>

        <li>
            <a href="UmpanBalik.php">
                💬 Umpan Balik
            </a>
        </li>

    </ul>

    <div class="nav-user">

        👤 <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?>

        <a
            class="logout-link"
            href="../../CONTROLLER/c_auth.php?logout=1"
        >
            Keluar
        </a>

    </div>

</nav>


<main>

    <a class="back" href="v_dasbord_admin.php">
        ← Dashboard
    </a>


    <div class="page-head">

        <div>

            <h1>📋 Data Aspirasi</h1>

            <p>
                Kelola laporan kerusakan dan lihat foto bukti dari siswa.
            </p>

        </div>

        <a
            class="btn btn-primary"
            href="UmpanBalik.php"
        >
            💬 Umpan Balik
        </a>

    </div>


    <?php if ($msg): ?>

        <div class="alert success">
            <?= htmlspecialchars($msg) ?>
        </div>

    <?php endif; ?>


    <?php if ($error): ?>

        <div class="alert error">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>


    <div class="table-card">

        <div class="table-wrap">

            <table>

                <tr>

                    <th>ID</th>

                    <th>NIS</th>

                    <th>Kelas</th>

                    <th>Kategori</th>

                    <th>Keterangan</th>

                    <th>Foto Bukti</th>

                    <th>Status</th>

                    <th>Admin</th>

                    <th>Feedback & Aksi</th>

                </tr>


                <?php if (!$data): ?>

                    <tr>

                        <td colspan="9" class="empty">
                            Belum ada data aspirasi.
                        </td>

                    </tr>

                <?php endif; ?>


                <?php foreach ($data as $r): ?>

                    <tr>

                        <td>

                            <b>
                                #<?= (int)$r['id_aspirasi'] ?>
                            </b>

                        </td>


                        <td>
                            <?= htmlspecialchars($r['nis']) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars($r['kelas']) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars($r['ket_kategori']) ?>
                        </td>


                        <!-- KETERANGAN -->

                        <td style="min-width:180px;">

                            <?= !empty($r['keterangan'])
                                ? nl2br(htmlspecialchars($r['keterangan']))
                                : '<span style="color:#94a3b8;">-</span>'
                            ?>

                        </td>


                        <!-- FOTO BUKTI -->

                        <td>

                            <?php if (!empty($r['foto'])): ?>

                                <a
                                    href="../../ASSETS/GAMBAR/<?= rawurlencode($r['foto']) ?>"
                                    target="_blank"
                                    title="Klik untuk melihat foto ukuran penuh"
                                >

                                    <img
                                        src="../../ASSETS/GAMBAR/<?= rawurlencode($r['foto']) ?>"
                                        alt="Bukti Kerusakan"

                                        style="
                                            width:110px;
                                            height:85px;
                                            object-fit:cover;
                                            border-radius:10px;
                                            border:1px solid #e2e8f0;
                                            cursor:pointer;
                                            display:block;
                                        "
                                    >

                                </a>

                                <small
                                    style="
                                        display:block;
                                        margin-top:5px;
                                        color:#64748b;
                                    "
                                >
                                    Klik foto
                                </small>


                            <?php else: ?>

                                <span style="color:#94a3b8;">
                                    Tidak ada foto
                                </span>

                            <?php endif; ?>

                        </td>


                        <!-- STATUS -->

                        <td>

                            <form
                                class="inline-form"
                                method="post"
                                action="../../CONTROLLER/c_aspirasi.php"
                            >

                                <input
                                    type="hidden"
                                    name="id_aspirasi"
                                    value="<?= (int)$r['id_aspirasi'] ?>"
                                >


                                <select name="status">

                                    <option
                                        value="Menunggu"
                                        <?= $r['status'] === 'Menunggu'
                                            ? 'selected'
                                            : ''
                                        ?>
                                    >
                                        Menunggu
                                    </option>


                                    <option
                                        value="Proses"
                                        <?= $r['status'] === 'Proses'
                                            ? 'selected'
                                            : ''
                                        ?>
                                    >
                                        Proses
                                    </option>


                                    <option
                                        value="Selesai"
                                        <?= $r['status'] === 'Selesai'
                                            ? 'selected'
                                            : ''
                                        ?>
                                    >
                                        Selesai
                                    </option>

                                </select>

                        </td>


                        <!-- ADMIN -->

                        <td>

                            <?= htmlspecialchars(
                                $r['username'] ?? '-'
                            ) ?>

                        </td>


                        <!-- FEEDBACK -->

                        <td>

                            <div class="inline-form">

                                <input
                                    class="feedback-input"
                                    name="feedback"
                                    value="<?= htmlspecialchars(
                                        $r['feedback'] ?? ''
                                    ) ?>"
                                    placeholder="Tulis feedback"
                                >


                                <button
                                    class="btn btn-primary"
                                    name="ubah_status"
                                >
                                    Simpan
                                </button>


                                <a
                                    class="btn btn-light"
                                    href="UmpanBalik.php?id=<?= (int)$r['id_aspirasi'] ?>"
                                >
                                    💬 Feedback
                                </a>

                            </div>

                            </form>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </table>

        </div>

    </div>

</main>

</body>
</html>