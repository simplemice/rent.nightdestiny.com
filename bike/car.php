<?php

include(__DIR__.'/app/bootstrap.php');

use Monkeycar\Helper as H;

$request = \Monkeycar\Request::fromRequest($_GET);
$store = \Monkeycar\Helper::createStore();

$calculator = new \Monkeycar\Calculator($store, $request);

try {
    $car = $store->getCarFromRequest($request);
} catch (\Exception $e) {
    \Monkeycar\Helper::redirect('/');
}

$carId = $car['id'];
$_carLink = '/bike/car.php?'.http_build_query($request->getPayload());

$_calcPrice = $calculator->calculatePrice($carId);
$_carLink = '/bike/car.php?'.http_build_query($request->getPayload());

$insurancePrice = $_calcPrice['price'] * (float)$store->getExtraByKey('insurance') / 100;
$chairPrice = $_calcPrice['days'] * (float)$store->getExtraByKey('baby_chair');
$simPrice = $store->getExtraByKey('sim');

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
    <title><?=$car['model']?> от <?=$_calcPrice['per_day']['price']?>$ в сутки</title>
    <meta name="robots" content="index, follow">
    <meta name="description" content="">
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
<?php include 'app/partials/header-menu.php'?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-lg-3 pp">
                <form class="bgform" action="" method="get">
                    <input type="hidden" name="car" value="<?=$car['id']?>">
                    <div class="form-group">
                        <label class="" for="place-in"><span class="icon-point"></span> <?=H::t('form:place_from')?></label>
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
                            <input id="customSwitch1" class="new_return custom-control-input" type="checkbox" name="new_return" value="1" <?php if (!$request->isSamePlace()): ?>checked<?php endif ?> >
                            <label class="custom-control-label" for="customSwitch1"><?=H::t('form:new_return')?></label>
                        </div>
                    </div>
                    <div class="form-group fs-place-out">
                        <label class="" for="place-out"><span class="icon-point"></span> <?=H::t('form:place_to')?></label>
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
                               type="text"
                               value="<?=$request->getStartDate()->format('Y-m-d H:i')?>">
                    </div>
                    <div class="form-group">
                        <label class="" for=""><span class="icon-calendar"></span> <?=H::t('form:date_to')?></label>
                        <input id="date_to"
                               class="form-control"
                               name="date_to"
                               type="text"
                               value="<?=$request->getEndDate()->format('Y-m-d H:i')?>">
                    </div>
                    <button class="btn btn-success btn-block btn-lg"><?=H::t('form:search')?></button>
                </form>
            </div>
            <div class="col-md-7 col-lg-9 pp">
                <div class="car-box">
                    <div class="row car-top">
                        <?php include 'app/partials/car-specifications.php'?>
                        <div class="col-auto car-price text-right">
                            <?php if ($_calcPrice['discountPercentage']): ?>
                                <h5 class="sale">$ <?=$_calcPrice['per_day']['old_price']?></h5>
                                <h4>$ <?=$_calcPrice['per_day']['price']?></h4>
                            <?php else: ?>
                                <h4><strong>$ <?=$_calcPrice['per_day']['price']?></strong></h4>
                            <?php endif ?>
                            <small><strong><?=H::t('car:price_for_day')?></strong></small>
                        </div>
                    </div>

                    <div class="car-tabs">
                        <ul class="nav nav-fill" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link"><?=$car['rating']?> Рейтинг</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="modal" data-target=".bd-terms-modal-lg"><span class="icon-doc"></span> Условия</a>
                                <!-- Large modal -->
                                <div id="modal-conditions-<?=$car['id']?>" class="modal fade bd-terms-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"><span class="icon-second-doc"></span> <strong><?=H::t('car-terms-conditions')?></strong></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-left">
                                                <div class="row">
                                                    <div class="col-auto mr-auto">
                                                        <h6><strong><?=H::t('car-terms')?></strong></h6>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a type="button" data-toggle="collapse" data-target="#car-terms" aria-expanded="false" aria-controls="car-terms">+</a>
                                                    </div>
                                                </div>
                                                <div class="collapse" id="car-terms">
                                                    <?=H::t('car-terms-list')?>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-auto mr-auto">
                                                        <h6><strong><?=H::t('car-conditions')?></strong></h6>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a type="button" data-toggle="collapse" data-target="#car-conditions" aria-expanded="false" aria-controls="car-conditions">+</a>
                                                    </div>
                                                </div>
                                                <div class="collapse" id="car-conditions">
                                                    <?=H::t('car-conditions-list')?>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-auto mr-auto">
                                                        <h6><strong><?=H::t('car-use')?></strong></h6>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a type="button" data-toggle="collapse" data-target="#car-use" aria-expanded="false" aria-controls="car-use">+</a>
                                                    </div>
                                                </div>
                                                <div class="collapse" id="car-use">
                                                    <?=H::t('car-use-list')?>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-auto mr-auto">
                                                        <h6><strong><?=H::t('car-tenant')?></strong></h6>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a type="button" data-toggle="collapse" data-target="#car-tenant" aria-expanded="false" aria-controls="car-tenant">+</a>
                                                    </div>
                                                </div>
                                                <div class="collapse" id="car-tenant">
                                                    <?=H::t('car-tenant-list')?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="modal" data-target=".bd-reviews-modal-lg"><span class="icon-like"></span> Отзывы</a>
                                <!-- Large modal -->
                                <div class="modal fade bd-reviews-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                                <?php foreach($reviews as $review):?>
                                                    <blockquote class="text-right">
                                                        <p class="mb-0">
                                                            <span class="icon-quote-left"></span>
                                                            <em> <?=$review['description']?></em>
                                                            <span class="icon-quote-right"></span>
                                                        </p>
                                                        <footer>
                                                            <small><strong><?=$review['name']?></strong> - <?=$review['date']?></small>
                                                        </footer>
                                                    </blockquote>
                                                <?php endforeach;?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="car-content">
                            <ul class="pl-0">
                                <li class="list-inline-item"><span class="icon-check"></span> ДВА ШЛЕМА</li>
                                <li class="list-inline-item"><span class="icon-check"></span> НЕОГРАНИЧЕННЫЙ ПРОБЕГ ПО ОСТРОВУ</li>
                                <li class="list-inline-item"><span class="icon-check"></span> РУСКОЯЗЫЧНАЯ ПОДДЕРЖКА</li>
                                <li class="list-inline-item"><span class="icon-check"></span> ПОМОЩЬ НА ДОРОГЕ 24/7</li>
                            </ul>
                        </div>
                    </div>
                    <form class="needs-validation js-form-place" method="post" novalidate>
                        <?php foreach ($request->getPayload() as $key => $item): ?>
                            <input type="hidden" name="<?=$key?>" value="<?=$item?>">
                        <?php endforeach ?>

                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th scope="row">
                                    <label class="form-check-label" for="form-cb-insurance">
                                        <?=H::t('form:insurance')?>
                                        (+<?=$insurancePrice?>$)
                                    </label>
                                </th>
                                <td class="text-right">
                                    <input type="checkbox" id="form-cb-insurance" class="js-recalculate" name="insurance" value="1" data-price="<?=$insurancePrice?>">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label class="form-check-label" for="form-cb-chair">
                                        <?=H::t('form:chair')?>
                                        (+<?=$chairPrice?>$)
                                    </label>
                                </th>
                                <td class="text-right">
                                    <input type="checkbox" id="form-cb-chair" class="js-recalculate" name="chair" value="1" data-price="<?=$chairPrice?>">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label class="form-check-label" for="form-cb-sim">
                                        <?=H::t('form:sim')?>
                                        (+<?=$simPrice?>$)
                                    </label>
                                </th>
                                <td class="text-right">
                                    <input type="checkbox" id="form-cb-sim" class="js-recalculate" name="sim" value="1" data-price="<?=$simPrice?>">
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><?=H::t('form:place_from')?>:</th>
                                <td class="text-right"><?=$calculator->getFromRegion()['name']?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?=H::t('form:place_to')?>:</th>
                                <td class="text-right"><?=$calculator->getToRegion()['name']?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?=H::t('form:date_from')?>:</th>
                                <td class="text-right"><?=$request->getStartDate()->format('d.m.Y H:i')?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?=H::t('form:date_to')?>:</th>
                                <td class="text-right"><?=$request->getEndDate()->format('d.m.Y H:i')?></td>
                            </tr>

                            <tr>
                                <th scope="row"><?=H::t('invoice:rent')?>:</th>
                                <td class="text-right">
                                    <span id="js-price-rent"><?=$_calcPrice['price']?></span> $
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?=H::t('invoice:discount')?>:</th>
                                <td class="text-right">
                                    <span id="js-price-discount">
                                        <?=$_calcPrice['discountPercentage']?>
                                    </span>
                                    %
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?=H::t('invoice:delivery')?>:</th>
                                <td class="text-right">
                                    + <span id="js-price-delivery"><?=$_calcPrice['delivery']?></span> $
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?=H::t('invoice:deposit')?>:</th>
                                <td class="text-right">
                                    + <span id="js-price-deposit"><?=$_calcPrice['deposit']?></span> $
                                </td>
                            </tr>
                            <tr class="table-secondary">
                                <th scope="row"><?=H::t('invoice:total')?>:</th>
                                <th class="text-right">
                                    <span id="js-total" data-price="<?=$_calcPrice['total']+$_calcPrice['deposit']?>"><?=$_calcPrice['total']+$_calcPrice['deposit']?></span> $
                                </th>
                            </tr>
                            </tbody>
                        </table>
                        <div class="car-footer">
                            <div class="row">
                                <div class="col-sm-6 col-lg-4">
                                    <label for="validationCustom01"><?=H::t('submit:name')?></label>
                                    <input type="text" class="form-control" id="validationCustom01" placeholder="<?=H::t('submit:p_name')?>" name="name" value="" required>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <label for="validationCustom02"><?=H::t('submit:phone')?></label>
                                    <input type="tel" class="form-control" id="validationCustom02" placeholder="<?=H::t('submit:p_phone')?>" name="phone" value="" required pattern="^\+?[ 0-9]+$">
                                </div>
                                <div class="col col-lg-4 pt-4 mt-auto">
                                    <button class="btn1 btn-success1 btn-block btn-lg" type="submit"><?=H::t('submit:place')?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'app/partials/footer.php'?>
