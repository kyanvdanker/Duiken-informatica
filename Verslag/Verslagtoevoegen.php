<html>
    <head>
        <link rel="Stylesheet" type="text/css" href="Styles.css">
    </head>
    <body>
<div id="background">
    <div class="head">
        <a href="Duiken.html">Home</a>
        <a href="Verslag.php">Verslag</a>
        <a href="Database.php">Database</a>
        <a class="active" href="Verslagtoevoegen.php">Schrijven</a>
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
            <h1 style="text-align: left; margin-top: 100px;">Verslag toevoegen</h1>
        </div>
        <center>
        <form class="toevoegen" action="add_post.php" method="post">
            <label for="title">Titel</label><br>
            <input type="text" id="title" name="title" required><br><br>

            <label for="content">Verslag</label><br>
            <textarea id="content" name="content" rows="10" cols="50" required></textarea><br><br>

            <input type="submit" value="Verzenden" class="btn success">
        </center>
        </form>
</div>
    </body>
</html>
