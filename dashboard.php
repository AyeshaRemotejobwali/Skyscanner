<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TravelSearch</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        header {
            background: #004aad;
            color: white;
            padding: 15px 0;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        header h1 {
            margin: 0;
        }
        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .dashboard-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .dashboard-section h2 {
            color: #004aad;
        }
        .search-item {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>User Dashboard</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <div class="container">
        <div class="dashboard-section">
            <h2>Saved Searches</h2>
            <?php
            session_start();
            require_once 'db.php';
            if (!isset($_SESSION['user_id'])) {
                header("Location: login.php");
                exit;
            }
            $stmt = $pdo->prepare("SELECT * FROM searches WHERE user_id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $searches = $stmt->fetchAll();
            foreach ($searches as $search) {
                $query = json_decode($search['query'], true);
                echo '<div class="search-item">';
                echo '<p>' . htmlspecialchars($search['type']) . ' Search: ' . json_encode($query) . '</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
