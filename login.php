<?php
include 'config.php';

// jika sudah login, arahkan ke index
if (isset($_SESSION['login_user'])) {
    header("Location: index.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = trim($_POST['password']);

    // pakai MD5 untuk mencocokkan dengan data default yang dimasukkan via SQL di atas
    $password_md5 = md5($password);

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password_md5' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['login_user'] = $user['username'];
        $_SESSION['name'] = $user['name']; // bisa null jika belum diisi
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login | Sistem Kalibrasi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow p-4" style="width: 380px;">
    <h3 class="text-center mb-3 text-primary">Login Sistem Kalibrasi</h3>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required autocomplete="username">
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required autocomplete="current-password">
      </div>
      <button type="submit" class="btn btn-primary w-100">Masuk</button>
    </form>
    <div class="mt-3 text-center">
      <small>Default admin: <strong>admin</strong> / <strong>12345</strong></small>
    </div>
  </div>
</body>
</html>
