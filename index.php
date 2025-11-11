<?php
include 'config.php';
if (!isset($_SESSION['login_user'])) {
    header("Location: login.php");
    exit;
}

// ambil data alat
$result = $conn->query("SELECT * FROM alat ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Kalibrasi Alat</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>📏 Data Kalibrasi Alat</h2> <!--ganti nama -->
    <div>
      <span class="me-3">👤 <?= htmlspecialchars($_SESSION['name'] ?? $_SESSION['login_user']); ?></span>
      <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
  </div>

  <div class="mb-3 d-flex justify-content-between">
    <a href="add.php" class="btn btn-primary">+ Tambah Data</a>
    <form class="d-flex" method="GET" action="index.php">
      <input class="form-control me-2" type="search" name="q" placeholder="Cari nama alat / no seri" value="<?= isset($_GET['q'])?htmlspecialchars($_GET['q']):'' ?>">
      <button class="btn btn-outline-secondary" type="submit">Cari</button>
    </form>
  </div>

  <?php
  // jika ada pencarian, lakukan filter
  if (!empty($_GET['q'])) {
      $q = $conn->real_escape_string(trim($_GET['q']));
      $result = $conn->query("SELECT * FROM alat WHERE nama_alat LIKE '%$q%' OR no_seri LIKE '%$q%' ORDER BY id DESC");
  }
  ?>

  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Nama Alat</th>
          <th>No Seri</th>
          <th>Tanggal Kalibrasi</th>
          <th>Teknisi</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id']; ?></td>
              <td><?= htmlspecialchars($row['nama_alat']); ?></td>
              <td><?= htmlspecialchars($row['no_seri']); ?></td>
              <td><?= htmlspecialchars($row['tanggal_kalibrasi']); ?></td>
              <td><?= htmlspecialchars($row['teknisi']); ?></td>
              <td><?= htmlspecialchars($row['status']); ?></td>
              <td>
                <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="7">Belum ada data.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
