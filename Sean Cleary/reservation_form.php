<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations | Seans Bistro</title>
    <link rel="stylesheet" href="style.css"> <!-- Shared stylesheet for common styles -->
    <style>
         /* Custom styles for the reservation form */
         main {
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="time"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #0056b3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #004494;
        }
    </style>
</head>
<body>
    <header>
            <nav>
                <ul>
                    <li><a href="Restaurant.html">Home</a></li>
                    <li><a href="menu.php">Menu</a></li>
                    <li><a href="reservation_form.php">Reservations</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="contact_form.php">Contact</a></li>
                </ul>
            </nav>
        </header>
    
    <main>
        <?php
        require_once 'db_connection.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Collect and sanitize input data
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
            $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_STRING);
            $people = filter_input(INPUT_POST, 'people', FILTER_SANITIZE_NUMBER_INT);

            // Prepare an SQL statement to insert data safely into the reservations table
            $sql = "INSERT INTO reservations (name, email, reservation_date, reservation_time, number_of_people) VALUES (?, ?, ?, ?, ?)";
            
            if ($stmt = $conn->prepare($sql)) {
                // Bind parameters and execute
                $stmt->bind_param("ssssi", $name, $email, $date, $time, $people);

                if ($stmt->execute()) {
                    echo "<p>Reservation successfully made! Redirecting in 3 seconds...</p>";
                    echo "<script>setTimeout(() => { window.location.href = 'Restaurant.html'; }, 3000);</script>";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
            $conn->close();
        } else {
            // The form was not submitted, display the form
        ?>
        <h1>Make a Reservation</h1>
        <form method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>

            <label for="people">Number of People:</label>
            <select id="people" name="people" required>
                <option value="">Select number of guests</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10+">10+</option>
            </select>

            <input type="submit" value="Book Reservation">
        </form>
        <?php
        } // End of the PHP else block
        ?>
    </main>
    
</body>
</html>
