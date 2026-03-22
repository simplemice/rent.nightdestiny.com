<?php

include(__DIR__.'/../app/bootstrap.php');

$result = [];

try {
    $payload = [];
    foreach ($_POST as $key => $val) {
        $payload[$key] = strip_tags($val);
    }

    $request = \Monkeycar\Request::fromRequest($payload);
    $store = \Monkeycar\Helper::createStore();
    $calculator = new \Monkeycar\Calculator($store, $request);
    $car = $store->getCarById($request->getCarId());
    $_calc = $calculator->calculatePrice($car['id']);

    $orderNo = "{$request->getCarId()}-".date('dm-hi');

    $_name = $payload['name'] ?? '';
    $_phone = $payload['phone'] ?? '';

    $fromRegion = $calculator->getFromRegion()['name'];
    $toRegion = $calculator->getToRegion()['name'];

    $result = [
        'status' => true,
        'payload' => [
            'order' => $orderNo
        ],
    ];

    // Создаем массив
    $arr = [
        'OrderNo' => $orderNo,
        'Name' => $_name,
        'Phone' => $_phone,

        'Pick up' => $fromRegion,
        'Drop off' => $toRegion,

        'Start Date' => $request->getStartDate()->format('d.m.Y H:i'),
        'End Date' => $request->getEndDate()->format('d.m.Y H:i'),
        'Days' => $_calc['days'],

        'Car' => $car['model'].'('.$car['id'].')',
        'Car Deposit' => $car['deposit'],

        'Insurance' => $request->getExtra()->isIncludeInsurance() ? 'Yes' : 'No',
        'Baby Chair' => $request->getExtra()->isIncludeBabyChair() ? 'Yes' : 'No',
        'Sim' => $request->getExtra()->isIncludeSim() ? 'Yes' : 'No',

        'Price' => $_calc['price'].'$',
        'Discount' => $_calc['discountPercentage'].'%',
        'Delivery' => $_calc['delivery'].'$',
        'Options' => $_calc['delivery'].'$',
        'Total Price' => $_calc['total'].'$',
    ];

    $txt = '';
    foreach ($arr as $key => $value) {
        $txt .= '<b>'.$key.'</b>: '.urlencode($value).'%0A';
    }

    if (!\Monkeycar\Helper::isDev()) {
        \Monkeycar\Helper::sendMessage($txt);
    }
} catch (\Exception $e) {
    $result = [
        'status' => false,
        'error' => error_reporting() ? $e->getMessage() : 'Invalid request',
    ];
}

http_response_code(200);
header('Content-Type: application/json');
echo json_encode($result, JSON_THROW_ON_ERROR, 512);
