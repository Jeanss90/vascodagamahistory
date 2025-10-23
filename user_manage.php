<?php 

session_start();
$now = time();

if (isset($_SESSION['id']) && isset($_SESSION['user_name']) && $now < $_SESSION['expire']) {

include('users.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#28282B"/>
    <title>Developer - Gerenciar Usuários</title>
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
                
                    <h1 style="text-align: center;">Gerenciar Ususários</h1>
                
                    <form action="/user_manage.php" method="post" name="player_form">
                        <div class="field-container" style="padding-bottom:5px; border-bottom: solid #D52315 0.5px; margin-bottom:10px">
                            <label style="padding-top: 8px">

                                <!-- IMPORTANT, use class browser-default as materialize css does not work properly with select on ios iphone-->
                                <select class="browser-default"  style="
                                        background-color: antiquewhite;
                                        color: var(--myred);
                                        font-weight: bold;
                                        font-style: italic;
                                        border: var(--mygrey) 1px solid;"
                                        id="select" name="select">
                                    <option value="" disabled selected>Selecionar usuário</option>
                                    <?php 
                                        $sql = 'SELECT * FROM users ORDER BY id ASC';    // Select table here 
                                        $result = mysqli_query($conn,$sql);  // here i am run the query
                                        $i = 1;                             // only creates sequence of the data
                                        while($row = mysqli_fetch_array($result)) // Showing all the data
                                        {  
                                        
                                            $id = $row['id'];
                                            $name = $row['name'];
                                            $dob = $row['dob'];
                                            $country = $row['country'];
                                            $cpf = $row['cpf'];
                                            $email = $row['email'];
                                            $user_name = $row['user_name'];
                                            $password = $row['password'];
                                            $role = $row['role'];

                                            $user[] = array(
                                                "id" => $id,
                                                "name" => $name,
                                                "dob" => $dob,
                                                "country" => $country,
                                                "cpf" => $cpf,
                                                "email" => $email,
                                                "user_name" => $user_name,
                                                "password" => $password,
                                                "role" => $role
                                            );

                                            echo "<option value='$id'>$name - ($id)</option>";
                                            
                                            $i++;
                                        }

                                    ?>
                                </select>

                            </label>
                            <div class="input-field"  style="display: grid; margin: auto;">
                                <input type="submit" name="buscar" value="Buscar" class="btn btn-info">
                                <button type="submit" name="select" value="" class="btn btn-info">Limpar</button>
                            </div>
                        </div>
                    </form>
                
                    <form action="/user_manage_results.php" method="post" enctype="multipart/form-data" name="player_form">
                        <div style="padding-bottom:5px; border-bottom: solid #D52315 0.5px; margin-bottom:10px">
                            <?php
                            
                            $select = $_POST['select'];
                            $buscar = $_POST['buscar'];
                            
                            if($select != "") {
                                #echo 'teste'; 
                                #echo $select;
                            }

                            foreach ($user as $use) {
                                if ($use['id'] == $select) {
                                    $form_id = $use['id'];
                                    $form_name = $use['name'];
                                    $form_dob = $use['dob'];
                                    $form_country = $use['country'];
                                    $form_cpf = $use['cpf'];
                                    $form_email = $use['email'];
                                    $form_user_name = $use['user_name'];
                                    $form_password = $use['password'];
                                    $form_role = $use['role'];
                                    
                                    $old_name = $name;
                                    $old_dob = $dob;
                                    $old_country = $country;
                                    $old_cpf = $cpf;
                                    $old_email = $email;
                                    $old_user_name = $user_name;
                                    $old_password = $password;
                                    $old_role = $role;
                                }
                            }
                            ?>

                            <div class="form-container">
                        
                                <div class="field-container">
                                    <label for="nome_completo">Nome Completo: </label>
                                    <div class="input-field">
                                        <input type="text" id="nome_completo" name="nome_completo" style="color: #28282B"
                                            <?php echo "value='$form_name'";?>>
                                    </div>
                                </div>
                
                                <div class="field-container">
                                    <label for="dob">Data de Nascimento: </label>
                                    <div class="input-field">
                                        <input type="date" id="dob" name="dob" style="color: #28282B"
                                            <?php echo "value='$form_dob'";
                                            ?>><br>
                                    </div>
                                </div>

                                <div class="field-container">
                                    <label for="country">País de Nascimento: </label>
                                    <div class="input-field">
                                        <input type="text" id="country" name="country" style="color: #28282B"
                                            <?php echo "value='$form_country'";?>>
                                    </div>
                                </div>

                                <div class="field-container">
                                    <label for="cpf">CPF: </label>
                                    <div class="input-field">
                                        <input type="text" id="cpf" name="cpf" style="color: #28282B"
                                            <?php echo "value='$form_cpf'";?>>
                                    </div>
                                </div>

                                <div class="field-container">
                                    <label for="email">Email: </label>
                                    <div class="input-field">
                                        <input type="email" id="email" name="email" style="color: #28282B"
                                            <?php echo "value='$form_email'";?>>
                                    </div>
                                </div>

                                <div class="field-container">
                                    <label for="user_name">Username: </label>
                                    <div class="input-field">
                                        <input type="text" id="user_name" name="user_name" style="color: #28282B"
                                            <?php echo "value='$form_user_name'";?>>
                                    </div>
                                </div>

                                <div class="field-container">
                                    <label for="password">Password: </label>
                                    <div class="input-field">
                                        <div style="display: inline-flex">
                                            <input type="password" id="passwordView" name="password" style="color: #28282B"
                                                <?php echo "value='$form_password'";?>>
                                            <i class="material-icons" id="togglePassword" style="margin: 5px auto; cursor: pointer; color:var(--myred)">visibility</i>
                                        </div>
                                    </div>
                                </div>

                        
                                <!--adding values for old_ inputs-->
                                <?php
                                echo
                                "<input hidden name='form_id' value='$form_id'>
                                <input hidden name='old_name' value='$old_name'>
                                <input hidden name='old_dob' value='$old_dob'>
                                <input hidden name='old_country' value='$old_country'>
                                <input hidden name='old_cpf' value='$old_cpf'>
                                <input hidden name='old_email' value='$old_email'>
                                <input hidden name='old_user_name' value='$old_user_name'>
                                <input hidden name='old_password' value='$old_password'>
                                <input hidden name='old_role' value='$old_role'>

                                "?>
                            </div>
                        </div>

                        <?php 
                            switch ($form_role) {
                                case 'admin':
                                    $admin = "selected";
                                    break;
                                case 'manager':
                                    $manager = "selected";
                                    break;
                                case 'member':
                                    $member = "selected";
                                    break;
                                case 'player':
                                    $player = "selected";
                                    break;
                                default:
                                    $default = "selected";
                                    break;
                            }
                        ?>

                        <div class="field-container">
                            <label for="role">Tipo de usuário: </label>
                                <div class="input-field">
                                    <select class="browser-default" style="
                                            background-color: antiquewhite;
                                            color: var(--myred);
                                            font-weight: bold;
                                            font-style: italic;
                                            border: var(--mygrey) 1px solid;
                                            width: 200%;
                                            margin: 25px 0;
                                            align-items: center;"
                                            id="role" name="role">

                                        <option value="" <?php echo $default ?? ''; ?> disabled>Selecionar Tipo</option>
                                        <option value="admin" <?php echo $admin ?? ''; ?>>Admin</option>
                                        <option value="manager" <?php echo $manager ?? ''; ?>>Manager</option>
                                        <option value="member" <?php echo $member ?? ''; ?>>Member</option>
                                        <option value="player" <?php echo $player ?? ''; ?>>Player</option>
                                    </select>
                                </div>
                        </div>
                    
                        <div class="player-actions">
                            <input type="submit" name="adicionar" value="Adicionar" class="btn btn-info" <?php 
                            if ($select){
                                echo 'disabled';
                            }?>>
                            <input type="submit" name="atualizar" value="Atualizar" class="btn btn-info" <?php 
                            if (!$select){
                                echo 'disabled';
                            }?>>
                            <input type="submit" name="deletar" value="Deletar" class="btn btn-info" <?php 
                            if (!$select){
                                echo 'disabled';
                            }?>>
                            <!-- criar janela para confirmar da acao de deletar o usuario **usuario sera deletado permanentemente**-->
                        </div>
                    </form>
                </div>
            
                <p style= "text-align: center">
                    <br>
                    <a href="/dev-options.php"><img class="backmainpage" >Go to options menu</a><br>
                    <a href="/squad.php"><img class="backmainpage" >Go to Squad page</a>
                </p>
            </span>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src='/script.js'></script>
    <script>
        <?php include('hide_pass.js');?>
    </script>
</body>
</html>

<?php 
} else {
    header("Location: dev.php");
    exit();
}
?>