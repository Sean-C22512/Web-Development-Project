<?php
require_once 'db_connection.php';  // Ensure you have a database connection file

// Handle POST request to update data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $reservation_date = $_POST['reservation_date'];
    $reservation_time = $_POST['reservation_time'];
    $number_of_people = $_POST['number_of_people'];

    // Prepare the update SQL statement
    $sql = "UPDATE reservations SET name = ?, email = ?, reservation_date = ?, reservation_time = ?, number_of_people = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $name, $email, $reservation_date, $reservation_time, $number_of_people, $id);
    if ($stmt->execute()) {
        echo "<p>Reservation updated successfully.</p>";
    } else {
        echo "<p>Error updating record: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// HTML and PHP to list and edit reservations
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservations | Seans Bistro</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form, ul {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-radius: 5px;
        }

        label {
            display: block;
            margin-top: 1em;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="time"],
        select,
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #004494;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li a {
            color: #0056b3;
            text-decoration: none;
        }

        li a:hover {
            text-decoration: underline;
        }

        footer {
            background: #2c3e50;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Edit Reservations</h1>
    <?php
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM reservations WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $reservation = $result->fetch_assoc();

        if ($reservation) {
            // Show the edit form
            ?>
            <form action="edit_reservations.php" method="post">
                <input type="hidden" name="id" value="<?php echo $reservation['id']; ?>">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($reservation['name']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($reservation['email']); ?>" required>

                <label for="reservation_date">Date:</label>
                <input type="date" id="reservation_date" name="reservation_date" value="<?php echo htmlspecialchars($reservation['reservation_date']); ?>" required>

                <label for="reservation_time">Time:</label>
                <input type="time" id="reservation_time" name="reservation_time" value="<?php echo htmlspecialchars($reservation['reservation_time']); ?>" required>

                <label for="number_of_people">Number of People:</label>
                <input type="number" id="number_of_people" name="number_of_people" value="<?php echo htmlspecialchars($reservation['number_of_people']); ?>" required>

                <input type="submit" value="Update Reservation">
            </form>
            <?php
        } else {
            echo "<p>Reservation not found.</p>";
        }
        $stmt->close();
    } else {
        // List all reservations with edit links
        $sql = "SELECT * FROM reservations";
        $result = $conn->query($sql);

        echo '<ul>';
        while ($row = $result->fetch_assoc()) {
            echo '<li><a href="edit_reservations.php?id=' . $row['id'] . '">' . htmlspecialchars($row['name']) . ' on ' . htmlspecialchars($row['reservation_date']) . '</a></li>';
        }
        echo '</ul>';
    }
    ?>
    <footer>
        <p>&copy; 2024 Seans Bistro. All rights reserved.</p>
    </footer>
</body>
</html>
<?php $conn->close(); ?>
