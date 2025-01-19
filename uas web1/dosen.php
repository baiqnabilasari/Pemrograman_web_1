<?php
include 'config.php';

// Tambah Data
if (isset($_POST['tambah'])) {
    $nidn = $_POST['nidn'];
    $nama_dosen = $_POST['nama_dosen'];

    $query = "INSERT INTO dosen (nidn, nama_dosen) VALUES ('$nidn', '$nama_dosen')";
    mysqli_query($conn, $query);

    header("Location: dosen.php");
    exit();
}

// Hapus Data
if (isset($_GET['hapus'])) {
    $nidn = $_GET['hapus'];
    $query = "DELETE FROM dosen WHERE nidn='$nidn'";
    mysqli_query($conn, $query);

    header("Location: dosen.php");
    exit();
}

// Edit Data
if (isset($_POST['update'])) {
    $nidn = $_POST['nidn'];
    $nama_dosen = $_POST['nama_dosen'];

    $query = "UPDATE dosen SET nama_dosen='$nama_dosen' WHERE nidn='$nidn'";
    mysqli_query($conn, $query);

    header("Location: dosen.php");
    exit();
}

// Tampilkan Data
$result = mysqli_query($conn, "SELECT * FROM dosen");

// Jika user memilih data untuk diedit
$editData = null;
if (isset($_GET['edit'])) {
    $nidn = $_GET['edit'];
    $editResult = mysqli_query($conn, "SELECT * FROM dosen WHERE nidn='$nidn'");
    $editData = mysqli_fetch_assoc($editResult);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dosen</title>
    <style>
        /* Gaya umum */
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

        /* Konten utama */
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

        /* Footer */
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

    <!-- Konten utama -->
    <main>
        <header>
            <h1>Data Dosen</h1>
        </header>

        <!-- Form Tambah Data -->
        <form method="POST">
            <h2>Tambah Data Dosen</h2>
            <input type="text" name="nidn" placeholder="NIDN" required>
            <input type="text" name="nama_dosen" placeholder="Nama Dosen" required>
            <button type="submit" name="tambah">Tambah</button>
        </form>

        <!-- Form Edit Data -->
        <?php if ($editData): ?>
        <form method="POST">
            <h2>Edit Data Dosen</h2>
            <input type="hidden" name="nidn" value="<?= $editData['nidn'] ?>" required>
            <input type="text" name="nama_dosen" placeholder="Nama Dosen" value="<?= $editData['nama_dosen'] ?>" required>
            <button type="submit" name="update">Update</button>
        </form>
        <?php endif; ?>

        <!-- Tabel Data Dosen -->
        <table>
            <thead>
                <tr>
                    <th>NIDN</th>
                    <th>Nama Dosen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($result) && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['nidn'] ?></td>
                            <td><?= $row['nama_dosen'] ?></td>
                            <td>
                                <a href="dosen.php?edit=<?= $row['nidn'] ?>">Edit</a> | 
                                <a href="dosen.php?hapus=<?= $row['nidn'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Tidak ada data dosen.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Sistem Akademik |by:Baiq Nabila</p>
    </footer>
</body>
</html>
