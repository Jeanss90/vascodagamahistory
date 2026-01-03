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
    $password = $_SESSION['password'];
    $role = $_SESSION['role'];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <title>Profile</title>
    <?php include('head.php');?>
    </head>


    <body>
        <?php include('logged-in-header.php');?>

        <div class="container">
            <div class="form-style">
            
                <h1>User Profile</h1>

                <div class="form-container">
            
                    <div class="field-container">
                        <label class="label-field" for="nome_completo">Full Name: </label>
                        <div>
                            <input class="input-field" type="text" id="nome_completo" name="nome_completo" disabled
                                <?php echo "value='$name'";?>>
                        </div>
                    </div>
    
                    <div class="field-container">
                        <label class="label-field" for="dob">Date of Birth: </label>
                        <div>
                            <input class="input-field" type="date" id="dob" name="dob" disabled
                                <?php echo "value='$dob'";
                                ?>>
                        </div>
                    </div>

                    <div class="field-container">
                        <label class="label-field" for="country">Country: </label>
                        <div>
                            <input class="input-field" type="text" id="country" name="country" disabled
                                <?php echo "value='$country'";?>>
                        </div>
                    </div>

                    <div class="field-container">
                        <label class="label-field" for="cpf">CPF: </label>
                        <div>
                            <input class="input-field" type="text" id="cpf" name="cpf" disabled
                                <?php echo "value='$cpf'";?>>
                        </div>
                    </div>

                    <div class="field-container">
                        <label class="label-field" for="email">Email: </label>
                        <div>
                            <input class="input-field" type="email" id="email" name="email" disabled
                                <?php echo "value='$email'";?>>
                        </div>
                    </div>

                    <div class="field-container">
                        <label class="label-field" for="user_name">Username: </label>
                        <div>
                            <input class="input-field" type="text" id="user_name" name="user_name" disabled
                                <?php echo "value='$user_name'";?>>
                        </div>
                    </div>

                    <div class="field-container">
                        <label class="label-field" for="password">Password: </label>
                        <div>
                            <div style="display: inline-flex">
                                <input style="width: 100%;" class="input-field" type="password" id="passwordView" name="password" disabled
                                    <?php echo "value='$password'";?>>
                                <span class="material-symbols-outlined" id="togglePassword" style="margin: 5px; cursor: pointer; color:var(--error)">visibility</span>
                            </div>
                        </div>
                    </div>

                    <div class="field-container">
                        <label class="label-field"> Profile Picture: </label>
                        <div class="input-field" style="height: 95px !important; text-align: center">
                            <?php
                                echo "<img src='/img/$role/$id.png' alt='$name'>";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($role == "admin") {
            echo "<p class='back'>
                <a href='/dev-options.php'>Go to options menu</a><br>
            </p>";
        }?>
        
        <?php include('back-to-main.html');?>
        
        <?php include('footer.php');?>

        <script src='/script.js'></script>
        <script>
            <?php include('hide-pass.js');?>
        </script>
    </body>
</html>

<?php 
} else {
    header("Location: dev.php");
    exit();
}
?>