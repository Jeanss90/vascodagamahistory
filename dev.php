<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#28282B"/>
    <title>Login - CRVG</title>
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
                    
                    <form action="login.php" method="post">
                    
                        <h2 style="text-align: center">Login</h2>
                        
                        <?php if (isset($_GET['error'])) { ?>
    
                        <p class="error" style="text-align: center;"><?php echo $_GET['error']; ?></p>
    
                        <?php } ?>
                                            
                        <div class="field-container">
                            <label>Username: </label>
                            <div class="input-fields">
                                <input type="text" name="uname" placeholder="Username"><br>
                            </div>
                        </div>
                
                        <div class="field-container">
                            <label>Password: </label>
                            <div class="input-fields">
                                <input type="password" name="password" placeholder="******"><br>
                            </div>
                        </div>
                
                        <div class="input-fields" style="text-align: center;">
                            <button type="submit" class="btn btn-info">Login</button>
                        </div>
                        
        
                    </form>
                
                </div>
            </span>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="/script.js"></script>



</body>
</html>