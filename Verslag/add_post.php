<?php
// Database connection details
$servername = "localhost:3306";
$username = "root";
$password = "3Musketiers!"; // Adjust as needed
$dbname = "blogDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$title = $_POST['title'];
$content = $_POST['content'];

// Insert the blog post into the database
$sql = "INSERT INTO posts (title, content) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $title, $content);

if ($stmt->execute()) {
    echo "New post added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>
