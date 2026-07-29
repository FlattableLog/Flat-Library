<?php
include 'koneksi.php';

$batas_per_halaman = 10;
$halaman_aktif = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$mulai = ($halaman_aktif > 1) ? ($halaman_aktif * $batas_per_halaman) - $batas_per_halaman : 0;

$query_total = mysqli_query($koneksi, "SELECT id FROM buku");
$total_data = mysqli_num_rows($query_total);
$total_halaman = ceil($total_data/$batas_per_halaman);

$data = mysqli_query($koneksi, "SELECT * FROM buku LIMIT $mulai, $batas_per_halaman");
?>

<?php include 'layout/header.html' ?>

<div class="halaman-admin">
    <div class="table-container">
        <div class="table-header">
            <h2>Daftar Buku</h2>
            <a href="tambah.php" class="btn-tambah">
                <i data-feather="plus"></i> Tambah Buku
            </a>
        </div>

        <div class="table-responsive">
            <table class="table-main">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Cover</th>
                        <th>Judul Buku & Penulis</th> 
                        <th>Tahun</th>
                        <th>Penerbit</th>
                        <th>Genre</th>
                        <th><span style="margin-left: 28%;">Stok</span></th>
                        <th><span style="margin-left: 20%;"> Aksi</span></th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php
                    $no = $mulai + 1;
                    while ($row = mysqli_fetch_array($data)) {
                        $genres = explode(',', $row['genre']); 
                    ?>
                    <tr>
                        <td><span style="font-size: 0.9rem; color: black; margin-left: 5px;"><?= $no++ ?></span></td>
                        <td class="col-cover">
                            <img src="asset/sampul/<?= $row['sampul']?>" alt="Cover <?= $row['judul']?>">
                        </td>

                        <td class="col-info">
                            <p class="judul"><?= $row['judul']?></p>
                            <p class="penulis">@<?= strtolower(str_replace(' ', '', $row['penulis'])) ?></p> 
                        </td>
                        <td><?= $row['tahun']?></td>
                        <td><?= $row['penerbit']?></td>

                        <td class="col-genre">
                            <div class="bungkus-genre">
                                <?php foreach($genres as $g): ?>
                                    <span class="badge-genre"><?= trim($g) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </td>
                        <td class="col-stok">
                            <div class="stok-kontrol">
                                <a href="jumlah.php?aksi=kurang&id=<?= $row['id'] ?>" class="btn-kurang">-</a>
                                <span class="angka"><?= $row['jumlah']?></span>
                                <a href="jumlah.php?aksi=tambah&id=<?= $row['id'] ?>" class="btn-tambah">+</a>
                            </div>
                        </td>
                        <td class="col-aksi">
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                            <a href="hapus.php?id=<?= $row['id']?>" onclick="return confirm('Yakin ingin menghapus buku <?= $row['judul']?>?')" class="btn-hapus">Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php if($total_halaman > 1): ?>
            <div class="pagination">
                <?php for($i = 1; $i <= $total_halaman; $i++): ?>
                    <a href="?halaman=<?= $i ?>" class="<?= ($i == $halaman_aktif) ? 'aktif' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'layout/footer.html' ?>