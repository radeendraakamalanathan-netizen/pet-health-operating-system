<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$dashboard = isset($_GET['dash']) ? $_GET['dash'] : '1';
$username = htmlspecialchars($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .header {
            background-color: #333;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 24px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logout-btn {
            background-color: #ff6b6b;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
        }

        .logout-btn:hover {
            background-color: #ff5252;
        }

        .nav {
            background-color: #444;
            padding: 0;
            display: flex;
        }

        .nav a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            border-right: 1px solid #555;
        }

        .nav a:hover {
            background-color: #555;
        }

        .nav a.active {
            background-color: #4CAF50;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .dashboard {
            background: white;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .dashboard h2 {
            color: #333;
            margin-bottom: 15px;
        }

        .dashboard p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .stat-card {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            border-left: 4px solid #4CAF50;
        }

        .stat-card h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .stat-card .number {
            font-size: 28px;
            color: #4CAF50;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Dashboard</h1>
        <div class="user-info">
            <span>Welcome, <strong><?php echo $username; ?></strong></span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="nav">
        <a href="?dash=1" class="<?php echo ($dashboard === '1') ? 'active' : ''; ?>">Dashboard 1</a>
        <a href="?dash=2" class="<?php echo ($dashboard === '2') ? 'active' : ''; ?>">Dashboard 2</a>
    </div>

    <div class="container">
        <?php if ($dashboard === '1'): ?>
            <div class="dashboard">
                <h2>Dashboard One - Overview</h2>
                <p>Welcome to your first dashboard. This section provides an overview of your account statistics and recent activity.</p>

                <div class="stats">
                    <div class="stat-card">
                        <h3>Total Posts</h3>
                        <div class="number">12</div>
                    </div>
                    <div class="stat-card">
                        <h3>Total Comments</h3>
                        <div class="number">34</div>
                    </div>
                    <div class="stat-card">
                        <h3>Followers</h3>
                        <div class="number">156</div>
                    </div>
                    <div class="stat-card">
                        <h3>Views</h3>
                        <div class="number">2,890</div>
                    </div>
                </div>

                <h3 style="margin-top: 30px; color: #333;">Recent Activity</h3>
                <p>Your recent posts and interactions will appear here.</p>
            </div>

        <?php elseif ($dashboard === '2'): ?>
            <div class="dashboard">
                <h2>Dashboard Two - Settings & Analytics</h2>
                <p>Manage your account settings and view detailed analytics about your performance.</p>

                <div class="stats">
                    <div class="stat-card">
                        <h3>Profile Completeness</h3>
                        <div class="number">85%</div>
                    </div>
                    <div class="stat-card">
                        <h3>Account Age</h3>
                        <div class="number">45 days</div>
                    </div>
                    <div class="stat-card">
                        <h3>Last Login</h3>
                        <div class="number">Today</div>
                    </div>
                    <div class="stat-card">
                        <h3>Storage Used</h3>
                        <div class="number">2.3 GB</div>
                    </div>
                </div>

                <h3 style="margin-top: 30px; color: #333;">Quick Settings</h3>
                <p>
                    <button style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 3px; cursor: pointer;">Edit Profile</button>
                    <button style="background-color: #2196F3; color: white; padding: 10px 20px; border: none; border-radius: 3px; cursor: pointer; margin-left: 10px;">Change Password</button>
                    <button style="background-color: #ff9800; color: white; padding: 10px 20px; border: none; border-radius: 3px; cursor: pointer; margin-left: 10px;">Privacy Settings</button>
                </p>
            </div>

        <?php endif; ?>
    </div>
</body>

</html>