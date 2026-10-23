<?php
session_start();

if (!isset($_SESSION['siswa'])) {
    header('Location: ../auth/v_login.php?type=siswa');
    exit;
}

require_once '../../MODEL/m_aspirasi.php';

$m = new Aspirasi();
$kat = $m->getKategori();

$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';

unset($_SESSION['error'], $_SESSION['success']);
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Kirim Aspirasi</title>
    <link rel="stylesheet" href="../../ASSETS/modern.css">
</head>

<body>

<main>

    <a class="back" href="dasbord_siswa.php">
        ← Dashboard
    </a>

    <div class="form-card">

        <h1>📣 Kirim Aspirasi</h1>

        <p class="sub">
            Sampaikan kebutuhan sarana atau prasarana sekolah.
        </p>

        <?php if ($error): ?>
            <div class="alert error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert success">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <div class="card" style="background:#f8fafc">
            <b>NIS</b>

            <div style="margin-top:5px;color:#64748b">
                <?= htmlspecialchars($_SESSION['nis']) ?>
            </div>
        </div>

        <form
            method="post"
            action="../../CONTROLLER/c_aspirasi.php"
            enctype="multipart/form-data"
        >

            <div class="form-group">

                <label>Kategori Sarana/Prasarana</label>

                <select name="id_kategori" required>

                    <option value="">
                        -- Pilih kategori --
                    </option>

                    <?php foreach ($kat as $k): ?>

                        <option value="<?= $k['id_kategori'] ?>">
                            <?= htmlspecialchars($k['ket_kategori']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <div class="form-group">

                <label>Keterangan Kerusakan</label>

                <textarea
                    name="keterangan"
                    rows="4"
                    required
                    placeholder="Contoh: Lampu kelas XII RPL 1 mati dan perlu diganti."
                ></textarea>

            </div>


            <div class="form-group">

                <label>Foto Bukti Kerusakan</label>

                <input
                    type="file"
                    name="foto"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    required
                >

                <small style="display:block;margin-top:6px;color:#64748b">
                    Upload foto barang/fasilitas yang rusak.
                    Format JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB.
                </small>

            </div>


            <button
                type="submit"
                class="btn btn-primary"
                style="width:100%"
                name="tambah_aspirasi"
            >
                Kirim Aspirasi →
            </button>

        </form>

    </div>

</main>

</body>
</html><?php
session_start();

if (!isset($_SESSION['siswa'])) {
    header('Location: ../auth/v_login.php?type=siswa');
    exit;
}

require_once '../../MODEL/m_aspirasi.php';

$m = new Aspirasi();
$kat = $m->getKategori();

$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';

unset($_SESSION['error'], $_SESSION['success']);
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Kirim Aspirasi</title>
    <link rel="stylesheet" href="../../ASSETS/modern.css">
</head>

<body>

<main>

    <a class="back" href="dasbord_siswa.php">
        ← Dashboard
    </a>

    <div class="form-card">

        <h1>📣 Kirim Aspirasi</h1>

        <p class="sub">
            Sampaikan kebutuhan sarana atau prasarana sekolah.
        </p>

        <?php if ($error): ?>
            <div class="alert error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert success">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <div class="card" style="background:#f8fafc">
            <b>NIS</b>

            <div style="margin-top:5px;color:#64748b">
                <?= htmlspecialchars($_SESSION['nis']) ?>
            </div>
        </div>

        <form
            method="post"
            action="../../CONTROLLER/c_aspirasi.php"
            enctype="multipart/form-data"
        >

            <div class="form-group">

                <label>Kategori Sarana/Prasarana</label>

                <select name="id_kategori" required>

                    <option value="">
                        -- Pilih kategori --
                    </option>

                    <?php foreach ($kat as $k): ?>

                        <option value="<?= $k['id_kategori'] ?>">
                            <?= htmlspecialchars($k['ket_kategori']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <div class="form-group">

                <label>Keterangan Kerusakan</label>

                <textarea
                    name="keterangan"
                    rows="4"
                    required
                    placeholder="Contoh: Lampu kelas XII RPL 1 mati dan perlu diganti."
                ></textarea>

            </div>


            <div class="form-group">

                <label>Foto Bukti Kerusakan</label>

                <input
                    type="file"
                    name="foto"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    required
                >

                <small style="display:block;margin-top:6px;color:#64748b">
                    Upload foto barang/fasilitas yang rusak.
                    Format JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB.
                </small>

            </div>


            <button
                type="submit"
                class="btn btn-primary"
                style="width:100%"
                name="tambah_aspirasi"
            >
                Kirim Aspirasi →
            </button>

        </form>

    </div>

</main>

</body>
</html><?php
session_start();

if (!isset($_SESSION['siswa'])) {
    header('Location: ../auth/v_login.php?type=siswa');
    exit;
}

require_once '../../MODEL/m_aspirasi.php';

$m = new Aspirasi();
$kat = $m->getKategori();

$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';

unset($_SESSION['error'], $_SESSION['success']);
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Kirim Aspirasi</title>
    <link rel="stylesheet" href="../../ASSETS/modern.css">
</head>

<body>

<main>

    <a class="back" href="dasbord_siswa.php">
        ← Dashboard
    </a>

    <div class="form-card">

        <h1>📣 Kirim Aspirasi</h1>

        <p class="sub">
            Sampaikan kebutuhan sarana atau prasarana sekolah.
        </p>

        <?php if ($error): ?>
            <div class="alert error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert success">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <div class="card" style="background:#f8fafc">
            <b>NIS</b>

            <div style="margin-top:5px;color:#64748b">
                <?= htmlspecialchars($_SESSION['nis']) ?>
            </div>
        </div>

        <form
            method="post"
            action="../../CONTROLLER/c_aspirasi.php"
            enctype="multipart/form-data"
        >

            <div class="form-group">

                <label>Kategori Sarana/Prasarana</label>

                <select name="id_kategori" required>

                    <option value="">
                        -- Pilih kategori --
                    </option>

                    <?php foreach ($kat as $k): ?>

                        <option value="<?= $k['id_kategori'] ?>">
                            <?= htmlspecialchars($k['ket_kategori']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <div class="form-group">

                <label>Keterangan Kerusakan</label>

                <textarea
                    name="keterangan"
                    rows="4"
                    required
                    placeholder="Contoh: Lampu kelas XII RPL 1 mati dan perlu diganti."
                ></textarea>

            </div>


            <div class="form-group">

                <label>Foto Bukti Kerusakan</label>

                <input
                    type="file"
                    name="foto"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    required
                >

                <small style="display:block;margin-top:6px;color:#64748b">
                    Upload foto barang/fasilitas yang rusak.
                    Format JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB.
                </small>

            </div>


            <button
                type="submit"
                class="btn btn-primary"
                style="width:100%"
                name="tambah_aspirasi"
            >
                Kirim Aspirasi →
            </button>

        </form>

    </div>

</main>

</body>
</html>