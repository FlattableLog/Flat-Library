
# 📚 Flat Library

> A simple web-based library management system built with **PHP Native** and **MySQL**.

![PHP](https://img.shields.io/badge/PHP-Native-777BB4?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

---

## 📖 About

Flat Library is a web application developed to manage a digital book collection. It provides features for adding, editing, deleting, and reading books directly from the browser.

This project was built as a learning project using **PHP Native**, **MySQL**, **HTML**, **CSS**, and **JavaScript** without using any framework.

---

## ✨ Features

- 📚 Display book collection
- ➕ Add new books
- ✏️ Edit book information
- ❌ Delete books
- 📖 Read PDF books directly in browser
- 🖼 Upload book cover images
- 📝 Book synopsis
- 🏷 Category & Genre
- 📦 Book stock management

---

## 🛠 Built With

- PHP Native
- MySQL
- HTML5
- CSS3
- JavaScript
- XAMPP

---

## 📋 Requirements

- PHP 8.0 or later
- MySQL 5.7+
- Apache Server
- XAMPP (recommended)
- Modern Web Browser

## 📂 Project Structure

```text
Flat-Library/
│
├── asset/
│   ├── ebook/
│   ├── sampul/
│   └── ...
│
├── database/
│   └── perpustakaan.sql
│
├── layout/
├── style/
│
├── baca.php
├── daftarBuku.php
├── edit.php
├── hapus.php
├── index.php
├── jumlah.php
├── koneksi.php
├── tambah.php
│
└── README.md
```

---

## 🚀 Installation

### 1. Clone Repository

```bash
git clone https://github.com/FlattableLog/Flat-Library.git
```

### 2. Move Project
</> Markdown
Move the cloned project into your XAMPP `htdocs` directory:

### 3. Import Database

Open **phpMyAdmin**

Create database:

```
perpustakaan
```

Import:

```
database/perpustakaan.sql
```

### 4. Configure Database

</> Markdown
Open phpMyAdmin and create a new database named:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "perpustakaan";
```

### 5. Run

Start **Apache** and **MySQL** from XAMPP.

Open:

```
http://localhost/perpustakaan
```

---

## 📸 Screenshots

### Home Page
Main page displaying the latest book collection and quick navigation.

![Home](screenshots/home1.png)
![Home](screenshots/home2.png)

### Book Detail
Displays complete information about the selected book.

![Detail](screenshots/detailBuku.png)

### Book List

![List](screenshots/daftarBuku.png)

### Add Book

![Add](screenshots/tambahBuku.png)

### Edit book

![Edit](screenshots/editBuku.png)

### PDF Reader

![Reader](screenshots/PDFreader.png)


## 🎯 Future Improvements

- Search books
- Pagination
- User authentication
- Admin dashboard
- Responsive mobile design
- Dark mode
- Book borrowing system
- Multi-user support

---

## 👨‍💻 Author

**Ahmad Hendra Adikurnia**

GitHub

https://github.com/FlattableLog

---

## 💡 Key Learning Outcomes

During this project, I practiced:

- CRUD operations using PHP Native
- File upload handling (PDF & image)
- MySQL database design
- Dynamic data rendering
- Form validation
- Responsive UI with HTML & CSS
- Organizing a small-scale web application


## 📄 License

This project is intended for educational purposes.
