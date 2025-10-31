<!DOCTYPE html>
<html lang="ar">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart - EchoTone</title>
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

  <div class="container my-5">
    <div class="section-title" data-aos="fade-up">
      <h1>Shopping Cart</h1>
    </div>

    <div class="row mt-5">
      <div class="col-lg-8" data-aos="fade-right">
        <div class="cart-page-container">
          <div class="items-in-cart" id="cart-items">
          </div>
        </div>
      </div>

      <div class="col-lg-4" data-aos="fade-left">
        <div class="cart-summary">
          <h3>Order Summary</h3>
          <div class="summary-details">
            <div class="summary-row">
              <span>Items:</span>
              <span class="count-item-cart">0</span>
            </div>
            <div class="summary-row total-row">
              <span>Total:</span>
              <div class="total-img">
                <img width="30px" src="../assets/img/sar.png" alt="">
                <span class="price-cart-total"></span>
              </div>
            </div>
          </div>
          <div class="button-cart">
            <a href="../pages/checkout.php" class="btn custom-btn w-100 mb-3">Checkout</a>
            <a href="../pages/index.php" class="btn custom-btn w-100 trans-bg">Continue Shopping</a>
          </div>
        </div>
      </div>
    </div>
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

  <script>
    function renderCart() {
      const cartItemsContainer = document.getElementById("cart-items");
      let cart = JSON.parse(localStorage.getItem("cart")) || [];

      if (cart.length === 0) {
        cartItemsContainer.innerHTML = `
                    <div class="empty-cart">
                        <i class="fa-solid fa-cart-shopping" style="font-size: 80px; color: var(--light-gray); margin-bottom: 20px;"></i>
                        <h3>Your cart is empty</h3>
                        <p>Add some items to get started!</p>
                        <a href="../pages/index.php" class="btn custom-btn mt-3">Start Shopping</a>
                    </div>
                `;
      } else {
        cartItemsContainer.innerHTML = "";

        cart.forEach((item, index) => {
          cartItemsContainer.innerHTML += `
                        <div class="item-cart-page">
                            <img src="../${item.img}" alt="${item.name}">
                            <div class="content">
                                <h6>${item.name}</h6>
                                <p class="desc-cart">${item.desc}</p>
                                <p style="color: #bbb;">${item.artist}</p> 
                                <div class="price-cart">
                                    <img src="../assets/img/sar.png">
                                    <span>${item.price}</span>
                                </div>
                                <div class="quantity-control">
                                    <button class="decrease-quantity" onclick="changeQuantity(${index}, -1)">-</button>
                                    <span class="quantity">${item.quantity}</span>
                                    <button class="increase-quantity" onclick="changeQuantity(${index}, 1)">+</button>
                                </div>
                            </div>
                            <button class="delete-item" onclick="removeItem(${index})"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    `;
        });
      }

      document.querySelector(".count-item-cart").textContent = cart.length;

      const total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
      document.querySelector(".price-cart-total").textContent = `${total.toFixed(2)}
       `;
    }

    function changeQuantity(index, delta) {
      let cart = JSON.parse(localStorage.getItem("cart")) || [];
      cart[index].quantity += delta;

      if (cart[index].quantity < 1) cart[index].quantity = 1;

      localStorage.setItem("cart", JSON.stringify(cart));
      renderCart();
    }

    function removeItem(index) {
      let cart = JSON.parse(localStorage.getItem("cart")) || [];

      Swal.fire({
        html: `
                <i class="fa-solid fa-circle-question" 
                style="font-size: 70px; color: rgb(2, 230, 255); margin-bottom: 15px;"></i>
                <h2 style="color:#ddd;">Remove Item?</h2>
                <p style="color:#ddd;">Are you sure you want to remove this item from your cart?</p>
                `,
        customClass: {
          popup: 'blur-popup'
        },
        showCancelButton: true,
        confirmButtonText: "Yes, remove it",
        cancelButtonText: "Cancel",
        confirmButtonColor: "rgb(2, 230, 255)",
        cancelButtonColor: "#c92908",
        background: "rgba(249, 249, 249, 0.3)",
      }).then((result) => {
        if (result.isConfirmed) {
          cart.splice(index, 1);
          localStorage.setItem("cart", JSON.stringify(cart));
          renderCart();

          Swal.fire({
            html: `
                        <i class="fa-solid fa-circle-check" 
                        style="font-size: 70px; color:rgb(2, 230, 255); margin-bottom: 15px;"></i>
                        <h2 style="color:#ddd;">Removed!</h2>
                        <p style="color:#ddd;">Item has been removed from your cart</p>
                        `,
            customClass: {
              popup: 'blur-popup'
            },
            confirmButtonText: "OK",
            confirmButtonColor: "rgb(2, 230, 255)",
            background: "rgba(249, 249, 249, 0.3)",
            timer: 2000
          });
        }

      });

    }

    document.addEventListener("DOMContentLoaded", renderCart);
  </script>

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