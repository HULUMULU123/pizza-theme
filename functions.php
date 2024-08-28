<?php 
function my_theme_styles() {
    wp_enqueue_style( 'my-theme-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'my_theme_styles' );

function my_theme_script(){
    wp_enqueue_script( 'newscript', get_template_directory_uri() . '/js/index.js');
}

function get_post_images_only($post_id) {
    // Получаем содержимое поста
    $content = get_post_field('post_content', $post_id);
    
    // Извлекаем изображения с помощью регулярных выражений
    preg_match_all('/<img[^>]+>/i', $content, $matches);
    
    // Собираем все изображения в один HTML блок
    $images = implode("\n", $matches[0]);
    
    return $images;}

function get_post_text_only($post_id) {
    // Получаем содержимое поста
    $content = get_post_field('post_content', $post_id);
    
    // Удаляем все HTML теги
    $text_only_content = wp_strip_all_tags($content);
    
    // Удаляем лишние пробелы
    $text_only_content = trim($text_only_content);
    
    return $text_only_content;
}

function register_my_menu() {
    register_nav_menus(
        array(
            'primary' => __( 'Primary Menu' ), // Название местоположения для меню
            'footer'  => __( 'Footer Menu' )   // Можно добавить другие местоположения
        )
    );
}
add_action( 'init', 'register_my_menu' );

function get_cart_item_count() {
    // Получаем объект корзины WooCommerce
    $cart = WC()->cart;

    // Проверяем, что корзина не пуста
    if ( $cart ) {
        // Получаем количество всех товаров в корзине
        $cart_item_count = $cart->get_cart_contents_count();
        return $cart_item_count;
    }

    return 0;
}

// Пример использования функции в теме
add_action('wp_footer', 'get_cart_item_count');


function enqueue_my_scripts() {
    wp_enqueue_script('my-script', get_template_directory_uri() . '/js/my-script.js', array('jquery'), null, true);

    // Данные для передачи в JavaScript
    $php_data = array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'initial_data' => get_cart_item_count()
    );
    wp_localize_script('my-script', 'my_script_data', $php_data);
}
add_action('wp_enqueue_scripts', 'enqueue_my_scripts');

// Обработчик AJAX запроса
add_action('wp_ajax_my_action', 'my_action_callback');
add_action('wp_ajax_nopriv_my_action', 'my_action_callback');

function my_action_callback() {
    // Получаем данные из AJAX запроса
    

    // Выполняем действия с данными
    $response = array('status' => 'success', 'received_data' => get_cart_item_count());

    // Отправляем ответ обратно в JavaScript
    wp_send_json($response);
}



function get_cart_total() {
    if ( WC()->cart ) {
        // Получаем общую сумму корзины
        $total = WC()->cart->get_cart_total();
        return $total;
    }
    return false;
}


function get_cart_total_with_shipping() {
    if ( WC()->cart ) {
        // Получаем общую стоимость корзины
        $cart_total = WC()->cart->get_cart_contents_total();
        
        // Получаем стоимость доставки
        $shipping_total = WC()->cart->get_shipping_total();
        
        // Получаем налоги и другие сборы
        $tax_total = WC()->cart->get_cart_contents_tax();
        
        
        // Общая сумма корзины (без учета доставки)
        $total_before_shipping = $cart_total + $tax_total ;
        
        // Общая сумма корзины с доставкой
        $total_with_shipping = $total_before_shipping + $shipping_total;
        
        return $total_with_shipping;
    }
    return false;
}

function get_shipping() {
    if ( WC()->cart ) {
        
        $shipping_total = WC()->cart->get_shipping_total();
        
        return wc_price($shipping_total);
            
    }
    return false;
}

function cart_script() {
    // Подключаем скрипт
    wp_enqueue_script(
        'cart', // Уникальный идентификатор для вашего скрипта
        get_template_directory_uri() . '/js/cart.js', // Путь к вашему файлу скрипта
        array('jquery'), // Зависимости (если есть, например, jQuery)
        null, // Версия скрипта (или null для автоматической генерации версии)
        true // Подключать в футере (true) или в хедере (false)
    );
    $php_data = array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'initial_data' => get_cart_total(),
        'shipping' => get_shipping(),
        'get_total' => get_cart_total_with_shipping()
    );
    // Локализуем скрипт (если нужно передать параметры)
    wp_localize_script('cart', 'cart_data', $php_data);
}
add_action('wp_enqueue_scripts', 'cart_script');

add_action('wp_ajax_cart_action', 'cart_callback');
add_action('wp_ajax_nopriv_cart_action', 'cart_callback');


function cart_callback() {
    // Получаем данные из AJAX запроса
    
    $data = $_POST;
    $product_id = $data['product_id'];
    $operation = $data['operation'];
    $cart = WC()->cart->get_cart();

    // Перебираем все товары в корзине
    foreach ($cart as $cart_item_key => $cart_item) {
        // Проверяем, совпадает ли ID товара
        if ($cart_item['product_id'] == $product_id) {
            // Определяем новое количество
            if ($operation === 'plus') {
                $quantity = $cart_item['quantity'] + 1;
            } elseif ($operation === 'minus') {
                $quantity = max(1, $cart_item['quantity'] - 1); // Минимум 1
            } elseif ($operation === 'delete') {
                $quantity = 0; // Минимум 1
            }
            else {
                wp_send_json_error(array('message' => 'Invalid operation'));
                return;
            }
    
        if ($quantity === 0){
            WC()->cart->remove_cart_item($cart_item_key);
        }else{
    // Обновляем количество товара в корзине
        WC()->cart->set_quantity($cart_item_key, $quantity, true);}
    
        // Пересчитываем итоги корзины
        WC()->cart->calculate_totals();
        WC()->cart->maybe_set_cart_cookies();
        }}
    // Выполняем действия с данными
    $response = array('status' => 'success', 'received_data' => $quantity, 'total_cart'=> get_cart_total(), 'shipping' => get_shipping(),
        'get_total' => get_cart_total_with_shipping(), 'quantity' => get_cart_item_count());

    // Отправляем ответ обратно в JavaScript
    wp_send_json($response);
}

