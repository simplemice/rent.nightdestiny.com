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
     * @param $message
     */
    public static function sendMessage($message): void
    {
        $token = '8045134223:AAExkZlXeW342szUZ388wtfcz7IGhsW-1ME';
        $chat_id = '-1001996176150';

        // Отправляем сообщение
        $fp = fopen(
            "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$message}",
            'rb'
        );

        fclose($fp);
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
}
