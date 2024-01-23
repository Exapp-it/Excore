<?php

namespace Excore\Core\Helpers;

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
        $cssFiles = glob(__DIR__ . '/../../public/css/base/*.css');
        $cssTags = '';

        foreach ($cssFiles as $cssFile) {
            $cssTags .= '<link rel="stylesheet" href="' . self::$root . 'public/css/base/' . basename($cssFile) . '">';
        }

        return $cssTags;
    }

    public static function js()
    {
        $jsFiles = glob(__DIR__ . '/../../public/js/base/*.js');
        $jsTags = '';

        foreach ($jsFiles as $jsFile) {
            $jsTags .= '<script src="' . self::$root . 'public/js/base/' . basename($jsFile) . '" type="module"></script>';
        }

        return $jsTags;
    }


    public static function fontAwesome()
    {
        return '<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
        ';
    }
}
