<html>
    <head>
        <link rel="stylesheet" type="text/css" href="Styles.css">
    </head>
    <body>
        
<div id="background">
    <div class="head">
        <a href="Duiken.html">Home</a>
        <a href="Verslag.php">Verslag</a>
        <a class="active" href="Database.php">Database</a>
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
        <div class="start"> 
            <h1 style="text-align: left; margin-top: 100px;">Database</h1>
        </div>
        <center>
        <form class="search" target="searchResults" action="phpSearch.php" method="post">
            <input class="input" placeholder="Search" type="text" name="search"><br>
            <button class="btn success">Zoeken</button>
        </form>
        </center>
        <h2>Resultaten</h2>

            <iframe name="searchResults" class="results"></iframe>
        <h2>Duiken</h2>
        <table>
            <thead>
                <tr>
                    <Th>Datum</Th>
                    <th>Duur</th>
                    <th>Diepte</th>
                    <th>No_decompression_time</th>
                    <th>No_decompression_time</th>
                </tr>
            </thead>
            <tbody>
                <P>
                <?php
                    $conn = mysqli_connect("localhost:3306", "root", "3Musketiers!", "databaseduiken");
                    if ($conn-> connect_error) {
                        die("Connection failed:". $conn-> connect_error);
                    }

                    $sql = "SELECT Datum, Duur, Diepte, No_decompression_time, Decompression_time FROM duiken";
                    $result = $conn-> query($sql);

                    if ($result-> num_rows > 0 ) {
                        while ($row = $result-> fetch_assoc()) {
                        echo "<tr><td>". $row["Datum"] ."</td><td>". $row["Duur"]. "</td><td>". $row["Diepte"] ."</td><td>". $row["No_decompression_time"]. "</td><td>". $row["Decompression_time"] ."</td></tr>";
                        }
                    echo "</table>";
                    }
                    else {
                        echo "0 result";
                    }
                    $conn-> close();                    
                ?> 
            </P>
            </tbody>
        </table>
</div>
    </body>
</html>