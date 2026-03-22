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
    <title>Дешевая аренда авто на Пхукете!</title>
    <meta name="robots" content="index, follow">
    <meta name="description" content="Лучший прокат авто на Пхукете, звоните прямо сейчас и получите специальную скидку WhatsApp +66881000005">
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-163386026-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-163386026-1');
</script>
</head>
<body>

<?php include 'app/partials/header-menu.php' ?>


<?php include 'app/partials/footer.php' ?>