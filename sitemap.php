<?php

/**
 * Dynamic XML sitemap, served as /sitemap.xml (see .htaccess).
 * Lists only canonical, parameter-free URLs; vehicles come from app/payload/cars.php,
 * so adding/removing a car updates the sitemap automatically.
 */

include(__DIR__.'/app/bootstrap.php');

use Monkeycar\Helper as H;

$cars = include __DIR__.'/app/payload/cars.php';
$carsMtime = filemtime(__DIR__.'/app/payload/cars.php') ?: time();
$homeMtime = max($carsMtime, filemtime(__DIR__.'/index.php') ?: 0, filemtime(__DIR__.'/app/payload/periods.php') ?: 0);

$urls = [[H::absUrl('/'), $homeMtime, '1.0']];
foreach (array_keys($cars) as $id) {
    $urls[] = [H::absUrl(H::carPath($id)), $carsMtime, '0.8'];
}

header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
foreach ($urls as [$loc, $mtime, $priority]) {
    echo '  <url><loc>'.htmlspecialchars($loc, ENT_XML1 | ENT_QUOTES, 'UTF-8').'</loc>'
        .'<lastmod>'.gmdate('Y-m-d', $mtime).'</lastmod>'
        .'<priority>'.$priority.'</priority></url>'."\n";
}
echo '</urlset>'."\n";
