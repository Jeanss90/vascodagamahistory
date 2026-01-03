<?php 

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

?>


<!DOCTYPE html>
<html lang="en">
    <title>Admin - Options</title>
    <?php include('head.php');?>
    <body class="login">
        <?php include('loader.html')?>
        <div class="login-box" id="offload-block">
            <div>
                    
                <h3>Hi <?php echo $_SESSION['name'];?>,</h3>
                <h4>Welcome Back!!</h4>
                <p class="subtitle">Choose one the options below:</p>

                <form action="user.php" method="post" name="user_form">
                    <div class="field">
                        <input class="btn" type="submit" name="user" value="Profile">
                    </div>
                </form>

                <form action="player.php" method="post" name="player_form">
                    <div class="field">
                        <input class="btn "type="submit" name="player" value="Players">
                    </div>
                </form>

                <form action="matches.php" method="post" name="score_form">
                    <div class="field">
                        <input class="btn "type="submit" name="score" value="Matches">
                    </div>
                </form>

                <form action="wages.php" method="post" name="wages_form">
                    <div class="field">
                        <input class="btn "type="submit" name="wages" value="Salaries">
                    </div>
                </form>

                <form action="user-manage.php" method="post" name="users_form">
                    <div class="field">
                        <input class="btn "type="submit" name="users" value="Users">
                    </div>
                </form>
            </div>
        </div>
        
        <script src='/script.js'></script>
    </body>
</html>

<?php 
    
    }else{
    
        header("Location: dev.php");
    
        exit();
    
    }
    
?>