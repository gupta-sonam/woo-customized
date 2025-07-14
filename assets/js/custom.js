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
    });