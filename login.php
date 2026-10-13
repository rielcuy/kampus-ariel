<?php
require_once 'config.php';
require_once 'lang.php';

$error = '';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(htmlspecialchars($_POST['username'] ?? ''));
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = $lang['empty_field'];
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, password FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit();
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $lang['login'] ?></title>
</head>
<body>
    <div>
        <a href="?lang=id">Bahasa Indonesia</a> | <a href="?lang=en">English</a>
    </div>
    <h2><?= $lang['login'] ?></h2>
    <?php if ($error): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
        <label><?= $lang['username'] ?>:</label><br>
        <input type="text" name="username" required><br><br>
        <label><?= $lang['password'] ?>:</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit"><?= $lang['login'] ?></button>
    </form>
</body>
</html>