<?php
session_start();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_or_email = trim($_POST['username_or_email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username_or_email === '' || $password === '') {
        $message = 'Please fill in all fields.';
    } else {
        $conn = new mysqli('localhost', 'root', '', 'login_system');
        if ($conn->connect_error) {
            $message = 'Database connection error.';
        } else {
            $stmt = $conn->prepare('SELECT id, username, password FROM users WHERE username = ? OR email = ? LIMIT 1');
            $stmt->bind_param('ss', $username_or_email, $username_or_email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    header('Location: dashboard.php');
                    exit;
                } else {
                    $message = 'Invalid password.';
                }
            } else {
                $message = 'No user found with that username or email.';
            }

            $stmt->close();
            $conn->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        label {
            display: block;
            margin: 8px 0;
        }
    </style>
</head>

<body>
    <?php if ($message): ?><p><?php echo htmlspecialchars($message); ?></p><?php endif; ?>

    <form method="post">
        <label>Username or email
            <input type="text" name="username_or_email" value="<?php
                                                                echo htmlspecialchars($_POST['username_or_email'] ?? ''); ?>" required>
        </label>
        <label>Password
            <input type="password" name="password" required>
        </label>
        <input type="submit" value="Login">
    </form>

    <p><a href="signup.php">Sign Up</a></p>
</body>

</html>