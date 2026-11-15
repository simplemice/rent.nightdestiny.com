<?php

include(__DIR__.'/../app/bootstrap.php');

use Monkeycar\Helper;

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

function respond(array $result, int $code = 200): void
{
    http_response_code($code);
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Allow: POST');
    respond(['status' => false, 'error' => 'Method not allowed'], 405);
}

try {
    // Only scalar values are accepted; strip tags and control characters, cap length.
    $payload = [];
    foreach ($_POST as $key => $val) {
        if (!is_string($key) || !is_scalar($val)) {
            continue;
        }
        $payload[$key] = mb_substr(trim(preg_replace('/[\x00-\x1F\x7F]/u', ' ', strip_tags((string)$val))), 0, 200);
    }

    $_name = $payload['name'] ?? '';
    $_phone = $payload['phone'] ?? '';

    if (mb_strlen($_name) < 2 || !preg_match('/^\+?[ 0-9()-]{6,20}$/', $_phone)) {
        respond(['status' => false, 'error' => 'Invalid name or phone'], 422);
    }

    $request = \Monkeycar\Request::fromRequest($payload);
    $store = \Monkeycar\Helper::createStore();
    $calculator = new \Monkeycar\Calculator($store, $request);
    $car = $store->getCarById($request->getCarId());
    $_calc = $calculator->calculatePrice($car['id']);

    $orderNo = "{$request->getCarId()}-".date('dm-hi');

    $fromRegion = $calculator->getFromRegion()['name'];
    $toRegion = $calculator->getToRegion()['name'];

    $arr = [
        'OrderNo' => $orderNo,
        'Name' => $_name,
        'Phone' => $_phone,

        'Pick up' => $fromRegion,
        'Drop off' => $toRegion,

        'Start Date' => $request->getStartDate()->format('d.m.Y H:i'),
        'End Date' => $request->getEndDate()->format('d.m.Y H:i'),
        'Days' => $_calc['days'],

        'Car' => trim($car['model']).'('.$car['id'].')',
        'Car Deposit' => $car['deposit'],

        'Insurance' => $request->getExtra()->isIncludeInsurance() ? 'Yes' : 'No',
        'Baby Chair' => $request->getExtra()->isIncludeBabyChair() ? 'Yes' : 'No',
        'Sim' => $request->getExtra()->isIncludeSim() ? 'Yes' : 'No',

        'Price' => $_calc['price'].'$',
        'Discount' => $_calc['discountPercentage'].'%',
        'Delivery' => $_calc['delivery'].'$',
        'Options' => $_calc['options'].'$',
        'Total Price' => $_calc['total'].'$',
    ];

    // Telegram parse_mode=html: user text must be escaped, newlines are real "\n".
    $txt = '';
    foreach ($arr as $key => $value) {
        $txt .= '<b>'.htmlspecialchars($key, ENT_QUOTES, 'UTF-8').'</b>: '
            .htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8')."\n";
    }
    $txt .= 'Order from nightdestiny.com';

    if (Helper::isDev()) {
        // Local/dev: never contact Telegram, never create a real order.
        respond(['status' => true, 'payload' => ['order' => $orderNo], 'dev' => true]);
    }

    if (!Helper::sendMessage($txt)) {
        respond(['status' => false, 'error' => 'Delivery failed'], 502);
    }

    respond(['status' => true, 'payload' => ['order' => $orderNo]]);
} catch (\Throwable $e) {
    error_log('send.php: '.$e->getMessage());
    respond(['status' => false, 'error' => 'Invalid request'], 400);
}
