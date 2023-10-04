<?php

namespace Excore\Core\Config;

use Excore\Core\Modules\Http\Request;

class Assets
{
    private static string $root;

    public function __construct(
        private Request $request,
    ) {
        self::$root = $request->fullUrl();
    }

    public static function init(Request $request)
    {
        return new static($request);
    }

    public static function css()
    {
        $cssFiles = glob(__DIR__ . '/../../public/css/*.css');
        $cssTags = '';

        foreach ($cssFiles as $cssFile) {
            $cssTags .= '<link rel="stylesheet" href="' . self::$root . 'public/css/' . basename($cssFile) . '">';
        }

        return $cssTags;
    }

    public static function js()
    {
        $jsFiles = glob(__DIR__ . '/../../public/js/*.js');
        $jsTags = '';

        foreach ($jsFiles as $jsFile) {
            $jsTags .= '<script src="' . self::$root . 'public/js/' . basename($jsFile) . '" type="module"></script>';
        }

        return $jsTags;
    }


    public static function alpineCDN()
    {
        return '<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.1/dist/cdn.min.js"></script>';
    }


    public static function fontAwesome()
    {
        return '<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
        ';
    }
}
