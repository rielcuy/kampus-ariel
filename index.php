<?php
require_once 'config.php';
require_once 'lang.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM mahasiswa ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $lang['title'] ?></title>
</head>
<body>
    <div>
        <a href="?lang=id">Bahasa Indonesia</a> | <a href="?lang=en">English</a> | 
        <a href="logout.php"><?= $lang['logout'] ?></a>
    </div>
    <h1><?= $lang['title'] ?></h1>
    <p><a href="tambah.php">+ <?= $lang['add_data'] ?></a></p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th><?= $lang['nim'] ?></th>
                <th><?= $lang['name'] ?></th>
                <th><?= $lang['major'] ?></th>
                <th><?= $lang['email'] ?></th>
                <th><?= $lang['action'] ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nim']) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['jurusan']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>"><?= $lang['edit'] ?></a> | 
                    <a href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('<?= $lang['delete_confirm'] ?>')"><?= $lang['delete'] ?></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>