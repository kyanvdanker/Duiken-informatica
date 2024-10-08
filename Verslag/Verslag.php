<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "3Musketiers!";
$dbname = "blogDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch blog posts from the database
$sql = "SELECT title, content, created_at FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);

?>
<html>
    <head>
        <link rel="Stylesheet" type="text/css" href="Styles.css">
    </head>
    <body>
<div id="background">
    <div class="head">
        <a href="Duiken.html">Home</a>
        <a class="active" href="Verslag.php">Verslag</a>
        <a href="Database.php">Database</a>
        <a href="Verslagtoevoegen.php">Schrijven</a>
        <a href="Kanban.html">Kanban</a>
        <div class="dropdown">
                <a class="dropdown-width" href="Project.html">Project</a>
                <div class="dropdown-content">
                    <a class="dropdown-width" href="Project.html">Project</a>
                    <a class="dropdown-width" href="Ontwerp.html">Ontwerp</a>
                    <a class="dropdown-width" href="Concept.html">Concept</a>
                </div>
            </div>
    </div>
    &nbsp;
        &nbsp;
    <div class="start">
        <h1 style="text-align: left; margin-top: 100px;">Verslag</h1>
    </div>
    <center>
    <br><br>

    <?php
    if ($result->num_rows > 0) {
        // Output data for each row
        while ($row = $result->fetch_assoc()) {
            echo "<h2 class='verslag-head'>" . $row["title"] . "</h2>";
            echo "<p><small>Posted on " . $row["created_at"] . "</small></p>";
            echo "<p>" . nl2br($row["content"]) . "</p><hr>";
        }
    } else {
        echo "No posts found.";
    }
    ?>
    </center>
</div>
    </body>
</html>