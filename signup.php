<?php
session_start();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $email === '' || $password === '') {
        $message = 'Please fill in all fields.';
    } else {

        $conn = new mysqli('localhost', 'root', '', 'login_system');

        if ($conn->connect_error) {
            $message = 'Database connection error.';
        } else {

            // Check if email already exists
            $check = $conn->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
            $check->bind_param('s', $email);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                $message = 'Email already registered.';
            } else {

                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare(
                    'INSERT INTO users (username, email, password) VALUES (?, ?, ?)'
                );
                $stmt->bind_param('sss', $username, $email, $hashed_password);

                if ($stmt->execute()) {
                    $message = 'Signup successful! You can now login.';
                } else {
                    $message = 'Something went wrong. Try again.';
                }

                $stmt->close();
            }

            $check->close();
            $conn->close();
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Signup</title>
</head>

<body>

    <h2>Create Account</h2>

    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="post">
        Username:
        <input type="text" name="username" required><br><br>

        Email:
        <input type="email" name="email" required><br><br>

        Password:
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Sign Up">
    </form>

    <p><a href="index.php">Back to Login</a></p>

</body>

</html>