<?php

include(__DIR__.'/app/bootstrap.php');

$request = \Monkeycar\Request::fromRequest($_GET);
$store = \Monkeycar\Helper::createStore();

$calculator = new \Monkeycar\Calculator($store, $request);

use Monkeycar\Helper as H;

$_cars = $store->getCarsByRequest($request);
$_carCount = count($_cars);

$_regionsByPrice = [];
foreach ($store->getRegions() as $_r) {
    $_regionsByPrice[$_r['price']][] = $_r['name'];
}
krsort($_regionsByPrice);
$_deposits = array_column($store->getCarsByRequest($request), 'deposit');
$_localBusiness = [
    '@context' => 'https://schema.org',
    '@type' => 'AutoRental',
    '@id' => H::absUrl('/#business'),
    'name' => H::SITE_NAME,
    'url' => H::absUrl('/'),
    'logo' => H::absUrl('/assets/images/logo.png'),
    'image' => H::absUrl('/assets/images/logo.png'),
    'telephone' => H::PHONE,
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => 'Mueang Phuket District',
        'addressRegion' => 'Phuket',
        'postalCode' => '83100',
        'addressCountry' => 'TH',
    ],
    'openingHoursSpecification' => [[
        '@type' => 'OpeningHoursSpecification',
        'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
        'opens' => '08:00',
        'closes' => '23:00',
    ]],
    'areaServed' => array_map(function ($r) {
        return ['@type' => 'Place', 'name' => $r['name'].', Phuket'];
    }, array_values($store->getRegions())),
    'sameAs' => ['https://www.instagram.com/simplemice_', 'https://t.me/simplemice'],
];
$seo = [
    'title' => 'Car Rental Phuket | Аренда авто на Пхукете – '.H::SITE_NAME,
    'description' => 'Аренда авто на Пхукете: '.$_carCount.' автомобилей, подача в аэропорт и по районам Пхукета, неограниченный пробег, страховка, русскоязычная поддержка. Car rental in Phuket – book online or via WhatsApp +66 94 265 4121.',
    'canonical' => H::absUrl('/'),
    'schema' => [
        [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => H::absUrl('/#website'),
            'url' => H::absUrl('/'),
            'name' => H::SITE_NAME,
            'inLanguage' => 'ru',
        ],
        $_localBusiness,
    ],
];

?><!DOCTYPE html>
<html lang="<?=H::currentLanguageCode()?>">
<head>
<?php include __DIR__.'/app/partials/head.php' ?>
</head>
<body>

<?php include 'app/partials/header-menu.php' ?>

