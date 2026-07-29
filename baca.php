<?php
include 'koneksi.php';

$id = $_GET['id'] ?? 0;
$data = mysqli_query($koneksi, "SELECT * FROM buku WHERE id = '$id'");
$row = mysqli_fetch_array($data);

if (!$row || empty($row['ebook'])) {
    die("Buku tidak ditemukan atau file Ebook belum diunggah!");
}

$file_pdf = "asset/ebook/" . $row['ebook'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membaca: <?= $row['judul'] ?></title>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf_viewer.min.css">
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        :root {
            --bg-main: #f0f2f5;
            --sidebar-bg: #ffffff;
            --sidebar-active: #e6f4f1;
            --sidebar-icon: #64748b;
            --sidebar-icon-active: #0f766e;
            --text-dark: #334155;
            --book-bg: #ffffff;
            --border-color: rgba(0,0,0,0.05);
            --arrow-bg: #ffffff;
            --arrow-hover: #f8fafc;
        }

        body.dark-mode {
            --bg-main: #0f172a;
            --sidebar-bg: #1e293b;
            --sidebar-active: #334155;
            --sidebar-icon: #94a3b8;
            --sidebar-icon-active: #38bdf8;
            --text-dark: #f8fafc;
            --book-bg: #ffffff; 
            --border-color: rgba(255,255,255,0.05);
            --arrow-bg: #334155;
            --arrow-hover: #475569;
        }

        body.dark-mode .book-page-container {
            filter: invert(1) hue-rotate(180deg) contrast(85%);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: var(--bg-main);
            height: 100vh; 
            display: flex; 
            overflow: hidden; 
            transition: background-color 0.3s;
        }

       
        .sidebar-mini {
            width: 70px;
            background-color: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
            gap: 20px;
            box-shadow: 2px 0 10px var(--border-color);
            z-index: 20;
            transition: background-color 0.3s;
        }

        .side-icon {
            width: 45px;
            height: 45px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 12px;
            color: var(--sidebar-icon);
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            border: none;
            background: transparent;
        }

        .side-icon:hover { background-color: var(--sidebar-active); color: var(--text-dark); }
        .side-icon.active { background-color: var(--sidebar-active); color: var(--sidebar-icon-active); }
        
        .spacer { flex-grow: 1; }

        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .top-header {
            height: 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 40px;
            background-color: transparent;
            z-index: 10;
        }

        .book-meta { text-align: center; flex-grow: 1; }
        .book-meta h1 { font-size: 1.1rem; color: var(--text-dark); margin-bottom: 2px; }
        .book-meta p { font-size: 0.85rem; color: var(--sidebar-icon); }

        .header-actions { display: flex; align-items: center; gap: 10px; color: var(--sidebar-icon); }
        
        .btn-action {
            background: transparent;
            border: none;
            color: var(--sidebar-icon);
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            display: flex;
            align-items: center;
        }
        .btn-action:hover { background-color: var(--sidebar-active); color: var(--text-dark); }

        .reader-layout {
            position: relative;
            flex-grow: 1;
            overflow: hidden; 
            display: flex;
        }

        .reader-wrapper {
            flex-grow: 1;
            overflow: auto; 
            padding: 2rem 5rem; 
            display: flex;
            justify-content: center;
            align-items: flex-start; 
        }

        .book-page-container {
            position: relative;
            background: var(--book-bg);
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border-radius: 4px 12px 12px 4px;
            margin-bottom: 50px; 
            transition: filter 0.3s;
        }

        .book-page-container::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 30px;
            background: linear-gradient(to right, rgba(0,0,0,0.05) 0%, rgba(0,0,0,0) 100%);
            z-index: 5;
            pointer-events: none;
        }

        .page-wrapper { position: relative; }
        canvas { display: block; border-radius: inherit; }

        .textLayer {
            position: absolute;
            left: 0; top: 0; right: 0; bottom: 0;
            overflow: hidden; opacity: 0.2; line-height: 1.0;
        }
        .textLayer span {
            color: transparent; position: absolute;
            white-space: pre; cursor: text; transform-origin: 0% 0%;
        }

        .nav-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--arrow-bg);
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            color: var(--sidebar-icon);
            z-index: 15;
            transition: all 0.2s;
        }

        .nav-arrow:hover {
            background-color: var(--arrow-hover);
            color: var(--text-dark);
            transform: translateY(-50%) scale(1.1); 
        }

        .left-arrow { left: 20px; }
        .right-arrow { right: 20px; }

        ::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }
        
        ::-webkit-scrollbar-track { 
            background: var(--bg-main); 
        }
        
        ::-webkit-scrollbar-thumb { 
            background: #cbd5e1; 
            border-radius: 6px; 
            border: 3px solid var(--bg-main); 
        }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        body.dark-mode ::-webkit-scrollbar-track { 
            background: var(--bg-main); 
        }
        body.dark-mode ::-webkit-scrollbar-thumb { 
            background: #475569; 
            border-color: var(--bg-main);
        }
        body.dark-mode ::-webkit-scrollbar-thumb:hover { 
            background: #64748b; 
        }

        #toast {
            visibility: hidden;
            min-width: 250px;
            background-color: blue; 
            color: yellow;
            text-align: center;
            border-radius: 50px;
            padding: 16px;
            position: fixed;
            z-index: 1000;
            left: 50%;
            bottom: 30px;
            transform: translateX(-50%);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            font-weigth: bold;
            font-size: 1.2rem;
        }

        #toast.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 1.5s;
        }

        @keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 60px; opacity: 1;}
        }

        @keyframes fadeout {
            from {bottom: 60px; opacity: 1;}
            to {bottom: 0; opacity: 0;}
        }
    </style>
