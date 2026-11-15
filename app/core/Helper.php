<?php

namespace Monkeycar;

class Helper
{

//function timeOptions()
//{
//    $output = '';
//    $ch = '00';
//    $m = 0;
//    for ($i = 0; $i < 1440; $i += 30) {
//        $m = $i % 60;
//
//        if (!$m) {
//            $output .= "<option value='$ch:0$m'>$ch:0$m</option>";
//        } else {
//            $output .= "<option value='$ch:$m'>$ch:$m</option>";
//        }
//        $ch = ceil($i / 60) < 10 ? '0'.ceil($i / 60) : ceil($i / 60);
//    }
//
//    return $output;
//}

    public static function redirect($url = '/'): void
    {
        header('Location: '.$url);
        exit(0);
    }

    /**
     * @return bool
     */
    public static function isDev(): bool
    {
        $env = getenv('APPLICATION_ENV') ?: 'production';

        return $env !== 'production';
    }

    /**
     * Read a config value: environment variable first, then app/config.local.php (untracked).
     *
     * @param string $key
     * @param string $env
     * @return string
     */
    public static function config(string $key, string $env = ''): string
    {
        static $local;
        if ($env !== '' && getenv($env) !== false && getenv($env) !== '') {
            return (string)getenv($env);
        }
        if ($local === null) {
            $file = __DIR__.'/../config.local.php';
            $local = is_file($file) ? (array)include $file : [];
        }

        return (string)($local[$key] ?? '');
    }

    /**
     * Send an HTML message to the Telegram booking chat.
     *
     * @param string $message already URL-safe text (see api/send.php)
     * @return bool true when Telegram accepted the message
     */
    public static function sendMessage($message): bool
    {
        $token = self::config('telegram_token', 'TELEGRAM_BOT_TOKEN');
        $chatId = self::config('telegram_chat_id', 'TELEGRAM_CHAT_ID');
        if ($token === '' || $chatId === '') {
            error_log('Telegram is not configured');

            return false;
        }

        $url = 'https://api.telegram.org/bot'.$token.'/sendMessage';
        $body = http_build_query(['chat_id' => $chatId, 'parse_mode' => 'html', 'text' => $message]);
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
                'content' => $body,
                'timeout' => 8,
                'ignore_errors' => true,
            ],
        ]);

        $response = @file_get_contents($url, false, $context);
        if ($response === false) {
            error_log('Telegram request failed');

            return false;
        }
        $decoded = json_decode($response, true);

        return is_array($decoded) && !empty($decoded['ok']);
    }

    /**
     * @return \Monkeycar\Store
     */
    public static function createStore(): \Monkeycar\Store
    {
        $cars = include(__DIR__.'/../payload/cars.php');
        $regions = include(__DIR__.'/../payload/regions.php');
        $periods = include(__DIR__.'/../payload/periods.php');
        $extra = include(__DIR__.'/../payload/extra.php');

        return new \Monkeycar\Store($cars, $regions, $periods, $extra);
    }

    /**
     * @param null $key
     * @return mixed|null
     */
    public static function t($key = null)
    {
        static $translations;
        if (!$translations) {
            $translations = include __DIR__.'/../payload/translate.php';
        }

        $lang = self::currentLanguageCode();

        if (array_key_exists($key, $translations[$lang])) {
            return $translations[$lang][$key];
        }

        return null;
    }

    /**
     * @return string
     */
    public static function currentLanguageCode(): string
    {
        $lang = 'ru';

        return $lang;
    }

    const BASE_URL = 'https://rent.nightdestiny.com';
    const SITE_NAME = 'Nightdestiny';
    const PHONE = '+66942654121';

    /**
     * HTML-escape for output.
     */
    public static function e($value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    /**
     * Absolute canonical URL for a path (path must start with "/").
     */
    public static function absUrl(string $path = '/'): string
    {
        return self::BASE_URL.$path;
    }

    /**
     * Canonical (parameter-free) path of a vehicle page.
     */
    public static function carPath($carId): string
    {
        return '/car.php?car='.(int)$carId;
    }

    /**
     * Human readable car name ("Toyota Yaris Ativ"), data contains stray spaces.
     */
    public static function carName(array $car): string
    {
        return trim(preg_replace('/\s+/', ' ', (string)$car['model']));
    }

    /**
     * Seats as a number ("Пять" -> 5, "Семь" -> 7); null when unknown.
     */
    public static function carSeats(array $car): ?int
    {
        $map = ['пять' => 5, 'семь' => 7, 'пять ' => 5];
        $key = mb_strtolower(trim((string)($car['seats'] ?? '')));
        if (isset($map[$key])) {
            return $map[$key];
        }

        return ctype_digit($key) ? (int)$key : null;
    }

    /**
     * Unique, fact-based meta description for a vehicle (only data that exists in cars.php / site texts).
     */
    public static function carDescription(array $car): string
    {
        $parts = [];
        $parts[] = 'Аренда '.self::carName($car).' на Пхукете';
        $facts = [];
        if (!empty($car['year'])) {
            $facts[] = $car['year'].' г.';
        }
        $facts[] = 'АКПП';
        if ($seats = self::carSeats($car)) {
            $facts[] = $seats.' мест';
        }
        if (!empty($car['engine'])) {
            $facts[] = 'двигатель '.$car['engine'].' л';
        }
        $text = $parts[0].': '.implode(', ', $facts).'.';
        $text .= ' Подача в аэропорт и по районам Пхукета, неограниченный пробег, страховка.';
        if (!empty($car['deposit'])) {
            $text .= ' Депозит '.$car['deposit'].'$.';
        }
        $text .= ' Бронь онлайн или в WhatsApp.';

        return $text;
    }

    /**
     * <picture> with WebP when a sibling .webp exists, intrinsic size, alt and loading hints.
     *
     * @param string $file file name inside assets/images
     * @param bool   $eager true for the LCP image (no lazy loading, high fetch priority)
     */
    public static function picture(string $file, string $alt, bool $eager = false, string $class = 'img-fluid'): string
    {
        $dir = dirname(__DIR__, 2).'/assets/images/';
        $src = '/assets/images/'.rawurlencode($file);
        $size = is_file($dir.$file) ? @getimagesize($dir.$file) : false;
        $attrs = '';
        if ($size) {
            $attrs .= ' width="'.(int)$size[0].'" height="'.(int)$size[1].'"';
        }
        $attrs .= $eager ? ' fetchpriority="high"' : ' loading="lazy" decoding="async"';

        $webpName = preg_replace('/\.(png|jpe?g)$/i', '.webp', $file);
        $html = '<picture>';
        if ($webpName !== $file && is_file($dir.$webpName)) {
            $html .= '<source type="image/webp" srcset="/assets/images/'.rawurlencode($webpName).'">';
        }
        $html .= '<img src="'.self::e($src).'" alt="'.self::e($alt).'" class="'.self::e($class).'"'.$attrs.'>';
        $html .= '</picture>';

        return $html;
    }
}
