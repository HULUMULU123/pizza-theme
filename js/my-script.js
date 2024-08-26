document.addEventListener("DOMContentLoaded", function () {
  const cartLink = document.querySelector(".cart-link");
  var cartQuantity = document.createElement("span");
  cartLink.appendChild(cartQuantity);
  cartQuantity.classList.add("cart-quantity");
  cartQuantity.textContent = my_script_data.initial_data;
  // Выводим данные из PHP в консоль
  console.log("Initial data from PHP:", my_script_data.initial_data);

  // Обработчик клика по кнопке

  var addToCartButtons = document.querySelectorAll(".add_to_cart_button");
  addToCartButtons.forEach((button) => {
    button.addEventListener("click", function () {
      button.classList.add("animate");
      var data = {
        action: "my_action",
        my_data: my_script_data.initial_data,
      };
      setTimeout(() => {
        // Выполняем AJAX запрос
        fetch(my_script_data.ajax_url, {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: new URLSearchParams(data),
        })
          .then((response) => response.json())
          .then((data) => {
            console.log("Response from PHP:", data);
            //   document.getElementById("response").textContent =
            //     "Response from PHP: " + data.received_data;
            cartQuantity.textContent = data.received_data;
          })
          .catch((error) => console.error("Error:", error));
        button.classList.remove("animate");
      }, 1000);
    });
  });
});
