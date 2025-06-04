<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Contoh validasi sederhana
    if ($email == "defdava@gmail.com" && $password == "defdava") {
        // Pengalihan ke halaman kalkulator
        header("Location: calculator.php");
        exit();
    } else {
        // Jika gagal, arahkan kembali ke login dengan pesan error
        header("Location: login.php?error=1");
        exit();
    }
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Money Calculator</title>
        <link rel="stylesheet" href="assets/css/styles.css">
    </head>
    <body>
        <div class="header">
            <div class="calculator-icon">
                <div class="screen"></div>
                <div class="buttons">
                    <div class="button"></div>
                    <div class="button"></div>
                    <div class="button"></div>
                </div>
            </div>
        </div>
        <div class="login-container">
            <img src="assets/images/kalkulator.png" alt="Calculator" class="calculator-image">
            <?php
            if (isset($_GET['error'])) {
                echo '<p class="error-message">Invalid email or password!</p>';
            }
            ?>
            <form method="POST" action="login_process.php">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="login-button">Login</button>
            </form>
        </div>
    </body>
    </html>
    <?php
}
?>
