<?php 

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#28282B"/>
    <title>Developer - Options</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>

<body class="login-form">
    <div class="section">
        <div class="card-panel">
            <span>

                    <div class="form-style">
                            
                        <h2 style="margin-top: 0px; text-align: center">Hi <?php echo $_SESSION['name'];?>,</h2>
                        <h3 style="text-align: center;">Welcome Back!!</h3>
                        
                        
                        <h4 style="text-align: center;">Choose one the options below:</h4><br>

                        <form action="user.php" method="post" name="user_form">
                            <div class="field-container" style="padding-bottom:5px; margin-bottom:10px">
                                <div class="input-fields"  style="display: grid; margin: auto;">
                                    <input type="submit" name="user" value="Meu Perfil" class="btn btn-info">
                                </div>
                            </div>
                        </form>

                        <form action="player.php" method="post" name="player_form">
                            <div class="field-container" style="padding-bottom:5px; margin-bottom:10px">
                                <div class="input-fields"  style="display: grid; margin: auto;">
                                    <input type="submit" name="player" value="Lista de Jogadores" class="btn btn-info">
                                </div>
                            </div>
                        </form>

                        <form action="score.php" method="post" name="score_form">
                            <div class="field-container" style="padding-bottom:5px; margin-bottom:10px">
                                <div class="input-fields"  style="display: grid; margin: auto;">
                                    <input type="submit" name="score" value="Lista de Jogos" class="btn btn-info">
                                </div>
                            </div>
                        </form>

                        <form action="wages.php" method="post" name="wages_form">
                            <div class="field-container" style="padding-bottom:5px; margin-bottom:10px">
                                <div class="input-fields"  style="display: grid; margin: auto;">
                                    <input type="submit" name="wages" value="Pagamentos" class="btn btn-info">
                                </div>
                            </div>
                        </form>
                    </div>
            </span>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src='/script.js'></script>
</body>
</html>

<?php 
    
    }else{
    
        header("Location: dev.php");
    
        exit();
    
    }
    
?>