document.addEventListener("DOMContentLoaded", function () {
    const originalPriceElement = document.querySelector(".original-price");
    const decrementButton = document.querySelector(".btn-decrement");
    const incrementButton = document.querySelector(".btn-increment");
    const quantityInput = document.getElementById("quantity");
    const stockElement = document.querySelector(".description li[data-stock]");
    const messageElement = document.getElementById("quantity-message");

    const originalPrice = parseInt(
        originalPriceElement.textContent.replace(/\D/g, "")
    );
    const stock = parseInt(stockElement.dataset.stock);

    function updatePrice(quantity) {
        const newPrice = originalPrice * quantity;
        originalPriceElement.textContent =
            newPrice.toLocaleString("vi-VN") + "đ";
    }

    function showMessage(message) {
        messageElement.textContent = message;
        messageElement.style.display = "block";
    }

    function hideMessage() {
        messageElement.style.display = "none";
    }

    incrementButton.addEventListener("click", function () {
        let quantity = parseInt(quantityInput.textContent);
        if (quantity < stock) {
            quantity++;
            quantityInput.textContent = quantity;
            updatePrice(quantity);
            hideMessage();
        } else {
            showMessage("Số lượng vượt quá tồn kho!");
        }
    });

    decrementButton.addEventListener("click", function () {
        let quantity = parseInt(quantityInput.textContent);
        if (quantity > 1) {
            quantity--;
            quantityInput.textContent = quantity;
            updatePrice(quantity);
            hideMessage();
        }
    });

    const addToCartButton = document.getElementById("add-to-cart");
    const buyNowButton = document.getElementById("buy-now-btn");
    const bookId = addToCartButton.dataset.bookId;


    addToCartButton.addEventListener("click", function () {
        const quantity = parseInt(quantityInput.textContent);
        const url = `/booknest_website/cartController/addToCart?book_id=${bookId}&quantity=${quantity}`;
        console.log(url);
        window.location.href = url;
    });

    buyNowButton.addEventListener("click", function () {
        const quantity = parseInt(quantityInput.textContent);
        const url = `/booknest_website/paymentController/buyNowDetail?book_id=${bookId}&quantity=${quantity}`;
        console.log(url);
        window.location.href = url;
    });
   
});
