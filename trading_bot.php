<?php
require 'vendor/autoload.php';

use Binance\API;

// اطلاعات API خود را اینجا وارد کنید
$api_key = 'YOUR_API_KEY';
$secret_key = 'YOUR_SECRET_KEY';

// ایجاد نمونه‌ای از API
$api = new API($api_key, $secret_key);

// تابع برای گرفتن قیمت کنونی
function get_current_price($api, $symbol) {
    $ticker = $api->prices();
    return $ticker[$symbol];
}

// تابع برای خرید
function buy($api, $symbol, $quantity) {
    return $api->marketBuy($symbol, $quantity);
}

// تابع برای فروش
function sell($api, $symbol, $quantity) {
    return $api->marketSell($symbol, $quantity);
}

// نمونه‌ای از یک استراتژی ساده
function strategy($api, $symbol, $quantity, $buy_price, $sell_price) {
    while (true) {
        $current_price = get_current_price($api, $symbol);
        if ($current_price <= $buy_price) {
            echo "خرید در قیمت: $current_price\n";
            buy($api, $symbol, $quantity);
        } elseif ($current_price >= $sell_price) {
            echo "فروش در قیمت: $current_price\n";
            sell($api, $symbol, $quantity);
        }
        sleep(5); // توقف به مدت 5 ثانیه
    }
}

// اجرای استراتژی
$symbol = 'BTCUSDT';
$quantity = 0.001;  // مقدار خرید یا فروش
$buy_price = 30000;  // قیمت خرید
$sell_price = 35000;  // قیمت فروش

strategy($api, $symbol, $quantity, $buy_price, $sell_price);
?>
