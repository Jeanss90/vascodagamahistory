<?php 

session_start();
$now = time();

if (isset($_SESSION['id']) && isset($_SESSION['user_name']) && $now < $_SESSION['expire']) {

    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    $dob = $_SESSION['dob'];
    $country = $_SESSION['country'];
    $cpf = $_SESSION['cpf'];
    $email = $_SESSION['email'];
    $user_name = $_SESSION['user_name'];
    $pass = $_SESSION['pass'];
    $role = $_SESSION['role'];

?>

<?php include('vasco.php')?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#28282B"/>
    <title>Meu Perfil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>


<body class="player-form">

    <?php include('loggedinheader.php');?>

    <div class="section">
        <div class="card-panel">   
            <span>
                <div class="form-style">
                
                    <h1 style="text-align: center;">Perfil de Usuário</h1>

                    <div class="form-container">
                
                        <div class="field-container">
                            <label for="nome_completo">Nome Completo: </label>
                            <div class="input-field">
                                <input type="text" id="nome_completo" name="nome_completo" style="color: #28282B" disabled
                                    <?php echo "value='$name'";?>>
                            </div>
                        </div>
        
                        <div class="field-container">
                            <label for="dob">Data de Nascimento: </label>
                            <div class="input-field">
                                <input type="date" id="dob" name="dob" style="color: #28282B" disabled
                                    <?php echo "value='$dob'";
                                    ?>><br>
                            </div>
                        </div>

                        <div class="field-container">
                            <label for="country">País de Nascimento: </label>
                            <div class="input-field">
                                <input type="text" id="country" name="country" style="color: #28282B" disabled
                                    <?php echo "value='$country'";?>>
                            </div>
                        </div>

                        <div class="field-container">
                            <label for="cpf">CPF: </label>
                            <div class="input-field">
                                <input type="text" id="cpf" name="cpf" style="color: #28282B" disabled
                                    <?php echo "value='$cpf'";?>>
                            </div>
                        </div>

                        <div class="field-container">
                            <label for="email">Email: </label>
                            <div class="input-field">
                                <input type="email" id="email" name="email" style="color: #28282B" disabled
                                    <?php echo "value='$email'";?>>
                            </div>
                        </div>

                        <div class="field-container">
                            <label for="user_name">Username: </label>
                            <div class="input-field">
                                <input type="text" id="user_name" name="user_name" style="color: #28282B" disabled
                                    <?php echo "value='$user_name'";?>>
                            </div>
                        </div>

                        <div class="field-container">
                            <label for="password">Password: </label>
                            <div class="input-field">
                                <div style="display: inline-flex">
                                    <input type="password" id="passwordView" name="password" style="color: #28282B" disabled
                                        <?php echo "value='$pass'";?>>
                                    <i class="material-icons" id="togglePassword" style="margin: 5px auto; cursor: pointer; color:var(--myred)">visibility</i>
                                </div>
                            </div>
                        </div>

                
                        <div class="field-container">
                            <label>Profile Picture: </label>
                            <div class="input-field">
                                <?php
                                    echo "<img src='/img/$role/$id.png' alt='$name' style='width:60px; height:80px; border: var(--mygrey) 1px solid;'>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            
                <p style= "text-align: center">
                    <br>
                    <?php if ($role == "admin") {
                        echo "<a href='/dev-options.php'><img class='backmainpage' >Go to options menu</a><br>";
                    }?>
                    <a href="/index.php">Back to main page</a>
                </p>
            </span>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src='/script.js'></script>
    <script>
        const passwordInput = document.getElementById('passwordView');
        const toggleBtn = document.getElementById('togglePassword');
        let hideTimer = null;

        toggleBtn.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
            // Show password
            passwordInput.type = 'text';
            toggleBtn.textContent = 'visibility_off';
            toggleBtn.style.color = '#009688';

            // Re-hide after 10 seconds
            clearTimeout(hideTimer);
            hideTimer = setTimeout(() => {
                passwordInput.type = 'password';
                toggleBtn.textContent = 'visibility';
                toggleBtn.style.color = 'var(--myred)';
            }, 10000);
            } else {
            // Immediately hide if clicked again
            passwordInput.type = 'password';
            toggleBtn.textContent = 'visibility';
            toggleBtn.style.color = 'var(--myred)';
            clearTimeout(hideTimer);
            }
        });
    </script>

</body>
</html>

<?php 
} else {
    header("Location: dev.php");
    exit();
}
?>