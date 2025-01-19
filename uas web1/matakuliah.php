<?php
include 'config.php';

// Tambah Data
if (isset($_POST['tambah'])) {
    $kode_matakuliah = $_POST['kode_matakuliah'];
    $nama_matakuliah = $_POST['nama_matakuliah'];
    $sks = $_POST['sks'];

    $query = "INSERT INTO matakuliah (kode_matakuliah, nama_matakuliah, sks) 
              VALUES ('$kode_matakuliah', '$nama_matakuliah', '$sks')";
    mysqli_query($conn, $query);

    // Redirect untuk menghindari form resubmission
    header("Location: matakuliah.php");
    exit();
}

// Hapus Data
if (isset($_GET['hapus'])) {
    $kode_matakuliah = $_GET['hapus'];

    // Hapus data terkait di tabel perkuliahan terlebih dahulu
    $query_perkuliahan = "DELETE FROM perkuliahan WHERE kode_matakuliah='$kode_matakuliah'";
    mysqli_query($conn, $query_perkuliahan);

    // Hapus data dari tabel matakuliah
    $query_matakuliah = "DELETE FROM matakuliah WHERE kode_matakuliah='$kode_matakuliah'";
    mysqli_query($conn, $query_matakuliah);

    // Redirect untuk menghindari URL resubmission
    header("Location: matakuliah.php");
    exit();
}

// Edit Data
if (isset($_POST['update'])) {
    $kode_matakuliah = $_POST['kode_matakuliah'];
    $nama_matakuliah = $_POST['nama_matakuliah'];
    $sks = $_POST['sks'];

    $query = "UPDATE matakuliah 
              SET nama_matakuliah='$nama_matakuliah', sks='$sks' 
              WHERE kode_matakuliah='$kode_matakuliah'";
    mysqli_query($conn, $query);

    // Redirect untuk menghindari form resubmission
    header("Location: matakuliah.php");
    exit();
}

// Tampilkan Data
$result = mysqli_query($conn, "SELECT * FROM matakuliah");

// Jika user memilih data untuk diedit
$editData = null;
if (isset($_GET['edit'])) {
    $kode_matakuliah = $_GET['edit'];
    $editResult = mysqli_query($conn, "SELECT * FROM matakuliah WHERE kode_matakuliah='$kode_matakuliah'");
    $editData = mysqli_fetch_assoc($editResult);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mata Kuliah</title>
    <style>
        /* Gaya umum */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f0f5;
            color: #4a2545;
        }
        header {
            background-color: #8e4585;
            color: white;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        header h1 {
            margin: 0;
            font-size: 2rem;
        }
        main {
            padding: 20px;
            margin-top: 20px;
            margin-bottom: 40px;
        }
        main h2 {
            color: #8e4585;
            margin-bottom: 20px;
        }
        main form {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        main form input, 
        main form button {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        main form button {
            background-color: #8e4585;
            color: white;
            border: none;
            cursor: pointer;
        }
        main form button:hover {
            background-color: #732c6c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #8e4585;
            color: white;
        }
        table a {
            color: #8e4585;
            text-decoration: none;
        }
        table a:hover {
            text-decoration: underline;
        }
        footer {
            background-color: #8e4585;
            color: white;
            text-align: center;
            padding: 15px 0;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Data Mata Kuliah</h1>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Form Tambah Data -->
        <form method="POST">
            <h2>Tambah Data</h2>
            <input type="text" name="kode_matakuliah" placeholder="Kode Mata Kuliah" required>
            <input type="text" name="nama_matakuliah" placeholder="Nama Mata Kuliah" required>
            <input type="number" name="sks" placeholder="Jumlah SKS" required>
            <button type="submit" name="tambah">Tambah</button>
        </form>

        <!-- Form Edit Data (jika ada) -->
        <?php if (isset($editData)): ?>
        <form method="POST">
            <h2>Edit Data</h2>
            <input type="hidden" name="kode_matakuliah" value="<?= $editData['kode_matakuliah'] ?>" required>
            <input type="text" name="nama_matakuliah" placeholder="Nama Mata Kuliah" value="<?= $editData['nama_matakuliah'] ?>" required>
            <input type="number" name="sks" placeholder="Jumlah SKS" value="<?= $editData['sks'] ?>" required>
            <button type="submit" name="update">Update</button>
        </form>
        <?php endif; ?>

        <!-- Tabel Data Mata Kuliah -->
        <table>
            <thead>
                <tr>
                    <th>Kode Mata Kuliah</th>
                    <th>Nama Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($result) && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['kode_matakuliah'] ?></td>
                            <td><?= $row['nama_matakuliah'] ?></td>
                            <td><?= $row['sks'] ?></td>
                            <td>
                                <a href="matakuliah.php?edit=<?= $row['kode_matakuliah'] ?>">Edit</a> | 
                                <a href="matakuliah.php?hapus=<?= $row['kode_matakuliah'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Tidak ada data mata kuliah.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Dashboard Akademik. By: Baiq Nabila.</p>
    </footer>
</body>
</html>
