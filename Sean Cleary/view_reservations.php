<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reservations | Seans Bistro</title>
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

        main {
            padding: 20px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #efefef;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .reservations-container {
            padding: 20px;
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
        <h1>Current Reservations</h1>
    </header>
    
    <main>
        <div class="reservations-container">
            <?php
            require_once 'db_connection.php'; // Include your database connection file

            // Fetch all reservations
            $query = "SELECT * FROM reservations ORDER BY reservation_date, reservation_time";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                echo '<table>';
                echo '<tr><th>Name</th><th>Email</th><th>Date</th><th>Time</th><th>Number of People</th></tr>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['reservation_date']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['reservation_time']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['number_of_people']) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p>No reservations found.</p>';
            }

            // Close the database connection
            $conn->close();
            ?>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2024 Seans Bistro. All rights reserved.</p>
    </footer>
</body>
</html>
