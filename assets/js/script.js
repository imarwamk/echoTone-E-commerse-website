let productsContainer = document.getElementById("item");

if (productsContainer) {

    fetch("http://localhost/echo-tone/api/getProduct.php")
        .then((response) => response.json())
        .then((result) => {
            console.log(result);
            renderProductsByCategory(result);
        })
        .catch((error) => console.error(error));

    function renderProductsByCategory(products) {
        productsContainer.innerHTML = "";

        const categories = {
            1: { name: "Pop", items: [] },
            2: { name: "Rock", items: [] },
            3: { name: "Top Hits", items: [] },
        };

        products.forEach((item) => {
            const catId = item.category_id;
            if (categories[catId]) {
                categories[catId].items.push(item);
            } else {
                if (!categories["others"]) {
                    categories["others"] = { name: "Others", items: [] };
                }
                categories["others"].items.push(item);
            }
        });

        for (const key in categories) {
            const category = categories[key];

            if (category.items.length > 0) {
                productsContainer.innerHTML += `
                    <h2 class="text-center text-light mt-5 mb-3" data-aos="fade-up">${category.name}</h2>
                    <div class="row" id="item">
                        ${category.items.map(item => `
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="card-home">
                                    <div class="top-bar">
                                        <div class="top-sale">
                                            <i class="fa-solid fa-fire"></i>
                                            <p>Top sale</p>
                                        </div>
                                        <div class="fav-icon">
                                            <i class="fa-regular fa-heart"></i>
                                        </div>
                                    </div>
                                    <img class="product-img" width="230px" src="../${item.AlbumCover}" alt="Album Cover">
                                    <div class="info-card">
                                        <div class="name"><h3>${item.albumName}</h3></div>
                                        <div class="desc"><p>${item.albumDesc}</p></div>
                                        <div class="brand"><p>${item.artistName}</p></div>
                                        <div class="price">
                                            <img width="20px" src="../assets/img/sar.png" alt="SAR">
                                            <p>${item.price}</p>
                                        </div>
                                        <button class="card-btn add-to-cart" 
                                            data-id="${item.id }" 
                                            data-name="${item.albumName}" 
                                            data-desc="${item.albumDesc}"
                                            data-price="${item.price}" 
                                            data-img="${item.AlbumCover}"
                                            data-artist="${item.artistName}">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                            Add to cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `).join("")}
                    </div>
                `;
            }
        }

        attachAddToCartListeners();
    }

    function attachAddToCartListeners() {
        const addToCartButtons = document.querySelectorAll(".add-to-cart");
        addToCartButtons.forEach(button => {
            button.addEventListener("click", () => {
                const id = button.dataset.id;
                const name = button.dataset.name;
                const desc = button.dataset.desc;
                const price = button.dataset.price;
                const artist = button.dataset.artist;
                const img = button.dataset.img;

                const product = { id, name, desc, price, img, artist, quantity: 1 };

                let cart = JSON.parse(localStorage.getItem("cart")) || [];
                const existingItem = cart.find(item => item.name === name);
                if (existingItem) {
                    existingItem.quantity++;
                } else {
                    cart.push(product);
                }

                localStorage.setItem("cart", JSON.stringify(cart));
                updateCartIconCount();

                Swal.fire({
                    html: `
                    <i class="fa-solid fa-circle-check" 
                    style="font-size: 70px; color: rgb(2, 230, 255); margin-bottom: 15px;"></i>
                    <h2 style="color:#ddd;">Item Added!</h2>
                    <p style="color:#ddd;">${name} has been added to your cart</p>
                    `,
                    customClass: { popup: 'blur-popup' },
                    showCancelButton: true,
                    confirmButtonText: "Go to Cart",
                    cancelButtonText: "Continue Shopping",
                    confirmButtonColor: "rgb(2, 230, 255)",
                    cancelButtonColor: "#6c757d",
                    background: "rgba(249, 249, 249, 0.3)",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../pages/cart.php";
                    }
                });
            });
        });
    }
}
