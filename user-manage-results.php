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
        <title>Users - Results</title>
        <?php include('head.php');?>
    </head>

    <body>
        <?php include('logged-in-header.php');?>

        <div class="container">
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
                                <label class='label-field'>Full Name </label>
                                <div class='input-field'>
                                    $form1<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>
                                <label class='label-field'>Date of Birth: </label>
                                <div class='input-field'>
                                    $form2<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>
                                <label class='label-field'>Country: </label>
                                <div class='input-field'>
                                    $form3</br>
                                </div>
                            </div>
                    
                            <div class='field-container'>
                                <label class='label-field'>CPF: </label>
                                <div class='input-field'>
                                    $form4<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>
                                <label class='label-field'>Email:</label>
                                <div class='input-field'>
                                    $form5<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>
                                <label class='label-field'>Username: </label>
                                <div class='input-field'>
                                    $form6<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>        
                                <label class='label-field'>Password: </label>
                                <div class='input-field'>
                                    $form7<br>
                                </div>
                            </div>
                            
                            <div class='field-container'>
                                <label class='label-field'>User Type: </label>
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
                        echo "<h1>User Added Succesfully!</h1>";
                        formResults($form_nome_completo, $form_dob, $form_country, $form_cpf, $form_email, $form_user_name, $form_password, $form_role);
                    } else {
                        if ($atualizar != "") {
                            echo "<h1>User Updated Succesfully!</h1>";
                            formResults($form_nome_completo, $form_dob, $form_country, $form_cpf, $form_email, $form_user_name, $form_password, $form_role);
                        } else {
                            if ($deletar != "") {
                                echo "<h1>User Deleted Succesfully!</h1>";
                                formResults($old_nome_completo, $form_old_dob, $old_country, $old_cpf, $old_email, $old_user_name, $old_password, $old_role);
                            } else {
                                echo "<h1>An error has occurred! Please try again.";
                            }
                        }
                    }
                    
                    if ($adicionar == "adicionar") {
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
                        if ($atualizar == "atualizar") {
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
                            if ($deletar == "deletar") {
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
        </div>    

        <?php include('back-to-options.html');?>
        <?php include('back-to-main.html');?>

        <?php include('footer.php');?>
        
        <script>
            <?php include('hide-pass.js');?>
        </script>
        
        <script src='/script.js'></script>
    </body>
</html>


<?php 
    
    }else{
    
        header("Location: dev.php");
    
        exit();
    
    }
    
?>