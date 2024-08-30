function formatNumber(number) {
  // Разделение числа на целую и дробную части
  let [integerPart, decimalPart] = number.toFixed(2).split(".");

  // Форматирование целой части с разделением тысяч
  integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, " ");

  // Возвращаем отформатированное число
  return `${integerPart},${decimalPart}`;
}

function finalNumber(element, data) {
  // Извлечь текст из элемента и заменить его отформатированной ценой
  var newData = parseFloat(data).toFixed(2);
  var rawPrice = newData.replace(/[^0-9.,]/g, ""); // Убираем все, кроме чисел и знаков
  var formattedPrice = formatNumber(parseFloat(rawPrice.replace(",", ".")));
  element.textContent = formattedPrice;
  console.log("format", formattedPrice);
}

document.addEventListener("DOMContentLoaded", function () {
  var customerForm = document.getElementById("customer-form");

  var cartQuantityHeader = document.querySelector(".cart-quantity");
  var cartTotal = document.querySelector(".cart-total-price");
  var totalPrice = document.querySelector(".total-price");
  var shippingPirce = document.querySelector(".shipping-price");
  cartTotal.innerHTML = cart_data.initial_data;
  finalNumber(totalPrice, cart_data.get_total);
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
            finalNumber(totalPrice, data.get_total);
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
            finalNumber(totalPrice, data.get_total);
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
            finalNumber(totalPrice, data.get_total);
            element.remove();
            cartQuantityHeader.textContent = data.quantity;
            var cart_items = cartItems.querySelectorAll("li");
            if (cart_items.length === 0) {
              var emptyCart = document.createElement("p");
              console.log(emptyCart);
              emptyCart.classList.add("empty-cart");
              emptyCart.textContent = "Your cart is empty.";
              shippingPrice.innerHTML = "0,00";
              cartItems.appendChild(emptyCart);
            }
          })
          .catch((error) => console.error("Error:", error));
      }, 500);
    });

    customerForm.addEventListener("submit", function (event) {
      event.preventDefault();
      const formData = new FormData(event.target);
      formData.append("action", "create_order_and_redirect");

      setTimeout(() => {
        fetch(cart_data.ajax_url, {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: new URLSearchParams(formData),
        })
          .then((res) => res.json())
          .then((data) => {
            window.open(data.confirmation.confirmation_url);
          })
          .catch((error) => console.log("Error:", error));
      }, 500);
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
