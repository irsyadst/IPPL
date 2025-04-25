<?php
include __DIR__ . "/../server/database.php";

session_start();

$error_code = 0;
$fullname = $username = $email = ""; // Menyimpan nilai input untuk mencegah reset

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirmpassword'] ?? '');

    if (!empty($fullname) && !empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            // Cek username
            $sql_check_username = "SELECT * FROM user WHERE username = ?";
            $stmt_check_username = $db->prepare($sql_check_username);
            $stmt_check_username->bind_param("s", $username);
            $stmt_check_username->execute();
            $result_check_username = $stmt_check_username->get_result();

            if ($result_check_username && $result_check_username->num_rows > 0) {
                $error_code = 3; // Username sudah digunakan
                $username = $email = $password = $confirm_password = ""; // Reset inputan jika username sudah ada
            } else {
                $stmt_check_username->close();

                // Cek email
                $sql_check_email = "SELECT * FROM user WHERE email = ?";
                $stmt_check_email = $db->prepare($sql_check_email);
                $stmt_check_email->bind_param("s", $email);
                $stmt_check_email->execute();
                $result_check_email = $stmt_check_email->get_result();

                if ($result_check_email && $result_check_email->num_rows > 0) {
                    $error_code = 4; // Email sudah digunakan
                    $email = $password = $confirm_password = ""; // Reset email dan password jika email sudah ada
                } else {
                    $stmt_check_email->close();

                    // Simpan data ke database
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                    $role = 'user';
                    $sql_insert = "INSERT INTO user (fullname, username, email, password, role) VALUES (?, ?, ?, ?, ?)";
                    $stmt_insert = $db->prepare($sql_insert);
                    $stmt_insert->bind_param("sssss", $fullname, $username, $email, $hashed_password, $role);


                    if ($stmt_insert->execute() && $stmt_insert->affected_rows > 0) {
                        header("Location: /server/Login.php");
                    } else {
                        $error_code = 2; // Gagal menyimpan ke database
                    }
                    $stmt_insert->close();
                }
            }
        } else {
            $error_code = 5; // Password dan konfirmasi password tidak cocok
            $password = $confirm_password = ""; // Reset hanya password dan confirm_password
        }
    }
    $db->close();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="/assets/style/register.css">

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const errorCode = <?php echo json_encode($error_code); ?>;

            const setError = (selector, message) => {
                const field = document.querySelector(selector);
                const errorElement = field.nextElementSibling; // Elemen dengan class error-message
                if (errorElement) {
                    errorElement.textContent = message;
                }
            };

            if (errorCode === 2) {
                setError("#confirmpassword", "Gagal mendaftar akun, silakan daftar ulang.");
            } else if (errorCode === 3) {
                setError("#username", "Username sudah digunakan.");
            } else if (errorCode === 4) {
                setError("#email", "Email sudah digunakan oleh pengguna lain.");
            } else if (errorCode === 5) {
                setError("#confirmpassword", "Password tidak cocok.");
            }
        });
    </script>

</head>

<body>
    <!-- Kontainer untuk seluruh halaman -->
    <div class="register-page">
        <!-- Bagian kiri dengan form login -->
        <div class="left-section">
            <div class="container-register">
                <h1>Please Fill out form to Register!</h1>
                <form action="/server/register.php" method="POST">
                    <label for="Fullname">Fullname:</label>
                    <input type="text" name="fullname" id="fullname" value="<?php echo htmlspecialchars($fullname); ?>" required>
                    <span class="error-message"></span>

                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>" required>
                    <span class="error-message"></span>

                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
                    <span class="error-message"></span>

                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>
                    <span class="error-message"></span>

                    <label for="confirmpassword">Confirm Password:</label>
                    <input type="password" name="confirmpassword" id="confirmpassword" required>
                    <span class="error-message"></span>

                    <button type="submit" class="login-btn">Register</button>
                </form>

                <p>Yes I have an account? <a href="/server/login.php">Login</a></p>
            </div>
        </div>

        <img src="/assets/img/icon-register-sate.png" alt="ramen" class="ramen-image">

        <!-- Bagian kanan tanpa gambar -->
        <div class="right-section">
            <!-- Area kanan kosong -->
        </div>
    </div>
</body>

</html>