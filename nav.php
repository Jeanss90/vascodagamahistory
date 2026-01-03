<nav class="navbar">
    <p class="logo"><a href="index.php"><img src="/img/android-chrome-192x192.png" alt="vascodagamahistory">vascodagamahistory<span>.com</span></a></p>

    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="squad.php">Squad</a></li>
        <li><a href="competitions.php">Competitions</a></li>
        <li class="index-login"><a href='dev.php'>
        <?php
            session_start();

            if (!empty($_SESSION['id']) && !empty($_SESSION['user_name'])) {
                $id = $_SESSION['id'];
                $role = $_SESSION['role'];
                $name = $_SESSION['name'];

                    if ($role == "admin") {
                        echo "Admin";
                    } else {
                        echo "My Profile";
                    }
                } else {
                    echo "Login<span class='material-symbols-outlined'>account_circle</span>";
                }
        ?>
        </a></li>
    </ul>

    <div class="hamburger">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>
</nav>