<section>
    <div class="container">
            <h1 class="mt-3 mb-2 text-center"> Car Rental in Phuket – Easy & Reliable Rent a Car Service </h1>
            <p class="text-center mb-3">Аренда авто на Пхукете с подачей в аэропорт и по районам Пхукета. Все виды услуг в одном офисе — аренда авто или яхты, экскурсии, апартаменты и виллы, обмен рублей и многое другое!</p>
            <p class="text-center mb-4">
                <a class="btn btn-outline-success btn-sm" href="https://wa.me/66942654121" target="_blank" rel="noopener" data-track="whatsapp"><span class="icon-whatsapp"></span> WhatsApp</a>
                <a class="btn btn-outline-success btn-sm" href="https://t.me/simplemice" target="_blank" rel="noopener" data-track="telegram"><span class="icon-telegram"></span> Telegram</a>
            </p>
        <div class="row">
            <div class="col-md-5 col-lg-3 pp">
                <form class="bgform" action="" method="get">
                    <div class="form-group">
                        <label class="" for="place-in"><span class="icon-point"></span> <?=H::t('form:place_from')?>
                        </label>
                        <select class="form-control custom-select" name="place_from" id="place-in">
                            <?php foreach ($store->getRegions() as $regionId => $region): ?>
                                <option
                                    <?php if ($request->getPlaceFromId() === $regionId): ?>
                                        selected="selected"
                                    <?php endif ?>
                                        value="<?=$regionId?>"
                                ><?=$region['name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input id="customSwitch1" class="new_return custom-control-input" type="checkbox" name="new_return" value="0"  >
                            <label class="custom-control-label" for="customSwitch1"><?=H::t('form:new_return')?></label>
                        </div>
                    </div>

                    <div class="form-group fs-place-out">
                        <label class="" for="place-out"><span class="icon-point"></span> <?=H::t('form:place_to')?>
                        </label>
                        <select class="form-control custom-select" name="place_to" id="place-out">
                            <?php foreach ($store->getRegions() as $regionId => $region): ?>
                                <option
                                    <?php if ($request->getPlaceToId() === $regionId): ?>
                                        selected
                                    <?php endif ?>
                                        value="<?=$regionId?>"
                                ><?=$region['name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="" for="date_from"><span class="icon-calendar"></span> <?=H::t('form:date_from')?></label>
                        <input id="date_from"
                               class="form-control"
                               name="date_from"
                               type="date"
                               value="<?=$request->getStartDate()->format('Y-m-d H:i')?>">
                    </div>
                    <div class="form-group">
                        <label class="" for="date_to"><span class="icon-calendar"></span> <?=H::t('form:date_to')?></label>
                        <input id="date_to"
                               class="form-control"
                               name="date_to"
                               type="date"
                               value="<?=$request->getEndDate()->format('Y-m-d H:i')?>">
                    </div>

                    <button class="btn btn-success btn-block btn-lg"><?=H::t('form:search')?></button>
                </form>

                <div class="card text-center d-none d-md-block">
                    <div class="card-header">Бронируйте по телефону</div>
                    <div class="card-body">
                        <div class="card-title h5"><span class="icon-phone"></span><b> <a class="text-dark" href="tel:+66942654121" data-track="phone">+66 094-265-41-21</a> Rus/Eng</b></div>
                        <p class="card-text">Работаем ежедневно <br>с 8:00 - 23:00</p>
                        <a href="https://maps.app.goo.gl/9b4uR9qGfEuf6xnRA" target="_blank" rel="noopener" class="btn btn-success2">Локация офиса</a> <br><br>
                        <a href="https://wa.me/66942654121?text=%D0%97%D0%B4%D1%80%D0%B0%D0%B2%D1%81%D1%82%D0%B2%D1%83%D0%B9%D1%82%D0%B5!" target="_blank" rel="noopener" data-track="whatsapp" class="btn btn-success2"><span class="icon-whatsapp"></span> WhatsApp</a>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-lg-9 pp">
                <h2 class="h4 mb-3">Автомобили для аренды на Пхукете (<?=$_carCount?>)</h2>

                <?php $_first = true; foreach ($_cars as $carId => $car): ?>
                    <?php
                    $_calcPrice = $calculator->calculatePrice($carId);
                    $_carLink = '/car.php?'.http_build_query(array_merge(['car' => $carId], $request->getPayload(false)));
                    $_eagerImage = $_first;
                    $_first = false;
                    $_carHeading = 'h3';
                    ?>
                    <div class="car-box">
                        <div class="row car-top">
                            <?php include 'app/partials/car-specifications.php' ?>
                            <div class="col-auto car-price text-right">
                                <small><strong><?=H::t('car:price_for_day')?></strong></small>
                                <?php if ($_calcPrice['discountPercentage']): ?>
                                    <h5 class="sale">$ <?=$_calcPrice['per_day']['old_price']?></h5>
                                    <h4><strong>$ <?=$_calcPrice['per_day']['price']?></strong></h4>
                                <?php else: ?>
                                    <h4><strong>$ <?=$_calcPrice['per_day']['price']?></strong></h4>
                                <?php endif ?>
                                <p>
                                    <small><?=H::t('car:total')?>:</small>
                                    <span>
                                        $
                                        <span class="total-price">
                                            <?=$_calcPrice['total']?>
                                        </span>
                                    </span>
                                </p>
                                <a href="<?=H::e($_carLink)?>" class="btn1 btn-success1"><?=H::t('select')?></a>
                            </div>
                        </div>
                        <div class="car-tabs">
                            <ul class="nav nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link"><?=$car['rating']?> Рейтинг</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#modal-conditions" data-toggle="modal" data-target="#modal-conditions"><span class="icon-doc"></span> Условия</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#modal-review-<?=$car['id']?>" data-toggle="modal" data-target="#modal-review-<?=$car['id']?>"><span class="icon-like"></span> Отзывы</a>
                                    <!-- Large modal -->
                                    <div id="modal-review-<?=$car['id']?>" class="modal fade bd-reviews-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="modal-title h5">Отзывы</div>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php $reviews = H::t('car-review:'.$car['id']) ?? []; ?>
                                                    <?php foreach ($reviews as $review): ?>
                                                        <blockquote class="text-right">
                                                            <p class="mb-0">
                                                                <span class="icon-quote-left"></span>
                                                                <em> <?=$review['description']?></em>
                                                                <span class="icon-quote-right"></span>
                                                            </p>
                                                            <footer>
                                                                <small><strong><?=$review['name']?></strong> - <?=$review['date']?>
                                                                </small>
                                                            </footer>
                                                        </blockquote>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="car-content">
                                <ul class="pl-0">
                                    <li class="list-inline-item">
                                        <span class="icon-check"></span> СТРАХОВКА ПЕРВОГО КЛАССА
                                    </li>
                                    <li class="list-inline-item">
                                        <span class="icon-check"></span> ЗАЩИТА ОТ ОТВЕТСТВЕННОСТИ ПЕРЕД ТРЕТЬИМИ ЛИЦАМИ
                                    </li>
                                    <li class="list-inline-item"><span class="icon-check"></span> ЗАЩИТА ОТ КРАЖИ</li>
                                    <li class="list-inline-item"><span class="icon-check"></span> НЕОГРАНИЧЕННЫЙ ПРОБЕГ
                                    </li>
                                    <li class="list-inline-item">
                                        <span class="icon-check"></span> ВЫЕЗД ЗА ПРЕДЕЛЫ ПХУКЕТА
                                    </li>
                                    <li class="list-inline-item">
                                        <span class="icon-check"></span> РУСКОЯЗЫЧНАЯ ПОДДЕРЖКА
                                    </li>
                                    <li class="list-inline-item"><span class="icon-check"></span> ПОМОЩЬ НА ДОРОГЕ 24/7
                                    </li>
                                    <li class="list-inline-item">
                                        <span class="icon-check"></span> ДОПОЛНИТЕЛЬНЫЙ ВОДИТЕЛЬ
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

        </div>

        <div class="row">
            <div class="col-12 pp seo-info">
                <h2 class="h4 mt-4">Как арендовать авто на Пхукете</h2>
                <p>Выберите место подачи, даты аренды и подходящий автомобиль, затем оставьте имя и телефон — заявка поступит менеджеру. Офис работает ежедневно с 8:00 до 23:00, общение на русском и английском: <a href="https://wa.me/66942654121" target="_blank" rel="noopener" data-track="whatsapp">WhatsApp</a>, <a href="https://t.me/simplemice" target="_blank" rel="noopener" data-track="telegram">Telegram</a> или <a href="tel:+66942654121" data-track="phone">+66 94 265 4121</a>.</p>

                <h2 class="h4 mt-4">Что входит в аренду</h2>
                <ul>
                    <li>Страховка первого класса, защита от ответственности перед третьими лицами и от кражи.</li>
                    <li>Неограниченный пробег и возможность выезда за пределы Пхукета.</li>
                    <li>Русскоязычная поддержка и помощь на дороге 24/7.</li>
                    <li>Дополнительный водитель.</li>
                </ul>
                <p>Полные условия — в разделе «Условия» у каждого автомобиля.</p>

                <h2 class="h4 mt-4">Подбор автомобиля</h2>
                <?php
                $_groups = ['Седаны' => [], 'Внедорожники и пикапы' => [], 'Семиместные автомобили для семьи и компании' => []];
                foreach ($store->getCarsByRequest($request) as $_id => $_c) {
                    if (H::carSeats($_c) === 7) {
                        $_groups['Семиместные автомобили для семьи и компании'][$_id] = $_c;
                    }
                    if ($_c['type'] === 'sedan') {
                        $_groups['Седаны'][$_id] = $_c;
                    }
                    if ($_c['type'] === 'jeep') {
                        $_groups['Внедорожники и пикапы'][$_id] = $_c;
                    }
                }
                ?>
                <?php foreach ($_groups as $_label => $_list): ?>
                    <?php if ($_list): ?>
                        <h3 class="h6 mt-3"><?=H::e($_label)?></h3>
                        <p>
                            <?php $_links = []; foreach ($_list as $_id => $_c) { $_links[] = '<a href="'.H::e(H::carPath($_id)).'">'.H::e(H::carName($_c)).'</a>'; } echo implode(', ', $_links); ?>
                        </p>
                    <?php endif ?>
                <?php endforeach ?>

                <h2 class="h4 mt-4">Подача и возврат автомобиля</h2>
                <p>Автомобиль подаётся и возвращается в выбранном вами районе Пхукета, включая аэропорт. Стоимость подачи и возврата зависит от района:</p>
                <ul>
                    <?php foreach ($_regionsByPrice as $_price => $_names): ?>
                        <li><strong><?=H::e($_price)?>$</strong> — <?=H::e(implode(', ', $_names))?></li>
                    <?php endforeach ?>
                </ul>
                <p>Цена указана за одну подачу или один возврат; итоговая сумма считается в форме бронирования.</p>

                <h2 class="h4 mt-4">Цены, депозит и дополнительные услуги</h2>
                <ul>
                    <li>Цена в сутки зависит от автомобиля и сезона; точная стоимость на ваши даты показана в карточке автомобиля.</li>
                    <?php if ($_deposits): ?>
                        <li>Депозит: от <?=H::e(min($_deposits))?>$ до <?=H::e(max($_deposits))?>$ в зависимости от автомобиля.</li>
                    <?php endif ?>
                    <li>Расширенная страховка — <?=H::e($store->getExtraByKey('insurance'))?>% от стоимости аренды, детское кресло — <?=H::e($store->getExtraByKey('baby_chair'))?>$ в сутки, SIM-карта с интернетом — <?=H::e($store->getExtraByKey('sim'))?>$.</li>
                    <li>Если время возврата позже времени получения более чем на <?=H::e($store->getExtraByKey('extra_hour'))?> ч., начисляются дополнительные сутки.</li>
                </ul>
            </div>
        </div>
    </div>

    <?php include 'app/partials/footer.php' ?>
