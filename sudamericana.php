<?php
    include("database_jogos.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Copa Sudamericana</title>
        <?php include('head.php');?>
    </head>
    <body>
        <?php include('loader.html')?>
        <div class="container" id="offload-flex">
            <a href="#">
                <img class="competition-logo" src="/img/copa_sudamericana.svg" alt="logo_copasudamericana">
            </a>
            
            <?php include('back-to-main.html');?>

            <?php include('back-to-competitions.html');?>

            <?php include("sudamericana-group.php");?>

            <?php include("sudamericana-knockout.php");?>

            <?php include('back-to-main.html');?>

            <?php include('back-to-competitions.html');?>
        </div>

        <?php include('footer.php');?>
        
        <script src='/script.js'></script>
    </body>
</html>