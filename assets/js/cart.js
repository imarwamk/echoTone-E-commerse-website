document.addEventListener("DOMContentLoaded", () => {
  const cartItemsContainer = document.getElementById("cart-items");
  const cart = JSON.parse(localStorage.getItem("cart")) || [];

  if (cart.length === 0) {
    cartItemsContainer.innerHTML = `
      <p style="color: #888; font-size: 18px;">Your cart is empty</p>
    `;
  } else {
    cartItemsContainer.innerHTML = cart.map(item => `
      <div class="cart-item d-flex align-items-center justify-content-center mb-3 p-3" style="gap: 15px; background: rgba(255,255,255,0.1); border-radius: 10px;">
        <img src="../${item.img}" width="100" style="border-radius: 10px;">
        <div>
          <h5 style="color: #fff;">${item.name}</h5>
          <p>${item.albumDesc}</p>
          <p style="color: #bbb;">${item.artist}</p> 
          <p style="color: #ccc;">${item.price}</p>
          <img src="../assets/img/sar.png" class="price-icon">
        </div>
      </div>
    `).join("");
  }
});

