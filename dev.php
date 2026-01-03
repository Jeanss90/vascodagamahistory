<?php
session_start();
$now = time();

if (!empty($_SESSION['id']) && !empty($_SESSION['user_name']) && $now < $_SESSION['expire']) {

    if ($_SESSION['role'] == 'admin') {
            header("Location: dev-options.php");
        } else {
            header("Location: user.php");
        }
    exit;
} else {
?>


<!DOCTYPE html>
<html lang="en">
    <title>Login</title>
    <?php include('head.php');?>
    <body class="login">
        <?php include('loader.html')?>
        <div class="login-box" id="offload-block">
            <h1>Welcome</h1>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <p class="subtitle">Sign in to your account</p>

            <form action="login.php" method="post">
                <div class="field">
                    <input type="username" name="uname" required>
                    <label for="uname">Username</label>
                </div>

                <div class="field">
                    <input type="password" name="pass" required>
                    <label for="password">Password</label>
                </div>

                <div class="options"><!--add cookie to remember me-->
                    <label for="remember">
                        <input type="checkbox">Remember Me
                    </label>
                    <a href="#">Forgot your password?</a>
                </div>

                <button type="submit">Sign In</button>
            </form>

            <div class="signup">
                Don't have an account?
                <a href="#">Sign Up</a>
            </div>
        </div>
        <script src="script.js"></script>
    </body>
</html>
<?php
}
?>