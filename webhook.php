<?php 

require_once('/var/www/html/wp-load.php');

$input = file_get_contents('php://input');
$eventData = json_decode($input, true);


if (!isset($eventData['type']) || !isset($eventData['object']['id'])) {
    http_response_code(400); // Неправильный запрос
    exit('Invalid request');
}

$order_id = $eventData['object']['metadata']['order_id']; // Предполагается, что ID заказа передается в метаданных
$paymentStatus = $eventData['event'];

switch ($paymentStatus) {
    case 'payment.succeeded':
        $order_status = 'completed'; // Статус для успешного платежа
        break;

    case 'payment.canceled':
        $order_status = 'cancelled'; // Статус для отмененного платежа
        break;

    default:
        $order_status = 'on-hold'; // Статус по умолчанию или игнорируем события
        break;
}
file_put_contents('/var/log/yookassa_webhook.log', print_r($eventData, true), FILE_APPEND);

if ($order_id) {
    $order = wc_get_order($order_id);
    if ($order) {
        $order->update_status($order_status, 'Order status updated by YKassa webhook.');

        http_response_code(200); // Успешная обработка
        exit('Order status updated and email sent');
    } else {
        http_response_code(404); // Заказ не найден
        exit('Order not found');
    }
} else {
    http_response_code(400); // Неверный ID заказа
    exit('Invalid order ID');
}
