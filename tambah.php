<?php
include 'koneksi.php';

$error = "";

//proses menambahkan data
if (isset($_POST['tambah'])) {
    $judul = $_POST ['judul'];
    $penulis = $_POST ['penulis'];
    $tahun = $_POST ['tahun'];
    $penerbit = $_POST ['penerbit'];
    $kategori = $_POST['kategori'];
    $genre = $_POST['genre'];
    $sipnosis = $_POST['sipnosis'];
    $jumlah = $_POST ['jumlah'];

    if(isset($_FILES['sampul']) && $_FILES['sampul']['error'] != 4){
        $namaSampul = $_FILES['sampul']['name'];
        $tmpSampul = $_FILES['sampul']['tmp_name'];
        $ukuranSampul = $_FILES['sampul']['size'];

        $extSampul = strtolower(pathinfo($namaSampul, PATHINFO_EXTENSION));

        if($extSampul != 'webp'){
            $error = "Gagal: File harus format .WEBP";
        }elseif($ukuranSampul > 1000000){
            $error = "Gagal: maksimum ukuran file 1 MB";
        }
    }else{
        $error = "Gagal: Anda belum mengunggah sampul!";
    }

    if(isset($_FILES['ebook']) && $_FILES['ebook']['error'] !=4){
        $namaEbook = $_FILES['ebook']['name'];
        $tmpEbook = $_FILES['ebook']['tmp_name'];
        $ukuranEbook = $_FILES['ebook']['size'];

        $extEbook = strtolower(pathinfo($namaEbook, PATHINFO_EXTENSION));

        if($extEbook != 'pdf'){
            $error = "Gagal: Ebook harus berformat .pdf";
        }elseif($ukuranEbook > 20000000){
            $error = "Gagal: maksimum ukuran file 20 MB";
        }
    }else{
        $error = "Gagal: anda belum mengunggah ebook!";
    }

    //query sql insert buku jika tidak ada error
    if(empty($error)){  
        $namaSampulBaru = uniqid('cover_', true) . ".webp";
        $namaEbookBaru = uniqid('ebook_', true) . ".pdf";
        
        $uploadSampul = move_uploaded_file( $tmpSampul, "asset/sampul/" . $namaSampulBaru);
        $uploadEbook = move_uploaded_file($tmpEbook, "asset/ebook/" . $namaEbookBaru);

        if($uploadSampul && $uploadEbook){
            $stmt = mysqli_prepare(
                $koneksi,
                "INSERT INTO buku
                (judul, penulis, tahun, penerbit, kategori, genre, sipnosis, jumlah, sampul, ebook)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "sssssssiss",
                $judul,
                $penulis,
                $tahun,
                $penerbit,
                $kategori,
                $genre,
                $sipnosis,
                $jumlah,
                $namaSampulBaru,
                $namaEbookBaru
            );

            mysqli_stmt_execute($stmt);
            header("location:daftarBuku.php");
            exit;
        }else{
            $error = "Gagal upload file.";
        }

    }
};
?>

<?php include 'layout/header.html' ?>

<div class="halaman-admin">
    <div class="form-container">
        <div class="form-header">
            <div class="icon-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"></path></svg>
            </div>
            <div>
                <h2>Tambah Buku</h2>
            </div>
        </div>

        <form method="POST" enctype="multipart/form-data">
            <div class="input-grid">
                <div class="input-group full-width">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" value="<?= $_POST['judul'] ?? '' ?>" placeholder="Contoh: Harry Potter" required>
                </div>

                <div class="input-group">
                    <label>Nama Penulis</label>
                    <input type="text" name="penulis" value="<?= $_POST['penulis'] ?? '' ?>" placeholder="Contoh: J.K. Rowling" required>
                </div>

                <div class="input-group">
                    <label>Penerbit</label>
                    <input type="text" name="penerbit" value="<?= $_POST['penerbit'] ?? '' ?>" placeholder="Contoh: Gramedia" required>
                </div>

                <div class="input-group">
                    <label>Tahun Terbit</label>
                    <input type="number" name="tahun" value="<?= $_POST['tahun'] ?? '' ?>" placeholder="Contoh: 2001" required>
                </div>

                <div class="input-group">
                    <label>Genre</label>
                    <input type="text" name="genre" value="<?= $_POST['genre'] ?? '' ?>" placeholder="Contoh: Fantasi, Petualangan" required>
                </div>

                <div class="input-group full-width">
                    <label>Sinopsis</label>
                    <textarea name="sipnosis" rows="4" placeholder="Tuliskan deskripsi singkat atau sinopsis buku di sini..." required><?= $_POST['sipnosis'] ?? '' ?></textarea>
                </div>

                <div class="input-group">
                    <label>Jumlah Stok</label>
                    <input type="number" name="jumlah" value="<?= $_POST['jumlah'] ?? '' ?>" placeholder="0" required>
                </div>

                <div class="input-group">
                    <label>Kategori</label>
                    <select name="kategori" required>
                        <option value="" disabled selected>Pilih Kategori...</option>
                        <option value="FIksi">Fiksi</option>
                        <option value="non-Fiksi">non-Fiksi</option>
                    </select>
                </div>
            </div>

            <div class="input-group full-width" style="margin-bottom: 1.5rem;">
                <label style="font-size: 0.9rem; font-weight: 600; color: #374151; display: block; margin-bottom: 8px;">
                    File Ebook (.pdf)
                </label>
                <input type="file" name="ebook" accept=".pdf" required 
                       style="width: 100%; padding: 12px 15px; border-radius: 10px; border: 2px dashed #cbd5e1; background-color: #f8fafc; cursor: pointer;">
                <small style="color: #64748b; margin-top: 5px; display: block;">* Maksimal ukuran file 20MB.</small>
            </div>

            <div class="upload-section">
                <label>Sampul Buku (.webp)</label>
                <input type="file" name="sampul" id="file-sampul" accept=".webp" hidden>

                <div class="upload-area" id="drop-zone">
                    <div class="upload-content" id="upload-content">
                        <span class="upload-area-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--secondary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        </span>
                        <span class="upload-area-title">Taruh sampul disini!</span>
                        <span class="upload-area-description">
                            Atau, upload dengan <br><strong>klik disini</strong>.
                        </span>
                    </div>

                    <img id="preview" style="display: none;" >
                </div>
            </div>
           
            <div class="form-footer">
                <a href="daftarBuku.php" class="btn-batal">Batal</a>
                <button type="submit" name="tambah" class="btn-simpan">Tambahkan</button>
            </div>
        </form>
    </div>

    <script>
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('file-sampul');
        const previewImg = document.getElementById('preview');
        const uploadContent = document.getElementById('upload-content');

        dropZone.addEventListener('click', () => fileInput.click());

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

        fileInput.addEventListener('change', () => {
            if(fileInput.files.length > 0){
                tampilkanPreview(fileInput.files[0]);
            }
        })

        function tampilkanPreview(file){
            if(file && file.name.toLowerCase().endsWith('.webp')){
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImg.src = event.target.result;
                    previewImg.style.display = 'block';
                    uploadContent.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }else{
                alert("Pastikan file .webp!");
                fileInput.value = "";
            }
        }
    </script>

    <?php if(!empty($error)): ?>
        <script>
            alert("<?= $error ?>");
        </script>
    <?php endif; ?>
</div>

<?php include 'layout/footer.html' ?>