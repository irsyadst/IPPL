<?php
// File: includes/login.php
include __DIR__ . "/../server/database.php";

session_start();

$error_code = 0; // Variabel untuk kode error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT * FROM user WHERE username = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Login berhasil, simpan session
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role']; // Menyimpan role pengguna

                // Arahkan berdasarkan role
                if ($user['role'] === 'admin') {
                    header("Location: /../includes/admin_dashboard.php"); // Admin ke dashboard admin
                } else {
                    header("Location: /../index.php"); // User biasa ke halaman utama
                }
                exit();
            } else {
                $error_code = 2; // Password salah
            }
        } else {
            $error_code = 1; // Username tidak ditemukan
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="/assets/style/login.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const errorCode = <?php echo json_encode($error_code); ?>;

            if (errorCode === 1) {
                const usernameError = document.createElement("p");
                usernameError.style.color = "red";
                usernameError.style.fontSize = "15px";
                usernameError.style.marginTop = "-5px";
                usernameError.style.marginBottom = "10px";
                usernameError.textContent = "Username tidak ditemukan.";

                const usernameField = document.querySelector("#username");
                usernameField.insertAdjacentElement("afterend", usernameError);
            } else if (errorCode === 2) {
                const passwordError = document.createElement("p");
                passwordError.style.color = "red";
                passwordError.style.fontSize = "15px";
                passwordError.style.marginTop = "-5px";
                passwordError.style.marginBottom = "10px";
                passwordError.textContent = "Password salah.";

                const passwordField = document.querySelector("#password");
                passwordField.insertAdjacentElement("afterend", passwordError);
            }
        });
    </script>
</head>

<body>
    <div class="login-page">
        <div class="left-section">
            <div class="container-login">
                <h1>Welcome Back!</h1>
                <form action="/server/login.php" method="POST">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required>

                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>

                    <button type="submit" class="login-btn">Login</button>
                </form>
                <p>Don't have an account? <a href="/server/register.php">Register</a></p>
            </div>
        </div>
        <img src="/assets/img/icon-login-ramen.png" alt="ramen" class="ramen-image">
        <div class="right-section"></div>
    </div>
</body>

</html>
