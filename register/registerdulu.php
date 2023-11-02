<?php
// Pastikan Anda telah melakukan koneksi ke database (koneksi.php)
require('../koneksi/koneksi.php');
function registerUser($data) {
    global $koneksi;

    $role = "customer";
    $username = strtolower(stripslashes($data["username"]));
    $nama_depan = mysqli_real_escape_string($koneksi, $data["nama_depan"]);
    $nama_belakang = mysqli_real_escape_string($koneksi, $data["nama_belakang"]);
    $email = mysqli_real_escape_string($koneksi, $data["email"]);
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $password2 = mysqli_real_escape_string($koneksi, $data["confirm_password"]);

    $cek_user = mysqli_query($koneksi, "SELECT username FROM perloginan WHERE username = '$username'");
    if (mysqli_fetch_assoc($cek_user)) {
        echo "<script>alert('USERNAME SUDAH TERDAFTAR');</script>";
        return false;
    }

    if ($password !== $password2) {
        echo "<script>alert('KONFIRMASI PASSWORD TIDAK SESUAI');</script>";
        return false;
    }

    // Mengamankan password
    // $password = password_hash($password, PASSWORD_DEFAULT);

    // Masukkan data
    $query = "INSERT INTO perloginan (nama_depan, nama_belakang, email, username, password, role) VALUES ('$nama_depan', '$nama_belakang', '$email', '$username', '$password', '$role')";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}
if(isset($_POST["register"])){
    if(registerUser($_POST) > 0){
        echo "
        <script>
        alert('USER BARU BERHASIL DI TAMBAHKAN');
        document.location.href = 'registerdulu.php';
        </script>
        "; 
    }else{
        echo mysqli_error($koneksi);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Registrasi</title>
    <style>
        .container {
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            text-align: left;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form label, form input {
            display: block;
            margin: 10px 0;
        }

        input[type="submit"] {
            display: block;
            margin: 10px auto;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Form Registrasi</h2>
        <form method="post" action="registerdulu.php">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>

            <label for="nama_depan">Nama Depan:</label>
            <input type="text" id="nama_depan" name="nama_depan" required>

            <label for="nama_belakang">Nama Belakang:</label>
            <input type="text" id="nama_belakang" name="nama_belakang" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Konfirmasi Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            
            <button type="submit" name="register">Register</button>
            
        </form>
    </div>
</body>
</html>

