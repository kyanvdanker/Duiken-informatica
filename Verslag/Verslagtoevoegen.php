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
    </div>
        &nbsp;
        <div class="start">
            <h1>Duik meter</h1>
        </div>
        <h2>verslag schrijven</h2>
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
