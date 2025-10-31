<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/auth.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - EchoTone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../assets/css/checkout.css">
</head>

<body>
    <?php include '../includes/navbar.php'; ?>

<div class="container d-flex justify-content-center align-items-start flex-wrap gap-4" style="min-height: 90vh;">

        <div class="checkout-card card-home p-4" data-aos="fade-up" style="width: 500px;">
            <h2 class="text-center mb-4" style="font-family: 'Cinzel'; color: white;">Checkout</h2>

            <form id="checkoutForm">
                <div class="mb-3 text-start">
                    <label>Full Name</label>
                    <input type="text" name="name" placeholder="Enter your name" required>
                </div>

                <div class="mb-3 text-start">
                    <label>Phone Number</label>
                    <input type="text" name="phone" placeholder="Enter your phone" required>
                </div>

                <div class="mb-3 text-start">
                    <label>Address</label>
                    <textarea name="address" placeholder="Enter your full address" required></textarea>
                </div>

                <div class="mb-3 text-start">
                    <label>Payment Method</label>
                    <div class="payment-options" style="margin-top: 8px;">
                        <label class="d-block mb-2">
                            <input type="radio" name="payment" value="Credit / Debit Card" required style="margin-right: 8px;">
                            Credit / Debit Card
                        </label>
                        <label class="d-block mb-2">
                            <input type="radio" name="payment" value="STC Pay" required style="margin-right: 8px;">
                            STC Pay
                        </label>
                        <label class="d-block">
                            <input type="radio" name="payment" value="Cash on Delivery" required style="margin-right: 8px;">
                            Cash on Delivery
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn custom-btn w-100 mt-2">Confirm Order</button>
                <a href="../pages/cart.php" class="btn trans-btn w-100 mt-3">Back to Cart</a>
            </form>
        </div>
                <div class="order-summary card-home p-4" style="width: 400px;" data-aos="fade-left">
            <h3 style="color: white; font-family: 'Cinzel'; text-align:center;">Order Summary</h3>
            <ul id="summaryItems" style="list-style: none; padding: 0; margin-top: 20px; color:#ddd; font-size: 14px;">
            </ul>
            <hr style="border-color: rgba(255,255,255,0.1);">
            <p class="mt-3 text-center" style="color:#ddd; font-size:15px;">
                <strong>Total: </strong><span id="summaryTotal">0</span> <img width=30px src="../assets/img/sar.png">
            </p>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script>
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        let summaryList = document.getElementById("summaryItems");
        let total = 0;

        if (cart.length > 0) {
            cart.forEach(item => {
                const li = document.createElement("li");
                li.style.display = "flex";
                li.style.justifyContent = "space-between";
                li.style.marginBottom = "10px";
                li.innerHTML = `
    <img width=80px src="../${item.img}" alt="${item.name}">
      <span>${item.name}</span>
      <span>${item.price} <img width=30px src="../assets/img/sar.png">

      </span>
    `;
                summaryList.appendChild(li);
                total += parseFloat(item.price);
            });
        } else {
            summaryList.innerHTML = `
    <li style="text-align:center; color:#bbb;">Your cart is empty.</li>
  `;
        }

        document.getElementById("summaryTotal").textContent = total.toFixed(2);

        document.getElementById("checkoutForm").addEventListener("submit", function(e) {
            e.preventDefault();

            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            if (cart.length === 0) {
                Swal.fire({
                    html: `
          <i class="fa-solid fa-circle-exclamation" 
          style="font-size: 70px; color:rgb(2, 230, 255); margin-bottom: 15px;"></i>
          <h2 style="color:#ddd;">Empty Cart</h2>
          <p style="color:#ddd;">Please add items before checkout</p>
        `,
                    customClass: {
                        popup: 'blur-popup'
                    },
                    confirmButtonText: "OK",
                    confirmButtonColor: "rgb(2, 230, 255)",
                    background: "rgba(249, 249, 249, 0.3)"
                });
                return;
            }

            const formData = new FormData(this);
            formData.append("items", JSON.stringify(cart));
            fetch("../api/process_order.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            html: `
            <i class="fa-solid fa-circle-check" 
            style="font-size: 70px; color:rgb(2, 230, 255); margin-bottom: 15px;"></i>
            <h2 style="color:#ddd;">Order Placed!</h2>
            <p style="color:#ddd;">Your order has been placed successfully.</p>
          `,
                            customClass: {
                                popup: 'blur-popup'
                            },
                            confirmButtonText: "OK",
                            confirmButtonColor: "rgb(2, 230, 255)",
                            background: "rgba(249, 249, 249, 0.3)",
                            timer: 2500
                        });
                        localStorage.removeItem("cart");
                        setTimeout(() => window.location.href = "../pages/index.php", 2000);
                    } else {
                        Swal.fire({
                            html: `
            <i class="fa-solid fa-triangle-exclamation" 
            style="font-size: 70px; color:#f66; margin-bottom: 15px;"></i>
            <h2 style="color:#ddd;">Order Failed</h2>
            <p style="color:#ddd;">${data.message || "Please try again"}</p>
          `,
                            customClass: {
                                popup: 'blur-popup'
                            },
                            confirmButtonColor: "rgb(2, 230, 255)",
                            background: "rgba(249, 249, 249, 0.3)"
                        });
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        html: `
          <i class="fa-solid fa-wifi-exclamation" 
          style="font-size: 70px; color:#f66; margin-bottom: 15px;"></i>
          <h2 style="color:#ddd;">Connection Error</h2>
          <p style="color:#ddd;">Please check your connection and try again</p>
        `,
                        customClass: {
                            popup: 'blur-popup'
                        },
                        confirmButtonColor: "rgb(2, 230, 255)",
                        background: "rgba(249, 249, 249, 0.3)"
                    });
                });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>