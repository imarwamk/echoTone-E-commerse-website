<nav class="navbar navbar-expand-lg custom-navbar">
    <div class="container">
        <a class="navbar-logo" href="#">EchoTone</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
            aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars menu-icon"></i>
            <i class="fas fa-times close-icon d-none"></i>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="../pages/index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Shop</a></li>
                <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                <li class="nav-item"><a class="nav-link" href="../pages/contact.php">Contact</a></li>
                <a href="../pages/cart.php" class="cart-icon">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <span class="cart-count">0</span>
                </a>
                <div class="search-card">
                    <a href="../api/search.php" class="btn icon-btn">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </a>
                </div>
                <a href="../logout.php" class="btn icon-btn">
                    <i class="fa-regular fa-user"> Logout</i>
                </a>
            </ul>
        </div>
    </div>
</nav>
