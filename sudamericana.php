<?php
    include("database_jogos.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#28282B"/>
    <title>Copa Sudamericana</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>

<body class="background">
    <div class="center-align">
        <div class="section">
            <div class="card-panel carioca">
                <span>

                <a id="logo-container" href="#" class="brand-logo" style="height: inherit;">
                    <img class="responsive table-logo-sula" src="/img/copa_sudamericana.svg" alt="logo_copasudamericana">
                </a>
                <p style= "text-align: center">
                    <a href="/index.php"><img class="backmainpage">Back to Main Page</a>
                </p>
                <p style= "text-align: center">
                    <a href="/competitions.php"><img class="backmainpage">Back to Competitions</a>
                </p>

                <?php
                /*
                include("sudamericana_group.php");
                */
                include("sudamericana_knockout.php");
                ?>

                </span>
                <p style= "text-align: center">
                    <a href="/index.php"><img class="backmainpage">Back to Main Page</a>
                </p>
                <p style= "text-align: center">
                    <a href="/competitions.php"><img class="backmainpage">Back to Competitions</a>
                </p>
            </div>
        </div>            
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src='/script.js'></script>
    
</body>

<footer>
    <?php
        include('footer.php');
    ?>
</footer>

</html>