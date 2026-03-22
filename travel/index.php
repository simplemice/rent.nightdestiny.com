<?php

include(__DIR__.'/app/bootstrap.php');

$request = \Monkeycar\Request::fromRequest($_GET);
$store = \Monkeycar\Helper::createStore();

$calculator = new \Monkeycar\Calculator($store, $request);

use Monkeycar\Helper as H;

?><!DOCTYPE html>
<html lang="<?=H::currentLanguageCode()?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta charset="utf-8">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css?v=5">
    <link rel="stylesheet" type="text/css" href="/assets/style.css?v=5">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600&display=swap&subset=cyrillic" rel="stylesheet">
    <title>Дешевые экскурсии  на Пхукете!</title>
    <meta name="robots" content="index, follow">
    <meta name="description" content="Лучшие экскурсии на Пхукете, звоните прямо сейчас и получите специальную скидку WhatsApp +66650210421">
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-J6HMVPCXPZ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-J6HMVPCXPZ');
</script>
</head>
<body>

<?php include 'app/partials/header-menu.php' ?>


<section>
    <div class="container">
         <div class="row">
             <marquee>
                 <span>Большой выбор экскурсий, экскурсии на любой вкус, однодневные и на несколько дней.</span>
             </marquee> 
             <input type="button" style="margin-left: 50%" onClick="location.href='https://t.me/phuketservicekaron'" value='Контакт'>
     </div>
     <br>
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
                        <label class="" for=""><span class="icon-calendar"></span> <?=H::t('form:date_from')?></label>
                        <input id="date_from"
                               class="form-control"
                               name="date_from"
                               type="date"
                               value="<?=$request->getStartDate()->format('Y-m-d H:i')?>">
                    </div>
                    <div class="form-group">
                        <label class="" for=""><span class="icon-calendar"></span> <?=H::t('form:date_to')?></label>
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
                        <h5 class="card-title"><span class="icon-phone"></span><b> +66650210421 Rus/Eng</b></h5>
                        <p class="card-text">Работаем ежедневно <br>с 9:00 - 23:00</p>
                        <a href="https://maps.app.goo.gl/sWmBbcubw2gmJirw6" class="btn btn-success2">Локация офиса</a> <br><br>
                        <a href="https://wa.me/66650210421?text=Здравствуйте!" class="btn btn-success2"><span class="icon-whatsapp"></span> WhatsApp</a>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-lg-9 pp">

                <?php foreach ($store->getCarsByRequest($request) as $carId => $car): ?>
                    <?php
                    $_calcPrice = $calculator->calculatePrice($carId);
                    $_carLink = '/travel/car.php?'.http_build_query(array_merge(['car' => $carId], $request->getPayload()));
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
                                <a href="<?=$_carLink?>" class="btn1 btn-success1"><?=H::t('select')?></a>
                            </div>
                        </div>
                        <div class="car-tabs">
                            <ul class="nav nav-fill" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link"><?=$car['rating']?> Рейтинг</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="modal" data-target="#modal-conditions"><span class="icon-doc"></span> Условия</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="modal" data-target="#modal-review-<?=$car['id']?>"><span class="icon-like"></span> Отзывы</a>
                                    <!-- Large modal -->
                                    <div id="modal-review-<?=$car['id']?>" class="modal fade bd-reviews-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Отзывы</h5>
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
                                    <li class="list-inline-item"><span class="icon-check"></span> СПАСАТЕЛЬНЫЕ ЖИЛЕТЫ
                                    </li>
                                    <li class="list-inline-item">
                                        <span class="icon-check"></span> РУСКОЯЗЫЧНАЯ ПОДДЕРЖКА
                                    </li>
                                    <li class="list-inline-item"><span class="icon-check"></span> ПОМОЩЬ В ОРГАНИЗАЦИИ 24/7
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

        </div>
    </div>

    <?php include 'app/partials/footer.php' ?>
