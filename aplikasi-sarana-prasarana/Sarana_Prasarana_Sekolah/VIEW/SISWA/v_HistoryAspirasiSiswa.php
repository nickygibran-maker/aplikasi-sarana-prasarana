<?php

session_start();


if (
    !isset($_SESSION['siswa']) &&
    !isset($_SESSION['admin'])
) {

    header('Location: ../auth/v_login.php');

    exit;
}


require_once '../../MODEL/m_histori.php';


$h = new Histori();


if (isset($_SESSION['siswa'])) {

    $data = $h->getBySiswa(
        (int)$_SESSION['nis']
    );

} else {

    $data = $h->getAll();
}


$isAdmin = isset($_SESSION['admin']);

?>

<!doctype html>

<html lang="id">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width,initial-scale=1"
    >

    <title>
        Histori Aspirasi
    </title>

    <link
        rel="stylesheet"
        href="../../ASSETS/modern.css"
    >

</head>


<body>


<main>


    <a
        class="back"
        href="<?= $isAdmin
            ? '../ADMIN/v_dasbord_admin.php'
            : 'dasbord_siswa.php'
        ?>"
    >
        ← Dashboard
    </a>


    <div class="page-head">

        <div>

            <h1>
                🕘 Histori Aspirasi
            </h1>


            <p>
                Riwayat laporan, foto bukti,
                perubahan status dan feedback.
            </p>

        </div>

    </div>


    <div class="table-card">

        <div class="table-wrap">

            <table>

                <tr>

                    <th>
                        ID
                    </th>

                    <th>
                        Aspirasi
                    </th>

                    <th>
                        NIS
                    </th>

                    <th>
                        Kategori
                    </th>

                    <th>
                        Keterangan
                    </th>

                    <th>
                        Foto Bukti
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Feedback
                    </th>

                    <th>
                        Tanggal
                    </th>

                </tr>


                <?php if (!$data): ?>

                    <tr>

                        <td
                            colspan="9"
                            class="empty"
                        >
                            Belum ada histori.
                        </td>

                    </tr>

                <?php endif; ?>


                <?php foreach ($data as $r): ?>

                    <tr>


                        <!-- ID HISTORI -->

                        <td>

                            #<?= (int)$r['id_histori'] ?>

                        </td>


                        <!-- ID ASPIRASI -->

                        <td>

                            #<?= (int)$r['id_aspirasi'] ?>

                        </td>


                        <!-- NIS -->

                        <td>

                            <?= htmlspecialchars(
                                $r['nis']
                            ) ?>

                        </td>


                        <!-- KATEGORI -->

                        <td>

                            <?= htmlspecialchars(
                                $r['ket_kategori'] ?? '-'
                            ) ?>

                        </td>


                        <!-- KETERANGAN -->

                        <td style="min-width:180px;">

                            <?php if (!empty($r['keterangan'])): ?>

                                <?= nl2br(
                                    htmlspecialchars(
                                        $r['keterangan']
                                    )
                                ) ?>

                            <?php else: ?>

                                <span style="color:#94a3b8;">
                                    -
                                </span>

                            <?php endif; ?>

                        </td>


                        <!-- FOTO BUKTI -->

                        <td>

                            <?php if (!empty($r['foto'])): ?>

                                <a
                                    href="../../ASSETS/GAMBAR/<?= rawurlencode($r['foto']) ?>"
                                    target="_blank"
                                    title="Klik untuk melihat foto"
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
                                            display:block;
                                            cursor:pointer;
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

                            <?php

                            $statusClass = 'badge-menunggu';

                            if (
                                strtolower($r['status']) ===
                                'proses'
                            ) {

                                $statusClass =
                                    'badge-proses';

                            } elseif (
                                strtolower($r['status']) ===
                                'selesai'
                            ) {

                                $statusClass =
                                    'badge-selesai';
                            }

                            ?>


                            <span
                                class="badge <?= $statusClass ?>"
                            >

                                <?= htmlspecialchars(
                                    $r['status']
                                ) ?>

                            </span>

                        </td>


                        <!-- FEEDBACK -->

                        <td>

                            <?= htmlspecialchars(
                                $r['feedback'] ?? '-'
                            ) ?>

                        </td>


                        <!-- TANGGAL -->

                        <td>

                            <?= htmlspecialchars(
                                $r['tanggal']
                            ) ?>

                        </td>


                    </tr>

                <?php endforeach; ?>


            </table>

        </div>

    </div>


</main>


</body>

</html>