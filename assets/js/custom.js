document.addEventListener("DOMContentLoaded", function () {
    const popup = document.getElementById("woo-popup");
    const overlay = document.getElementById("woo-popup-overlay");
    const content = document.getElementById("woo-popup-content");
    const closeBtn = document.getElementById("woo-close-popup");

    document.querySelectorAll(".woo-show-details").forEach(function (btn) {
      btn.addEventListener("click", function (e) {
        e.preventDefault();
        const desc = this.getAttribute("data-desc");
        content.innerText = desc;
        popup.style.display = "block";
        overlay.style.display = "block";
      });
    });

    closeBtn.addEventListener("click", function () {
      popup.style.display = "none";
      overlay.style.display = "none";
    });

    overlay.addEventListener("click", function () {
      popup.style.display = "none";
      this.style.display = "none";
    });

    calculate_price_by_qty(); 
});

function calculate_price_by_qty(){
  document.querySelectorAll('.woo-custom-product').forEach(product => {
    const pricePerUnit = parseFloat(product.dataset.price);
    const qtyInput = product.querySelector('.woo-qty-input');
    const totalDisplay = product.querySelector('.woo-total-price');
    const minusBtn = product.querySelector('.woo-qty-minus');
    const plusBtn = product.querySelector('.woo-qty-plus');

    function updateTotal() {
      let qty = parseInt(qtyInput.value);
      if (!qty || qty < 1) qty = 1;
      const total = (qty * pricePerUnit).toFixed(2);
      totalDisplay.textContent = `₹${total}`;
    }

    minusBtn.addEventListener('click', function () {
      let qty = parseInt(qtyInput.value);
      if (qty > 1) qtyInput.value = qty - 1;
      updateTotal();
    });

    plusBtn.addEventListener('click', function () {
      let qty = parseInt(qtyInput.value);
      qtyInput.value = qty + 1;
      updateTotal();
    });

    qtyInput.addEventListener('input', updateTotal);
  });
}