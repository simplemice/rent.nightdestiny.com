<?php
/**
 * Shared <head>. Expects $seo = [
 *   'title', 'description', 'canonical' (absolute URL), 'robots' (optional),
 *   'og_image' (absolute URL, optional), 'og_type' (optional), 'schema' (list of arrays, optional)
 * ]
 */

use Monkeycar\Helper as H;

$seo = $seo ?? [];
$_title = $seo['title'] ?? H::SITE_NAME;
$_desc = $seo['description'] ?? '';
$_canonical = $seo['canonical'] ?? H::absUrl('/');
$_robots = $seo['robots'] ?? 'index, follow, max-image-preview:large';
$_ogImage = $seo['og_image'] ?? H::absUrl('/assets/images/logo.png');
$_ogType = $seo['og_type'] ?? 'website';

// GA4: ids kept exactly as found in the original templates (see SEO_AUDIT.md S13 — owner must confirm).
$_gaLoadId = 'G-8V98B9L0YW';
$_gaConfigId = 'G-7LP6NTXNHG';
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=H::e($_title)?></title>
<?php if ($_desc !== ''): ?>
<meta name="description" content="<?=H::e($_desc)?>">
<?php endif ?>
<meta name="robots" content="<?=H::e($_robots)?>">
<link rel="canonical" href="<?=H::e($_canonical)?>">
<meta property="og:site_name" content="<?=H::e(H::SITE_NAME)?>">
<meta property="og:type" content="<?=H::e($_ogType)?>">
<meta property="og:title" content="<?=H::e($_title)?>">
<?php if ($_desc !== ''): ?>
<meta property="og:description" content="<?=H::e($_desc)?>">
<?php endif ?>
<meta property="og:url" content="<?=H::e($_canonical)?>">
<meta property="og:image" content="<?=H::e($_ogImage)?>">
<meta property="og:locale" content="ru_RU">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?=H::e($_title)?>">
<?php if ($_desc !== ''): ?>
<meta name="twitter:description" content="<?=H::e($_desc)?>">
<?php endif ?>
<meta name="twitter:image" content="<?=H::e($_ogImage)?>">
<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/assets/favicon/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/assets/favicon/apple-touch-icon.png">
<link rel="manifest" href="/assets/favicon/site.webmanifest">
<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/assets/css/style.css?v=6">
<link rel="stylesheet" type="text/css" href="/assets/style.css?v=6">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600&display=swap&subset=cyrillic" rel="stylesheet">
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?=H::e($_gaLoadId)?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?=H::e($_gaConfigId)?>');
</script>
<?php foreach (($seo['schema'] ?? []) as $_schema): ?>
<script type="application/ld+json"><?=json_encode($_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP)?></script>
<?php endforeach ?>
