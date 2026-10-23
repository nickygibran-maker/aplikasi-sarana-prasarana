<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: ../auth/v_login.php?type=admin');
    exit;
}

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Tambah Siswa • Sarpras</title>

    <link
        rel="stylesheet"
        href="../../ASSETS/modern.css"
    >
</head>

<body>

    <main>

        <a
            class="back"
            href="v_DaftarSiswa.php"
        >
            ← Kembali
        </a>

        <section class="form-card">

            <span class="eyebrow">
                DATA SISWA
            </span>

            <h1>
                ➕ Tambah Siswa
            </h1>

            <p class="sub">
                Tambahkan siswa baru ke sistem sarpras.
            </p>

            <?php if ($error): ?>

                <div class="alert error">
                    ⚠️ <?= htmlspecialchars($error) ?>
                </div>

            <?php endif; ?>


            <form
                method="post"
                action="../../CONTROLLER/c_siswa.php"
            >

                <input
                    type="hidden"
                    name="action"
                    value="tambah"
                >


                <!-- NIS -->
                <div class="form-group">

                    <label for="nis">
                        NIS
                    </label>

                    <input
                        type="text"
                        id="nis"
                        name="nis"
                        inputmode="numeric"
                        pattern="[0-9]+"
                        placeholder="Contoh: 1000000011"
                        required
                    >

                </div>


                <!-- KELAS -->
                <div class="form-group">

                    <label for="kelas">
                        Kelas
                    </label>

                    <input
                        type="text"
                        id="kelas"
                        name="kelas"
                        maxlength="10"
                        placeholder="Contoh: XII RPL 1"
                        required
                    >

                </div>


                <!-- TOMBOL -->
                <button
                    class="btn btn-primary"
                    type="submit"
                >
                    Simpan Siswa
                </button>

                <a
                    class="btn btn-light"
                    href="v_DaftarSiswa.php"
                >
                    Batal
                </a>

            </form>

        </section>

    </main>

</body>

</html>