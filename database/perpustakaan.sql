-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2026 at 04:36 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `penulis` varchar(50) NOT NULL,
  `penerbit` varchar(50) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `tahun` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `sampul` varchar(255) NOT NULL,
  `ebook` varchar(255) NOT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `sipnosis` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `judul`, `penulis`, `penerbit`, `kategori`, `tahun`, `jumlah`, `sampul`, `ebook`, `genre`, `sipnosis`) VALUES
(32, 'Komet', 'Tere Liye', 'PT Gramedia Pustaka Utama', 'Fiksi', 2018, 1, 'cover_6a3d75005c8903.47387099.webp', 'ebook_6a3d7b084d3224.59397936.pdf', 'aksi, petualangan', 'Setelah \"musuh besar\" kami lolos, dunia pararel dalam situasi genting. Hanya soal waktu, kapan pun pertempuran besar akan terjadi. Bagaimana jika ribuan petarung yang bisa menghilang, mengeluarkan petir, termasuk teknologi maju lainnya muncul di permukaan bumi? Tidak ada yang bisa membayangkan kekacauan yang akan terjadi. Situasi menjadi lebih rumit lagi saat Ali, pada detik terakhir, melompat ke portal menuju Klan Komet. Kami bertiga tersesat di klan asing untuk mencari pusaka paling hebat di dunia pararel.\r\n\r\nBuku ini berkisah tentang petualangan tiga sahabat. Raib bisa menghilang. Seli bisa mengeluarkan petir. Dan Ali bisa melakukan apa saja. Buku ini juga berkisah tentang persahabatan yang mengharukan, pengorbanan yang tulus, keberanian, dan selalu berbuat baik. Karena sejatinya, itulah kekuatan terbesar di dunia pararel.'),
(33, 'Start With Why', 'Simon Sinek', 'Penguin Group', 'non-Fiksi', 2009, 1, 'cover_6a3d730ebee2f1.78809593.webp', 'ebook_6a3d7b12e6d5c5.70059890.pdf', 'Bisnis, Manajemen, Pengembangan Diri', 'Apakah Wright bersaudara, Martin Luther King Jr, dan perusahaan Apple\r\nadalah sosok dengan kualitas terbaik pada masanya? Mungkin kebanyakan\r\norang akan menjawab \"Ya\" namun kenyataannya tidak. Mereka adalah\r\ncontoh pemimpin yang sukses bukan karena hanya mereka satu-satunya\r\nyang memiliki keterampilan di bidang yang mereka tekuni. Kunci kesuksesan\r\nmereka adalah mampu menginspirasi orang lain dan memulai segalanya\r\ndengan \"Mengapa\" (Why).\r\nDalam buku ini Simon Sinek, seorang entrepreneur, menjelaskan mengapa\r\nbeberapa pemimpin dan perusahaan sukses sedangkan yang lain tidak, yaitu\r\ndengan filosofi Lingkaran Emas (Golden Circle). Menurutnya, kebanyakan\r\npemimpin berbicara tentang APA yang mereka lakukan, yaitu produk atau\r\npelayanan yang menghasilkan uang bagi mereka. Lalu beberapa pemimpin\r\nberbicara tentang BAGAIMANA proses membuat produk/jasa tersebut yang\r\nmembuat mereka istimewa. Namun, hanya sedikit pemimpin yang berbicara\r\ntentang MENGAPA, yaitu alasan mengapa mereka melakukan pekerjaan\r\ntersebut.'),
(34, 'Pulang', 'Tere Liye', 'Republika', 'Fiksi', 2015, 1, 'cover_6a3d7471c59194.74205516.webp', 'ebook_6a3d7b1d3c1b15.03584238.pdf', 'aksi, petualangan', 'Sebuah kisah tentang perjalanan pulang, melalui pertarungan demi pertarungan, kesedihan demi kesedihan, untuk memeluk erat semua kebencian dan rasa sakit. Pulang.'),
(35, 'Rahasia Menulis Kreatif', 'Raditya Dika', 'Gagas Media', 'non-Fiksi', 2010, 1, 'cover_6a3d7852bd1d32.27503391.webp', 'ebook_6a3d7ae6c3ad26.36497741.pdf', 'Edukasi', 'Buku \'Rahasia Menulis Kreatif\' oleh Raditya Dika\r\nmengupas teknik dan strategi dalam menulis fiksi, mulai\r\ndari persiapan, penggalian ide, hingga pengembangan\r\nkarakter dan struktur cerita. Penulis juga menekankan\r\npentingnya editing dan promosi setelah penulisan untuk\r\nmencapai kesuksesan. Dengan pendekatan yang\r\npraktis, buku ini memberikan wawasan berharga bagi\r\npenulis yang ingin mengasah keterampilan menulis\r\nmereka.'),
(36, 'Hands-on Mahine Learning With C++', 'Kirll Kolodiazhnyi', 'Packt Publishing Ltd.', 'non-Fiksi', 2020, 1, 'cover_6a3e30d999f407.87685546.webp', 'ebook_6a3e30d999f8d8.96687852.pdf', 'Edukasi, Programming', 'Build, Train, and Deploy end-to-end Machine Learning and deep learning pipelines'),
(38, 'MEGA BANK SMBPTN SAINTEK 2017', 'The King Eduka', 'Cmedia Imprint Kawan Pustaka', 'non-Fiksi', 2016, 1, 'cover_6a3e345015b4e9.07949446.webp', 'ebook_6a3e345015b650.93143028.pdf', 'Edukasi', 'Kumpulan soal SMBPTN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
