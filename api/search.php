<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Search </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/search.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>


    <?php include '../includes/navbar.php'; ?>

    <div class="container my-5">
        <div class="section-title" data-aos="fade-up">
        </div>
        <div class="page-search-card" data-aos="fade-up">
            <input type="text" id="searchInput" placeholder="Search by album or artist..." autocomplete="off">
            <button type="button" onclick="document.getElementById('searchInput').focus()">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>

        <div class="container my-5">
            <div class="section-title" data-aos="fade-up">
                <h1>Recently Searched</h1>
            </div>

            <div id="productsContainer" class="row mt-5" data-aos="fade-up">
            </div>

            <p class="error-message" id="noResultsMessage" style="display: none;">
                No album or artist found for "<span id="searchTerm"></span>"
            </p>
        </div>

    </div>

    <?php include '../includes/footer.php'; ?>

    <script>
        const searchInput = document.getElementById('searchInput');
        const productsContainer = document.getElementById('productsContainer');
        const noResultsMessage = document.getElementById('noResultsMessage');
        const searchTerm = document.getElementById('searchTerm');

        function renderProducts(products) {
            productsContainer.innerHTML = '';
            products.forEach(p => {
                productsContainer.innerHTML += `
            <div class="col product-item">
                <div class="card-home resent">
                    <img src="../${p.AlbumCover}" width="130px" alt="${p.albumName}">
                    <div class="col">
                        <h3 style="font-size: 20px;">${p.albumName}</h3>
                        <p>${p.artistName}</p>
                        <p><img src="../assets/img/sar.png" width="20"> ${p.price} </p>
                    </div>
                    <button class="card-btn">View</button>
                </div>
            </div>
        `;
            });
        }
        fetch("../api/getProduct.php")
            .then(res => res.json())
            .then(data => renderProducts(data))
            .catch(err => console.error(err));

        searchInput.addEventListener('input', () => {
            const searchValue = searchInput.value.trim();

            if (searchValue === '') {
                noResultsMessage.style.display = 'none';
                return;
            }

            fetch(`../api/searchProduct.php?q=${encodeURIComponent(searchValue)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        renderProducts(data);
                        noResultsMessage.style.display = 'none';
                    } else {
                        productsContainer.innerHTML = '';
                        noResultsMessage.style.display = 'block';
                        searchTerm.textContent = searchValue;
                    }
                })
                .catch(err => console.error(err));
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>

</html>