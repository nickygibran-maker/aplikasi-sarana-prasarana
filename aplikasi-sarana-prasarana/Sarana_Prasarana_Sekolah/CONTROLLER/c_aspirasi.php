<?php

session_start();

require_once __DIR__ . '/../MODEL/m_aspirasi.php';
require_once __DIR__ . '/../MODEL/m_histori.php';

if (!isset($_SESSION['siswa']) && !isset($_SESSION['admin'])) {
    header('Location: ../index.php');
    exit;
}

$m = new Aspirasi();
$h = new Histori();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /*
    |--------------------------------------------------------------------------
    | TAMBAH ASPIRASI SISWA
    |--------------------------------------------------------------------------
    */
    if (isset($_POST['tambah_aspirasi']) && isset($_SESSION['siswa'])) {

        $nis = (int) $_SESSION['nis'];
        $idKategori = (int) ($_POST['id_kategori'] ?? 0);
        $keterangan = trim($_POST['keterangan'] ?? '');

        if ($idKategori <= 0) {
            $_SESSION['error'] = 'Silakan pilih kategori.';
            header('Location: ../VIEW/SISWA/v_form_aspirasi.php');
            exit;
        }

        if ($keterangan === '') {
            $_SESSION['error'] = 'Keterangan kerusakan wajib diisi.';
            header('Location: ../VIEW/SISWA/v_form_aspirasi.php');
            exit;
        }


        /*
        |--------------------------------------------------------------------------
        | CEK FOTO
        |--------------------------------------------------------------------------
        */

        if (
            !isset($_FILES['foto']) ||
            $_FILES['foto']['error'] !== UPLOAD_ERR_OK
        ) {
            $_SESSION['error'] = 'Foto bukti kerusakan wajib diupload.';
            header('Location: ../VIEW/SISWA/v_form_aspirasi.php');
            exit;
        }


        $file = $_FILES['foto'];


        /*
        |--------------------------------------------------------------------------
        | BATAS UKURAN 5 MB
        |--------------------------------------------------------------------------
        */

        $maxSize = 5 * 1024 * 1024;

        if ($file['size'] > $maxSize) {
            $_SESSION['error'] = 'Ukuran foto maksimal 5 MB.';
            header('Location: ../VIEW/SISWA/v_form_aspirasi.php');
            exit;
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI FILE BERDASARKAN MIME TYPE
        |--------------------------------------------------------------------------
        */

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);

        $allowedMime = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp'
        ];

        if (!isset($allowedMime[$mime])) {
            $_SESSION['error'] =
                'Format foto harus JPG, JPEG, PNG, atau WEBP.';

            header('Location: ../VIEW/SISWA/v_form_aspirasi.php');
            exit;
        }


        /*
        |--------------------------------------------------------------------------
        | FOLDER PENYIMPANAN
        |--------------------------------------------------------------------------
        */

        $folder = __DIR__ . '/../ASSETS/GAMBAR/';

        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }


        /*
        |--------------------------------------------------------------------------
        | BUAT NAMA FILE BARU
        |--------------------------------------------------------------------------
        */

        $extension = $allowedMime[$mime];

        try {
            $random = bin2hex(random_bytes(8));
        } catch (Exception $e) {
            $random = uniqid();
        }

        $namaFoto =
            time() .
            '_' .
            $random .
            '.' .
            $extension;


        $tujuan = $folder . $namaFoto;


        /*
        |--------------------------------------------------------------------------
        | SIMPAN FOTO KE ASSETS/GAMBAR
        |--------------------------------------------------------------------------
        */

        if (!move_uploaded_file(
            $file['tmp_name'],
            $tujuan
        )) {

            $_SESSION['error'] =
                'Foto gagal disimpan.';

            header('Location: ../VIEW/SISWA/v_form_aspirasi.php');
            exit;
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN KE DATABASE
        |--------------------------------------------------------------------------
        */

        $id = $m->tambah(
            $nis,
            $idKategori,
            $namaFoto,
            $keterangan
        );


        if ($id) {

            $h->tambah(
                $id,
                'Menunggu',
                'Laporan telah diterima'
            );

            $_SESSION['success'] =
                'Aspirasi dan foto bukti berhasil dikirim.';

        } else {

            // Jika database gagal, hapus foto yang tadi sudah diupload
            if (file_exists($tujuan)) {
                unlink($tujuan);
            }

            $_SESSION['error'] =
                'Aspirasi gagal dikirim.';
        }


        header(
            'Location: ../VIEW/SISWA/v_form_aspirasi.php'
        );

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS OLEH ADMIN
    |--------------------------------------------------------------------------
    */

    if (
        isset($_POST['ubah_status']) &&
        isset($_SESSION['admin'])
    ) {

        $id = (int) $_POST['id_aspirasi'];

        $status =
            $_POST['status'] ?? 'Menunggu';

        $feedback =
            trim($_POST['feedback'] ?? '');

        $ok = $m->updateStatus(
            $id,
            $status,
            (int) $_SESSION['id_admin']
        );


        if ($ok) {

            $h->tambah(
                $id,
                $status,
                $feedback !== ''
                    ? $feedback
                    : null
            );

            $m->updateFeedback(
                $id,
                $feedback !== ''
                    ? $feedback
                    : null
            );

            $_SESSION['success'] =
                'Status aspirasi berhasil diperbarui.';

        } else {

            $_SESSION['error'] =
                'Gagal memperbarui status.';
        }


        header(
            'Location: ../VIEW/ADMIN/v_DataAspirasi.php'
        );

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS ASPIRASI SISWA
    |--------------------------------------------------------------------------
    */

    if (
        isset($_POST['hapus_aspirasi']) &&
        isset($_SESSION['siswa'])
    ) {

        $id = (int) $_POST['id_aspirasi'];
        $nis = (int) $_SESSION['nis'];

        // Ambil data agar foto juga bisa dihapus
        $data = $m->getById($id);

        if (
            $data &&
            (int) $data['nis'] === $nis &&
            $data['status'] === 'Menunggu'
        ) {

            if ($m->hapus($id, $nis)) {

                if (!empty($data['foto'])) {

                    $fotoPath =
                        __DIR__ .
                        '/../ASSETS/GAMBAR/' .
                        basename($data['foto']);

                    if (file_exists($fotoPath)) {
                        unlink($fotoPath);
                    }
                }

                $_SESSION['success'] =
                    'Aspirasi berhasil dihapus.';
            }
        }


        header(
            'Location: ../VIEW/SISWA/daftar_laporan.php'
        );

        exit;
    }
}