// Добавляем AJAX действия для авторизованных и неавторизованных пользователей
add_action( 'wp_ajax_create_order_and_redirect', 'create_order_and_redirect' );
add_action( 'wp_ajax_nopriv_create_order_and_redirect', 'create_order_and_redirect' );

function create_order_and_redirect() {
    // Создаем новый заказ
    $cart = WC()->cart;
    
    // Проверяем, пуста ли корзина
    if ( $cart->is_empty() ) {
        return 'Корзина пуста.';
    }

    $order = wc_create_order();

    foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
        $product_id = $cart_item['product_id'];
        $quantity = $cart_item['quantity'];
        
        // Добавляем товар в заказ
        $order->add_product( wc_get_product( $product_id ), $quantity );
    }
    // Добавляем товар в заказ (пример с ID товара 12 и количеством 1)
    // $product_id = 64; // ID товара
    // $quantity = 1;    // Количество товара
    // $order->add_product( wc_get_product( $product_id ), $quantity );

    // Устанавливаем адрес покупателя
    $order->set_address( array(
        'first_name' => 'Иван',
        'last_name'  => 'Иванов',
        'email'      => 'ivanov@example.com',
        'phone'      => '1234567890',
        'address_1'  => 'Улица Пушкина, дом Колотушкина',
        'city'       => 'Москва',
        'postcode'   => '101000',
        'country'    => 'RU'
    ), 'billing' );

    // Устанавливаем метод оплаты как "Robokassa" (или другой нужный метод)
    $order->set_payment_method('yookassa');

    


    // Рассчитываем и сохраняем заказ
    
    $order->calculate_totals();
    $order->save();

    // Получаем ID заказа и сумму для оплаты
    $order_id = $order->get_id();

    $current_total = $order->get_total();
    $cart_shipping_total = WC()->cart->get_cart_shipping_total();

    // Преобразуем строку в число
    $cart_shipping_total_number = intdiv(floatval( preg_replace('/[^\d.]/', '', $cart_shipping_total) ), 1000000);
    // Увеличиваем сумму заказа
    $new_total = $current_total + $cart_shipping_total_number;

    // Устанавливаем новую общую сумму
    $order->set_total( $new_total );

    // Сохраняем заказ
    $order->save();
    // $amount = $order->get_total();
    $amount = number_format($order->get_total(), 2, '.', '');


    

    // Данные магазина
    $shop_id = '338135';
    $secret_key = 'test_80nfHSIw8FhUgm4M7vZtd3TnRCNuSHomw10UGbKhiRI';
    
    // URL для создания платежа
    $url = 'https://api.yookassa.ru/v3/payments';
    
    // Данные платежа
    $data = array(
        'amount' => array(
            'value' => $amount, // Сумма платежа
            'currency' => 'RUB', // Валюта
        ),
        'confirmation' => array(
            'type' => 'redirect',
            'return_url' => 'https://your-website.com/thank-you', // URL для возврата после оплаты
        ),
        'description' => 'Оплата заказа №12345',
        "metadata" => array(
            "order_id"=> $order_id,
        ),
    );
    
    // Кодировка данных в JSON
    $data_json = json_encode($data);
    
    // Установка curl для отправки запроса
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Idempotence-Key: ' . uniqid(), // Идемпотентный ключ для предотвращения повторных запросов
        'Authorization: Basic ' . base64_encode("$shop_id:$secret_key") // Базовая авторизация через Shop ID и Secret Key
    ));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Получение ответа от сервера ЮKassa
    $response = curl_exec($ch);
curl_close($ch);

// Декодируем ответ в массив
$paymentData = json_decode($response, true);

// Возвращаем URL для подтверждения платежа
header('Content-Type: application/json');
wp_send_json( $paymentData );

   
    

    // // Учетные данные для Robokassa
    // $robokassa_login = 'pizza123';
    // $robokassa_password1 = '1234';


    // $signatureString = "$robokassa_login:$amount:$order_id:$robokassa_password1";
    // // Генерация подписи для Robokassa
    // $signature_value = md5($signatureString);

    
    
    // // // Генерация URL для оплаты
    // // $payment_url = "https://auth.robokassa.ru/Merchant/Index.aspx?" . http_build_query(array(
    // //     'MerchantLogin'   => $robokassa_login,
    // //     'OutSum'          => $amount,
    // //     'InvId'           => $order_id,
    // //     'SignatureValue'  => $signature_value,
    // //     'Description'     => 'Оплата заказа №' . $order_id,
    // //     'Culture'         => 'ru',
    // //     'Encoding'        => 'utf-8'
    // // ));

    // $payment_url = "https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=" . $robokassa_login . "&OutSum=" . $amount . "&InvId=" . $order_id . "&SignatureValue=" . $signature_value;
    
    // // // Отправляем ответ клиенту с URL оплаты
    // wp_send_json_success( array( 'payment_url' => $payment_url ) );
}
