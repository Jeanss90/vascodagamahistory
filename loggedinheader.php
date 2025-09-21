<header class="header-match">
    <div class="game" style="justify-content: space-evenly; visibility: visible; display: flex; border-bottom: var(--myred) 2px solid;">
        <div>
        <h2>Hello, <?php echo $_SESSION['name']; ?></h2>
        </div>
        <div>
        <a href="logout.php" class="btn btn-info">Logout</a>
        </div>
    </div>
</header>