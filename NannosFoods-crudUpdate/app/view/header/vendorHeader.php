<!-- NAV BAR START -->
<?php session_start(); ?>
<nav class="navbar navbar-expand-sm navbar-light bg-light">
    <a class="navbar-brand ml-5" href="../model/logout.php">Nanno's Food</a>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ml-auto mr-5">

            <span class="navbar-text">
                Welcome, <?php echo $_SESSION['VendorName']; ?>!
            </span>

            <li class="nav-item">
                <a class="nav-link active" href="../model/logout.php">Log Out</a>
            </li>
        </div>
    </div>
</nav>

<!-- NAV BAR END -->