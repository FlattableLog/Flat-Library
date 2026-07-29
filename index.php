<?php

include 'koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM buku");

?>

<?php include 'layout/header.html' ?>

<section class="hero" id="hero">
    <main class="content">
        <h1><span> Library <span class="sc">of Flat</span><br></span> Dunia tanpa batas.</h1>
        <p>Membaca mengubah pemikiran datar dengan wawasan tanpa batas.</p>
        <a href="#buku" class="cta">Mulai Membaca</a>
    </main>
</section>

<div class="katalog-buku" id="buku">
    <?php while ($row = mysqli_fetch_array($data)) :
        $genres = explode(',', $row['genre']) ?>

    <article class="kartu-buku">
        <div class="kategori-buku">
            <span><?= $row['kategori'] ?></span>
        </div>

        <div class="cover-buku">
            <img src="asset/sampul/<?= $row['sampul'] ?>" alt="cover Bawah <?= $row['judul'] ?>>">
            <img src="asset/sampul/<?=$row['sampul'] ?>" alt="Cover Atas <?= $row['judul'] ?>">
        </div>

        <div class="info-buku">
            <h3 class="judul-buku"><?= $row['judul'] ?></h3>
            <p class="penulis-buku"><?= $row['penulis'] ?></p>

            <div class="genre-list">
                <?php foreach($genres as $g): ?>
                <span class="gelembung"><?= trim($g) ?></span>
                <?php endforeach; ?>
            </div>

            <button class="btn-detail" onclick="bukaModal(<?= $row['id'] ?>)">Lihat Detail</button>
        </div>
    </article>

    <div class="latar-modal" id="modal-<?= $row['id'] ?>">
        <div class="modal-content">
            <button class="cls-btn" onclick="tutupModal(<?= $row['id'] ?>)">&times;</button>

            <div class="modal-layout">
                <div class="modal-cover">
                    <img src="asset/sampul/<?= $row['sampul'] ?>" alt="cover <?= $row['judul'] ?>">
                </div>

                <div class="modal-info">
                    <h2><?= $row['judul'] ?></h2>
                    <p class="nama-penulis">Penulis: <?= $row['penulis'] ?></p>

                    <div class="genre-list">
                        <strong>Genre:</strong>
                        <?php foreach($genres as $g): ?>
                        <span class="gelembung"><?= trim($g) ?></span>
                        <?php endforeach; ?>
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <span>Tahun Terbit</span>
                            <strong><?= $row['tahun'] ?></strong>
                        </div>
                        <div class="info-item">
                            <span>Penerbit</span>
                            <strong><?= $row ['penerbit'] ?></strong>
                        </div>
                        <div class="info-item">
                            <span>Jumlah buku</span>
                            <?php if($row['jumlah'] > 0): ?>
                                <strong style="color: #05343f;"><?= $row['jumlah'] ?> buah.</strong>
                            <?php else: ?>
                                <strong style="color: #9b1c1c;">Habis</strong>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="sipnosis-box">
                        <h3>Sipnosis</h3>
                        <p><?= $row['sipnosis'] ?></p>
                    </div>

                    <a href="baca.php?id=<?= $row['id'] ?>" class="btn-baca">Baca Sekarang</a>
                </div>
            </div>
        </div>
    </div>

    <?php endwhile; ?>
</div>

<script>
    function bukaModal(id){
        const modal = document.getElementById('modal-' + id);
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function tutupModal(id){
        const modal = document.getElementById('modal-' + id);
        modal.classList.remove('show');
        document.body.style.overflow = "auto";
    }

    window.onclick = function(event){
        if(event.target.classList.contains('latar-modal')){
            event.target.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    }
</script>

<?php include 'layout/footer.html' ?>
