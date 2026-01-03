<?php 

session_start();
$now = time();

if (isset($_SESSION['id']) && isset($_SESSION['user_name']) && $now < $_SESSION['expire']) {

include('users.php');

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Users</title>
        <?php include('head.php');?>
    </head>

    <body>
        <?php include('logged-in-header.php');?>

        <div class="container">
            <div class="form-style">
            
                <h1>Manage Users</h1>
            
                <form action="/user-manage.php" method="post" name="player_form">
                    <div class="form-container-select">
                        <label>
                        <select class="input-field input-field-select" id="select" name="select">
                                <option value="" disabled selected>Select User</option>
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
                        <div>
                            <button type="submit" name="buscar" value="select" class="btn btn-form">Select</button>
                            <button type="submit" name="select" calue="limpar" class="btn btn-form">Clear</button>
                        </div>
                    </div>
                </form>
            
                <form action="/user-manage-results.php" method="post" enctype="multipart/form-data" name="player_form">

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
                            <label class="label-field" for="nome_completo">Full Name: </label>
                            <input class="input-field" type="text" id="nome_completo" name="nome_completo" style="color: #28282B"
                                <?php echo "value='$form_name'";?>>
                        </div>
        
                        <div class="field-container">
                            <label class="label-field" for="dob">Date of Birth: </label>
                            <input class="input-field" type="date" id="dob" name="dob" style="color: #28282B"
                                <?php echo "value='$form_dob'";
                                ?>>
                        </div>

                        <div class="field-container">
                            <label class="label-field" for="country">Country: </label>
                            <input class="input-field" type="text" id="country" name="country" style="color: #28282B"
                                <?php echo "value='$form_country'";?>>
                        </div>

                        <div class="field-container">
                            <label class="label-field" for="cpf">CPF: </label>
                            <input class="input-field" type="text" id="cpf" name="cpf" style="color: #28282B"
                                <?php echo "value='$form_cpf'";?>>
                        </div>

                        <div class="field-container">
                            <label class="label-field" for="email">Email: </label>
                            <input class="input-field"type="email" id="email" name="email" style="color: #28282B"
                                <?php echo "value='$form_email'";?>>
                        </div>

                        <div class="field-container">
                            <label class="label-field" for="user_name">Username: </label>
                            <input class="input-field" type="text" id="user_name" name="user_name" style="color: #28282B"
                                <?php echo "value='$form_user_name'";?>>
                        </div>

                        <div class="field-container">
                            <label class="label-field" for="password">Password: </label>
                            <div>
                                <div style="display: inline-flex">
                                    <input style="width: 100%;" class="input-field" type="password" id="passwordView" name="password"
                                        <?php echo "value='$form_password'";?>>
                                    <span class="material-symbols-outlined" id="togglePassword" style="margin: 5px; cursor: pointer; color:var(--error)">visibility</span>
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
                            <label class="label-field" for="role">User Type: </label>
                                <select  class="input-field" id="role" name="role">
                                    <option value="" <?php echo $default ?? ''; ?> disabled>Selecionar Tipo</option>
                                    <option value="admin" <?php echo $admin ?? ''; ?>>Admin</option>
                                    <option value="manager" <?php echo $manager ?? ''; ?>>Manager</option>
                                    <option value="member" <?php echo $member ?? ''; ?>>Member</option>
                                    <option value="player" <?php echo $player ?? ''; ?>>Player</option>
                                </select>
                        </div>
                
                        <div class="form-actions">
                            <button type="submit" name="adicionar" value="adicionar" class="btn btn-form" <?php 
                            if ($select){
                                echo 'disabled';
                            }?>>Add</button>
                            <button type="submit" name="atualizar" value="atualizar" class="btn btn-form" <?php 
                            if (!$select){
                                echo 'disabled';
                            }?>>Update</button>
                            <button type="submit" name="deletar" value="deletar" class="btn btn-form" <?php 
                            if (!$select){
                                echo 'disabled';
                            }?>>Delete</button>
                            <!-- criar janela para confirmar da acao de deletar o usuario **usuario sera deletado permanentemente**-->
                        </div>
                    </div>
                </form>
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
} else {
    header("Location: dev.php");
    exit();
}
?>