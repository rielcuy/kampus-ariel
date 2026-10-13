<?php
require_once 'config.php';
require_once 'lang.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit();
}

$stmt = mysqli_prepare($conn, "SELECT * FROM mahasiswa WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$data) {
    header("Location: index.php");
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
        $update_stmt = mysqli_prepare($conn, "UPDATE mahasiswa SET nim = ?, nama = ?, jurusan = ?, email = ? WHERE id = ?");
        mysqli_stmt_bind_param($update_stmt, "ssssi", $nim, $nama, $jurusan, $email, $id);

        if (mysqli_stmt_execute($update_stmt)) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Gagal memperbarui data!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $lang['edit'] ?></title>
</head>
<body>
    <h2><?= $lang['edit'] ?></h2>
    <?php if ($error): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
        <label><?= $lang['nim'] ?>:</label><br>
        <input type="text" name="nim" value="<?= htmlspecialchars($data['nim']) ?>" required><br><br>
        
        <label><?= $lang['name'] ?>:</label><br>
        <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required><br><br>

        <label><?= $lang['major'] ?>:</label><br>
        <input type="text" name="jurusan" value="<?= htmlspecialchars($data['jurusan']) ?>" required><br><br>

        <label><?= $lang['email'] ?>:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" required><br><br>

        <button type="submit"><?= $lang['save'] ?></button>
        <a href="index.php"><?= $lang['cancel'] ?></a>
    </form>
</body>
</html>