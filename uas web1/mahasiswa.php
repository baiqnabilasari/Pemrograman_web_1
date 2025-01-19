<?php
include 'config.php';

// Tambah Data
if (isset($_POST['tambah'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    $query = "INSERT INTO mahasiswa (nim, nama_mhs, tgl_lahir, alamat, jenis_kelamin) 
              VALUES ('$nim', '$nama', '$tgl_lahir', '$alamat', '$jenis_kelamin')";
    mysqli_query($conn, $query);

    // Redirect untuk menghindari form resubmission
    header("Location: mahasiswa.php");
    exit();
}

// Hapus Data
if (isset($_GET['hapus'])) {
    $nim = $_GET['hapus'];

    // Hapus data terkait di tabel perkuliahan terlebih dahulu
    $query = "DELETE FROM perkuliahan WHERE nim='$nim'";
    mysqli_query($conn, $query);

    // Hapus data di tabel mahasiswa
    $query = "DELETE FROM mahasiswa WHERE nim='$nim'";
    mysqli_query($conn, $query);

    // Redirect untuk menghindari URL resubmission
    header("Location: mahasiswa.php");
    exit();
}

// Edit Data
if (isset($_POST['update'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    $query = "UPDATE mahasiswa 
              SET nama_mhs='$nama', tgl_lahir='$tgl_lahir', alamat='$alamat', jenis_kelamin='$jenis_kelamin' 
              WHERE nim='$nim'";

    // Periksa apakah query berhasil
    if (mysqli_query($conn, $query)) {
        // Redirect jika berhasil
        header("Location: mahasiswa.php");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

// Tampilkan Data
$result = mysqli_query($conn, "SELECT * FROM mahasiswa");

// Jika user memilih data untuk diedit
$editData = null;
if (isset($_GET['edit'])) {
    $nim = $_GET['edit'];
    $editResult = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim='$nim'");
    $editData = mysqli_fetch_assoc($editResult);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
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
            margin-top: 20px; /* Menghindari tumpang tindih dengan header */
            margin-bottom: 40px; /* Menghindari tumpang tindih dengan footer */
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
        main form textarea, 
        main form select, 
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
        <h1>Data Mahasiswa</h1>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Form Tambah Data -->
        <form method="POST">
            <h2>Tambah Data</h2>
            <input type="text" name="nim" placeholder="NIM" required>
            <input type="text" name="nama" placeholder="Nama" required>
            <input type="date" name="tgl_lahir" required>
            <textarea name="alamat" placeholder="Alamat" required></textarea>
            <select name="jenis_kelamin">
                <option value="L">Laki-Laki</option>
                <option value="P">Perempuan</option>
            </select>
            <button type="submit" name="tambah">Tambah</button>
        </form>

        <!-- Form Edit Data (jika ada) -->
        <?php if (isset($editData)): ?>
        <form method="POST">
            <h2>Edit Data</h2>
            <input type="hidden" name="nim" value="<?= $editData['nim'] ?>" required>
            <input type="text" name="nama" placeholder="Nama" value="<?= $editData['nama_mhs'] ?>" required>
            <input type="date" name="tgl_lahir" value="<?= $editData['tgl_lahir'] ?>" required>
            <textarea name="alamat" placeholder="Alamat" required><?= $editData['alamat'] ?></textarea>
            <select name="jenis_kelamin">
                <option value="L" <?= $editData['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>Laki-Laki</option>
                <option value="P" <?= $editData['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
            </select>
            <button type="submit" name="update">Update</button>
        </form>
        <?php endif; ?>

        <!-- Tabel Data Mahasiswa -->
        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Tgl Lahir</th>
                    <th>Alamat</th>
                    <th>Jenis Kelamin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($result) && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['nim'] ?></td>
                            <td><?= $row['nama_mhs'] ?></td>
                            <td><?= $row['tgl_lahir'] ?></td>
                            <td><?= $row['alamat'] ?></td>
                            <td><?= $row['jenis_kelamin'] ?></td>
                            <td>
                                <a href="mahasiswa.php?edit=<?= $row['nim'] ?>">Edit</a> | 
                                <a href="mahasiswa.php?hapus=<?= $row['nim'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Tidak ada data mahasiswa.</td>
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
