<div class="form-group">

    <label>Keterangan Kerusakan</label>

    <textarea readonly><?= htmlspecialchars($r['keterangan'] ?? '-') ?></textarea>

</div>

<div class="form-group">

    <label>Foto Bukti Kerusakan</label>

    <?php if (!empty($r['foto'])): ?>

        <div style="margin-top:10px;">

            <img
                src="../../ASSETS/GAMBAR/<?= rawurlencode($r['foto']) ?>"
                alt="Foto bukti kerusakan"
                style="
                    width:100%;
                    max-width:500px;
                    max-height:350px;
                    object-fit:cover;
                    border-radius:12px;
                    border:1px solid #e2e8f0;
                "
            >

        </div>

    <?php else: ?>

        <p>Foto tidak tersedia.</p>

    <?php endif; ?>

</div>