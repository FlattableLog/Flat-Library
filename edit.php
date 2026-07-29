<?php
include 'koneksi.php';

$error = "";

if(isset($_POST['ubah'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $tahun = $_POST['tahun'];
    $penerbit = $_POST['penerbit'];
    $kategori = $_POST['kategori'];
    $genre = $_POST['genre'];
    $sipnosis = $_POST['sipnosis'];
    $jumlah = $_POST['jumlah'];
    $sampulLama = $_POST['sampul_lama'];
    $ebookLama = $_POST['ebook-lama'];
    
    if(!isset($_FILES['sampul']) || $_FILES['sampul']['error'] == 4){
        $namaSampulBaru = $sampulLama;
    }else{
        $namaSampul = $_FILES['sampul']['name'];
        $tmpSampul = $_FILES['sampul']['tmp_name'];
        $ukuranSampul = $_FILES['sampul']['size'];

        $extSampul = strtolower(pathinfo($namaSampul, PATHINFO_EXTENSION));

        if($extSampul != 'webp'){
            $error = "Gagal: File harus format .WEBP!";
        }
            
        if($ukuranSampul >1000000){
            $error = "Gagal: ukuran file maksimum 1 MB!";
        }

        $namaSampulBaru = uniqid('cover_', true) . ".webp";

        
        if(move_uploaded_file( $tmpSampul, "asset/sampul/" . $namaSampulBaru)){ 
                if(!empty($sampulLama) && file_exists("asset/sampul/" . $sampulLama)){
                    unlink("asset/sampul/" . $sampulLama);
                }
        }
    }

    if(empty($error)){
        if(!isset($_FILES['ebook']) || $_FILES['ebook']['error'] == 4){
            $namaEbookBaru = $ebookLama;
        }else{
            $namaEbook = $_FILES['ebook']['name'];
            $tmpEbook = $_FILES['ebook']['tmp_name'];
            $ukuranEbook = $_FILES['ebook']['size'];

            $extEbook = strtolower(pathinfo($namaEbook, PATHINFO_EXTENSION));

            if($extEbook != 'pdf'){
                $error = "Gagal: File harus berformat .pdf!";
            }

            if($ukuranEbook > 10000000){
                $error = "Gagal: ukuran file maksimal 20 MB!";
            }

            $namaEbookBaru = uniqid('ebook_', true) . ".pdf";

            if(move_uploaded_file($tmpEbook, "asset/ebook/" . $namaEbookBaru)){
                if(!empty($ebookLama) && file_exists("asset/ebook/" . $ebookLama)){
                    unlink("asset/ebook/" . $ebookLama);
                }
            }
        }

    }

    //query sql update data
    if(empty($error)){
        $stmt = mysqli_prepare(
            $koneksi,
            "UPDATE buku
            SET judul=?,
                penulis=?,
                tahun=?,
                penerbit=?,
                kategori=?,
                genre=?,
                sipnosis=?,
                jumlah=?,
                sampul=?,
                ebook=?
            WHERE id=?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sssssssissi",
            $judul,
            $penulis,
            $tahun,
            $penerbit,
            $kategori,
            $genre,
            $sipnosis,
            $jumlah,
            $namaSampulBaru,
            $namaEbookBaru,
            $id
        );

        mysqli_stmt_execute($stmt);
    }
    header("location: daftarBuku.php");
    exit;
}

$data = mysqli_query($koneksi, "SELECT * from buku WHERE id = '$_GET[id]'");
$row = mysqli_fetch_array($data);
?>

<?php include 'layout/header.html' ?>

<div class="halaman-admin">
    <div class="form-container">
        <div class="form-header">
            <div class="icon-header">
                <i data-feather="book-open"></i>
            </div>
            <div>
                <h2>Edit Detail Buku</h2>
            </div>
        </div>

        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <div class="input-grid">
                <div class="input-group full-width">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" value="<?= $row['judul'] ?? '' ?>" required>
                </div>

                <div class="input-group">
                    <label>Nama Penulis</label>
                    <input type="text" name="penulis" value="<?= $row['penulis'] ?>" required>
                </div>

                <div class="input-group">
                    <label>Penerbit</label>
                    <input type="text" name="penerbit" value="<?= $row['penerbit'] ?>" required>
                </div>

                <div class="input-group">
                    <label>Tahun Terbit</label>
                    <input type="number" name="tahun" value="<?= $row['tahun'] ?>" required>
                </div>

                <div class="input-group">
                    <label>Genre</label>
                    <input type="text" name="genre" value="<?= $row['genre'] ?>" required>
                </div>

                <div class="input-group full-width">
                    <label>Sinopsis</label>
                    <textarea name="sipnosis" rows="4" required><?= $row['sipnosis'] ?></textarea>
                </div>

                <div class="input-group">
                    <label>Jumlah Stok</label>
                    <input type="number" name="jumlah" value="<?= $row['jumlah'] ?>" required>
                </div>

                <div class="input-group">
                    <label>Kategori</label>
                    <select name="kategori" required>
                        <option value="Fiksi" <?= ($row['kategori'] == 'Fiksi') ? 'selected' : '' ?>>Fiksi</option>
                        <option value="non-Fiksi" <?= ($row['kategori'] == 'non-Fiksi') ? 'selected' : '' ?>>non-Fiksi</option>
                    </select>
                </div>
            </div>

            <div class="input-group full-width" style="margin-bottom: 1.5rem;">
                <label style="font-size: 0.9rem; font-weight: 600; color: #374151; display: block; margin-bottom: 8px;">
                    Ganti File Ebook (.pdf)
                </label>
                <input type="hidden" name="ebook-lama" value="<?= $row['ebook'] ?>">
                
                <input type="file" name="ebook" accept=".pdf" 
                       style="width: 100%; padding: 12px 15px; border-radius: 10px; border: 2px dashed #cbd5e1; background-color: #f8fafc; cursor: pointer;">
                
                <small style="color: #64748b; margin-top: 5px; display: block;">
                    * Biarkan kosong jika tidak ingin mengganti PDF saat ini. (File aktif: <strong><?= $row['ebook'] ?: 'Belum ada file' ?></strong>)
                </small>
            </div>

            <div class="upload-section">
                <label>Sampul Buku (.webp)</label>
                <input type="file" name="sampul" id="file-sampul" accept=".webp" hidden>
                <input type="hidden" name="sampul_lama" value="<?= $row['sampul'] ?>">

                <div class="upload-area" id="drop-zone">
                    <div class="upload-content" id="upload-content" style="<?= !empty($row['sampul']) ? 'display: none;' : '' ?>">
                        <span class="upload-area-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--secondary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        </span>
                        <span class="upload-area-title">Taruh sampul baru disini!</span>
                        <span class="upload-area-description">
                            Atau<br><strong>klik disini</strong>.
                        </span>
                    </div>

                    <img id="preview" src="<?= !empty($row['sampul']) ? 'asset/sampul/' . $row['sampul'] : '' ?>" style=" <?= !empty($row['sampul']) ? 'display:block;' : 'display:none;' ?>" >
                </div>
            </div>
           
            <div class="form-footer">
                <a href="daftarBuku.php" class="btn-batal">Batal</a>
                <button type="submit" name="ubah" class="btn-simpan">Selesai</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function(){
            const dropZone = document.getElementById('drop-zone');
            const fileInput = document.getElementById('file-sampul');
            const previewImg = document.getElementById('preview');
            const uploadContent = document.getElementById('upload-content');

            if(previewImg.src && previewImg.src !== window.location.href){
                previewImg.style.display = 'block';
                uploadContent.style.display = 'none';
            }

            dropZone.addEventListener('click', () => {
                fileInput.click();
            });

            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('dragover');
            });

            dropZone.addEventListener('dragleave', () => {
                dropZone.classList.remove('dragover');
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('dragover');

                if(e.dataTransfer.files.length > 0){
                    fileInput.files = e.dataTransfer.files;
                    tampilkanPreview(fileInput.files[0]);
                }
            });

            fileInput.addEventListener('change', function(){
                if(fileInput.files.length > 0){
                    tampilkanPreview(fileInput.files[0]);
                }
            })

            function tampilkanPreview(file){
                if(file && file.name.toLowerCase().endsWith('.webp')) {
                    const reader = new FileReader();
                    reader.onload = function(event){
                        previewImg.src = event.target.result;
                        previewImg.style.display = 'block';
                        uploadContent.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                }else{
                    alert("Pastikan gambar dengan format .webp!");
                    fileInput.value = "";
                }
            }
        })
    </script>

    <?php if(!empty($error)): ?>
        <script>
            alert("<?= $error ?>");
        </script>
    <?php endif; ?>
</div>

<?php include 'layout/footer.html' ?>