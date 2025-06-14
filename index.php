<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelSearch - Flight & Hotel Booking</title>
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
            font-size: 2.5em;
        }
        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .search-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .search-box h2 {
            margin: 0 0 20px;
            color: #004aad;
        }
        .search-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .search-form input, .search-form select, .search-form button {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }
        .search-form input[type="text"], .search-form select {
            flex: 1;
            min-width: 200px;
        }
        .search-form button {
            background: #004aad;
            color: white;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }
        .search-form button:hover {
            background: #003087;
        }
        @media (max-width: 768px) {
            .search-form {
                flex-direction: column;
            }
            .search-form input, .search-form select, .search-form button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>TravelSearch</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="signup.php">Signup</a>
            <a href="dashboard.php">Dashboard</a>
        </nav>
    </header>
    <div class="container">
        <div class="search-box">
            <h2>Search Flights</h2>
            <form class="search-form" id="flight-search-form">
                <input type="text" name="from" placeholder="From (e.g., Lahore)" required>
                <input type="text" name="to" placeholder="To (e.g., Karachi)" required>
                <input type="date" name="depart" required>
                <input type="date" name="return">
                <select name="passengers">
                    <option value="1">1 Passenger</option>
                    <option value="2">2 Passengers</option>
                    <option value="3">3 Passengers</option>
                </select>
                <button type="submit">Search Flights</button>
            </form>
        </div>
        <div class="search-box" style="margin-top: 20px;">
            <h2>Search Hotels</h2>
            <form class="search-form" id="hotel-search-form">
                <input type="text" name="destination" placeholder="Destination (e.g., Karachi)" required>
                <input type="date" name="checkin" required>
                <input type="date" name="checkout" required>
                <select name="guests">
                    <option value="1">1 Guest</option>
                    <option value="2">2 Guests</option>
                    <option value="3">3 Guests</option>
                </select>
                <button type="submit">Search Hotels</button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('flight-search-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const query = new URLSearchParams(formData).toString();
            window.location.href = `search_results.php?type=flight&${query}`;
        });
        document.getElementById('hotel-search-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const query = new URLSearchParams(formData).toString();
            window.location.href = `search_results.php?type=hotel&${query}`;
        });
    </script>
</body>
</html>
