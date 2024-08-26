var foodCategories = document.querySelectorAll(".food-category");
var header = document.querySelector(".header");
var htmlDoc = document.querySelector(".body");
var posts = document.querySelectorAll(".section-item");
window.addEventListener("scroll", function () {
  var menu = document.querySelector(".header");
  if (window.scrollY > 100) {
    menu.classList.add("header-between");
  } else {
    menu.classList.remove("header-between");
  }
  if (window.scrollY > 300) {
    menu.classList.add("sticky-header");
  } else {
    menu.classList.remove("sticky-header");
  }
});
window.addEventListener("scroll", function () {
  var headerPosition = {
    top: htmlDoc.clientTop,
    left: window.pageXOffset + header.getBoundingClientRect().left,
    right: window.pageXOffset + header.getBoundingClientRect().right,
    bottom: htmlDoc.clientTop + 400,
  };
  var windowPosition = {
    top: window.pageYOffset,
    left: window.pageXOffset,
    right: window.pageXOffset + document.documentElement.clientWidth,
    bottom: window.pageYOffset + document.documentElement.clientHeight,
  };

  foodCategories.forEach((category) => {
    var targetPosition = {
      top: window.pageYOffset + category.getBoundingClientRect().top,
      left: window.pageXOffset + category.getBoundingClientRect().left,
      right: window.pageXOffset + category.getBoundingClientRect().right,
      bottom: window.pageYOffset + category.getBoundingClientRect().bottom,
    };

    if (
      targetPosition.bottom > windowPosition.top && // Если позиция нижней части элемента больше позиции верхней чайти окна, то элемент виден сверху
      targetPosition.top < windowPosition.bottom && // Если позиция верхней части элемента меньше позиции нижней чайти окна, то элемент виден снизу
      targetPosition.right > windowPosition.left && // Если позиция правой стороны элемента больше позиции левой части окна, то элемент виден слева
      targetPosition.left < windowPosition.right
    ) {
      // Если позиция левой стороны элемента меньше позиции правой чайти окна, то элемент виден справа
      // Если элемент полностью видно, то запускаем следующий код

      category.classList.add("active");
    } else {
      // Если элемент не видно, то запускаем этот код
      //   category.classList.remove("active");
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  let availableWidth = screen.availWidth;
  console.log(availableWidth);

  console.log("hiod", posts);

  const menuToggle = document.getElementById("menu-toggle");
  const menuToggle1 = document.getElementById("menu-toggle1");
  const navMenu = document.querySelector(".nav-div");
  console.log(menuToggle, "toggle");

  if (availableWidth < 767) {
    var menuButtons = document.querySelectorAll(".menu-item");
    menuButtons.forEach((button) => {
      button.addEventListener("click", function () {
        menuToggle.classList.toggle("active");
        navMenu.classList.toggle("active");
      });
    });
  }

  menuToggle.addEventListener("click", function () {
    // Переключаем классы active для анимации и показа меню
    menuToggle.classList.toggle("active");
    navMenu.classList.toggle("active");
  });

  menuToggle1.addEventListener("click", function () {
    // Переключаем классы active для анимации и показа меню
    menuToggle.classList.toggle("active");
    navMenu.classList.toggle("active");
  });

  posts.forEach((post) => {
    var button = post.querySelector(".add_to_cart_button");
    button.addEventListener("click", function () {
      console.log("click");
    });
  });
  // Функция для обновления количества товаров в корзине
  function updateCartItemCount() {
    var xhr = new XMLHttpRequest();
    xhr.open(
      "GET",
      wc_add_to_cart_params.ajax_url + "?action=get_cart_item_count",
      true
    );
    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 300) {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          // Обновляем содержимое <span> с классом 'cart-item-count'
          var spanElement = document.querySelector(".cart-item-count");
          if (spanElement) {
            spanElement.textContent = "Items in cart: " + response.data;
          }
        } else {
          console.error("Error fetching cart item count");
        }
      } else {
        console.error("Error with the request");
      }
    };
    xhr.send();
  }

  // Обновляем количество товаров при загрузке страницы
  updateCartItemCount();

  // Также можно настроить обновление при добавлении товара в корзину
  document.addEventListener("added_to_cart", function () {
    updateCartItemCount();
  });
});

var Add;
addToCartForms.forEach((form) => {
  form.addEventListener("click", (event) => {
    setTimeout(() => {
      button.classList.remove("animate");
    }, 500); // Длительность анимации в миллисекундах
  });
});

document.addEventListener("DOMContentLoaded", function () {});
