document.addEventListener("DOMContentLoaded", function () {
  var cartQuantityHeader = document.querySelector(".cart-quantity");
  var cartTotal = document.querySelector(".cart-total-price");
  var totalPrice = document.querySelector(".total-price");
  var shippingPirce = document.querySelector(".shipping-price");
  cartTotal.innerHTML = cart_data.initial_data;
  totalPrice.innerHTML = cart_data.get_total;
  shippingPirce.innerHTML = cart_data.shipping;
  var orderBtn = document.querySelector("#order");
  // Выводим данные из PHP в консоль
  console.log("Initial data from PHP:", cart_data.initial_data);

  // Обработчик клика по кнопке
  var cartItems = document.querySelector(".cart-items");
  var addToCartButtons = document.querySelectorAll(".cart-item");

  addToCartButtons.forEach((element) => {
    var product_id = element.id;
    var minus = element.querySelector(".minus");
    var plus = element.querySelector(".plus");
    var itemQuantity = element.querySelector(".item-quantity");
    var deleteBtn = element.querySelector(".delete-btn");
    minus.addEventListener("click", function () {
      var data = {
        action: "cart_action",
        product_id: product_id,
        operation: "minus",
      };

      setTimeout(() => {
        // Выполняем AJAX запрос
        fetch(cart_data.ajax_url, {
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
            itemQuantity.textContent = `Quantity: ${data.received_data}`;
            cartTotal.innerHTML = data.total_cart;
          })
          .catch((error) => console.error("Error:", error));
      }, 500);
    });

    plus.addEventListener("click", function () {
      var data = {
        action: "cart_action",
        product_id: product_id,
        operation: "plus",
      };

      console.log("plus");
      setTimeout(() => {
        // Выполняем AJAX запрос
        fetch(cart_data.ajax_url, {
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
            itemQuantity.textContent = `Quantity: ${data.received_data}`;
            cartTotal.innerHTML = data.total_cart;
          })
          .catch((error) => console.error("Error:", error));
      }, 500);
    });

    deleteBtn.addEventListener("click", function () {
      var data = {
        action: "cart_action",
        product_id: product_id,
        operation: "delete",
      };

      setTimeout(() => {
        // Выполняем AJAX запрос
        fetch(cart_data.ajax_url, {
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

            cartTotal.innerHTML = data.total_cart;
            totalPrice.innerHTML = data.get_total;
            element.remove();
            cartQuantityHeader.textContent = data.quantity;
            var cart_items = cartItems.querySelectorAll("li");
            if (cart_items.length === 0) {
              var emptyCart = document.createElement("p");
              console.log(emptyCart);
              emptyCart.classList.add("empty-cart");
              emptyCart.textContent = "Your cart is empty.";
              cartItems.appendChild(emptyCart);
            }
          })
          .catch((error) => console.error("Error:", error));
      }, 500);
    });

    orderBtn.addEventListener("click", function () {
      console.log("orderBtn");
      // Создаем новый запрос
      var xhr = new XMLHttpRequest();

      // Настраиваем запрос на сервер (POST)
      xhr.open("POST", cart_data.ajax_url, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      // Формируем данные для отправки
      var data = "action=create_order_and_redirect";

      // Обрабатываем ответ от сервера
      xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 400) {
          // Парсим ответ сервера
          var response = JSON.parse(xhr.responseText);
          if (response.confirmation.confirmation_url) {
            // Перенаправляем клиента на URL оплаты

            window.location.href = response.confirmation.confirmation_url;
          } else {
            console.error("Ошибка: Не удалось получить ссылку на оплату.");
          }
        } else {
          console.error("Ошибка при запросе к серверу.");
        }
      };

      // Отправляем запрос с данными
      xhr.send(data);
    });

    // button.addEventListener("click", function () {
    //   button.classList.add("animate");
    //   var data = {
    //     action: "cart_action",
    //     my_data: cart_data.initial_data,
    //   };
    //   setTimeout(() => {
    //     // Выполняем AJAX запрос
    //     fetch(cart_data.ajax_url, {
    //       method: "POST",
    //       headers: {
    //         "Content-Type": "application/x-www-form-urlencoded",
    //       },
    //       body: new URLSearchParams(data),
    //     })
    //       .then((response) => response.json())
    //       .then((data) => {
    //         console.log("Response from PHP:", data);
    //         //   document.getElementById("response").textContent =
    //         //     "Response from PHP: " + data.received_data;
    //       })
    //       .catch((error) => console.error("Error:", error));
    //     button.classList.remove("animate");
    //   }, 1000);
    // });
  });
});