</head>
<body>

    <aside class="sidebar-mini">
        <a href="index.php" class="side-icon" title="Kembali ke Beranda"><i data-feather="home"></i></a>
        <button class="side-icon active" title="Membaca"><i data-feather="book-open"></i></button>
        <button class="side-icon" id="btn-bookmark" title="Tandai Halaman (Bookmark)"><i data-feather="bookmark"></i></button>
        
        <div class="spacer"></div> <button class="side-icon" id="btn-dark-mode" title="Mode Malam"><i data-feather="moon"></i></button>
    </aside>

    <main class="main-content">
        <header class="top-header">
            <div style="width: 100px;"></div> <div class="book-meta">
                <h1><?= $row['judul'] ?></h1>
                <p>Halaman <span id="page-num">1</span> dari <span id="page-count-display">...</span></p>
            </div>
            
            <div class="header-actions">
                <button class="btn-action" id="btn-zoom-out" title="Perkecil (-)"><i data-feather="zoom-out"></i></button>
                <span id="zoom-val" style="font-size: 0.85rem; font-weight: bold; width: 45px; text-align: center;">130%</span>
                <button class="btn-action" id="btn-zoom-in" title="Perbesar (+)"><i data-feather="zoom-in"></i></button>
            </div>
        </header>

        <div class="reader-layout">
            <button class="nav-arrow left-arrow" id="btn-prev"><i data-feather="chevron-left"></i></button>
            
            <div class="reader-wrapper">
                <div class="book-page-container">
                    <div class="page-wrapper" id="page-wrapper">
                        <canvas id="pdf-render"></canvas>
                        <div id="text-layer" class="textLayer"></div>
                    </div>
                </div>
            </div>

            <button class="nav-arrow right-arrow" id="btn-next"><i data-feather="chevron-right"></i></button>
        </div>
    </main>

    <div id="toast"></div>

    <script>
        feather.replace();

        const url = '<?= $file_pdf ?>';
        const bookId = 'buku_<?= $id ?>'; 
        
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

        let pdfDoc = null,
            pageNum = 1,
            pageIsRendering = false,
            pageNumIsPending = null,
            scale = 1.3, 
            canvas = document.querySelector('#pdf-render'),
            ctx = canvas.getContext('2d'),
            textLayerDiv = document.querySelector('#text-layer'),
            pageWrapper = document.querySelector('#page-wrapper');

        const renderPage = num => {
            pageIsRendering = true;

            pdfDoc.getPage(num).then(page => {
                const viewport = page.getViewport({ scale: scale });
                
                pageWrapper.style.width = viewport.width + "px";
                pageWrapper.style.height = viewport.height + "px";
                canvas.width = viewport.width;
                canvas.height = viewport.height;

                const renderCtx = { canvasContext: ctx, viewport: viewport };

                page.render(renderCtx).promise.then(() => {
                    pageIsRendering = false;
                    if (pageNumIsPending !== null) {
                        renderPage(pageNumIsPending);
                        pageNumIsPending = null;
                    }
                });

                page.getTextContent().then(textContent => {
                    textLayerDiv.innerHTML = '';
                    pdfjsLib.renderTextLayer({
                        textContent: textContent,
                        container: textLayerDiv,
                        viewport: viewport,
                        textDivs: []
                    });
                });

                document.querySelector('#page-num').textContent = num;
                document.querySelector('#zoom-val').textContent = Math.round(scale * 100) + '%';
                
                cekBookmark();
            });
        };

        const queueRenderPage = num => {
            if (pageIsRendering) { pageNumIsPending = num; } 
            else { renderPage(num); }
        };

        document.querySelector('#btn-prev').addEventListener('click', () => {
            if (pageNum <= 1) return;
            pageNum--;
            queueRenderPage(pageNum);
        });

        document.querySelector('#btn-next').addEventListener('click', () => {
            if (pageNum >= pdfDoc.numPages) return;
            pageNum++;
            queueRenderPage(pageNum);
        });

        document.querySelector('#btn-zoom-in').addEventListener('click', () => {
            if(scale >= 3.0) return; 
            scale += 0.2;
            queueRenderPage(pageNum);
        });

        document.querySelector('#btn-zoom-out').addEventListener('click', () => {
            if(scale <= 0.7) return; 
            scale -= 0.2;
            queueRenderPage(pageNum);
        });

        document.querySelector('#btn-dark-mode').addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            const iconElement = document.querySelector('#btn-dark-mode i');
            if(document.body.classList.contains('dark-mode')) {
                iconElement.setAttribute('data-feather', 'sun');
            } else {
                iconElement.setAttribute('data-feather', 'moon');
            }
            feather.replace(); 
        });

        function cekBookmark() {
            const savedPage = localStorage.getItem(bookId);
            const btnBookmark = document.querySelector('#btn-bookmark');
            
            if (savedPage && parseInt(savedPage) === pageNum) {
                btnBookmark.classList.add('active'); 
            } else {
                btnBookmark.classList.remove('active'); 
            }
        }

        function showToast(msg) {
            const toast = document.getElementById("toast");
            toast.textContent = msg;
            toast.className = "show";
            setTimeout(function(){ toast.className = ""; }, 2000);
        }

        document.querySelector('#btn-bookmark').addEventListener('click', () => {
            const savedPage = localStorage.getItem(bookId);
            
            if (savedPage && parseInt(savedPage) === pageNum) {
                localStorage.removeItem(bookId);
                showToast('Bookmark dihapus.'); 
            } else {
                localStorage.setItem(bookId, pageNum);
                showToast('Halaman ' + pageNum + ' berhasil ditandai!'); 
            }
            cekBookmark(); 
        });

        pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
            pdfDoc = pdfDoc_;
            document.querySelector('#page-count-display').textContent = pdfDoc.numPages;
            
            const savedPage = localStorage.getItem(bookId);
            if (savedPage && parseInt(savedPage) <= pdfDoc.numPages) {
                pageNum = parseInt(savedPage); 
            }
            
            renderPage(pageNum);
        });
    </script>
</body>
</html>