<?php
require_once 'config.php';
require_once 'lang.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = trim(htmlspecialchars($_POST['nim'] ?? ''));
    $nama = trim(htmlspecialchars($_POST['nama'] ?? ''));
    $jurusan = trim(htmlspecialchars($_POST['jurusan'] ?? ''));
    $email = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));

    if (empty($nim) || empty($nama) || empty($jurusan) || empty($email)) {
        $error = $lang['empty_field'];
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = $lang['invalid_email'];
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO mahasiswa (nim, nama, jurusan, email) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $nim, $nama, $jurusan, $email);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Gagal menyimpan data!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $lang['add_data'] ?></title>
</head>
<body>
    <h2><?= $lang['add_data'] ?></h2>
    <?php if ($error): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
        <label><?= $lang['nim'] ?>:</label><br>
        <input type="text" name="nim" required><br><br>
        
        <label><?= $lang['name'] ?>:</label><br>
        <input type="text" name="nama" required><br><br>

        <label><?= $lang['major'] ?>:</label><br>
        <input type="text" name="jurusan" required><br><br>

        <label><?= $lang['email'] ?>:</label><br>
        <input type="email" name="email" required><br><br>

        <button type="submit"><?= $lang['save'] ?></button>
        <a href="index.php"><?= $lang['cancel'] ?></a>
    </form>
</body>
</html>