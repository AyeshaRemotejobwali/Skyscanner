<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - TravelSearch</title>
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
            display: flex;
            gap: 20px;
        }
        .filters {
            width: 25%;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .results {
            width: 75%;
        }
        .filters h3, .results h3 {
            color: #004aad;
            margin-bottom: 15px;
        }
        .filter-group {
            margin-bottom: 15px;
        }
        .filter-group label {
            display: block;
            margin-bottom: 5px;
        }
        .filter-group input, .filter-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .result-card {
            background: white;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .result-card button {
            background: #004aad;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .result-card button:hover {
            background: #003087;
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            .filters, .results {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header style="background: #004aad; color: white; padding: 15px 0; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
        <h1>Search Results</h1>
        <nav>
            <a href="index.php" style="color: white; margin: 0 15px; text-decoration: none;">Home</a>
            <a href="dashboard.php" style="color: white; margin: 0 15px; text-decoration: none;">Dashboard</a>
        </nav>
    </header>
    <div class="container">
        <div class="filters">
            <h3>Filters</h3>
            <div class="filter-group">
                <label for="price-range">Price Range</label>
                <input type="range" id="price-range" min="0" max="1000" value="1000">
            </div>
            <div class="filter-group">
                <label for="sort-by">Sort By</label>
                <select id="sort-by">
                    <option value="price">Cheapest</option>
                    <option value="duration">Fastest</option>
                    <option value="rating">Best Rated</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="airline">Airline</label>
                <select id="airline">
                    <option value="">All</option>
                    <option value="emirates">Emirates</option>
                    <option value="pia">PIA</option>
                </select>
            </div>
        </div>
        <div class="results">
            <h3>Results</h3>
            <?php
            session_start();
            require_once 'db.php';
            $type = $_GET['type'] ?? 'flight';
            $dummy_flights = [
                ['provider' => 'Emirates', 'from' => 'Lahore', 'to' => 'Karachi', 'price' => 300, 'duration' => '2h', 'rating' => 4.5, 'link' => 'https://emirates.com'],
                ['provider' => 'PIA', 'from' => 'Lahore', 'to' => 'Karachi', 'price' => 250, 'duration' => '2.5h', 'rating' => 4.0, 'link' => 'https://pia.com.pk']
            ];
            $dummy_hotels = [
                ['name' => 'Marriott Karachi', 'location' => 'Karachi', 'price' => 150, 'rating' => 4.8, 'link' => 'https://marriott.com'],
                ['name' => 'Avari Towers', 'location' => 'Karachi', 'price' => 120, 'rating' => 4.2, 'link' => 'https://avari.com']
            ];
            $results = $type === 'flight' ? $dummy_flights : $dummy_hotels;
            if (isset($_SESSION['user_id']) && !empty($results)) {
                $stmt = $pdo->prepare("INSERT INTO searches (user_id, type, query) VALUES (?, ?, ?)");
                $stmt->execute([$_SESSION['user_id'], $type, json_encode($_GET)]);
            }
            foreach ($results as $result) {
                echo '<div class="result-card">';
                echo '<div>';
                echo '<h4>' . ($type === 'flight' ? $result['provider'] : $result['name']) . '</h4>';
                echo '<p>' . ($type === 'flight' ? "From: {$result['from']} To: {$result['to']}" : "Location: {$result['location']}") . '</p>';
                echo '<p>Price: $' . $result['price'] . '</p>';
                echo '<p>' . ($type === 'flight' ? "Duration: {$result['duration']}" : "Rating: {$result['rating']}/5") . '</p>';
                echo '</div>';
                echo '<button onclick="bookNow(\'' . $result['link'] . '\')">Book Now</button>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <script>
        function bookNow(url) {
            window.location.href = url;
        }
        document.getElementById('sort-by').addEventListener('change', function() {
            const sortBy = this.value;
            const results = document.querySelectorAll('.result-card');
            const sorted = Array.from(results).sort((a, b) => {
                const aData = a.querySelector('p:nth-child(3)').textContent.match(/\d+/)[0];
                const bData = b.querySelector('p:nth-child(3)').textContent.match(/\d+/)[0];
                return sortBy === 'price' ? aData - bData : bData - aData;
            });
            const resultsContainer = document.querySelector('.results');
            resultsContainer.innerHTML = '<h3>Results</h3>';
            sorted.forEach(result => resultsContainer.appendChild(result));
        });
    </script>
</body>
</html>
