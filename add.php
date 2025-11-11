<?php
include 'config.php';
if (!isset($_SESSION['login_user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $conn->real_escape_string(trim($_POST['nama_alat']));
    $seri = $conn->real_escape_string(trim($_POST['no_seri']));
    $tgl  = $conn->real_escape_string($_POST['tanggal_kalibrasi']);
    $teknisi = $conn->real_escape_string(trim($_POST['teknisi']));
    $status = $conn->real_escape_string(trim($_POST['status']));

    $sql = "INSERT INTO alat (nama_alat, no_seri, tanggal_kalibrasi, teknisi, status)
            VALUES ('$nama', '$seri', '$tgl', '$teknisi', '$status')";

    if ($conn->query($sql)) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location='index.php';</script>";
        exit;
    } else {
        $error = "Gagal: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Data Kalibrasi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container mt-5">
  <h3 class="mb-4">Tambah Data Kalibrasi</h3>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="POST" action="">
    <div class="mb-3">
      <label class="form-label">Nama Alat</label>
      <input type="text" name="nama_alat" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">No Seri</label>
      <input type="text" name="no_seri" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Tanggal Kalibrasi</label>
      <input type="date" name="tanggal_kalibrasi" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Teknisi</label>
      <input type="text" name="teknisi" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Status</label>
      <select name="status" class="form-select" required>
        <option value="Terkalibrasi">Terkalibrasi</option>
        <option value="Proses">Proses</option>
        <option value="Belum">Belum</option>
      </select>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>
</body>
</html>
