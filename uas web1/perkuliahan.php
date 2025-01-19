<?php
include 'config.php';

// Tambah Data
if (isset($_POST['tambah'])) {
    $nim = $_POST['nim'];
    $kode_matakuliah = $_POST['kode_matakuliah'];
    $nidn = $_POST['nidn'];
    $nilai = $_POST['nilai'];

    // Validasi apakah NIM, Kode Mata Kuliah, dan NIDN ada di tabel masing-masing
    $cekMahasiswa = mysqli_query($conn, "SELECT nim FROM mahasiswa WHERE nim = '$nim'");
    $cekMatakuliah = mysqli_query($conn, "SELECT kode_matakuliah FROM matakuliah WHERE kode_matakuliah = '$kode_matakuliah'");
    $cekDosen = mysqli_query($conn, "SELECT nidn FROM dosen WHERE nidn = '$nidn'");

    if (mysqli_num_rows($cekMahasiswa) > 0 && mysqli_num_rows($cekMatakuliah) > 0 && mysqli_num_rows($cekDosen) > 0) {
        // Jika validasi berhasil, tambahkan data ke tabel perkuliahan
        $query = "INSERT INTO perkuliahan (nim, kode_matakuliah, nidn, nilai) 
                  VALUES ('$nim', '$kode_matakuliah', '$nidn', '$nilai')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil ditambahkan!'); window.location='perkuliahan.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan data: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Data tidak valid. Pastikan NIM, Kode Mata Kuliah, dan NIDN sudah terdaftar.');</script>";
    }
}

// Hapus Data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $query = "DELETE FROM perkuliahan WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='perkuliahan.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data: " . mysqli_error($conn) . "');</script>";
    }
}

// Edit Data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nim = $_POST['nim'];
    $kode_matakuliah = $_POST['kode_matakuliah'];
    $nidn = $_POST['nidn'];
    $nilai = $_POST['nilai'];

    // Validasi apakah NIM, Kode Mata Kuliah, dan NIDN ada di tabel masing-masing
    $cekMahasiswa = mysqli_query($conn, "SELECT nim FROM mahasiswa WHERE nim = '$nim'");
    $cekMatakuliah = mysqli_query($conn, "SELECT kode_matakuliah FROM matakuliah WHERE kode_matakuliah = '$kode_matakuliah'");
    $cekDosen = mysqli_query($conn, "SELECT nidn FROM dosen WHERE nidn = '$nidn'");

    if (mysqli_num_rows($cekMahasiswa) > 0 && mysqli_num_rows($cekMatakuliah) > 0 && mysqli_num_rows($cekDosen) > 0) {
        // Jika validasi berhasil, update data di tabel perkuliahan
        $query = "UPDATE perkuliahan 
                  SET nim='$nim', kode_matakuliah='$kode_matakuliah', nidn='$nidn', nilai='$nilai' 
                  WHERE id='$id'";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Data berhasil diperbarui!'); window.location='perkuliahan.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui data: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Data tidak valid. Pastikan NIM, Kode Mata Kuliah, dan NIDN sudah terdaftar.');</script>";
    }
}

// Tampilkan Data
$result = mysqli_query($conn, "SELECT * FROM perkuliahan");

// Jika user memilih data untuk diedit
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editResult = mysqli_query($conn, "SELECT * FROM perkuliahan WHERE id='$id'");
    $editData = mysqli_fetch_assoc($editResult);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Perkuliahan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f0f5;
            color: #4a2545;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            margin: 0 auto;
            padding: 20px;
            max-width: 1200px;
            width: 100%;
        }
        header {
            background-color: #8e4585;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        header h1 {
            margin: 0;
            font-size: 2rem;
        }
        form {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        form input, form button {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        form button {
            background-color: #8e4585;
            color: white;
            border: none;
            cursor: pointer;
        }
        form button:hover {
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
            margin-top: auto;
            width: 100%;
        }
    </style>
</head>
<body>
    <main>
        <header>
            <h1>Data Perkuliahan</h1>
        </header>
        <!-- Form Tambah Data -->
        <form method="POST">
            <h2>Tambah Data Perkuliahan</h2>
            <input type="text" name="nim" placeholder="NIM Mahasiswa" required>
            <input type="text" name="kode_matakuliah" placeholder="Kode Mata Kuliah" required>
            <input type="text" name="nidn" placeholder="NIDN Dosen" required>
            <input type="text" name="nilai" placeholder="Nilai" required>
            <button type="submit" name="tambah">Tambah</button>
        </form>
        <!-- Form Edit Data -->
        <?php if ($editData): ?>
        <form method="POST">
            <h2>Edit Data Perkuliahan</h2>
            <input type="hidden" name="id" value="<?= $editData['id'] ?>" required>
            <input type="text" name="nim" placeholder="NIM Mahasiswa" value="<?= $editData['nim'] ?>" required>
            <input type="text" name="kode_matakuliah" placeholder="Kode Mata Kuliah" value="<?= $editData['kode_matakuliah'] ?>" required>
            <input type="text" name="nidn" placeholder="NIDN Dosen" value="<?= $editData['nidn'] ?>" required>
            <input type="text" name="nilai" placeholder="Nilai" value="<?= $editData['nilai'] ?>" required>
            <button type="submit" name="update">Update</button>
        </form>
        <?php endif; ?>
        <!-- Tabel Data Perkuliahan -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NIM</th>
                    <th>Kode Mata Kuliah</th>
                    <th>NIDN</th>
                    <th>Nilai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['nim'] ?></td>
                        <td><?= $row['kode_matakuliah'] ?></td>
                        <td><?= $row['nidn'] ?></td>
                        <td><?= $row['nilai'] ?></td>
                        <td>
                            <a href="perkuliahan.php?edit=<?= $row['id'] ?>">Edit</a> | 
                            <a href="perkuliahan.php?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; 2025 Sistem Akademik |by:Baiq Nabila</p>
    </footer>
</body>
</html>
