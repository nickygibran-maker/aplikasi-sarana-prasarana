<?php

session_start();
if (!isset($_SESSION['siswa'])) {
    header('Location: ../auth/v_login.php?type=siswa');
    exit;
}

require_once __DIR__ . '/../../MODEL/m_aspirasi.php';
require_once __DIR__ . '/../../template/layout.php';

$kategori = (new Aspirasi())->getKategori();

renderHead('Kirim Aspirasi');
renderNavbar('siswa', 'kirim');
?>
<main>
    <section class="form-card">
        <span class="eyebrow">Aspirasi Baru</span>
        <h1>📣 Kirim Aspirasi</h1>
        <p class="sub">Sampaikan kebutuhan sarana atau prasarana sekolah.</p>

        <?php flashMessages(); ?>

        <div class="nis-box">
            <span class="k">NIS kamu</span>
            <b><?= e($_SESSION['nis']) ?></b>
        </div>

        <form method="post" action="../../CONTROLLER/c_aspirasi.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="id_kategori">Kategori Sarana/Prasarana</label>
                <select id="id_kategori" name="id_kategori" required>
                    <option value="">-- Pilih kategori --</option>
                    <?php foreach ($kategori as $k): ?>
                        <option value="<?= (int) $k['id_kategori'] ?>"><?= e($k['ket_kategori']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan Kerusakan</label>
                <textarea id="keterangan" name="keterangan" rows="4" required
                          placeholder="Contoh: Lampu kelas XII RPL 1 mati dan perlu diganti."></textarea>
            </div>

            <div class="form-group">
                <label for="foto">Foto Bukti Kerusakan</label>
                <input id="foto" type="file" name="foto" required
                       accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                <small class="hint">Upload foto barang/fasilitas yang rusak. Format JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB.</small>
            </div>

            <button class="btn btn-primary btn-block" type="submit" name="tambah_aspirasi">Kirim Aspirasi →</button>
        </form>
    </section>
</main>
<?php renderFoot(); ?>
