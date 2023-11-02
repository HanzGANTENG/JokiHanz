<?php
require('../koneksi/koneksi.php');

if (isset($_POST['submit'])) {
    $user = $_POST['txt_user'];
    $pass = $_POST['txt_pass'];

    if (empty(trim($user)) || empty(trim($pass))) {
        $error = 'Email/Username dan Password harus diisi!';
        header('Location: logindulu.php');
        exit;
    }

    // Ganti query SQL
    $query = "SELECT * FROM perloginan WHERE (email = '$user' OR username = '$user') AND password = '$pass'";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        $error = 'Terjadi kesalahan dalam query!';
        header('Location: logindulu.php');
        exit;
    }

    $row = mysqli_fetch_assoc($result);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        $roleVal = $row['role'];

        // Periksa peran pengguna
        switch ($roleVal) {
            case 'admin':
                header('Location: ../dashboard_admin/admin.php');
                break;
            case 'penjoki':
                header('Location: ../dashbboard_penjoki/penjoki.php');
                break;
            case 'customer':
                header('Location: ../dashboard_customer/customer.php');
                break;
            default:
                $error = 'Role tidak valid!';
                header('Location: logindulu.php');
                break;
        }
    } else {
        $error = 'Login gagal. Email/Username atau Password salah.';
        header('Location: logindulu.php');
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <h2 class="logo">Hanzjoki</h2>
        <nav class="navigation">
            <a href="#">Home</a>
            <a href="aboutus.php">About us</a>
            <a href="#">Contact</a>
            <button class="btnLogin">Login</button>
        </nav>
    </header>

    <div class="wrapper">
        <span class="icon-close"><ion-icon name="close-outline"></ion-icon></span>
        <div class="form-box Login">
            <h2>Login</h2>
            <form method="post" action="logindulu.php">
                <div class="login-input">
                    <div class="input-box">
                        <label for="txt_user">Email/Username:</label>
                        <input type="text" name="txt_user" id="txt_user" required>
                        <ion-icon class="icon" name="person-outline"></ion-icon>
                    </div>
                </div>
                <div class="login-input">
                    <div class="input-box">
                        <label for="txt_pass">Password:</label>
                        <input type="password" name="txt_pass" id="txt_pass" required>
                        <ion-icon class="icon" name="lock-closed-outline"></ion-icon>
                    </div>
                </div>
                <div class="remember-forget">
                    <label><input type="checkbox"> Remember me</label>
                    <a href="#">Forgot Password?</a>
                </div>
                <input type="submit" name="submit" value="Login" class="btnLogin">
            </form>
        </div>
    </div>

    <script src="script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>