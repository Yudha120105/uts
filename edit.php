<?php
include 'config.php';
if (!isset($_SESSION['login_user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];
$data = $conn->query("SELECT * FROM alat WHERE id=$id")->fetch_assoc();
if (!$data) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $conn->real_escape_string(trim($_POST['nama_alat']));
    $seri = $conn->real_escape_string(trim($_POST['no_seri']));
    $tgl  = $conn->real_escape_string($_POST['tanggal_kalibrasi']);
    $teknisi = $conn->real_escape_string(trim($_POST['teknisi']));
    $status = $conn->real_escape_string(trim($_POST['status']));

    $sql = "UPDATE alat SET
            nama_alat='$nama',
            no_seri='$seri',
            tanggal_kalibrasi='$tgl',
            teknisi='$teknisi',
            status='$status'
            WHERE id=$id";

    if ($conn->query($sql)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='index.php';</script>";
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
  <title>Edit Data Kalibrasi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container mt-5">
  <h3 class="mb-4">Edit Data Kalibrasi</h3>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="POST" action="">
    <div class="mb-3">
      <label class="form-label">Nama Alat</label>
      <input type="text" name="nama_alat" class="form-control" value="<?= htmlspecialchars($data['nama_alat']); ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">No Seri</label>
      <input type="text" name="no_seri" class="form-control" value="<?= htmlspecialchars($data['no_seri']); ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Tanggal Kalibrasi</label>
      <input type="date" name="tanggal_kalibrasi" class="form-control" value="<?= htmlspecialchars($data['tanggal_kalibrasi']); ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Teknisi</label>
      <input type="text" name="teknisi" class="form-control" value="<?= htmlspecialchars($data['teknisi']); ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Status</label>
      <select name="status" class="form-select" required>
        <option <?= $data['status']=='Terkalibrasi'?'selected':''; ?>>Terkalibrasi</option>
        <option <?= $data['status']=='Proses'?'selected':''; ?>>Proses</option>
        <option <?= $data['status']=='Belum'?'selected':''; ?>>Belum</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="index.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>
</body>
</html>
