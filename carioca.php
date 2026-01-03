<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Carioca</title>
        <?php echo ""; include('head.php');?>
    </head>
    <body>
        <?php include('loader.html')?>
        <div class="container" id="offload-flex">
            <a href="#">
                <img class="competition-logo" src="/img/carioca2025_vertical.svg" alt="logo_campeonatocarioca">
            </a>

            <?php include('back-to-main.html');?>

            <?php include('back-to-competitions.html');?>

            <?php include("carioca-group.php");?>

            <?php include("carioca-matches.php");?>

            <?php include('back-to-main.html');?>

            <?php include('back-to-competitions.html');?>
        </div>

        <?php include('footer.php');?>

        <script src='/script.js'></script>
    </body>
</html>