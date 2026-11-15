<?php

use Monkeycar\Helper as H;

if (!class_exists('Monkeycar\Helper')) {
    include_once __DIR__.'/app/bootstrap.php';
}
if (!headers_sent()) {
    http_response_code(404);
}

$seo = [
    'title' => 'Страница не найдена | '.H::SITE_NAME,
    'description' => '',
    'canonical' => H::absUrl('/'),
    'robots' => 'noindex, follow',
];
?><!DOCTYPE html>
<html lang="<?=H::currentLanguageCode()?>">
<head>
<?php include __DIR__.'/app/partials/head.php' ?>
</head>
<body>
<?php include __DIR__.'/app/partials/header-menu.php' ?>
<section>
    <div class="container text-center py-5">
        <h1 class="mb-3">Страница не найдена</h1>
        <p>Такой страницы или автомобиля нет. Посмотрите <a href="/">каталог автомобилей для аренды на Пхукете</a> или напишите нам в <a href="https://wa.me/66942654121" target="_blank" rel="noopener" data-track="whatsapp">WhatsApp</a>.</p>
    </div>
<?php include __DIR__.'/app/partials/footer.php' ?>
