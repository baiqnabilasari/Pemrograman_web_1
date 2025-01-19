<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Akademik</title>
    <style>
        /* Gaya untuk body */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f0f5; /* Warna latar pink keunguan sangat terang */
            color: #4a2545; /* Warna teks keunguan gelap */
        }

        /* Gaya untuk header */
        header {
            background-color: #8e4585; /* Warna pink keunguan tua */
            color: white; /* Warna teks putih */
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        /* Gaya untuk konten utama */
        main {
            padding: 40px 20px;
            text-align: center;
        }

        main h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #8e4585; /* Warna pink keunguan tua */
        }

        main p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        main ul {
            list-style-type: none;
            padding: 0;
            margin: 0 auto;
            display: inline-block; /* Membuat daftar tetap berada di tengah */
        }

        main ul li {
            margin: 15px 0;
        }

        main ul li a {
            text-decoration: none;
            font-size: 1.2rem;
            color: #8e4585; /* Warna teks pink keunguan tua */
            padding: 10px 30px;
            border: 2px solid #8e4585; /* Warna border pink keunguan tua */
            border-radius: 5px;
            transition: all 0.3s ease;
            display: inline-block; /* Memastikan tombol terlihat rapi */
        }

        main ul li a:hover {
            background-color: #8e4585; /* Warna pink keunguan tua saat hover */
            color: white; /* Warna teks putih saat hover */
        }

        /* Gaya untuk footer */
        footer {
            background-color: #8e4585; /* Warna pink keunguan tua */
            color: white; /* Warna teks putih */
            text-align: center;
            padding: 15px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }

        footer p {
            margin: 0;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Dashboard Akademik</h1>
    </header>

    <!-- Main Content -->
    <main>
        <h2>Selamat Datang di Dashboard Akademik</h2>
        <p>Silakan pilih menu berikut untuk melanjutkan:</p>
        <ul>
            <li><a href="mahasiswa.php">Data Mahasiswa</a></li>
            <li><a href="dosen.php">Data Dosen</a></li>
            <li><a href="matakuliah.php">Data Mata Kuliah</a></li>
            <li><a href="perkuliahan.php">Data Perkuliahan</a></li>
        </ul>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Dashboard Akademik. By: Baiq Nabila.</p>
    </footer>
</body>
</html>
