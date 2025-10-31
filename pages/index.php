<?php
session_start();

if (!isset($_SESSION['user_id'])) {

    header("Location: ../auth/auth.php");
    exit();
}

$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EchoTone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <?php include '../includes/navbar.php'; ?>

    <section class="hero text-center text-light">
        <div class="container py-5">
            <h1 data-aos="fade-up" class="display-4 fw-bold">Feel the Rhythm</h1>
            <p data-aos="fade-up" data-aos-delay="200" class="lead">Discover timeless vinyls — from classics to new
                hits.</p>
            <a href="#item" class="btn custom-btn mt-3" data-aos="zoom-in" data-aos-delay="300">Shop Now</a>
            <a href="#" class="btn custom-btn mt-3" data-aos="zoom-in" data-aos-delay="300">View Collections</a>
        </div>
    </section>
    <div data-aos="fade-up" class="container-fluid hero-bg">
    </div>


    <div class="container" data-aos="fade-up">

        <h2 class="text-center text-light mt-5 mb-3" data-aos="fade-up"></h2>
        <div class="row" id="item">
        </div>

        <h2 class="text-center text-light mt-5 mb-3" data-aos="fade-up"></h2>
        <div class="row" id="item">
        </div>

        <h2 class="text-center text-light mt-5 mb-3" data-aos="fade-up"></h2>
        <div class="row" id="item">
        </div>

        <section>
            <div class="banner1" data-aos="zoom-in"> <img width="110px" src="../assets/img/vinylImg/dis.png" alt=""
                    class="rotate"> <img width="210px"
                    src="../assets/img/vinylImg/pink.png" alt=""
                    class="rotate"> <img width="110px"
                    src="../assets/img/vinylImg/blue.png" alt=""
                    class="rotate"> <br><br>
                <h1>Jazz & Soul Nights</h1>
                <p>Smooth tunes for every mood — perfect for cozy evenings.</p> <button class="banener-btn"> Shop
                    Jazz</button>
            </div>
        </section>
    </div>




    <?php include '../includes/footer.php'; ?>


    <script>
        const toggler = document.querySelector('.navbar-toggler');
        const menuIcon = document.querySelector('.menu-icon');
        const closeIcon = document.querySelector('.close-icon');
        toggler.addEventListener('click', () => {
            menuIcon.classList.toggle('d-none');
            closeIcon.classList.toggle('d-none');
        });
    </script>

    <script src="../assets/js/script.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        function updateCartIconCount() {
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            const count = cart.reduce((total, item) => total + item.quantity, 0);
            const cartCount = document.querySelector(".cart-count");
            if (cartCount) {
                cartCount.textContent = count;
                cartCount.style.display = count > 0 ? "inline-block" : "none";
            }
        }
        document.addEventListener("DOMContentLoaded", updateCartIconCount);
    </script>

</body>

</html>