<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | Seans Bistro</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Custom styles for the contact form */
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
        textarea {
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
            // Collect post data
            $name = $conn->real_escape_string($_POST['name']);
            $email = $conn->real_escape_string($_POST['email']);
            $message = $conn->real_escape_string($_POST['message']);

            // Prepare SQL Insert statement
            $sql = "INSERT INTO enquiries (name, email, message) VALUES ('$name', '$email', '$message')";

            // Execute the query
            if ($conn->query($sql) === TRUE) {
                echo "<p>Your query was successful. Redirecting in 3 seconds...</p>";
                echo "<script>setTimeout(() => { window.location.href = 'Restaurant.html'; }, 3000);</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        } else {
            // Form was not submitted, display the form
        ?>
        <h1>Contact Us</h1>
        <form method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>

            <input type="submit" value="Send">
        </form>
        <?php
        } // End of the PHP else block
        ?>
    </main>
    
</body>
</html>
