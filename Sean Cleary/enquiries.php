<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Enquiries | Seans Bistro</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background: #2c3e50;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
        }

        .enquiries-container {
            padding: 20px;
            margin: auto;
            width: 80%;
            max-width: 600px;
            background: white;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ccc;  /* Ensures only the bottom of each cell has a border */
        }

        th {
            background-color: #efefef;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        footer {
            background: #2c3e50;
            color: #fff;
            text-align: center;
            padding: 10px 20px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Customer Enquiries</h1>
    </header>

    <div class="enquiries-container">
        <?php
        require_once 'db_connection.php';  // Include your database connection file

        // Fetch all enquiries
        $query = "SELECT * FROM enquiries ORDER BY name";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>Name</th><th>Email</th><th>Message</th></tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                echo '<td>' . htmlspecialchars($row['message']) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No enquiries found.</p>';
        }

        $conn->close();
        ?>
    </div>

    <footer>
        <p>&copy; 2024 Seans Bistro. All rights reserved.</p>
    </footer>
</body>
</html>
