<?php 

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

?>


<?php
include("users.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#28282B"/>
    <title>Gerenciar Usuários - Results</title>
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
        <div id="results" class="form-style">
            
        <?php
            
            $adicionar = $_POST['adicionar'];
            $atualizar = $_POST['atualizar'];
            $deletar = $_POST['deletar'];
            
            $form_id = $_POST['form_id'];
            $form_nome_completo = $_POST['nome_completo'];
            $dob = $_POST['dob'];
            $form_country = $_POST['country'];
            $form_cpf = $_POST['cpf'];
            $form_email = $_POST['email'];
            $form_user_name = $_POST['user_name'];
            $form_password = $_POST['password'];
            $form_role = $_POST['role'];
            
            $old_nome_completo = $_POST['old_name'];
            $old_dob = $_POST['old_dob'];
            $old_country = $_POST['old_country'];
            $old_cpf = $_POST['old_cpf'];
            $old_email = $_POST['old_email'];
            $old_user_name = $_POST['old_user_name'];
            $old_password = $_POST['password'];
            $old_role = $_POST['old_role'];

            
            $form_dob = date_format(date_create($dob), 'd/m/Y');
            $form_old_dob = date_format(date_create($old_dob), 'd/m/Y');            
            
            function formResults($form1, $form2, $form3, $form4, $form5, $form6, $form7, $form8) {
                echo
                "<div class='form-container'>
                    <div class='field-container'>
                        <label>Nome Completo: </label>
                        <div class='input-field'>
                            $form1<br>
                        </div>
                    </div>
                    
                    <div class='field-container'>
                        <label>Data de Nascimento: </label>
                        <div class='input-field'>
                            $form2<br>
                        </div>
                    </div>
                    
                    <div class='field-container'>
                        <label>País de Nascimento: </label>
                        <div class='input-field'>
                            $form3</br>
                        </div>
                    </div>
            
                    <div class='field-container'>
                        <label>CPF: </label>
                        <div class='input-field'>
                            $form4<br>
                        </div>
                    </div>
                    
                    <div class='field-container'>
                        <label>Email:</label>
                        <div class='input-field'>
                            $form5<br>
                        </div>
                    </div>
                    
                    <div class='field-container'>
                        <label>Username: </label>
                        <div class='input-field'>
                            $form6<br>
                        </div>
                    </div>
                    
                    <div class='field-container'>        
                        <label>Password: </label>
                        <div class='input-field'>
                            $form7<br>
                        </div>
                    </div>
                    
                    <div class='field-container'>
                        <label>Tipo de Usuário: </label>
                        <div class='input-field'>
                            $form8<br>
                        </div>
                    </div>
                </div>
                ";
            }

            #echo $adicionar;
            #echo $atualizar;
            #echo $deletar;

            if ($adicionar != "") {
                echo "<h1 style='text-align: center'>Usuario Adicionado com Sucesso!</h1>";
                formResults($form_nome_completo, $form_dob, $form_country, $form_cpf, $form_email, $form_user_name, $form_password, $form_role);
            } else {
                if ($atualizar != "") {
                    echo "<h1 style='text-align: center'>Lista de Usuario Atualizada Com Sucesso!</h1>";
                    formResults($form_nome_completo, $form_dob, $form_country, $form_cpf, $form_email, $form_user_name, $form_password, $form_role);
                } else {
                    if ($deletar != "") {
                        echo "<h1 style='text-align: center'>Usuario Deletado Com Sucesso!</h1>";
                        formResults($old_nome_completo, $form_old_dob, $old_country, $old_cpf, $old_email, $old_user_name, $old_password, $old_role);
                    } else {
                        echo "<h1 style='text-align: center'>An error has occurred! Please try again.";
                    }
                }
            }
            
            if ($adicionar == "Adicionar") {
                $sql = "INSERT INTO users (
                `user_name`,
                `password`,
                `name`,
                `dob`, 
                `country`,
                `cpf`,
                `email`,
                `role`
                )
                VALUES (
                '$form_user_name',
                '$form_password',
                '$form_nome_completo',
                '$dob',
                '$form_country',
                '$form_cpf',
                '$form_email',
                '$form_role'
                )";
            } else {
                if ($atualizar == "Atualizar") {
                    $sql = "UPDATE users SET 
                        `user_name` = '$form_user_name',
                        `password` = '$form_password',
                        `name` = '$form_nome_completo',
                        `dob` = '$dob',
                        `country` = '$form_country',
                        `cpf` = '$form_cpf',
                        `email` = '$form_email',
                        `role` = '$form_role'
                        WHERE id = '$form_id';";
                } else {
                    if ($deletar == "Deletar") {
                        $sql = "DELETE FROM users WHERE id = '$form_id';";
                    }
                }
            }
            
            #echo $adicionar." ";
            #echo $atualizar." ";
            #echo $deletar." ";
            
            
            if ($conn->query($sql) === TRUE) {
                #echo " Records updated! ".$form_user_name."-".$form_password."-".$form_nome_completo."-".$dob."-".$form_country."-".$form_cpf."-".$form_email."-".$form_role;
            } else {
                #echo " Error: ".$sql."<br>".$conn->error;
            }
            ?>

        </div>
        
        </span>

        
        <p style= "text-align: center">
            <a href="/user_manage.php"><img class="backmainpage">Back to Users List</a><br>
            <a href="/dev_options.php"><img class="backmainpage">Go to options menu</a><br>
            <a href="/squad.php"><img class="backmainpage">Go to Squad page</a>
        </p>
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