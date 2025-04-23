// menu.js

document.addEventListener("DOMContentLoaded", function () {
    const orderButtons = document.querySelectorAll(".order-btn");
  
    orderButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const menuItem = this.closest(".menu-item");
        const name = menuItem.querySelector("h3").innerText;
        const priceText = menuItem.querySelector(".price").innerText;
        
        // Convert price to number (remove 'k' and convert to thousands)
        let price = 0;
        if (priceText.includes(',')) {
          // For example "2,5k"
          price = parseFloat(priceText.replace(',', '.')) * 1000;
        } else {
          price = parseFloat(priceText.replace('k', '')) * 1000;
        }
  
        // Create order item object
        const orderItem = {
          name: name,
          price: price,
          quantity: 1
        };
  
        // Get current orders from localStorage
        let orders = JSON.parse(localStorage.getItem("orders")) || [];
  
        // Check if item already in cart
        const existingItem = orders.find(item => item.name === orderItem.name);
        if (existingItem) {
          existingItem.quantity += 1;
        } else {
          orders.push(orderItem);
        }
  
        // Save back to localStorage
        localStorage.setItem("orders", JSON.stringify(orders));
  
        // Optional: alert or redirect
        alert(`${orderItem.name} ditambahkan ke pesanan!`);
        // window.location.href = "/checkout.php"; // Uncomment if needed
      });
    });
  });
  