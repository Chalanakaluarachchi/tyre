<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Tyre Mart</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url('bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            text-align: center;
        }
        .header {
            background: rgba(0, 0, 0, 0.6);
            padding: 20px 0;
        }
        .header h1 {
            margin: 0;
            font-size: 3em;
        }
        .time-display {
            margin-top: 10px;
            font-size: 1.2em;
        }
        .main-content {
            margin-top: 50px;
        }
        .search-bar {
            margin: 20px auto;
            width: 80%;
            max-width: 600px;
            display: flex;
        }
        .search-bar input[type="text"] {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 4px 0 0 4px;
            font-size: 16px;
        }
        .search-bar button {
            padding: 10px;
            border: none;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }
        .search-bar button:hover {
            background-color: #0056b3;
        }
        .btn-container {
            margin-top: 30px;
        }
        .btn-container a {
            display: inline-block;
            padding: 15px 30px;
            margin: 10px;
            text-decoration: none;
            background-color: #28a745;
            color: #fff;
            font-size: 18px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            transition: background 0.3s, box-shadow 0.3s;
        }
        .btn-container a:hover {
            background-color: #218838;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.4);
        }
    </style>
    <script>
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString();
            document.getElementById('time').innerText = timeString;
        }
        setInterval(updateTime, 1000);
        window.onload = updateTime;
    </script>
</head>
<body>
    <div class="header">
        <h1>Welcome to Auto Tyre Mart</h1>
        <div class="time-display">
            Local Time: <span id="time"></span>
        </div>
    </div>

    <div class="main-content">
    <img src='logo.png' alt='logo'>
        

        <div class="btn-container">
            <a href="index.php">Go to Product Page</a>
           
        </div>
    </div>
</body>
</html>
